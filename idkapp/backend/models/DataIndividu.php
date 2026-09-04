<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_individu".
 *
 * @property int $id
 * @property string|null $ref_kegiatan
 * @property string|null $ref_subkegiatan
 * @property string|null $kodeRekening
 * @property string|null $namaKegiatan
 * @property string|null $kodeDesa
 * @property string|null $kodeKecamatan
 * @property string|null $alamat
 * @property string|null $satuan
 * @property int|null $jumlah
 * @property int|null $harga
 * @property string|null $kodeDana
 */
class DataIndividu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_individu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaKegiatan'], 'string'],
            [['jumlah', 'harga', 'kodeTahun'], 'integer'],
            [['koderef_kegiatan', 'ref_kegiatan', 'koderef_subkegiatan', 'ref_subkegiatan', 'kodeRekening', 'kodeDesa', 'kodeKecamatan', 'alamat', 'satuan', 'kodeDana'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'koderef_kegiatan' => 'Kode Kegiatan',
            'ref_kegiatan' => 'Ref Kegiatan',
            'koderef_subkegiatan' => 'Kode Sub Kegiatan',
            'ref_subkegiatan' => 'Ref Subkegiatan',
            'kodeRekening' => 'Kode Rekening',
            'namaKegiatan' => 'Nama Kegiatan',
            'kodeDesa' => 'Kode Desa',
            'kodeKecamatan' => 'Kode Kecamatan',
            'alamat' => 'Alamat',
            'satuan' => 'Satuan',
            'jumlah' => 'Jumlah',
            'harga' => 'Harga',
            'kodeDana' => 'Kode Dana',
            'kodeTahun' => 'Tahun',
        ];
    }

    public function getKodeTahun0()
    {
        return $this->hasOne(TahunSepticTankIndividu::class, ['tahun' => 'kodeTahun']);
    }


    /**
     * Gets query for [[KodeDana0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeDana0()
    {
        return $this->hasOne(DanaSepticIndividu::class, ['sumberDana' => 'kodeDana']);
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

    /**
     * Gets query for [[KodeDesa0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeDesa0()
    {
        return $this->hasOne(DataDesa::class, ['namaDesa' => 'KodeDesa']);
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
