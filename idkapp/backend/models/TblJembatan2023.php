<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_jembatan2023".
 *
 * @property int $id
 * @property int|null $no
 * @property string|null $namaPekerjaan
 * @property string|null $penyedia
 * @property string|null $nilaiPagu
 * @property string|null $nilaiKontrak
 * @property string|null $nilaiKontrakAdd
 * @property string|null $noSpmk
 * @property string|null $noKontrak
 * @property string|null $noKontrakAdd
 * @property string|null $noPho
 * @property string|null $realisasi_meter
 * @property string|null $keterangan
 */
class TblJembatan2023 extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_jembatan2023';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no'], 'integer'],
            [['namaPekerjaan', 'penyedia'], 'string'],
            [['nilaiPagu', 'nilaiKontrak', 'nilaiKontrakAdd', 'noSpmk', 'noKontrak', 'noKontrakAdd', 'noPho', 'realisasi_meter', 'keterangan'], 'string', 'max' => 255],
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
            'namaPekerjaan' => 'Nama Pekerjaan',
            'penyedia' => 'Penyedia',
            'nilaiPagu' => 'Nilai Pagu',
            'nilaiKontrak' => 'Nilai Kontrak',
            'nilaiKontrakAdd' => 'Nilai Kontrak Add',
            'noSpmk' => 'No Spmk',
            'noKontrak' => 'No Kontrak',
            'noKontrakAdd' => 'No Kontrak Add',
            'noPho' => 'No Pho',
            'realisasi_meter' => 'Realisasi Meter',
            'keterangan' => 'Keterangan',
        ];
    }
}
