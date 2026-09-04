<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Tahapan[] $tahapanList */

$this->title = 'Tahapan Perencanaan';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="hero_in" class="general">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span>Tahapan Perencanaan</h1>
        </div>
    </div>
</section>
<!--/hero_in-->

<div class="container margin_120_95">
    <div class="main_title_2">
        <span><em></em></span>
        <h2>Daftar Tahapan Perencanaan</h2>
        <p>Pilih tahapan perencanaan yang ingin Anda lihat.</p>
    </div>

    <div class="row">
        <?php if (empty($tahapanList)): ?>
            <div class="col-md-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Belum ada data tahapan perencanaan.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($tahapanList as $tahapan): ?>
                <div class="col-md-4 mb-4">
                    <a href="<?= Url::to(['tahapan/view', 'id' => $tahapan->id]) ?>" class="card-tahapan-link">
                        <div class="card-tahapan">
                            <div class="card-tahapan-year"><?= Html::encode($tahapan->tahun) ?></div>
                            <div class="card-tahapan-title"><?= Html::encode($tahapan->judul_tahapan) ?></div>
                            <div class="card-tahapan-count">
                                <i class="fas fa-list-ul"></i> <?= count($tahapan->tahapanItems) ?> Tahapan
                            </div>
                            <div class="card-tahapan-arrow">
                                Lihat Detail <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<!--/container-->

<style>
.card-tahapan-link {
    text-decoration: none;
    color: inherit;
    display: block;
}
.card-tahapan {
    background: #fff;
    border-radius: 10px;
    padding: 30px 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border-top: 5px solid #0047ba;
    transition: all 0.3s ease;
    height: 100%;
}
.card-tahapan:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,71,186,0.15);
}
.card-tahapan-year {
    font-size: 48px;
    font-weight: 800;
    color: #0047ba;
    line-height: 1;
    margin-bottom: 10px;
}
.card-tahapan-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    line-height: 1.4;
}
.card-tahapan-count {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}
.card-tahapan-arrow {
    font-size: 14px;
    color: #0047ba;
    font-weight: 600;
}
</style>
