<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_kpspams".
 *
 * @property int $id
 * @property string|null $provinsi
 * @property string|null $kabupaten
 * @property string|null $kodeKecamatan
 * @property string|null $kodeDesa
 * @property string|null $namaKades
 * @property int|null $noKades
 * @property string|null $namaKpspams
 * @property int|null $noKpspams
 * @property int|null $kodeTahun
 */
class DataKpspams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_kpspams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provinsi', 'kabupaten', 'namaKades', 'namaKpspams'], 'string'],
            [['noKades', 'noKpspams', 'kodeTahun'], 'integer'],
            [['kodeKecamatan', 'kodeDesa'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'kodeKecamatan' => 'Kode Kecamatan',
            'kodeDesa' => 'Kode Desa',
            'namaKades' => 'Nama Kades',
            'noKades' => 'No Kades',
            'namaKpspams' => 'Nama Kpspams',
            'noKpspams' => 'No Kpspams',
            'kodeTahun' => 'Kode Tahun',
        ];
    }

    public function getKodeTahun0()
    {
        return $this->hasOne(TahunKpspams::class, ['tahun' => 'kodeTahun']);
    }

    /**
     * Gets query for [[KodeKecamatan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeKecamatan0()
    {
        return $this->hasOne(DataKecamatan::class, ['namaKecamatan' => 'kodeKecamatan']);
    }

    public function getDesa()
    {
        return $this->hasOne(DataDesa::class, ['namaDesa' => 'kodeDesa']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Konversi kodeKecamatan menjadi namaKecamatan
            $kecamatan = DataKecamatan::findOne(['kode' => $this->kodeKecamatan]);
            if ($kecamatan) {
                $this->kodeKecamatan = $kecamatan->namaKecamatan;
            }

            // Konversi kodeDesa menjadi namaDesa
            $desa = DataDesa::findOne(['kode' => $this->kodeDesa]);
            if ($desa) {
                $this->kodeDesa = $desa->namaDesa;
            }

            return true;
        } else {
            return false;
        }
    }
}
