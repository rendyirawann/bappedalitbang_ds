<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "reftujuanrenstra".
 *
 * @property int $reftujuanrenstra_id
 * @property int|null $refmisi_id
 * @property int|null $reftujuan_id
 * @property int|null $refsasaran_id
 * @property string|null $refskpd_id
 * @property string|null $reftujuanrenstra_uraian
 * @property int $status_tahun1
 * @property int $status_tahun2
 * @property int $status_tahun3
 * @property int $status_tahun4
 * @property int $status_tahun5
 * @property string|null $usr_create
 * @property string|null $date_create
 * @property string|null $reason_edit
 * @property string|null $usr_edit
 * @property string|null $date_edit
 * @property string $reason_delete
 * @property string $usr_delete
 * @property string|null $date_delete
 */
class Reftujuanrenstra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reftujuanrenstra';
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
            [['refmisi_id', 'reftujuan_id', 'refsasaran_id', 'status_tahun1', 'status_tahun2', 'status_tahun3', 'status_tahun4', 'status_tahun5'], 'integer'],
            [['reftujuanrenstra_uraian', 'reason_edit', 'reason_delete'], 'string'],
            [['status_tahun1', 'status_tahun2', 'status_tahun3', 'status_tahun4', 'status_tahun5', 'reason_delete', 'usr_delete'], 'required'],
            [['date_create', 'date_edit', 'date_delete'], 'safe'],
            [['refskpd_id'], 'string', 'max' => 30],
            [['usr_create', 'usr_edit', 'usr_delete'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reftujuanrenstra_id' => 'Reftujuanrenstra ID',
            'refmisi_id' => 'Refmisi ID',
            'reftujuan_id' => 'Reftujuan ID',
            'refsasaran_id' => 'Refsasaran ID',
            'refskpd_id' => 'Refskpd ID',
            'reftujuanrenstra_uraian' => 'Reftujuanrenstra Uraian',
            'status_tahun1' => 'Status Tahun1',
            'status_tahun2' => 'Status Tahun2',
            'status_tahun3' => 'Status Tahun3',
            'status_tahun4' => 'Status Tahun4',
            'status_tahun5' => 'Status Tahun5',
            'usr_create' => 'Usr Create',
            'date_create' => 'Date Create',
            'reason_edit' => 'Reason Edit',
            'usr_edit' => 'Usr Edit',
            'date_edit' => 'Date Edit',
            'reason_delete' => 'Reason Delete',
            'usr_delete' => 'Usr Delete',
            'date_delete' => 'Date Delete',
        ];
    }
}
