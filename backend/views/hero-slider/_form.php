<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\HeroSlider $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <div class="form-group">
    <?= $form->field($model, 'berkas')->fileInput(['accept' => 'image/jpeg,image/png,image/webp'])
        ->hint('Format JPG, PNG, atau WebP. Maksimal 20 MB. '
             . 'Ukuran akan disesuaikan otomatis menjadi 2400 &times; 1200 piksel, '
             . 'jadi tidak perlu diubah manual dulu.'
             . ($model->isNewRecord ? '' : ' Kosongkan bila gambarnya tidak diganti.')) ?>
  </div>

  <?php if (!$model->isNewRecord && !empty($model->gambar)): ?>
    <div class="form-group">
      <label>Gambar saat ini</label><br>
      <img src="<?= Html::encode($model->urlGambarBackend()) ?>"
           alt="Banner saat ini"
           style="width:100%; max-width:520px; height:auto; border:1px solid #dee2e6; border-radius:3px;">
    </div>
  <?php endif; ?>

  <hr>

  <p class="text-muted">
    Bagian di bawah ini <strong>opsional</strong>. Isi hanya bila tulisan perlu
    ditampilkan sebagai lapisan di atas gambar, seperti pada banner eSakip
    SIMONALISA. Bila banner sudah memuat tulisannya sendiri di dalam gambar
    &mdash; seperti banner Bupati &mdash; biarkan kosong saja.
  </p>

  <?= $form->field($model, 'judul')->textInput(['maxlength' => true])
      ->hint('Teks besar di tengah banner. Kosongkan bila tidak perlu.') ?>

  <?= $form->field($model, 'subjudul')->textarea(['rows' => 3])
      ->hint('Keterangan singkat di bawah judul.') ?>

  <div class="row">
    <div class="col-md-4">
      <?= $form->field($model, 'teks_tombol')->textInput(['maxlength' => true, 'placeholder' => 'Explore'])
          ->hint('Kosongkan bila tanpa tombol.') ?>
    </div>
    <div class="col-md-8">
      <?= $form->field($model, 'url_tombol')->textInput([
            'maxlength' => true,
            'placeholder' => 'https://esakipsimonalisa.deliserdangkab.go.id/',
          ])->hint('Wajib diisi bila tombol diberi tulisan.') ?>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-4">
      <?= $form->field($model, 'urutan')->input('number', ['min' => 0, 'max' => 9999])
          ->hint('Angka lebih kecil tampil lebih dulu.') ?>
    </div>
    <div class="col-md-8">
      <?= $form->field($model, 'aktif')->checkbox()
          ->hint('Hapus centang untuk menyembunyikan banner tanpa menghapusnya.') ?>
    </div>
  </div>

  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Simpan Banner' : 'Simpan Perubahan',
        ['class' => 'btn btn-success']) ?>
    <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
  </div>

<?php ActiveForm::end(); ?>
