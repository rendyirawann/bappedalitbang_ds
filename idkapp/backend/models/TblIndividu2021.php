<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_individu2021".
 *
 * @property int $id
 * @property int|null $no
 * @property string|null $namaKegiatan
 * @property string|null $desa
 * @property string|null $keterangan
 * @property string|null $uraian
 * @property string|null $target
 * @property string|null $capaian
 */
class TblIndividu2021 extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_individu2021';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no'], 'integer'],
            [['namaKegiatan', 'desa', 'keterangan'], 'string'],
            [['uraian', 'target', 'capaian'], 'string', 'max' => 255],
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
            'keterangan' => 'Keterangan',
            'uraian' => 'Uraian',
            'target' => 'Target',
            'capaian' => 'Capaian',
        ];
    }
}
