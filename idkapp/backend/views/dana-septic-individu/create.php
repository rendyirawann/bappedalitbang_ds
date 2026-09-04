<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\DanaSepticIndividu $model */

$this->title = 'Create Dana Septic Individu';
$this->params['breadcrumbs'][] = ['label' => 'Dana Septic Individus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dana-septic-individu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
