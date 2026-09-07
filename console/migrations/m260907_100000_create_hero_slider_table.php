<?php

use yii\db\Migration;

/**
 * Tabel hero_slider - pengelolaan banner pada halaman depan.
 *
 * Sebelum ini setiap slide ditulis langsung di
 * frontend/views/site/index.php, sehingga menambah atau mengganti
 * banner harus lewat editor kode. Dengan tabel ini pengelolaan
 * dipindahkan ke backend.
 *
 * Kolom teks bersifat opsional. Bila judul dikosongkan, slide tampil
 * sebagai gambar polos - itulah yang dipakai dua banner Bupati dan
 * Website yang tulisannya sudah menyatu di dalam gambar. Slide seperti
 * eSakip yang tulisannya berupa lapisan di atas gambar tinggal mengisi
 * judul, subjudul, dan tombolnya.
 */
class m260907_100000_create_hero_slider_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%hero_slider}}', [
            'id'          => $this->primaryKey(),

            // Nama berkas gambar di web/uploads/hero/. Selalu hasil
            // pemrosesan otomatis: 2400x1200 (2:1), JPEG progresif.
            'gambar'      => $this->string(255)->notNull(),

            // Teks lapisan di atas gambar. Semuanya boleh kosong.
            'judul'       => $this->string(255)->null(),
            'subjudul'    => $this->text()->null(),
            'teks_tombol' => $this->string(100)->null(),
            'url_tombol'  => $this->string(255)->null(),

            'urutan'      => $this->integer()->notNull()->defaultValue(0),
            'aktif'       => $this->smallInteger()->notNull()->defaultValue(1),

            'created_at'  => $this->integer()->null(),
            'updated_at'  => $this->integer()->null(),
        ]);

        $this->createIndex('idx-hero_slider-aktif-urutan', '{{%hero_slider}}', ['aktif', 'urutan']);

        // Folder web/uploads/ tidak ikut ke repositori, sedangkan tiga
        // banner awal di bawah dirujuk oleh data yang disisipkan. Pada
        // pemasangan baru berkasnya disalin dulu dari udema/bappeda,
        // yang memang ikut ter-commit.
        $this->salinBannerAwal();

        // Pindahkan tiga slide yang sekarang tertulis di dalam kode,
        // supaya tampilan halaman depan tidak berubah sama sekali
        // setelah migrasi dijalankan.
        $waktu = time();
        $this->batchInsert('{{%hero_slider}}',
            ['gambar', 'judul', 'subjudul', 'teks_tombol', 'url_tombol', 'urutan', 'aktif', 'created_at', 'updated_at'],
            [
                ['hero-bupati-2025-2030.jpg', null, null, null, null, 1, 1, $waktu, $waktu],
                ['hero-kepala-bappedalitbang.jpg', null, null, null, null, 2, 1, $waktu, $waktu],
                [
                    'hero-esakip.jpg',
                    'Aplikasi eSakip SIMONALISA',
                    'Sistem Akuntabilitas Kinerja Instansi Pemerintah secara elektronik dan Monitoring Analisa',
                    'Explore',
                    'https://esakipsimonalisa.deliserdangkab.go.id/',
                    3, 1, $waktu, $waktu,
                ],
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%hero_slider}}');
    }

    /**
     * Menyalin tiga banner awal ke web/uploads/hero/ pada frontend dan
     * backend. Berkas yang sudah ada tidak ditimpa, jadi menjalankan
     * ulang migrasi ini tidak akan menghapus banner yang sudah dikelola
     * lewat backend.
     */
    private function salinBannerAwal()
    {
        $asal = \Yii::getAlias('@frontend/web/udema/bappeda');
        $berkas = [
            'hero-bupati-2025-2030.jpg',
            'hero-kepala-bappedalitbang.jpg',
            'hero-esakip.jpg',
        ];

        $tujuanDaftar = [
            \Yii::getAlias('@frontend/web/uploads/hero'),
            \Yii::getAlias('@backend/web/uploads/hero'),
        ];

        foreach ($tujuanDaftar as $tujuan) {
            if (!is_dir($tujuan)) {
                \yii\helpers\FileHelper::createDirectory($tujuan, 0775, true);
            }
            foreach ($berkas as $b) {
                $sumber = $asal . DIRECTORY_SEPARATOR . $b;
                $target = $tujuan . DIRECTORY_SEPARATOR . $b;
                if (is_file($sumber) && !is_file($target)) {
                    @copy($sumber, $target);
                }
            }
        }
    }
}
