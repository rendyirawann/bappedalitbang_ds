<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\FileHelper;

/**
 * Seeder untuk mengisi data awal aplikasi.
 *
 * Jalankan dengan: php yii seeder/standar-pelayanan
 */
class SeederController extends Controller
{
    /**
     * Seed dokumen Standar Pelayanan:
     * - menyalin file dokumen dari console/data/standar-pelayanan ke uploads frontend & backend
     * - memasukkan data ke tabel standar_pelayanan
     * - mendaftarkan route RBAC /standar-pelayanan/* untuk role admin & superadmin
     *
     * @return int
     */
    public function actionStandarPelayanan()
    {
        $sourceDir = Yii::getAlias('@console/data/standar-pelayanan');
        $targetDirs = [
            Yii::getAlias('@frontend/web/uploads/standar-pelayanan'),
            Yii::getAlias('@backend/web/uploads/standar-pelayanan'),
        ];

        foreach ($targetDirs as $dir) {
            FileHelper::createDirectory($dir);
        }

        // Gambar-gambar SP dan laporan SKM sudah digabung menjadi satu PDF per dokumen
        // (sumber gambar tersimpan di folder yang sama untuk regenerasi bila diperlukan)
        $documents = [
            ['file' => 'standar-pelayanan-2026.pdf', 'namaFile' => 'Standar Pelayanan Bappedalitbang Deli Serdang', 'tahun' => 2026],
            ['file' => 'laporan-skm-triwulan-1-2026.pdf', 'namaFile' => 'Laporan Survei Kepuasan Masyarakat Triwulan I 2026', 'tahun' => 2026],
        ];

        $db = Yii::$app->db;

        foreach ($documents as $doc) {
            $sourcePath = $sourceDir . DIRECTORY_SEPARATOR . $doc['file'];

            if (!is_file($sourcePath)) {
                $this->stdout("LEWAT   : file sumber tidak ditemukan: {$doc['file']}\n");
                continue;
            }

            foreach ($targetDirs as $dir) {
                copy($sourcePath, $dir . DIRECTORY_SEPARATOR . $doc['file']);
            }

            $exists = $db->createCommand(
                'SELECT COUNT(*) FROM {{%standar_pelayanan}} WHERE file = :file',
                [':file' => $doc['file']]
            )->queryScalar();

            if ($exists) {
                $this->stdout("SUDAH ADA: {$doc['namaFile']}\n");
                continue;
            }

            $db->createCommand()->insert('{{%standar_pelayanan}}', $doc)->execute();
            $this->stdout("DITAMBAH : {$doc['namaFile']}\n");
        }

        $this->seedRbacRoutes();

        $this->stdout("Selesai.\n");

        return ExitCode::OK;
    }

    /**
     * Mendaftarkan route /standar-pelayanan/* ke RBAC (mengikuti pola route /galeri/*)
     * agar dapat diakses role admin dan superadmin.
     */
    protected function seedRbacRoutes()
    {
        $db = Yii::$app->db;
        $now = time();

        $routes = [
            '/standar-pelayanan/*',
            '/standar-pelayanan/index',
            '/standar-pelayanan/create',
            '/standar-pelayanan/update',
            '/standar-pelayanan/view',
            '/standar-pelayanan/delete',
            '/standar-pelayanan/download',
        ];

        foreach ($routes as $route) {
            $exists = $db->createCommand(
                'SELECT COUNT(*) FROM {{%auth_item}} WHERE name = :name',
                [':name' => $route]
            )->queryScalar();

            if (!$exists) {
                $db->createCommand()->insert('{{%auth_item}}', [
                    'name' => $route,
                    'type' => 2,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])->execute();
            }

            foreach (['admin', 'superadmin'] as $role) {
                $childExists = $db->createCommand(
                    'SELECT COUNT(*) FROM {{%auth_item_child}} WHERE parent = :parent AND child = :child',
                    [':parent' => $role, ':child' => $route]
                )->queryScalar();

                if (!$childExists) {
                    $db->createCommand()->insert('{{%auth_item_child}}', [
                        'parent' => $role,
                        'child' => $route,
                    ])->execute();
                }
            }
        }

        $this->stdout("RBAC     : route /standar-pelayanan/* terdaftar untuk admin & superadmin\n");
    }
}
