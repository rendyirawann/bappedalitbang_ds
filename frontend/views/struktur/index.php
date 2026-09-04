<?php

use frontend\models\Struktur;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use coderius\lightbox2\Lightbox2;

/** @var yii\web\View $this */
/** @var frontend\models\search\StrukturSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Strukturs';
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
			<h1 class="fadeInUp"><span></span>Struktur Organisasi</h1>
		</div>
	</div>
</section>
<!--/hero_in-->

<div class="container margin_120_95">
	<div class="main_title_2">
		<span><em></em></span>
		<h2>Struktur Organisasi</h2>
		<p>
			<?php
			// Bagian ini menampilkan semua namaFile secara berurutan.
			// Jika $struktur->namaFile adalah judul untuk setiap gambar,
			// mungkin Anda ingin menampilkannya secara berbeda atau ini adalah daftar judul.
			$titles = [];
			foreach ($dataProvider->getModels() as $struktur) {
				$titles[] = Html::decode($struktur->namaFile); // Menggunakan Html::decode seperti kode asli Anda
			}
			echo implode(', ', $titles); // Contoh: memisahkan dengan koma
			?>
		</p>
	</div>
	<div class="row">
		<?php foreach ($dataProvider->getModels() as $key => $struktur): ?>
			<div class="col-lg-12 col-md-12 mb-4"> <?php // Menambahkan margin-bottom untuk spasi jika ada beberapa gambar 
													?>
				<a class="box_feat"
					href="<?= Url::base(true) . '/uploads/struktur/' . Html::encode($struktur->file) ?>"
					data-lightbox="struktur-gallery" <?php // Nama grup untuk galeri lightbox 
														?>
					data-title="<?= Html::encode($struktur->namaFile) ?>" <?php // Judul yang akan tampil di lightbox 
																			?>
					title="<?= Html::encode($struktur->namaFile) ?>" <?php // Tooltip opsional saat hover 
																		?>>
					<img src="<?= Url::base(true) . '/uploads/struktur/' . Html::encode($struktur->file) ?>"
						alt="<?= Html::encode($struktur->namaFile ? $struktur->namaFile : 'Struktur Organisasi ' . ($key + 1)) ?>" <?php // Teks alternatif yang deskriptif 
																																	?>
						style="width: 760px; max-width: 100%; height: auto;" <?php // Menambahkan max-width dan height auto untuk responsivitas dasar 
																				?>>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>