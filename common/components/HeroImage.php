<?php

namespace common\components;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Pemroses gambar banner halaman depan.
 *
 * TUJUAN
 *   Pengelola cukup mengunggah gambar apa adanya. Semua penyesuaian
 *   ukuran dikerjakan di sini, sehingga banner tidak pernah tampil
 *   ter-zoom, gepeng, atau terpotong tidak beraturan seperti sebelumnya.
 *
 * CARA KERJA
 *   Setiap gambar diubah menjadi kanvas tetap 2400x1200 piksel (2:1),
 *   ukuran yang sama dengan kotak slider di halaman depan (tingginya
 *   diatur 50vw). Karena rasionya identik, gambar selalu mengisi penuh
 *   sampai tepi kiri-kanan.
 *
 *   Bila gambar yang diunggah rasionya berbeda, bagian tengahnya yang
 *   diambil. Contoh: foto 16:9 kehilangan sekitar 5,5% di atas dan di
 *   bawah. Karena itu bagian penting - wajah, tulisan - sebaiknya tidak
 *   diletakkan mepet tepi atas atau bawah.
 *
 *   Gambar yang lebih kecil dari 2400 piksel tidak diperbesar melebihi
 *   ukuran aslinya secara berlebihan; kanvas tetap 2:1 agar seragam.
 *
 * KELUARAN
 *   JPEG progresif kualitas 88. Banner 6-10 MB umumnya turun menjadi
 *   sekitar 300-500 KB tanpa penurunan kualitas yang terlihat.
 */
class HeroImage
{
    /** Lebar kanvas hasil, piksel. */
    const LEBAR = 2400;

    /** Tinggi kanvas hasil, piksel. Rasio LEBAR:TINGGI wajib 2:1. */
    const TINGGI = 1200;

    /** Kualitas JPEG. 88 cukup tinggi untuk menjaga ketajaman tulisan. */
    const KUALITAS = 88;

    /** Subfolder di dalam web/uploads/. */
    const SUBDIR = 'hero';

    /**
     * Memproses berkas unggahan lalu menyimpannya di folder frontend
     * dan backend sekaligus.
     *
     * @param UploadedFile $unggahan
     * @return string|null nama berkas hasil, atau null bila gagal
     */
    public static function simpan(UploadedFile $unggahan)
    {
        $sumber = self::baca($unggahan->tempName);
        if ($sumber === null) {
            return null;
        }

        $kanvas = self::keKanvas($sumber);
        imagedestroy($sumber);

        $nama = self::namaBaru($unggahan);
        $berhasil = false;

        foreach (self::daftarFolder() as $folder) {
            if (!is_dir($folder)) {
                FileHelper::createDirectory($folder, 0775, true);
            }
            if (imagejpeg($kanvas, $folder . DIRECTORY_SEPARATOR . $nama, self::KUALITAS)) {
                $berhasil = true;
            }
        }

        imagedestroy($kanvas);

        return $berhasil ? $nama : null;
    }

    /**
     * Menghapus berkas gambar dari kedua folder.
     * Nama berkas diperlakukan sebagai data yang tidak dipercaya.
     *
     * @param string $nama
     */
    public static function hapus($nama)
    {
        $nama = basename((string) $nama);
        if ($nama === '' || $nama === '.' || $nama === '..') {
            return;
        }

        foreach (self::daftarFolder() as $folder) {
            $dasar = realpath($folder);
            if ($dasar === false) {
                continue;
            }
            $target = realpath($dasar . DIRECTORY_SEPARATOR . $nama);
            // Pastikan hasil resolusi benar-benar di dalam folder unggahan.
            if ($target !== false
                && strncmp($target, $dasar . DIRECTORY_SEPARATOR, strlen($dasar) + 1) === 0
                && is_file($target)
            ) {
                @unlink($target);
            }
        }
    }

    /**
     * Folder tujuan penyimpanan: frontend untuk ditampilkan ke publik,
     * backend supaya pratinjau di halaman pengelolaan ikut muncul.
     *
     * @return string[]
     */
    private static function daftarFolder()
    {
        return [
            Yii::getAlias('@frontend/web/uploads/' . self::SUBDIR),
            Yii::getAlias('@backend/web/uploads/' . self::SUBDIR),
        ];
    }

    /**
     * Nama berkas yang aman dan tidak bertabrakan. Nama asli dari
     * pengguna tidak dipakai sebagai nama fisik berkas.
     *
     * @param UploadedFile $unggahan
     * @return string
     */
    private static function namaBaru(UploadedFile $unggahan)
    {
        $slug = preg_replace('/[^A-Za-z0-9\-_]/', '-', basename((string) $unggahan->baseName));
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        $slug = strtolower(mb_substr($slug, 0, 40));

        if ($slug === '') {
            $slug = 'hero';
        }

        return 'hero-' . $slug
            . '-' . date('Ymd-His')
            . '-' . Yii::$app->security->generateRandomString(6)
            . '.jpg';
    }

    /**
     * Membaca berkas menjadi sumber daya gambar GD, apa pun format
     * yang didukung (JPEG, PNG, GIF, WebP).
     *
     * @param string $jalur
     * @return resource|\GdImage|null
     */
    private static function baca($jalur)
    {
        $info = @getimagesize($jalur);
        if ($info === false) {
            return null;
        }

        switch ($info[2]) {
            case IMAGETYPE_JPEG: $gambar = @imagecreatefromjpeg($jalur); break;
            case IMAGETYPE_PNG:  $gambar = @imagecreatefrompng($jalur);  break;
            case IMAGETYPE_GIF:  $gambar = @imagecreatefromgif($jalur);  break;
            case IMAGETYPE_WEBP: $gambar = @imagecreatefromwebp($jalur); break;
            default: return null;
        }

        return $gambar ?: null;
    }

    /**
     * Menempatkan gambar ke kanvas 2:1 dengan pemotongan tengah.
     *
     * @param resource|\GdImage $sumber
     * @return resource|\GdImage
     */
    private static function keKanvas($sumber)
    {
        $lebarAsal  = imagesx($sumber);
        $tinggiAsal = imagesy($sumber);
        $rasio      = self::LEBAR / self::TINGGI;

        // Ambil area terbesar dari gambar asli yang rasionya sudah 2:1.
        if ($lebarAsal / $tinggiAsal > $rasio) {
            // Gambar lebih lebar daripada kanvas: potong kiri-kanan.
            $tinggiAmbil = $tinggiAsal;
            $lebarAmbil  = (int) round($tinggiAsal * $rasio);
        } else {
            // Gambar lebih tinggi: potong atas-bawah.
            $lebarAmbil  = $lebarAsal;
            $tinggiAmbil = (int) round($lebarAsal / $rasio);
        }

        $x = (int) round(($lebarAsal - $lebarAmbil) / 2);
        $y = (int) round(($tinggiAsal - $tinggiAmbil) / 2);

        $kanvas = imagecreatetruecolor(self::LEBAR, self::TINGGI);
        // Latar putih menjaga hasil tetap wajar bila sumbernya PNG
        // transparan, karena JPEG tidak mengenal transparansi.
        imagefill($kanvas, 0, 0, imagecolorallocate($kanvas, 255, 255, 255));
        imagecopyresampled(
            $kanvas, $sumber,
            0, 0, $x, $y,
            self::LEBAR, self::TINGGI,
            $lebarAmbil, $tinggiAmbil
        );

        // Progresif: gambar terlihat lebih cepat pada koneksi lambat.
        imageinterlace($kanvas, true);

        return $kanvas;
    }
}
