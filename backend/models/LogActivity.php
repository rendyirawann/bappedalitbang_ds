<?php

namespace backend\models;

use Yii;

class LogActivity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'log_activity';
    }

    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['username', 'model'], 'string', 'max' => 255],
            [['action'], 'string', 'max' => 50],
            [['ip_address'], 'string', 'max' => 45],
        ];
    }
}