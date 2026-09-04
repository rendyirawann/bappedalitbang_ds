<?php

use coderius\lightbox2\Lightbox2;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Tahapan $model */

$this->title = $model->judul_tahapan . ' Tahun ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Tahapan Perencanaan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Initialize Lightbox2
echo Lightbox2::widget([
    'clientOptions' => [
        'resizeDuration' => 200,
        'wrapAround' => true,
    ],
]);

$items = $model->tahapanItems;

// Group by urutan
$groupedItems = [];
foreach ($items as $item) {
    $groupedItems[$item->urutan][] = $item;
}
$groups = array_values($groupedItems);
$totalGroups = count($groups);

// Collect unique icon images
$allIconImages = [];
foreach ($items as $item) {
    if ($item->icon_gambar) {
        $allIconImages[] = $item->icon_gambar;
    }
}
$allIconImages = array_unique(array_values($allIconImages));
?>

<section id="hero_in" class="general">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span><?= Html::encode($model->judul_tahapan) ?></h1>
        </div>
    </div>
</section>

<div class="container margin_120_95">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap" style="gap:10px; border-bottom: 2px solid #e8edf5; padding-bottom: 15px;">
            <h2 style="font-size:22px; font-weight:700; color:#003080; margin:0;">
                <?= Html::encode($model->judul_tahapan . ' Tahun ' . $model->tahun) ?>
            </h2>
            <a href="<?= Url::to(['tahapan/index']) ?>" class="btn-back-tahapan">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">

        <!-- ===== LEFT: Connected Timeline / Flowchart ===== -->
        <div class="col-lg-7">
            <?php if (empty($groups)): ?>
                <div class="alert alert-info">Belum ada data tahapan.</div>
            <?php else: ?>
                <div class="timeline-flow">
                    <?php
                    $colorPalette = [
                        ['border' => '#e63946', 'text' => '#e63946', 'dot' => '#e63946'],
                        ['border' => '#f4a261', 'text' => '#c17000', 'dot' => '#f4a261'],
                        ['border' => '#2a9d8f', 'text' => '#1a6b62', 'dot' => '#2a9d8f'],
                        ['border' => '#e9c46a', 'text' => '#9a7a00', 'dot' => '#e9c46a'],
                        ['border' => '#264653', 'text' => '#264653', 'dot' => '#264653'],
                        ['border' => '#e76f51', 'text' => '#c04a28', 'dot' => '#e76f51'],
                    ];
                    foreach ($groups as $i => $group):
                        $firstItem = $group[0];
                        $isLeft = ($i % 2 === 0);
                        $isLast = ($i === $totalGroups - 1);
                        $c = $colorPalette[$i % count($colorPalette)];
                    ?>
                    <div class="tl-row <?= $isLeft ? 'tl-left' : 'tl-right' ?>">

                        <!-- Dot on center line -->
                        <div class="tl-dot" style="background: <?= $c['dot'] ?>; border-color: <?= $c['dot'] ?>"></div>

                        <!-- Card -->
                        <div class="tl-card" style="border-color: <?= $c['border'] ?>">
                            <?php if ($firstItem->icon_gambar): ?>
                                <div class="tl-icon" style="border-color: <?= $c['border'] ?>">
                                    <img src="<?= Url::base(true) ?>/uploads/tahapan/<?= Html::encode($firstItem->icon_gambar) ?>" alt="">
                                </div>
                            <?php else: ?>
                                <div class="tl-icon tl-icon-empty" style="border-color: <?= $c['border'] ?>; background: <?= $c['border'] ?>22">
                                    <i class="fas fa-tasks" style="color:<?= $c['border'] ?>"></i>
                                </div>
                            <?php endif; ?>

                            <div class="tl-body">
                                <?php foreach ($group as $idx => $item): ?>
                                    <div class="tl-entry <?= $idx > 0 ? 'tl-entry-sep' : '' ?>">
                                        <h5 class="tl-name" style="color: <?= $c['text'] ?>">
                                            <?= Html::encode($item->nama_tahapan) ?>
                                        </h5>
                                        <?php if ($item->tanggal): ?>
                                            <div class="tl-date">
                                                <?= Html::encode($item->tanggal) ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($item->dokumen): ?>
                                            <a href="<?= Url::base(true) ?>/uploads/tahapan/<?= Html::encode($item->dokumen) ?>" class="tl-dl-btn" target="_blank">
                                                <i class="fas fa-download"></i> Unduh Hasil
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ===== RIGHT: Diamond Photo Grid + Info ===== -->
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 100px;">

                <?php if (!empty($allIconImages)): ?>
                <!-- Diamond Gallery -->
                <div class="diamond-gallery-wrap">
                    <?php
                    $showImages = array_slice($allIconImages, 0, 4);
                    $extraCount = max(0, count($allIconImages) - 4);

                    // Positions in diamond arrangement
                    $dPositions = [
                        ['top' => '0px',   'left' => '50%',   'tx' => '-50%'],  // top center
                        ['top' => '110px', 'left' => '5%',    'tx' => '0'],     // middle left
                        ['top' => '110px', 'left' => '55%',   'tx' => '0'],     // middle right
                        ['top' => '220px', 'left' => '50%',   'tx' => '-50%'],  // bottom center
                    ];
                    ?>
                    <div class="diamond-stage">
                        <?php foreach ($showImages as $d => $img):
                            $isLast = $d === count($showImages) - 1 && $extraCount > 0;
                        ?>
                        <div class="diamond-wrap" style="top:<?= $dPositions[$d]['top'] ?>; left:<?= $dPositions[$d]['left'] ?>; transform: translateX(<?= $dPositions[$d]['tx'] ?>) rotate(45deg);">
                            <a href="<?= Url::base(true) ?>/uploads/tahapan/<?= Html::encode($img) ?>"
                               data-lightbox="tahapan-<?= $model->id ?>"
                               data-title="<?= Html::encode($model->judul_tahapan . ' ' . $model->tahun) ?>">
                                <div class="diamond-img-inner">
                                    <img src="<?= Url::base(true) ?>/uploads/tahapan/<?= Html::encode($img) ?>" alt="">
                                    <?php if ($isLast && $extraCount > 0): ?>
                                        <div class="diamond-overlay">+<?= $extraCount ?></div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>

                        <?php
                        // Hidden lightbox links for the extra images (so they appear in the gallery)
                        if ($extraCount > 0):
                            foreach (array_slice($allIconImages, 4) as $extraImg):
                        ?>
                            <a href="<?= Url::base(true) ?>/uploads/tahapan/<?= Html::encode($extraImg) ?>"
                               data-lightbox="tahapan-<?= $model->id ?>"
                               data-title="<?= Html::encode($model->judul_tahapan . ' ' . $model->tahun) ?>"
                               style="display:none"></a>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
                <?php else: ?>
                <!-- Placeholder -->
                <div class="diamond-gallery-wrap">
                    <div class="diamond-stage">
                        <div class="diamond-wrap" style="top:110px; left:50%; transform:translateX(-50%) rotate(45deg);">
                            <div class="diamond-img-inner diamond-placeholder">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Summary Info -->
                <div class="tl-summary-box">
                    <div class="tl-summary-item">
                        <div class="tl-summary-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div>
                            <small>Tahun Perencanaan</small>
                            <strong><?= Html::encode($model->tahun) ?></strong>
                        </div>
                    </div>
                    <div class="tl-summary-item">
                        <div class="tl-summary-icon"><i class="fas fa-list-ol"></i></div>
                        <div>
                            <small>Total Tahapan</small>
                            <strong><?= count($items) ?> Item</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
/* ===========================
   Back Button
=========================== */
.btn-back-tahapan {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 18px; background: #f0f4ff; color: #0047ba;
    border-radius: 8px; text-decoration: none; font-size: 14px;
    font-weight: 600; border: 1px solid #c5d4f5; transition: all .2s;
}
.btn-back-tahapan:hover { background: #0047ba; color: #fff !important; }

/* ===========================
   Timeline / Flowchart
=========================== */
.timeline-flow {
    position: relative;
    padding: 10px 0 10px 0;
}

/* The vertical center spine line */
.timeline-flow::before {
    content: '';
    position: absolute;
    top: 0; bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 3px;
    background: linear-gradient(to bottom, #c5d4f5, #0047ba, #c5d4f5);
    z-index: 0;
}

.tl-row {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 0;
    padding: 20px 0;
    z-index: 1;
}

/* Dot on spine */
.tl-dot {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 16px; height: 16px;
    border-radius: 50%;
    border: 3px solid;
    background: #fff;
    z-index: 2;
    box-shadow: 0 0 0 4px rgba(255,255,255,0.7);
}

/* Card on left side */
.tl-left .tl-card {
    margin-right: calc(50% + 30px);
    margin-left: 0;
}

/* Card on right side */
.tl-right .tl-card {
    margin-left: calc(50% + 30px);
    margin-right: 0;
}

/* Connector horizontal line from dot to card */
.tl-left .tl-card::after,
.tl-right .tl-card::after {
    content: '';
    position: absolute;
    top: 50%; transform: translateY(-50%);
    height: 2px; width: 30px;
    background: currentColor;
    z-index: 1;
}
.tl-left .tl-card {
    position: relative;
}
.tl-left .tl-card::after {
    right: -30px;
    background: inherit;
    border-top: 2px dashed #aac4f0;
    height: 0;
}
.tl-right .tl-card {
    position: relative;
}
.tl-right .tl-card::after {
    left: -30px;
    border-top: 2px dashed #aac4f0;
    height: 0;
}

/* Card box */
.tl-card {
    display: flex;
    align-items: flex-start;
    background: #fff;
    border-radius: 10px;
    padding: 14px 16px;
    border: 2px solid #ddd;
    box-shadow: 0 3px 12px rgba(0,0,0,0.07);
    gap: 12px;
    width: calc(50% - 30px);
    transition: transform .25s, box-shadow .25s;
}
.tl-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(0,0,0,0.1);
}

/* Icon circle */
.tl-icon {
    width: 56px; height: 56px; flex-shrink: 0;
    border-radius: 50%; border: 3px solid;
    overflow: hidden;
}
.tl-icon img { width: 100%; height: 100%; object-fit: cover; }
.tl-icon-empty {
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
}

/* Card body text */
.tl-body { flex: 1; min-width: 0; }
.tl-entry { padding: 4px 0; }
.tl-entry-sep { padding-top: 8px; margin-top: 6px; border-top: 1px dashed #ddd; }
.tl-name { font-size: 14px; font-weight: 700; margin-bottom: 3px; line-height: 1.3; }
.tl-date { font-size: 12px; color: #666; margin-bottom: 5px; }
.tl-dl-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; background: #003080; color: #fff !important;
    border-radius: 5px; font-size: 11px; text-decoration: none;
    transition: background .2s;
}
.tl-dl-btn:hover { background: #0055c8; }

/* ===========================
   Diamond Gallery
=========================== */
.diamond-gallery-wrap { width: 100%; margin-bottom: 20px; }
.diamond-stage {
    position: relative;
    width: 100%;
    height: 380px;
}

.diamond-wrap {
    position: absolute;
    width: 140px; height: 140px;
    overflow: hidden;
    border-radius: 8px;
    border: 4px solid #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.18);
    cursor: pointer;
    transition: transform .3s, box-shadow .3s;
}
.diamond-wrap:hover {
    box-shadow: 0 10px 30px rgba(0,71,186,0.25);
    z-index: 10;
}
/* Undo rotate inside so image stays upright */
.diamond-img-inner {
    width: 200%;
    height: 200%;
    margin: -50% 0 0 -50%;
    transform: rotate(-45deg);
    overflow: hidden;
    position: relative;
    display: flex; align-items: center; justify-content: center;
}
.diamond-img-inner img {
    width: 71%; height: 71%;
    object-fit: cover;
    transform: scale(1.5);
}
.diamond-placeholder {
    background: #0047ba;
    color: #fff; font-size: 36px;
    width: 100%; height: 100%; margin: 0;
    transform: none;
}
.diamond-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,48,128,0.75);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 26px; font-weight: 700;
    transform: rotate(45deg);
}

/* ===========================
   Summary Box
=========================== */
.tl-summary-box {
    background: #fff;
    border-radius: 12px;
    padding: 18px 20px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.07);
    display: flex; flex-direction: column; gap: 14px;
}
.tl-summary-item {
    display: flex; align-items: center; gap: 14px;
}
.tl-summary-icon {
    width: 42px; height: 42px;
    background: #e8eeff; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: #0047ba; flex-shrink: 0;
}
.tl-summary-item small { display: block; font-size: 11px; color: #999; text-transform: uppercase; }
.tl-summary-item strong { display: block; font-size: 16px; color: #333; }

/* ===========================
   Responsive
=========================== */
@media (max-width: 768px) {
    .timeline-flow::before { left: 20px; }
    .tl-dot { left: 20px; }
    .tl-left .tl-card, .tl-right .tl-card {
        margin-left: 50px;
        margin-right: 0;
        width: calc(100% - 60px);
    }
    .tl-left .tl-card::after, .tl-right .tl-card::after { left: -30px; right: auto; }
    .diamond-stage { height: 290px; }
    .diamond-wrap { width: 100px; height: 100px; }
}
</style>
