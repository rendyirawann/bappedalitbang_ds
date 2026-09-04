<style>
    #loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Dark semi-transparent background */
        z-index: 9999; /* Make sure it's on top of everything */
    }

    /* Style the loading spinner (optional) */
    #loading-overlay:after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 40px;
        height: 40px;
        margin-top: -20px;
        margin-left: -20px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Bidang;
use backend\models\User;

/** @var yii\web\View $this */
/** @var \models\User $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJs("
    $(document).on('beforeSubmit', 'form#user', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

");
?>
<div class="loading-overlay" id="loading-overlay"></div>

<div class="user-form">

<?php $form = ActiveForm::begin([
                'id' => 'user',
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

    <!-- Hidden input for username -->
    <?= $form->field($model, 'username')->hiddenInput()->label(false) ?>

    <!-- Hidden input for email -->
    <?= $form->field($model, 'email')->hiddenInput()->label(false) ?>

    <!-- Hidden input for bidang_id -->
    <?= $form->field($model, 'bidang_id')->hiddenInput()->label(false) ?>

    <!-- Password input -->
    <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>

    <!-- Hidden input for created_at -->
    <?= $form->field($model, 'created_at')->hiddenInput(['value' => $model->created_at])->label(false) ?>

    <!-- Hidden input for updated_at -->
    <?= $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Ganti Password', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>



</div>
