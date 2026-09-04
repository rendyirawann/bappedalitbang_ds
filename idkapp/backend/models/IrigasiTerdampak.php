<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "irigasi_terdampak".
 *
 * @property int $id
 * @property string|null $nomeklatur
 * @property int|null $kodeDesa
 * @property int|null $luasIrigasi
 * @property string|null $arealBaik
 * @property string|null $arealRusakRingan
 * @property string|null $arealRusakSedang
 * @property string|null $arealRusakBerat
 * @property string|null $total
 * @property int|null $kodeTahun
 */
class IrigasiTerdampak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'irigasi_terdampak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['luasIrigasi', 'kodeTahun'], 'integer'],
            [['kodeDesa'], 'string', 'max' => 150],
            [['nomeklatur', 'arealBaik', 'arealRusakRingan', 'arealRusakSedang', 'arealRusakBerat'], 'string', 'max' => 150],
            [['total'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomeklatur' => 'Nomeklatur',
            'kodeDesa' => 'Kode Desa',
            'luasIrigasi' => 'Luas Irigasi',
            'arealBaik' => 'Areal Baik',
            'arealRusakRingan' => 'Areal Rusak Ringan',
            'arealRusakSedang' => 'Areal Rusak Sedang',
            'arealRusakBerat' => 'Areal Rusak Berat',
            'total' => 'Total',
            'kodeTahun' => 'Kode Tahun',
        ];
    }
}
