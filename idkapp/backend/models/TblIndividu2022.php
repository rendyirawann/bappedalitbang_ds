<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_individu2022".
 *
 * @property int $id
 * @property int|null $no
 * @property string|null $namaKegiatan
 * @property string|null $desa
 * @property string|null $kecamatan
 * @property int|null $jumlah
 * @property string|null $anggaran
 * @property string|null $keterangan
 */
class TblIndividu2022 extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_individu2022';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no', 'jumlah'], 'integer'],
            [['namaKegiatan', 'desa', 'kecamatan', 'anggaran', 'keterangan'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 10], // Ukuran maksimum 10 MB per file
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no' => 'No',
            'namaKegiatan' => 'Nama Kegiatan',
            'desa' => 'Desa',
            'kecamatan' => 'Kecamatan',
            'jumlah' => 'Jumlah',
            'anggaran' => 'Anggaran',
            'keterangan' => 'Keterangan',
        ];
    }
}
