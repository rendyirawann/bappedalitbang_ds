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

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Berita;
use backend\models\Bidang;

/** @var yii\web\View $this */
/** @var backend\models\Berita $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJs("
    $(document).on('beforeSubmit', 'form#berita', function(){
        $('#loading-overlay').show();
    });

    $(document).on('ajaxComplete', function(){
        $('#loading-overlay').hide();
    });

");
?>

<div class="loading-overlay" id="loading-overlay"></div>

<div class="berita-form">

    <?php $form = ActiveForm::begin([
            'id' => 'berita',
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>
        
          <?php
                    $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
                    if (isset($assignments['superadmin']) || isset($assignments['admin']) || isset($assignments['operator'])) {
                      ?>

    <?= $form->field($model, 'file_doc')->fileInput()->label('Upload Gambar Berita')->hint('Maksimal Ukuran File Upload per Gambar: 10MB') ?>

    <?= $form->field($model, 'judulBerita')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'isiBerita')->widget(CKEditor::className(), [
    'options' => ['rows' => 5],
    'preset' => 'full',
    'clientOptions' => [
        // Izinkan blockquote, script, iframe, DAN tag <a>
        'extraAllowedContent' => 'blockquote(instagram-media); script[src]; iframe[*]; a[*]',
    ],
]); ?>
    <?= $form->field($model, 'bidang_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(\backend\models\Bidang::find()->all(), 'id', 'bidang'),
    ['prompt' => 'Pilih Bidang Berita']
) ?>

    <?= $form->field($model, 'tgl_berita')->textInput(['type' => 'date']) ?>

    <?php } ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([0 => 'Review', 1 => 'Publish', 2 => 'Ditolak']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
