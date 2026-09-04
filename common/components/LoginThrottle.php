<?php

namespace common\components;

use Yii;

/**
 * Pembatas percobaan login (anti brute force).
 *
 * LATAR BELAKANG
 *   Server ini berada di belakang Cloudflare dan sebuah gateway.
 *   Semua koneksi sampai ke Apache dengan alamat 10.0.20.1, sehingga
 *   fail2ban tidak bisa dipakai: yang akan terblokir justru gateway
 *   itu sendiri dan seluruh situs ikut mati. Karena itu pembatasan
 *   dilakukan di lapisan aplikasi.
 *
 *   Alamat asli pengunjung sudah dipulihkan oleh mod_remoteip
 *   (/etc/apache2/conf-enabled/remoteip-cloudflare.conf), jadi
 *   Yii::$app->request->userIP sekarang berisi IP sebenarnya,
 *   bukan lagi IP gateway.
 *
 * CARA KERJA
 *   Dua penghitung disimpan di cache dengan masa berlaku terbatas:
 *     1. per (IP + username) - menahan tebakan sandi pada satu akun
 *     2. per IP saja         - menahan penyisiran banyak akun sekaligus
 *   Setelah batas terlampaui, login dari IP itu ditolak sementara.
 *
 * SIFAT AMAN (fail-open)
 *   Setiap operasi cache dibungkus try/catch. Bila cache bermasalah,
 *   fungsi mengembalikan "tidak diblokir" sehingga login tetap
 *   berjalan normal. Pembatas ini tidak boleh sampai mengunci
 *   pengguna sah gara-gara gangguan teknis.
 *
 * MENYETEL / MEMATIKAN
 *   Ubah nilai konstanta di bawah. Untuk mematikan sepenuhnya,
 *   setel AKTIF menjadi false.
 */
class LoginThrottle
{
    /** Setel false untuk mematikan pembatas ini sepenuhnya. */
    const AKTIF = true;

    /** Maksimal kegagalan untuk satu kombinasi IP + username. */
    const MAKS_PER_AKUN = 10;

    /** Maksimal kegagalan dari satu IP untuk semua username. */
    const MAKS_PER_IP = 30;

    /** Rentang waktu penghitungan, dalam detik (15 menit). */
    const JENDELA = 900;

    private static function ip()
    {
        try {
            return (string) Yii::$app->request->userIP;
        } catch (\Throwable $e) {
            return '0.0.0.0';
        }
    }

    private static function kunciAkun($username)
    {
        return 'throttle:akun:' . sha1(self::ip() . '|' . strtolower((string) $username));
    }

    private static function kunciIp()
    {
        return 'throttle:ip:' . sha1(self::ip());
    }

    private static function ambil($kunci)
    {
        try {
            $nilai = Yii::$app->cache->get($kunci);
            return is_array($nilai) ? $nilai : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Apakah percobaan login dari IP ini sedang ditahan?
     *
     * @param string $username
     * @return bool
     */
    public static function terblokir($username)
    {
        if (!self::AKTIF) {
            return false;
        }

        $akun = self::ambil(self::kunciAkun($username));
        if ($akun !== null && $akun['jumlah'] >= self::MAKS_PER_AKUN) {
            return true;
        }

        $ip = self::ambil(self::kunciIp());
        if ($ip !== null && $ip['jumlah'] >= self::MAKS_PER_IP) {
            return true;
        }

        return false;
    }

    /**
     * Perkiraan sisa waktu tunggu dalam menit, dibulatkan ke atas.
     * Dipakai hanya untuk menyusun pesan kesalahan yang informatif.
     *
     * @param string $username
     * @return int
     */
    public static function sisaMenit($username)
    {
        $paling = 0;
        foreach ([self::kunciAkun($username), self::kunciIp()] as $kunci) {
            $data = self::ambil($kunci);
            if ($data !== null) {
                $sisa = (int) ($data['kedaluwarsa'] - time());
                if ($sisa > $paling) {
                    $paling = $sisa;
                }
            }
        }

        return $paling > 0 ? (int) ceil($paling / 60) : 1;
    }

    /**
     * Catat satu percobaan login yang gagal.
     *
     * @param string $username
     */
    public static function catatGagal($username)
    {
        if (!self::AKTIF) {
            return;
        }

        foreach ([self::kunciAkun($username), self::kunciIp()] as $kunci) {
            try {
                $data = self::ambil($kunci);
                if ($data === null) {
                    $data = ['jumlah' => 0, 'kedaluwarsa' => time() + self::JENDELA];
                }
                $data['jumlah']++;

                // Masa berlaku mengikuti sisa jendela yang sudah berjalan,
                // supaya penyerang tidak bisa mereset hitungan sendiri
                // hanya dengan berhenti sejenak lalu mencoba lagi.
                $sisa = max((int) ($data['kedaluwarsa'] - time()), 1);
                Yii::$app->cache->set($kunci, $data, $sisa);
            } catch (\Throwable $e) {
                // Sengaja dibiarkan: kegagalan cache tidak boleh
                // mengganggu proses login.
            }
        }

        try {
            Yii::warning(
                'Login gagal | username=' . $username . ' | ip=' . self::ip(),
                'security'
            );
        } catch (\Throwable $e) {
            // diabaikan dengan sengaja
        }
    }

    /**
     * Bersihkan penghitung setelah login berhasil, supaya pengguna sah
     * yang sempat salah ketik tidak terus terhitung.
     *
     * @param string $username
     */
    public static function bersihkan($username)
    {
        foreach ([self::kunciAkun($username), self::kunciIp()] as $kunci) {
            try {
                Yii::$app->cache->delete($kunci);
            } catch (\Throwable $e) {
                // diabaikan dengan sengaja
            }
        }
    }
}
