<?php

use coderius\lightbox2\Lightbox2;
use frontend\models\Galeri;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\search\GaleriSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Galeri Kegiatan';
$this->params['breadcrumbs'][] = $this->title;
echo Lightbox2::widget([
	'clientOptions' => [
		'resizeDuration' => 200,
		'wrapAround' => true,
	],
]);
?>
<section id="hero_in" class="general">
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span>Galeri Kegiatan</h1>
		</div>
	</div>
</section>
<!--/hero_in-->

<div class="container margin_60_35">
	<div class="main_title_2">
		<span><em></em></span>
		<h2>Galeri Kegiatan</h2>
		<p>Galeri Kegiatan Bappedalitbang Deli Serdang</p>
	</div>
	<div class="grid">
		<ul class="magnific-gallery">
			<?php foreach ($dataProvider->getModels() as $galeri): ?>
				<li class="ms-5 mt-2">
					<figure>
						<img src="<?= Url::base(true) ?>/uploads/galeri/<?= Html::encode($galeri->file) ?>" alt="" style="width: 340px; height: 200px; object-fit: cover;">
						<figcaption>
							<div class="caption-content">
								<a href="<?= Url::base(true) ?>/uploads/galeri/<?= Html::encode($galeri->file) ?>" title="<?= Html::encode($galeri->namaFile) ?>" data-lightbox="gallery" data-title="<?= Html::encode($galeri->namaFile) ?>">
									<i class="pe-7s-albums"></i>
									<p><?= Html::encode($galeri->namaFile) ?></p>
								</a>
							</div>
						</figcaption>
					</figure>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<!-- /grid gallery -->
</div>
<!-- /container -->

<!-- <div class="bg_color_1">
			<div class="container margin_60_35">
				<div class="main_title_2">
					<span><em></em></span>
					<h2>Here some videos ...</h2>
					<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
				</div>
				<div class="grid">
					<ul class="magnific-gallery">
						<li>
							<figure>
								<img src="img/gallery/large/pic_2.jpg" alt="">
								<figcaption>
								<div class="caption-content">
									<a href="https://vimeo.com/45830194" class="video" title="Video Vimeo">
										<i class="pe-7s-film"></i>
										<p>Your caption</p>
								</a>
								</div>
								</figcaption>
							</figure>
						</li>
				
						<li>
							<figure>
								<img src="img/gallery/large/pic_13.jpg" alt="">
								<figcaption>
								<div class="caption-content">
									 <a href="https://www.youtube.com/watch?v=Zz5cu72Gv5Y" class="video" title="Video Youtube">
										<i class="pe-7s-film"></i>
										<p>Your caption</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
						<li>
							<figure>
								<img src="img/gallery/large/pic_4.jpg" alt="">
								<figcaption>
								<div class="caption-content">
									<a href="https://vimeo.com/45830194" class="video" title="Video Vimeo">
										<i class="pe-7s-film"></i>
										<p>Your caption</p>
									</a>
								</div>
								</figcaption>
							</figure>
						</li>
					</ul>
				</div>
			</div>
		</div> -->
<!-- /bg_color_1 -->