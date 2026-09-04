<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "target_indikator_sasaran".
 *
 * @property int $indikator_id
 * @property int $cascadingrenstrasasaran_id
 * @property int|null $refsasaranrenstra_id
 * @property string|null $refskpd_id
 * @property int $tahun_id
 * @property string|null $target
 * @property string|null $target_rkt_p
 * @property string|null $sebab_rkt_p
 * @property string|null $target_pk
 * @property string|null $sebab_pk
 * @property string $target_pk_p
 * @property string|null $sebab_pk_p
 * @property string $realisasi
 * @property string $capaian
 * @property string|null $keterangan
 * @property string|null $analisis
 * @property string|null $analisis_date
 * @property string|null $analisis_usr
 * @property float|null $test
 */
class TargetIndikatorSasaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'target_indikator_sasaran';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cascadingrenstrasasaran_id', 'tahun_id', 'target_pk_p', 'realisasi', 'capaian'], 'required'],
            [['cascadingrenstrasasaran_id', 'refsasaranrenstra_id', 'tahun_id'], 'integer'],
            [['sebab_rkt_p', 'sebab_pk', 'sebab_pk_p', 'keterangan', 'analisis'], 'string'],
            [['analisis_date'], 'safe'],
            [['test'], 'number'],
            [['refskpd_id'], 'string', 'max' => 40],
            [['target', 'target_rkt_p', 'target_pk', 'target_pk_p', 'realisasi', 'capaian'], 'string', 'max' => 30],
            [['analisis_usr'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'indikator_id' => 'Indikator ID',
            'cascadingrenstrasasaran_id' => 'Cascadingrenstrasasaran ID',
            'refsasaranrenstra_id' => 'Refsasaranrenstra ID',
            'refskpd_id' => 'Refskpd ID',
            'tahun_id' => 'Tahun ID',
            'target' => 'Target',
            'target_rkt_p' => 'Target Rkt P',
            'sebab_rkt_p' => 'Sebab Rkt P',
            'target_pk' => 'Target Pk',
            'sebab_pk' => 'Sebab Pk',
            'target_pk_p' => 'Target Pk P',
            'sebab_pk_p' => 'Sebab Pk P',
            'realisasi' => 'Realisasi',
            'capaian' => 'Capaian',
            'keterangan' => 'Keterangan',
            'analisis' => 'Analisis',
            'analisis_date' => 'Analisis Date',
            'analisis_usr' => 'Analisis Usr',
            'test' => 'Test',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->target_pk_p != 0) {
                $this->capaian = ($this->realisasi / $this->target_pk_p) * 100;
            } else {
                $this->capaian = 0;
            }
            return true;
        } else {
            return false;
        }
    }
}
