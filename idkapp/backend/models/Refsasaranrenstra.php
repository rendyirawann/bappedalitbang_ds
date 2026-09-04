<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "refsasaranrenstra".
 *
 * @property int $refsasaranrenstra_id
 * @property string|null $refskpd_id
 * @property int|null $refsasaran_id
 * @property string $reftujuanrenstra_id
 * @property string|null $refsasaranrenstra_uraian
 * @property string|null $enable
 */
class Refsasaranrenstra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'refsasaranrenstra';
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
            [['refsasaran_id'], 'integer'],
            [['reftujuanrenstra_id'], 'required'],
            [['refsasaranrenstra_uraian', 'enable'], 'string'],
            [['refskpd_id'], 'string', 'max' => 50],
            [['reftujuanrenstra_id'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'refsasaranrenstra_id' => 'Refsasaranrenstra ID',
            'refskpd_id' => 'Refskpd ID',
            'refsasaran_id' => 'Refsasaran ID',
            'reftujuanrenstra_id' => 'Reftujuanrenstra ID',
            'refsasaranrenstra_uraian' => 'Refsasaranrenstra Uraian',
            'enable' => 'Enable',
        ];
    }
}
