<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sakip_sasaranrenstra".
 *
 * @property int $refsasaranrenstra_id
 * @property string $uraian_sasaranrenstra
 * @property int|null $refskpd_id
 * @property int|null $refsasaran_id
 * @property int|null $reftujuanrenstra_id
 * @property string|null $sasaranrenstra_isaktif
 */
class SakipSasaranrenstra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sakip_sasaranrenstra';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uraian_sasaranrenstra', 'refsasaran_id', 'refmisi_id', 'reftujuan_id', 'refvisi_id'], 'required'],
            [['uraian_sasaranrenstra', 'alasan_sasaranrenstra', 'formulasi_sasaranrenstra', 'kriteria_sasaranrenstra'], 'string'],
            [['refskpd_id', 'refperiode_id', 'refvisi_id', 'refmisi_id', 'refsasaran_id', 'reftujuanrenstra_id', 'reftujuan_id'], 'integer'],
            [['sasaranrenstra_isaktif'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'refsasaranrenstra_id' => 'Refsasaranrenstra ID',
            'uraian_sasaranrenstra' => 'Uraian Sasaranrenstra',
            'refskpd_id' => 'Refskpd ID',
            'refvisi_id' => 'Visi Terkait',
            'refmisi_id' => 'Misi Terkait',
            'reftujuan_id' => 'Tujuan Terkait',
            'refperiode_id' => 'Periode',
            'refsasaran_id' => 'Refsasaran ID',
            'reftujuanrenstra_id' => 'Reftujuanrenstra ID',
            'sasaranrenstra_isaktif' => 'Sasaranrenstra Isaktif',
            'alasan_sasaranrenstra' => 'Alasan Sasaranrenstra',
            'formulasi_sasaranrenstra' => 'Formulasi Sasaranrenstra',
            'kriteria_sasaranrenstra' => 'Kriteria Sasaranrenstra',
        ];
    }

    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    public function getRefPeriode()
    {
        return $this->hasOne(SakipPeriode::class, ['refperiode_id' => 'refperiode_id']);
    }

    public function getIndikators()
    {
        return $this->hasMany(SakipIndikatorsasaranrenstra::class, ['refsasaranrenstra_id' => 'refsasaranrenstra_id']);
    }

    public function getIndikatorSasaran()
    {
        return $this->hasMany(SakipIndikatorsasaranrenstra::class, ['refsasaranrenstra_id' => 'refsasaranrenstra_id']);
    }

    public function getRefIndikatorsasaranrenstra()
    {
        return $this->hasMany(SakipIndikatorsasaranrenstra::class, ['refsasaranrenstra_id' => 'refsasaranrenstra_id']);
    }
}
