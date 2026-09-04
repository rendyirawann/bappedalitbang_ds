<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Login';

$this->registerJs("
    $(document).on('submit', 'form#login-overlay', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });
");
?>

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

<div class="loading-overlay" id="loading-overlay"></div>
<div id="preloader">
    <div data-loader="circle-side"></div>
</div>
<div id="login">
    <aside>
        <figure>
            <a href="<?= Url::to(['/site/index']) ?>"><img src="<?= Url::base(true)?>/udema/bappeda/bappeda.png" alt="logo Deli Serdang" width="36"></a>
        </figure>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form', // Menggunakan ID yang lebih standar
            'options' => ['autocomplete' => 'off'], // Matikan autocomplete di level form
            'fieldConfig' => [
                'template' => "<span class=\"input\">{input}{label}</span>\n{error}",
                'labelOptions' => ['class' => 'input_label'],
                'inputOptions' => ['class' => 'input_field'],
            ],
        ]); ?>

            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger">
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php // CSRF token sudah otomatis ditambahkan oleh ActiveForm::begin() ?>

            <?= $form->field($model, 'username', [
                // Kustomisasi template jika diperlukan
                'template' => '<span class="input">{input}<label class="input_label"><span class="input__label-content">Username</span></label></span>{error}'
            ])->textInput(['autocomplete' => 'off']) ?>

            <?= $form->field($model, 'password', [
                // Kustomisasi template agar sesuai dengan struktur Anda
                'template' => '<span class="input">{input}<label class="input_label"><span class="input__label-content">Password</span></label></span>{error}'
            ])->passwordInput(['id' => 'password-input', 'autocomplete' => 'new-password']) ?>
            
            <div class="form-check mt-2">
                <input type="checkbox" class="form-check-input" id="show-password" onclick="togglePassword()">
                <label class="form-check-label" for="show-password">Show Password</label>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn_1 rounded full-width add_top_60']) ?>
            </div>

        <?php ActiveForm::end(); ?>

        <div class="copy">Copyright &copy; 2024 Bappedalitbang Deli Serdang</div>
    </aside>
</div>