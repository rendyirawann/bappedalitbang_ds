<?php

use frontend\models\Unduhan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\search\UnduhanSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Bappedalitbang - Unduhan';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="hero_in" class="general">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span>UNDUHAN</h1>
        </div>
    </div>
</section>
<!--/hero_in-->

<div class="container margin_120_95">
    <div class="main_title_2 text-center mb-4">
        <span><em></em></span>
        <h2>Profil dan Dokumen Bappedalitbang</h2>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <button class="btn btn-outline-primary d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfile" aria-expanded="false">
                    <i class="bi bi-folder me-2 closed-icon"></i>
                    <i class="bi bi-folder2-open me-2 open-icon d-none"></i>
                    <span>Profil Bappedalitbang</span>
                </button>
            </div>
            <div class="collapse" id="collapseProfile">
                <div class="card border-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Profil Bappedalitbang</h5>
                        <p class="card-text">
                            Ini adalah isi profil Bappedalitbang. Anda dapat menyertakan visi, misi, struktur organisasi, dan penjelasan umum terkait peran dan fungsi lembaga ini.
                        </p>

                        <?php // AWAL BAGIAN PENAMBAHAN UNTUK MENAMPILKAN GAMBAR PROFIL 
                        ?>
                        <?php if (!empty($profils)): ?>
                            <hr> <?php // Pemisah visual 
                                    ?>
                            <h6 class="mt-3">Dokumentasi/Gambar Terkait Profil:</h6>
                            <div class="row mt-2">
                                <?php foreach ($profils as $profilItem): ?>
                                    <?php if (!empty($profilItem->file)): ?>
                                        <div class="col-lg-12 mb-3"> <?php // Setiap gambar dalam col-lg-12 
                                                                        ?>
                                            <div class="card shadow-sm">
                                                <?php if (!empty($profilItem->namaFile)): ?>
                                                    <div class="card-header bg-light">
                                                        <p class="card-title mb-0 fw-bold"><?= Html::encode($profilItem->namaFile) ?></p>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="card-body text-center p-2">
                                                    <img src="<?= Yii::getAlias('@web/uploads/profil/') . Html::encode($profilItem->file) ?>"
                                                        alt="<?= Html::encode(!empty($profilItem->namaFile) ? $profilItem->namaFile : 'Gambar Profil') ?>"
                                                        class="img-fluid rounded" style="max-height: 500px; width: auto; max-width: 100%;">
                                                    <?php if (!empty($profilItem->tanggalUpload)): ?>
                                                        <p class="card-text mt-2 mb-0">
                                                            <small class="text-muted">
                                                                Diupload pada: <?= Yii::$app->formatter->asDate($profilItem->tanggalUpload, 'long') ?>
                                                            </small>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="mt-3 fst-italic"><em>Tidak ada gambar profil yang tersedia untuk ditampilkan.</em></p>
                        <?php endif; ?>
                        <?php // AKHIR BAGIAN PENAMBAHAN 
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Row 2: Dokumen Pendukung -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <button class="btn btn-outline-secondary d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDokumen" aria-expanded="false">
                    <i class="bi bi-folder me-2 closed-icon"></i>
                    <i class="bi bi-folder2-open me-2 open-icon d-none"></i>
                    <span>Berkas Bappeda</span>
                </button>
            </div>
            <div class="collapse" id="collapseDokumen">
                <div class="card border-secondary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Berkas Unduhan per Bidang</h5>
                        <ul class="list-group list-group-flush">
                            <?php // Salin kode dari Poin 2 (Modifikasi View) ke sini 
                            ?>
                            <?php if (!empty($bidangs)): ?>
                                <?php foreach ($bidangs as $indexBidang => $bidang): ?>
                                    <li class="list-group-item py-3">
                                        <h6 class="mb-2 text-primary fw-bold"><?= Html::encode($bidang->bidang) ?></h6>
                                        <?php if (!empty($bidang->unduhans)): ?>
                                            <ul class="list-group list-group-flush ms-lg-3 ms-md-2 ms-1">
                                                <?php foreach ($bidang->unduhans as $indexUnduhan => $unduhan): ?>
                                                    <li class="list-group-item">
                                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                                            <a class="text-decoration-none d-block w-100" data-bs-toggle="collapse" href="#collapseUnduhan<?= $bidang->id ?>_<?= $unduhan->id ?>" role="button" aria-expanded="false" aria-controls="collapseUnduhan<?= $bidang->id ?>_<?= $unduhan->id ?>">
                                                                <i class="bi bi-chevron-right me-2 toggle-icon"></i><?= Html::encode($unduhan->namaFile) ?>
                                                            </a>
                                                        </div>
                                                        <div class="collapse" id="collapseUnduhan<?= $bidang->id ?>_<?= $unduhan->id ?>">
                                                            <div class="mt-2 ps-3">
                                                                <?php if (!empty($unduhan->unduhanFiles)): ?>
                                                                    <ul class="list-unstyled">
                                                                        <?php foreach ($unduhan->unduhanFiles as $unduhanFile): ?>
                                                                            <li class="mb-1 py-1">
                                                                                <i class="bi bi-file-earmark-arrow-down text-success me-1"></i>
                                                                                <a href="<?= Url::to(['/unduhan-file/download', 'id' => $unduhanFile->id]) ?>"
                                                                                    title="Download <?= Html::encode($unduhanFile->file) ?>"
                                                                                    target="_blank" class="text-dark">
                                                                                    <?= Html::encode($unduhanFile->file) ?>
                                                                                </a>
                                                                                <?php if ($unduhanFile->tanggalUpload): ?>
                                                                                    <span class="text-muted ms-2" style="font-size: 0.85em;">(<i class="bi bi-calendar-event me-1"></i><?= Yii::$app->formatter->asDate($unduhanFile->tanggalUpload, 'php:d M Y') ?>)</span>
                                                                                <?php endif; ?>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
                                                                <?php else: ?>
                                                                    <p class="text-muted fst-italic"><small>Tidak ada berkas file untuk unduhan ini.</small></p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="ms-3 text-muted fst-italic"><small>Tidak ada data unduhan untuk bidang ini.</small></p>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item">Tidak ada data bidang yang tersedia saat ini.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Script untuk toggle ikon folder -->
<script>
    document.querySelectorAll('button[data-bs-toggle="collapse"]').forEach(button => {
        const targetId = button.getAttribute('data-bs-target');
        if (!targetId) return;
        const target = document.querySelector(targetId);
        if (!target) return;

        const closedIcon = button.querySelector('.closed-icon');
        const openIcon = button.querySelector('.open-icon');

        if (closedIcon && openIcon) {
            target.addEventListener('show.bs.collapse', () => {
                closedIcon.classList.add('d-none');
                openIcon.classList.remove('d-none');
            });

            target.addEventListener('hide.bs.collapse', () => {
                closedIcon.classList.remove('d-none');
                openIcon.classList.add('d-none');
            });
        }
    });

    // Script tambahan untuk toggle ikon chevron pada item unduhan
    document.querySelectorAll('a[data-bs-toggle="collapse"]').forEach(anchor => {
        const targetId = anchor.getAttribute('href');
        if (!targetId) return;
        const targetCollapse = document.querySelector(targetId);
        if (!targetCollapse) return;

        const icon = anchor.querySelector('i.toggle-icon'); // Menggunakan class .toggle-icon

        if (icon) {
            targetCollapse.addEventListener('show.bs.collapse', () => {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-down');
                anchor.setAttribute('aria-expanded', 'true');
            });
            targetCollapse.addEventListener('hide.bs.collapse', () => {
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-right');
                anchor.setAttribute('aria-expanded', 'false');
            });
            // Set initial state based on if the collapse is shown by default (e.g. if 'show' class is present)
            if (targetCollapse.classList.contains('show')) {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-down');
                anchor.setAttribute('aria-expanded', 'true');
            }
        }
    });
</script>