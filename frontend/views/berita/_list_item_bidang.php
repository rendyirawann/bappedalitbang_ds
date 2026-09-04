<style>
    /* CSS untuk pagination */
.pagination {
    display: inline-block;
    padding-left: 0;
    margin: 20px 0; /* Sesuaikan margin sesuai kebutuhan */
    border-radius: 4px;
}

.pagination > li {
    display: inline;
}

.pagination > li > a,
.pagination > li > span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #337ab7;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
}

.pagination > li:first-child > a,
.pagination > li:first-child > span {
    margin-left: 0;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.pagination > li:last-child > a,
.pagination > li:last-child > span {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
    color: #23527c;
    background-color: #eee;
    border-color: #ddd;
}

.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus {
    z-index: 2;
    color: #fff;
    cursor: default;
    background-color: #337ab7;
    border-color: #337ab7;
}

</style>
<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var frontend\models\Berita $model */
?>
<article class="blog wow fadeIn">
    <div class="row g-0">
        <div class="col-lg-7">
            <figure>
                <a href="<?= Url::to(['berita/view-bidang', 'id' => $model->id]) ?>">
                    <img src="<?= Url::base(true) ?>/uploads/berita/<?= Html::encode($model->file) ?>" alt="" style="max-width: 400px; max-height: 200px;">
                    <div class="preview"><span>Baca Lebih Lanjut</span></div>
                </a>
            </figure>
        </div>
        <div class="col-lg-5">
            <div class="post_info">
                <small><?= Yii::$app->formatter->asDate($model->tgl_berita) ?></small>
                <h3>
                    <a href="<?= Url::to(['berita/view', 'id' => $model->id]) ?>">
                        <?= Html::encode($model->judulBerita) ?>
                    </a>
                </h3>
                <p><?= Html::encode(mb_strimwidth(strip_tags($model->isiBerita), 0, 150, '...')) ?></p>
                <ul>
                    <li>
                        <i class="fa fa-user"></i>
                        <?= Html::encode($model->bidang->bidang) ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</article>
<!-- /article -->
