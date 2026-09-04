<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>
<style>
	/* 1. Atur posisi untuk parent <li> dan tambahkan padding bawah */
	#top_menu>li {
		position: relative;
		padding-bottom: 10px;
		/* DIUBAH: Menambahkan area hover di bawah menu */
	}

	/* 2. Targetkan <ul> yang ada di dalam <li> (ini adalah menu dropdown-nya) */
	#top_menu>li>ul {
		display: none;
		position: absolute;
		top: 100%;
		left: 0;
		background-color: white;
		list-style: none;
		padding: 10px 0;
		margin-top: 0;
		/* DIUBAH: Hapus margin yang membuat celah */
		min-width: 220px;
		box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
		border-radius: 5px;
		z-index: 1000;
	}

	/* 3. Atur tampilan untuk setiap item <li> di dalam dropdown */
	#top_menu>li>ul>li {
		padding: 0;
		margin: 0;
	}

	/* 4. Atur tampilan untuk link <a> di dalam dropdown */
	#top_menu>li>ul>li>a {
		padding: 10px 20px;
		display: block;
		color: #333;
		text-decoration: none;
		white-space: nowrap;
	}

	/* 5. Efek hover pada item dropdown */
	#top_menu>li>ul>li>a:hover {
		background-color: #f2f2f2;
	}

	/* 6. Tampilkan dropdown saat kursor berada di atas parent <li> */
	#top_menu>li:hover>ul {
		display: block;
	}

	/* 7. Opsional: Tambahkan panah kecil di samping menu */
	#top_menu>li>span>a:after {
		content: ' \25BC';
		font-size: 0.8em;
		margin-left: 5px;
	}
</style>
<div id="preloader">
	<div data-loader="circle-side"></div>
</div>
<!-- End Preload -->
<header class="header fadeInDown">
	<div id="logo">
		<a href="<?= Url::to(['site/index']) ?>"><img src="<?= Url::base(true) ?>/udema/bappeda/bappeda.png" width="32" alt=""></a> Bappedalitbang Deli Serdang
	</div>
	<ul id="top_menu" style="color:black;">
		<li><a href="<?= Url::to(['/site/index']) ?>" class="login">Beranda</a></li>
		<li><span><a href="#0">Profil</a></span>
			<ul>
				<li><a href="<?= Url::to(['/visimisi/index']) ?>">Visi & Misi</a></li>
				<li><a href="<?= Url::to(['/struktur/index']) ?>">Struktur Organisasi</a></li>
				<li><a href="<?= Url::to(['/unduhan/index']) ?>">Unduhan</a></li>
			</ul>
		</li>
		<li><a href="<?= Url::to(['/tahapan/index']) ?>">Tahapan Perencanaan</a></li>
		<li><a href="<?= Url::to(['/berita/index']) ?>" class="search-overlay-menu-btn">Berita Perencanaan</a></li>
		<li><a href="<?= Url::to(['/standar-pelayanan/index']) ?>">Standar Pelayanan</a></li>
		<li class="hidden_tablet"><a href="<?= Url::to(['/galeri/index']) ?>">Galeri</a></li>
		<!-- <li class="hidden_tablet"><a href="<?= Url::to(['/unduhan/index']) ?>" target="_blank" rel="noopener noreferrer">Unduhan</a></li> -->
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
					<h3><a href="<?= Url::to(['site/index']) ?>" style="text-decoration:none; color:white;">Home</a></h3>
				</div>
				<div class="col-md-3">
					<h3><a href="<?= Url::to(['berita/index']) ?>" style="text-decoration:none; color:white;">Berita Perencanaan</a></h3>
					<ul>
						<li><a href="<?= Url::to(['berita/index']) ?>">Berita Bidang PPED</a></li>
						<li><a href="<?= Url::to(['berita/index']) ?>">Berita Bidang Infrastruktur dan Kewilayahan</a></li>
						<li><a href="<?= Url::to(['berita/index']) ?>">Berita Bidang Penelitian dan Pengembangan</a></li>
						<li><a href="<?= Url::to(['berita/index']) ?>">Berita Bidang Umum</a></li>
						<li><a href="<?= Url::to(['berita/index']) ?>">Berita Bidang Program</a></li>
						<li><a href="<?= Url::to(['berita/index']) ?>">Berita Bidang Keuangan</a></li>
						<li><a href="<?= Url::to(['berita/index']) ?>">Berita Bidang Ekonomi dan SDA</a></li>
						<li><a href="<?= Url::to(['berita/index']) ?>">Berita Bidang PPM</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h3>Profil</h3>
					<ul>
						<li><a href="<?= Url::to(['visimisi/index']) ?>">Visi dan Misi</a></li>
						<li><a href="<?= Url::to(['struktur/index']) ?>">Struktur Organisasi</a></li>
						<li><a href="<?= Url::to(['unduhan/index']) ?>">Unduhan</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<h3>Galeri</h3>
					<ul>
						<li><a href="<?= Url::to(['galeri/index']) ?>">Galeri Kegiatan</a></li>
						<li><a href="<?= Url::to(['standar-pelayanan/index']) ?>">Standar Pelayanan</a></li>
					</ul>
				</div>
			</div>
			<!-- /row -->
		</nav>
		<div class="follow_us">
			<ul>
				<li>Follow us</li>
				<li><a href="https://web.facebook.com/pages/Bappeda-Deli-Serdang/366920706655586" target="_blank" rel="noopener noreferrer"><i class="bi bi-facebook"></i></a></li>
				<li><a href="https://www.instagram.com/bappedalitbangds/" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a></li>
			</ul>
		</div>
	</div>
</div>
<!-- /main_menu -->