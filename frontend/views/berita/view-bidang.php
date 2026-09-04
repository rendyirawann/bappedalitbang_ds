<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Berita $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Beritas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<section id="hero_in" class="general">
			<div class="wrapper">
				<div class="container">
					<h1 class="fadeInUp"><span></span>Baca Berita Perencanaan</h1>
				</div>
			</div>
		</section>
		<!--/hero_in-->

		<div class="container margin_60_35">
			<div class="row">
				<div class="col-lg-9">
					<div class="bloglist singlepost">
						<p><img alt="" class="img-fluid" src="<?= Url::base(true) ?>/uploads/berita/<?= Html::encode($model->file) ?>"></p>
						<h1><?= Html::encode($model->judulBerita) ?></h1>
						<div class="postmeta">
							<ul>
							<li><a href="#"><i class="icon_folder-alt"></i> <?= Html::encode($model->bidang->bidang) ?></a></li>
							<li><a href="#"><i class="icon_clock_alt"></i> <?= Yii::$app->formatter->asDate($model->tgl_berita) ?></a></li>
							<li><a href="#"><i class="icon_pencil-edit"></i> <?= Html::encode($model->bidang->bidang) ?></a></li>
							</ul>
						</div>
						<!-- /post meta -->
						<div class="post-content">
							<div class="dropcaps">
							<p><?= Html::decode($model->isiBerita) ?></p>
							</div>
						</div>
						<!-- /post -->
					</div>
					<!-- /single-post -->

					
				</div>
				<!-- /col -->

				<aside class="col-lg-3">
					<!-- /widget -->
					<div class="widget">
						<div class="widget-title">
							<h4>Berita Perencanaan</h4>
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
							<?php foreach ($kategoriBidangBerita as $kategori): ?>
								<li><i class="fa fa-folder-open-o"></i><a><?= $kategori['bidang'] . " <span>(" . $kategori['jumlah'] . ")</span>" ?></a></li>
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
