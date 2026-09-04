<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Tahapan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tahapan-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'judul_tahapan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahun')->textInput(['type' => 'number', 'value' => $model->isNewRecord ? date('Y') : $model->tahun]) ?>

    <hr>
    <h4>Daftar Tahapan (Repeater)</h4>
    <div id="tahapan-repeater">
        <?php
        $items = $model->isNewRecord ? [new \common\models\TahapanItem()] : $model->tahapanItems;
        foreach ($items as $index => $item):
        ?>
        <div class="tahapan-item-row card mb-3">
            <div class="card-body">
                <button type="button" class="btn btn-danger btn-sm float-right btn-remove-row"><i class="fa fa-times"></i> Hapus</button>
                <div class="row">
                    <?= Html::hiddenInput("TahapanItem[$index][id]", $item->id) ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Tahapan</label>
                            <?= Html::textInput("TahapanItem[$index][nama_tahapan]", $item->nama_tahapan, ['class' => 'form-control', 'required' => true]) ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Urutan</label>
                            <?= Html::textInput("TahapanItem[$index][urutan]", $item->urutan ?: $index + 1, ['class' => 'form-control input-urutan', 'type' => 'number']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Waktu / Tanggal</label>
                            <?= Html::textInput("TahapanItem[$index][tanggal]", $item->tanggal, ['class' => 'form-control', 'placeholder' => 'Contoh: 12 s/d 13 Februari 2025']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mt-2">
                            <label>File Icon (Image)</label>
                            <?= Html::fileInput("TahapanItem[$index][fileImage]", null, ['class' => 'form-control']) ?>
                            <?php if ($item->icon_gambar): ?>
                                <div class="mt-2">
                                    <small class="d-block text-muted mb-1">Preview Icon Saat Ini:</small>
                                    <a href="<?= Yii::getAlias('@web/../../frontend/web/uploads/tahapan/') . $item->icon_gambar ?>" target="_blank">
                                        <img src="<?= Yii::getAlias('@web/../../frontend/web/uploads/tahapan/') . $item->icon_gambar ?>" alt="Icon" style="height: 60px; max-width: 100px; object-fit: contain; border-radius: 5px; border: 1px solid #ddd; padding: 2px; background: #fff;">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mt-2">
                            <label>File Dokumen</label>
                            <?= Html::fileInput("TahapanItem[$index][fileDocument]", null, ['class' => 'form-control']) ?>
                            <?php if ($item->dokumen): ?>
                                <div class="mt-2 p-2" style="background:#f8f9fa; border-radius:5px; border:1px solid #eee;">
                                    <small class="d-block text-muted mb-1">Dokumen Saat Ini:</small>
                                    <a href="<?= Yii::getAlias('@web/../../frontend/web/uploads/tahapan/') . $item->dokumen ?>" target="_blank" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-file-alt"></i> Buka / Lihat File
                                    </a>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="TahapanItem[<?= $index ?>][removeDocument]" value="1" id="removeDoc_<?= $index ?>">
                                    <label class="form-check-label text-danger" for="removeDoc_<?= $index ?>">
                                        <small><i class="fas fa-trash"></i> Hapus file dokumen saat ini</small>
                                    </label>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="btn btn-info btn-add-row"><i class="fa fa-plus"></i> Tambah Tahapan</button>

    <div class="form-group mt-4">
        <?= Html::submitButton('Simpan Semua', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$count = count($items);
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var itemIndex = <?= $count ?>;

    document.querySelector('.btn-add-row').addEventListener('click', function() {
        var template = `
        <div class="tahapan-item-row card mb-3">
            <div class="card-body">
                <button type="button" class="btn btn-danger btn-sm float-right btn-remove-row"><i class="fa fa-times"></i> Hapus</button>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Tahapan</label>
                            <input type="text" name="TahapanItem[${itemIndex}][nama_tahapan]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="TahapanItem[${itemIndex}][urutan]" class="form-control input-urutan" value="${itemIndex + 1}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Waktu / Tanggal</label>
                            <input type="text" name="TahapanItem[${itemIndex}][tanggal]" class="form-control" placeholder="Contoh: 12 s/d 13 Februari 2025">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>File Icon (Image)</label>
                            <input type="file" name="TahapanItem[${itemIndex}][fileImage]" class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <label>File Dokumen</label>
                            <input type="file" name="TahapanItem[${itemIndex}][fileDocument]" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        
        var repeater = document.getElementById('tahapan-repeater');
        repeater.insertAdjacentHTML('beforeend', template);
        itemIndex++;
        updateUrutan();
    });

    document.addEventListener('click', function(e) {
        if (e.target && (e.target.matches('.btn-remove-row') || e.target.closest('.btn-remove-row'))) {
            var rows = document.querySelectorAll('.tahapan-item-row');
            if (rows.length > 1) {
                var btn = e.target.closest('.btn-remove-row');
                btn.closest('.tahapan-item-row').remove();
                updateUrutan();
            } else {
                alert("Minimal harus ada satu tahapan.");
            }
        }
    });

    function updateUrutan() {
        var inputs = document.querySelectorAll('.input-urutan');
        inputs.forEach(function(input, index) {
            input.value = index + 1;
        });
    }
});
</script>
