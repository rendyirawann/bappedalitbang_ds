<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "irigasi_saluran".
 *
 * @property int $id
 * @property string|null $nomeklatur
 * @property string|null $kodeDesa
 * @property int|null $luasIrigasi
 * @property int|null $igt
 * @property string|null $primerKondisiBaik
 * @property string|null $primerSaluranStatus
 * @property string|null $primerPjgSaluran
 * @property string|null $primerSaluranBaik
 * @property string|null $sekunderKondisiBaik
 * @property string|null $sekunderSaluranStatus
 * @property string|null $sekunderPjgSaluran
 * @property string|null $sekunderSaluranBaik
 * @property string|null $pembuangKondisiBaik
 * @property string|null $pembuangSaluranStatus
 * @property string|null $bangunanBagiKondisiBaik
 * @property string|null $bangunanBagiStatus
 * @property string|null $bangunanBagiSadapKondisiBaik
 * @property string|null $bangunanBagiSadapStatus
 * @property string|null $bangunanSadapKondisiBaik
 * @property string|null $bangunanSadapStatus
 * @property string|null $bangunanPintuAirKondisiBaik
 * @property string|null $bangunanPintuAirStatus
 * @property string|null $bangunanTalangKondisiBaik
 * @property string|null $bangunanTalangStatus
 * @property string|null $bangunanSiponKondisiBaik
 * @property string|null $bangunanSiponStatus
 * @property string|null $bangunanGorongKondisiBaik
 * @property string|null $bangunanGorongStatus
 * @property string|null $bangunanTerjunKondisiBaik
 * @property string|null $bangunanTerjunStatus
 * @property string|null $bangunanTanggulKondisiBaik
 * @property string|null $bangunanTanggulStatus
 * @property string|null $rataJaringanKondisiBaik
 * @property string|null $rataJaringanStatus
 * @property string|null $arealBaik
 * @property string|null $arealRusakRingan
 * @property string|null $arealRusakSedang
 * @property string|null $arealRusakBerat
 * @property string|null $arealTotal
 * @property string|null $indeksPrasaranaFisik
 * @property string|null $indeksProduktivitas
 * @property string|null $indeksSaranaPenunjang
 * @property string|null $indeksOrganisasiPersonalia
 * @property string|null $indeksDokumentasi
 * @property string|null $indeksPpa
 * @property string|null $indeksJumlah
 * @property string|null $indeksKategori
 * @property string|null $keterangan
 * @property int|null $kodeTahun
 */
class IrigasiSaluran extends \yii\db\ActiveRecord
{
    public $pembagiRataKondisi;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'irigasi_saluran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['luasIrigasi', 'kodeTahun'], 'integer'],
            [['igt', 'primerSaluranStatus', 'sekunderSaluranStatus', 'pembuangSaluranStatus', 'bangunanBagiStatus', 'bangunanBagiSadapStatus', 'bangunanSadapStatus', 'bangunanPintuAirStatus', 'bangunanTalangStatus', 'bangunanSiponStatus', 'bangunanGorongStatus', 'bangunanTerjunStatus', 'bangunanTanggulStatus', 'rataJaringanStatus', 'indeksKategori', 'keterangan'], 'string'],
            [['nomeklatur'], 'string', 'max' => 100],
            [['kodeDesa'], 'string', 'max' => 25],
            [['primerKondisiBaik', 'primerPjgSaluran', 'primerSaluranBaik', 'sekunderKondisiBaik', 'sekunderPjgSaluran', 'sekunderSaluranBaik', 'pembuangKondisiBaik', 'bangunanBagiKondisiBaik', 'bangunanBagiSadapKondisiBaik', 'bangunanSadapKondisiBaik', 'bangunanPintuAirKondisiBaik', 'bangunanTalangKondisiBaik', 'bangunanSiponKondisiBaik', 'bangunanGorongKondisiBaik', 'bangunanTerjunKondisiBaik', 'bangunanTanggulKondisiBaik', 'rataJaringanKondisiBaik', 'arealBaik', 'arealRusakRingan', 'arealRusakSedang', 'arealRusakBerat', 'arealTotal', 'indeksPrasaranaFisik', 'indeksProduktivitas', 'indeksSaranaPenunjang', 'indeksOrganisasiPersonalia', 'indeksDokumentasi', 'indeksPpa', 'indeksJumlah'], 'string', 'max' => 75],
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
            'igt' => 'Sawah/Fungsional(Pemetaan IGT) (Ha)',
            'primerKondisiBaik' => 'Primer Kondisi Baik',
            'primerSaluranStatus' => 'Primer Saluran Status',
            'primerPjgSaluran' => 'Primer Pjg Saluran',
            'primerSaluranBaik' => 'Primer Saluran Baik',
            'sekunderKondisiBaik' => 'Sekunder Kondisi Baik',
            'sekunderSaluranStatus' => 'Sekunder Saluran Status',
            'sekunderPjgSaluran' => 'Sekunder Pjg Saluran',
            'sekunderSaluranBaik' => 'Sekunder Saluran Baik',
            'pembuangKondisiBaik' => 'Pembuang Kondisi Baik',
            'pembuangSaluranStatus' => 'Pembuang Saluran Status',
            'bangunanBagiKondisiBaik' => 'Bangunan Bagi Kondisi Baik',
            'bangunanBagiStatus' => 'Bangunan Bagi Status',
            'bangunanBagiSadapKondisiBaik' => 'Bangunan Bagi Sadap Kondisi Baik',
            'bangunanBagiSadapStatus' => 'Bangunan Bagi Sadap Status',
            'bangunanSadapKondisiBaik' => 'Bangunan Sadap Kondisi Baik',
            'bangunanSadapStatus' => 'Bangunan Sadap Status',
            'bangunanPintuAirKondisiBaik' => 'Bangunan Pintu Air Kondisi Baik',
            'bangunanPintuAirStatus' => 'Bangunan Pintu Air Status',
            'bangunanTalangKondisiBaik' => 'Bangunan Talang Kondisi Baik',
            'bangunanTalangStatus' => 'Bangunan Talang Status',
            'bangunanSiponKondisiBaik' => 'Bangunan Sipon Kondisi Baik',
            'bangunanSiponStatus' => 'Bangunan Sipon Status',
            'bangunanGorongKondisiBaik' => 'Bangunan Gorong Kondisi Baik',
            'bangunanGorongStatus' => 'Bangunan Gorong Status',
            'bangunanTerjunKondisiBaik' => 'Bangunan Terjun Kondisi Baik',
            'bangunanTerjunStatus' => 'Bangunan Terjun Status',
            'bangunanTanggulKondisiBaik' => 'Bangunan Tanggul Kondisi Baik',
            'bangunanTanggulStatus' => 'Bangunan Tanggul Status',
            'rataJaringanKondisiBaik' => 'Rata Jaringan Kondisi Baik',
            'rataJaringanStatus' => 'Rata Jaringan Status',
            'arealBaik' => 'Areal Baik',
            'arealRusakRingan' => 'Areal Rusak Ringan',
            'arealRusakSedang' => 'Areal Rusak Sedang',
            'arealRusakBerat' => 'Areal Rusak Berat',
            'arealTotal' => 'Areal Total',
            'indeksPrasaranaFisik' => 'Indeks Prasarana Fisik',
            'indeksProduktivitas' => 'Indeks Produktivitas',
            'indeksSaranaPenunjang' => 'Indeks Sarana Penunjang',
            'indeksOrganisasiPersonalia' => 'Indeks Organisasi Personalia',
            'indeksDokumentasi' => 'Indeks Dokumentasi',
            'indeksPpa' => 'Indeks Ppa',
            'indeksJumlah' => 'Indeks Jumlah',
            'indeksKategori' => 'Indeks Kategori',
            'keterangan' => 'Keterangan',
            'kodeTahun' => 'Kode Tahun',
        ];
    }

    public function getKodeTahun0()
    {
        return $this->hasOne(TahunIrigasi::class, ['tahun' => 'tahun']);
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
}
