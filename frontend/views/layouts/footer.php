<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>
<footer>
	<div class="container margin_120_95">
		<div class="row justify-content-between">
			<div class="col-lg-5 col-md-12">
				<p><img src="<?= Url::base(true) ?>/udema/bappeda/bappeda.png" width="72" alt="Deli Serdang Logo"></p>
				<p>Badan Perencanaan Pembangunan Daerah Penelitian dan Pengembangan Deli Serdang</p>
				<div class="follow_us">
					<ul>
						<li>Follow us</li>
						<li><a href="https://web.facebook.com/pages/Bappeda-Deli-Serdang/366920706655586" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a></li>
						<li><a href="https://www.instagram.com/bappedalitbangds/" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 ml-lg-auto">
				<h5>Aplikasi Bappedalitbang Deli Serdang</h5>
				<ul class="links">
					<li><a href='https://dokrenbang.deliserdangkab.go.id/' target="_blank" rel="noopener noreferrer">Aplikasi Dokumen Perencanaan dan Pembangunan (DOKRENBANG)</a></li>
					<li><a href='https://esakipsimonalisa.deliserdangkab.go.id/' target="_blank" rel="noopener noreferrer">Aplikasi Sistem Akuntabilitas Kinerja Instansi Pemerintah secara elektronik dan Monitoring Analisa (eSakip SIMONALISA)</a></li>
					<li><a href='https://emonev.deliserdangkab.go.id/' target="_blank" rel="noopener noreferrer">Aplikasi e-MONEV</a></li>
					<!-- <li><a href='https://ikmds.deliserdangkab.go.id/' target="_blank" rel="noopener noreferrer">Aplikasi Indeks Kepuasan Masyarakat (IKM)</a></li> -->
				</ul>
			</div>
			<div class="col-lg-4 col-md-6">
				<h5>Kontak Kami</h5>
				<ul class="contacts">
					<li><a href="tel://617951422"><i class="ti-mobile"></i> + 61 79 5142 2</a></li>
					<li><a href="mailto:bappedalitbang@deliserdangkab.go.id"><i class="ti-email"></i> bappedalitbang@deliserdangkab.go.id</a></li>
					<li><a href="mailto:simpuldeliserdang@gmail.com"><i class="ti-email"></i> simpuldeliserdang@gmail.com</a></li>
				</ul>
			</div>
		</div>
		<!--/row-->
		<hr>
		<div class="row">
			<div class="col-md-8">
				<ul id="additional_links">
					<!-- <li><a href="#0">Terms and conditions</a></li>
						<li><a href="#0">Privacy</a></li> -->
				</ul>
			</div>
			<div class="col-md-4">
				<div id="copy">Copyright &copy; 2024 Bappedalitbang Deliserdang</div>
			</div>
		</div>
	</div>
</footer>
<!--/footer-->


<script type="text/javascript">
	'use strict';
	$('#layerslider').layerSlider({
		autoStart: true,
		navButtons: false,
		navStartStop: false,
		showCircleTimer: false,
		responsive: true,
		responsiveUnder: 1280,
		layersContainer: 1200,
		skinsPath: 'udema/layerslider/skins/'
		// Please make sure that you didn't forget to add a comma to the line endings
		// except the last line!
	});
</script>