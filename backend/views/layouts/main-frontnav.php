<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use backend\assets\AppAssetFront;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>
<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>
	<!-- End Preload -->
	
	<header class="header fadeInDown">
		<div id="logo">
			<a href="#preview"><img src="<?= Url::base(true)?>/udema/bappeda/bappeda.png" width="32" alt=""></a> Bappedalitbang Deli Serdang
		</div>
		<ul id="top_menu" style="color:black;">
			<li><a href="#preview" class="login">Beranda</a></li>
			<li><a href="#preview" class="search-overlay-menu-btn">Berita Perencanaan</a></li>
			<li class="hidden_tablet"><a href="#preview">Galeri</a></li>
			<li class="hidden_tablet"><a href="#preview" target="_blank" rel="noopener noreferrer">Dokrenbang</a></li>
			<li class="hidden_tablet"><a href="#preview" target="_blank" rel="noopener noreferrer">PPID</a></li>
			<!-- <li class="hidden_tablet"><a href="admission.html" class="btn_1 rounded">Admission</a></li> -->
			<li>
				<div class="hamburger hamburger--spin">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
			</li>
		</ul>
		<!-- /top_menu -->
	</header>
	<!-- /header -->
	
	<div id="main_menu">
		<div class="container">
			<nav class="version_2">
				<div class="row">
					<div class="col-md-3">
						<h3><a href="#preview" style="text-decoration:none; color:white;">Home</a></h3>
					</div>
					<div class="col-md-3">
						<h3><a href="#preview" style="text-decoration:none; color:white;">Berita Perencanaan</a></h3>
						<ul>
							<li><a href="#preview">Berita Bidang PPED</a></li>
							<li><a href="#preview">Berita Bidang Infrastruktur dan Kewilayahan</a></li>
							<li><a href="#preview">Berita Bidang Penelitian dan Pengembangan</a></li>
							<li><a href="#preview">Berita Bidang Umum</a></li>
							<li><a href="#preview">Berita Bidang Program</a></li>
							<li><a href="#preview">Berita Bidang Keuangan</a></li>
							<li><a href="#preview">Berita Bidang Ekonomi dan SDA</a></li>
							<li><a href="#preview">Berita Bidang PPM</a></li>
						</ul>
					</div>
					<div class="col-md-3">
						<h3>Profil</h3>
						<ul>
							<li><a href="#preview">Visi dan Misi</a></li>
							<li><a href="#preview">Struktur Organisasi</a></li>
						</ul>
					</div>
					<div class="col-md-3">
						<h3>Galeri</h3>
						<ul>
							<li><a href="#preview">Galeri Kegiatan</a></li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</nav>
			<div class="follow_us">
				<ul>
					<li>Follow us</li>
					<li><a href="#preview"><i class="bi bi-facebook"></i></a></li>
					<li><a href="#preview"><i class="bi bi-instagram"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /main_menu -->