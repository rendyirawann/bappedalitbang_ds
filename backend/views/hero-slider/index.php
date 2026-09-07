<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Banner Halaman Depan';
$this->params['breadcrumbs'][] = $this->title;

$daftar = $dataProvider->getModels();
?>
<div class="content-wrapper">
  <div class="container-fluid">

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Banner Halaman Depan</li>
    </ol>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-image"></i> Banner Slider Halaman Depan
      </div>
      <div class="card-body">

        <?php if (Yii::$app->session->hasFlash('success')): ?>
          <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('error')): ?>
          <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error') ?></div>
        <?php endif; ?>

        <div class="alert alert-info">
          <strong>Cukup unggah gambarnya.</strong> Ukuran diatur otomatis menjadi
          2400 &times; 1200 piksel supaya banner mengisi penuh layar tanpa ter-zoom
          atau terpotong tidak beraturan.
          <br>
          Agar hasilnya paling rapi, siapkan gambar dengan perbandingan
          <strong>2 : 1</strong> (misalnya 2400 &times; 1200 atau 1600 &times; 800).
          Gambar dengan perbandingan lain akan diambil bagian tengahnya, jadi jangan
          menaruh tulisan atau wajah terlalu mepet ke tepi atas dan bawah.
        </div>

        <p>
          <?= Html::a('Tambah Banner', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="width:70px;">Urutan</th>
                <th style="width:260px;">Gambar</th>
                <th>Teks di Atas Gambar</th>
                <th style="width:110px;">Status</th>
                <th style="width:230px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
            <?php if (empty($daftar)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted">
                  Belum ada banner. Halaman depan akan tampil tanpa slider sampai
                  banner pertama ditambahkan.
                </td>
              </tr>
            <?php endif; ?>

            <?php foreach ($daftar as $slide): ?>
              <tr>
                <td class="text-center align-middle"><?= Html::encode($slide->urutan) ?></td>

                <td class="align-middle">
                  <img src="<?= Html::encode($slide->urlGambarBackend()) ?>"
                       alt="<?= Html::encode($slide->judul ?: 'Banner') ?>"
                       style="width:100%; max-width:240px; height:auto; border:1px solid #dee2e6; border-radius:3px;">
                </td>

                <td class="align-middle">
                  <?php if ($slide->punyaTeks()): ?>
                    <strong><?= Html::encode($slide->judul) ?></strong>
                    <?php if (!empty($slide->subjudul)): ?>
                      <br><small class="text-muted"><?= Html::encode(StringHelper::truncate($slide->subjudul, 120)) ?></small>
                    <?php endif; ?>
                    <?php if ($slide->punyaTombol()): ?>
                      <br><span class="badge badge-primary"><?= Html::encode($slide->teks_tombol) ?></span>
                      <small class="text-muted"><?= Html::encode($slide->url_tombol) ?></small>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-muted">
                      Tanpa teks &mdash; tulisan sudah menyatu di dalam gambar
                    </span>
                  <?php endif; ?>
                </td>

                <td class="text-center align-middle">
                  <?php if ($slide->aktif): ?>
                    <span class="badge badge-success">Tampil</span>
                  <?php else: ?>
                    <span class="badge badge-secondary">Disembunyikan</span>
                  <?php endif; ?>
                </td>

                <td class="align-middle">
                  <?= Html::a('Ubah', ['update', 'id' => $slide->id], ['class' => 'btn btn-sm btn-primary']) ?>

                  <?= Html::a($slide->aktif ? 'Sembunyikan' : 'Tampilkan',
                        ['toggle', 'id' => $slide->id],
                        [
                          'class' => 'btn btn-sm ' . ($slide->aktif ? 'btn-warning' : 'btn-info'),
                          'data' => [
                            'method' => 'post',
                            'params' => [Yii::$app->request->csrfParam => Yii::$app->request->csrfToken],
                          ],
                        ]) ?>

                  <?= Html::a('Hapus', ['delete', 'id' => $slide->id],
                        [
                          'class' => 'btn btn-sm btn-danger',
                          'data' => [
                            'confirm' => 'Hapus banner ini beserta berkas gambarnya? Tindakan ini tidak bisa dibatalkan.',
                            'method' => 'post',
                            'params' => [Yii::$app->request->csrfParam => Yii::$app->request->csrfToken],
                          ],
                        ]) ?>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <p class="text-muted mb-0">
          Urutan kecil tampil lebih dulu. Banner yang disembunyikan tetap tersimpan
          dan bisa ditampilkan lagi kapan saja tanpa perlu diunggah ulang.
        </p>

      </div>
    </div>
  </div>
</div>
