<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Tahapan;

class TahapanController extends Controller
{
    public function actionIndex()
    {
        $tahapanList = Tahapan::find()->orderBy(['tahun' => SORT_DESC, 'id' => SORT_DESC])->all();

        return $this->render('index', [
            'tahapanList' => $tahapanList,
        ]);
    }

    public function actionView($id)
    {
        $model = Tahapan::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
