<?php

use frontend\models\Visimisi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\search\VisimisiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Visi dan Misi';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="hero_in" class="general">
			<div class="wrapper">
				<div class="container">
					<h1 class="fadeInUp"><span></span>Visi dan Misi</h1>
				</div>
			</div>
		</section>
		<!--/hero_in-->

		<div class="container margin_120_95">
			<div class="main_title_2">
				<span><em></em></span>
				<!-- <h2>Why choose Udema</h2>
				<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p> -->
			</div>
			<div class="row">
    <div class="col-md-12">
        <blockquote>
            <p><?= Html::decode($visimisiData->visiTeks) ?></p>
            <cite><strong><?= Html::decode($visimisiData->visiJudul) ?></strong></cite>
        </blockquote>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h5>
            <?= Html::decode($visimisiData->misiJudul) ?>
        </h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p><?= Html::decode($visimisiData->misiTeks) ?></p>
    </div>
</div>


		</div>
		<!-- /container -->

		<!-- <div class="bg_color_1">
			<div class="container margin_120_95">
				<div class="main_title_2">
					<span><em></em></span>
					<h2>Our Origins and Story</h2>
					<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
				</div>
				<div class="row justify-content-between">
					<div class="col-lg-6 wow" data-wow-offset="150">
						<figure class="block-reveal">
							<div class="block-horizzontal"></div>
							<img src="img/course_1.jpg" class="img-fluid" alt="">
						</figure>
					</div>
					<div class="col-lg-5">
						<p>Lorem ipsum dolor sit amet, homero erroribus in cum. Cu eos <strong>scaevola probatus</strong>. Nam atqui intellegat ei, sed ex graece essent delectus. Autem consul eum ea. Duo cu fabulas nonumes contentiones, nihil voluptaria pro id. Has graeci deterruisset ad, est no primis detracto pertinax, at cum malis vitae facilisis.</p>
						<p>Dicam diceret ut ius, no epicuri dissentiet philosophia vix. Id usu zril tacimates neglegentur. Eam id legimus torquatos cotidieque, usu decore <strong>percipitur definitiones</strong> ex, nihil utinam recusabo mel no. Dolores reprehendunt no sit, quo cu viris theophrastus. Sit unum efficiendi cu.</p>
						<p><em>CEO Marc Schumaker</em></p>
					</div>
				</div>

			</div>

		</div> -->
		<!--/bg_color_1-->

		<!-- <div class="container margin_120_95">
			<div class="main_title_2">
				<span><em></em></span>
				<h2>Our founders</h2>
				<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
			</div>
			<div id="carousel" class="owl-carousel owl-theme">
				<div class="item">
					<a href="#0">
						<div class="title">
							<h4>Julia Holmes<em>CEO</em></h4>
						</div><img src="img/1_carousel.jpg" alt="">
					</a>
				</div>
				<div class="item">
					<a href="#0">
						<div class="title">
							<h4>Lucas Smith<em>Marketing</em></h4>
						</div><img src="img/2_carousel.jpg" alt="">
					</a>
				</div>
				<div class="item">
					<a href="#0">
						<div class="title">
							<h4>Paul Stephens<em>Business strategist</em></h4>
						</div><img src="img/3_carousel.jpg" alt="">
					</a>
				</div>
				<div class="item">
					<a href="#0">
						<div class="title">
							<h4>Pablo Himenez<em>Customer Service</em></h4>
						</div><img src="img/4_carousel.jpg" alt="">
					</a>
				</div>
				<div class="item">
					<a href="#0">
						<div class="title">
							<h4>Andrew Stuttgart<em>Admissions</em></h4>
						</div><img src="img/5_carousel.jpg" alt="">
					</a>
				</div>
			</div> -->

		<!-- </div> -->
		<!--/container-->
