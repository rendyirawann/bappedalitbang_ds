<?php

namespace common\components;

use Yii;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

/**
 * Helper terpusat untuk operasi file yang berhubungan dengan input pengguna.
 *
 * Letakkan file ini di: common/components/SecureFile.php
 *
 * Tujuannya supaya logika pengamanan hanya ada di satu tempat.
 * Kalau nanti ada perbaikan, cukup ubah di sini, tidak perlu
 * menyisir belasan controller lagi.
 */
class SecureFile
{
    /**
     * Menghasilkan nama file yang aman dan tidak bertabrakan.
     *
     * Nama asli dari pengguna tidak dipakai sebagai nama fisik file:
     *  - komponen direktori dibuang
     *  - karakter selain huruf, angka, dash, underscore diganti dash
     *  - ditambah timestamp dan string acak supaya tidak saling menimpa
     *  - ekstensi disaring dan dipaksa huruf kecil
     *
     * @param UploadedFile $upload
     * @param int $panjangSlug jumlah karakter nama asli yang dipertahankan
     * @return string nama file, tanpa jalur
     */
    public static function safeName(UploadedFile $upload, $panjangSlug = 40)
    {
        // basename memutus percobaan path traversal lewat nama file
        $asli = basename((string) $upload->baseName);

        $slug = preg_replace('/[^A-Za-z0-9\-_]/', '-', $asli);
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        $slug = strtolower(mb_substr($slug, 0, $panjangSlug));

        if ($slug === '') {
            $slug = 'file';
        }

        // ekstensi hanya boleh alfanumerik
        $ext = strtolower(preg_replace('/[^A-Za-z0-9]/', '', (string) $upload->extension));

        return $slug
            . '-' . date('Ymd-His')
            . '-' . Yii::$app->security->generateRandomString(6)
            . ($ext !== '' ? '.' . $ext : '');
    }

    /**
     * Menyimpan file unggahan ke folder frontend dan backend sekaligus,
     * memakai nama yang dihasilkan safeName().
     *
     * @param UploadedFile $upload
     * @param string $subdir nama subfolder di dalam web/uploads, mis. 'berita'
     * @return string|null nama file yang tersimpan, atau null jika gagal
     */
    public static function store(UploadedFile $upload, $subdir)
    {
        $subdir = trim(preg_replace('/[^A-Za-z0-9\-_]/', '', $subdir), '-_');
        if ($subdir === '') {
            return null;
        }

        $nama = self::safeName($upload);

        $tujuan = [
            Yii::getAlias('@frontend/web/uploads/' . $subdir),
            Yii::getAlias('@backend/web/uploads/' . $subdir),
        ];

        $berhasil = false;

        foreach ($tujuan as $dir) {
            if (!is_dir($dir)) {
                \yii\helpers\FileHelper::createDirectory($dir, 0770, true);
            }
            if ($upload->saveAs($dir . DIRECTORY_SEPARATOR . $nama, false)) {
                $berhasil = true;
            }
        }

        return $berhasil ? $nama : null;
    }

    /**
     * Mengirim file ke pengguna dengan jalur dikurung di dalam
     * web/uploads/<subdir>.
     *
     * Nilai $namaFile diperlakukan sebagai data yang TIDAK dipercaya,
     * walaupun berasal dari database.
     *
     * @param string $subdir subfolder di dalam web/uploads, mis. 'berita'
     * @param string $namaFile nilai kolom file dari database
     * @param string|null $namaTampil nama yang dilihat pengguna saat mengunduh
     * @param string $baseAlias '@backend' atau '@frontend'
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public static function send($subdir, $namaFile, $namaTampil = null, $baseAlias = '@backend')
    {
        // Lapisan 1: buang seluruh komponen direktori.
        // Setelah baris ini tidak ada lagi '../' yang bisa diresolusi.
        $nama = basename((string) $namaFile);

        if ($nama === '' || $nama === '.' || $nama === '..') {
            throw new NotFoundHttpException('File tidak ditemukan.');
        }

        $subdirBersih = trim(preg_replace('/[^A-Za-z0-9\-_]/', '', $subdir), '-_');

        // Lapisan 2: resolusi jalur sebenarnya, termasuk symlink
        $baseDir = realpath(Yii::getAlias($baseAlias . '/web/uploads/' . $subdirBersih));
        if ($baseDir === false) {
            throw new NotFoundHttpException('File tidak ditemukan.');
        }

        $target = realpath($baseDir . DIRECTORY_SEPARATOR . $nama);

        // Lapisan 3: hasil akhir wajib berada di dalam $baseDir.
        // DIRECTORY_SEPARATOR pada pembanding mencegah folder
        // bernama "uploads_lain" ikut lolos.
        if ($target === false
            || strncmp($target, $baseDir . DIRECTORY_SEPARATOR, strlen($baseDir) + 1) !== 0
            || !is_file($target)
        ) {
            Yii::warning(
                'Percobaan akses file di luar folder unggahan: ' . $namaFile
                . ' | subdir=' . $subdir
                . ' | user=' . (Yii::$app->has('user') ? Yii::$app->user->id : '-')
                . ' | ip=' . Yii::$app->request->userIP,
                'security'
            );
            throw new NotFoundHttpException('File tidak ditemukan.');
        }

        return Yii::$app->response->sendFile($target, $namaTampil ?: $nama);
    }
}