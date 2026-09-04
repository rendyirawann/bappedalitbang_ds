<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Galeri $model */

$this->title = 'Create Galeri';
$this->params['breadcrumbs'][] = ['label' => 'Galeris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="galeri-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
