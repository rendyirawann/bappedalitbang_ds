<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cascadingrenstrasasaran".
 *
 * @property int $cascadingrenstrasasaran_id
 * @property int|null $refsasaranrenstra_id
 * @property int|null $refsasaran_id
 * @property string|null $refskpd_id
 * @property string|null $refsasaran_indikator
 * @property string|null $alasan
 * @property string|null $formulasi
 * @property string|null $kriteria
 * @property string|null $sasaran_target_th5
 * @property string|null $sasaran_satuan_th5
 * @property string|null $sasaran_anggaran_th5
 * @property string|null $sasaran_target_th2
 * @property string|null $sasaran_satuan_th2
 * @property string|null $sasaran_anggaran_th2
 * @property string|null $sasaran_target_th3
 * @property string|null $sasaran_satuan_th3
 * @property string|null $sasaran_anggaran_th3
 * @property string|null $sasaran_target_th4
 * @property string|null $sasaran_satuan_th4
 * @property string|null $sasaran_anggaran_th4
 * @property string|null $sasaran_target_th1
 * @property string|null $sasaran_satuan_th1
 * @property string|null $sasaran_anggaran_th1
 * @property int $sasaran_iku
 * @property int $sasaran_pk
 * @property int $status_th5
 * @property int $status_th2
 * @property int $status_th3
 * @property int $status_th4
 * @property int $status_th1
 */
class Cascadingrenstrasasaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cascadingrenstrasasaran';
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
            [['refsasaranrenstra_id', 'refsasaran_id', 'sasaran_iku', 'sasaran_pk', 'status_th5', 'status_th2', 'status_th3', 'status_th4', 'status_th1'], 'integer'],
            [['refsasaran_indikator', 'alasan', 'formulasi', 'kriteria'], 'string'],
            [['sasaran_iku', 'sasaran_pk'], 'required'],
            [['refskpd_id'], 'string', 'max' => 40],
            [['sasaran_target_th5', 'sasaran_target_th2', 'sasaran_target_th3', 'sasaran_target_th4', 'sasaran_target_th1'], 'string', 'max' => 20],
            [['sasaran_satuan_th5', 'sasaran_anggaran_th5', 'sasaran_satuan_th2', 'sasaran_anggaran_th2', 'sasaran_satuan_th3', 'sasaran_anggaran_th3', 'sasaran_satuan_th4', 'sasaran_anggaran_th4', 'sasaran_satuan_th1', 'sasaran_anggaran_th1'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cascadingrenstrasasaran_id' => 'Cascadingrenstrasasaran ID',
            'refsasaranrenstra_id' => 'Refsasaranrenstra ID',
            'refsasaran_id' => 'Refsasaran ID',
            'refskpd_id' => 'Refskpd ID',
            'refsasaran_indikator' => 'Refsasaran Indikator',
            'alasan' => 'Alasan',
            'formulasi' => 'Formulasi',
            'kriteria' => 'Kriteria',
            'sasaran_target_th5' => 'Sasaran Target Th5',
            'sasaran_satuan_th5' => 'Sasaran Satuan Th5',
            'sasaran_anggaran_th5' => 'Sasaran Anggaran Th5',
            'sasaran_target_th2' => 'Sasaran Target Th2',
            'sasaran_satuan_th2' => 'Sasaran Satuan Th2',
            'sasaran_anggaran_th2' => 'Sasaran Anggaran Th2',
            'sasaran_target_th3' => 'Sasaran Target Th3',
            'sasaran_satuan_th3' => 'Sasaran Satuan Th3',
            'sasaran_anggaran_th3' => 'Sasaran Anggaran Th3',
            'sasaran_target_th4' => 'Sasaran Target Th4',
            'sasaran_satuan_th4' => 'Sasaran Satuan Th4',
            'sasaran_anggaran_th4' => 'Sasaran Anggaran Th4',
            'sasaran_target_th1' => 'Sasaran Target Th1',
            'sasaran_satuan_th1' => 'Sasaran Satuan Th1',
            'sasaran_anggaran_th1' => 'Sasaran Anggaran Th1',
            'sasaran_iku' => 'Sasaran Iku',
            'sasaran_pk' => 'Sasaran Pk',
            'status_th5' => 'Status Th5',
            'status_th2' => 'Status Th2',
            'status_th3' => 'Status Th3',
            'status_th4' => 'Status Th4',
            'status_th1' => 'Status Th1',
        ];
    }
}
