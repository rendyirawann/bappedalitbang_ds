<style>
    /* CSS untuk pagination */
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        /* Sesuaikan margin sesuai kebutuhan */
        border-radius: 4px;
    }

    .pagination>li {
        display: inline;
    }

    .pagination>li>a,
    .pagination>li>span {
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

    .pagination>li:first-child>a,
    .pagination>li:first-child>span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .pagination>li:last-child>a,
    .pagination>li:last-child>span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    .pagination>li>a:hover,
    .pagination>li>span:hover,
    .pagination>li>a:focus,
    .pagination>li>span:focus {
        color: #23527c;
        background-color: #eee;
        border-color: #ddd;
    }

    .pagination>.active>a,
    .pagination>.active>span,
    .pagination>.active>a:hover,
    .pagination>.active>span:hover,
    .pagination>.active>a:focus,
    .pagination>.active>span:focus {
        z-index: 2;
        color: #fff;
        cursor: default;
        background-color: #337ab7;
        border-color: #337ab7;
    }
</style>
<?php

use frontend\models\Berita;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var frontend\models\search\BeritaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Beritas';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="hero_in" class="general">
    <div class="wrapper">
        <div class="container">
            <h1 class="fadeInUp"><span></span>Berita Perencanaan</h1>
        </div>
    </div>
</section>
<!--/hero_in-->

<div class="container margin_60_35">
    <div class="main_title_2">
        <span><em></em></span>
        <h2>Berita Perencanaan</h2>
        <p>Berita Perencanaan Bappedalitbang Deli Serdang</p>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'article'],
                'layout' => "{items}\n<div class='text-center'>{pager}</div>", // Tambahkan class 'text-center' untuk memposisikan pager ke tengah
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_list_item', ['model' => $model]);
                },
            ]) ?>
        </div>
        <!-- /col -->
        <aside class="col-lg-3">
            <div class="widget">
                <div class="widget-title">
                    <h4>Berita Terbaru</h4>
                </div>
                <ul class="comments-list">
                    <?php foreach ($latestBerita as $berita): ?>
                        <li>
                            <div class="alignleft">
                                <a href="<?= Url::to(['berita/view', 'id' => $berita->id]) ?>"><img src="<?= Url::base(true) ?>/uploads/berita/<?= Html::encode($berita->file) ?>" alt="" style="max-width: 400px; max-height: 200px;"></a>
                            </div>
                            <small><?= Yii::$app->formatter->asDate($berita->tgl_berita) ?></small>
                            <h3><a href="<?= Url::to(['berita/view', 'id' => $berita->id]) ?>" title=""><?= Html::encode(mb_strimwidth(strip_tags($berita->judulBerita), 0, 50, '...')) ?></a></h3>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- /widget -->
            <div class="widget">
                <div class="widget-title">
                    <h4>Kategori Bidang Berita</h4>
                </div>
                <ul class="cats">
                    <?php foreach ($queryBidang as $bidang): ?>
                        <li><i class="fa fa-folder-open-o"></i><a href="<?= Url::to(['berita/index-bidang', 'bidang_id' => $bidang['id']]) ?>"><?= $bidang['bidang'] ?><span>(<?= $bidang['jumlah_berita'] ?>)</span></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- /widget -->
        </aside>
        <!-- /aside -->
    </div>
    <!-- /row -->
</div>
<!-- /container -->