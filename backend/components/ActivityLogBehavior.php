<?php

namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use backend\models\LogActivity;

class ActivityLogBehavior extends Behavior
{
    public $mainAttribute = 'id'; // Default attribute

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'logCreate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'logUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'logDelete',
        ];
    }

    public function logCreate($event)
    {
        $this->saveLog('CREATE', "Menambahkan data: " . $this->getDescription($event->sender));
    }

    public function logUpdate($event)
    {
        $this->saveLog('UPDATE', "Mengubah data: " . $this->getDescription($event->sender));
    }

    public function logDelete($event)
    {
        $this->saveLog('DELETE', "Menghapus data: " . $this->getDescription($event->sender));
    }

    protected function getDescription($model)
    {
        $attr = $this->mainAttribute;
        // Kalau atributnya ada isinya, ambil itu. Kalau kosong, ambil ID-nya aja.
        return isset($model->$attr) ? $model->$attr : '#' . $model->id;
    }

    protected function saveLog($action, $description)
    {
        $log = new LogActivity();
        $log->user_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
        $log->username = !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : 'System';
        $log->action = $action;
        $log->model = (new \ReflectionClass($this->owner))->getShortName(); 
        $log->description = $description;
        $log->ip_address = Yii::$app->request->userIP;
        $log->save();
    }
}