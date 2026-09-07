<?php

/** @var yii\web\View $this */

$this->title = 'Website Bappedalitbang Deli Serdang';

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>

<style>
/* ------------------------------------------------------------------
   Perbaikan tampilan banner hero - 7 September 2026

   Masalah: banner terlihat ter-zoom dan terpotong di kiri-kanan.
   Penyebabnya LayerSlider menulis sendiri width/height/left/top secara
   inline pada <img class="ls-bg"> dan ikut menskalakannya mengikuti
   opsi layersContainer (1200 px, lihat views/layouts/footer.php),
   sehingga pada layar lebar gambar diperbesar jauh melebihi kotak
   slider. Opsi bgsize:contain milik plugin tidak mempan menahannya.

   Solusi: kunci gambar latar agar tepat mengisi kotak slide, lalu
   pakai object-fit:contain supaya seluruh isi gambar terlihat dan
   tidak ada bagian yang terpotong.

   Catatan rasio: ketiga banner hero dibuat 2:1, sama dengan kotak
   slider yang tingginya 50vw, sehingga contain dan cover memberi hasil
   identik - gambar mengisi penuh dan tidak ada yang terpotong.
   Foto eSakip aslinya 16:9; versinya yang dipakai di sini
   (hero-esakip-simona.jpg) sudah dijadikan 2:1 dengan cara menambah
   lanjutan foto yang diburamkan di kiri-kanan, bukan dengan memotong.
   Banner baru sebaiknya juga dibuat 2:1 agar seragam.

   Membatalkan: hapus blok <style> ini.
   ------------------------------------------------------------------ */
#layerslider .ls-slide .ls-bg {
  left: 0 !important;
  top: 0 !important;
  width: 100% !important;
  height: 100% !important;
  max-width: none !important;
  max-height: none !important;
  object-fit: contain !important;
  object-position: center center !important;
}
</style>

<!-- Slider -->
<div id="full-slider-wrapper">
  <!-- Tinggi dibuat 50vw, bukan 750px tetap, supaya mengikuti rasio banner
       hero yang 2:1 (2400x1200). Dengan begitu gambar tampil selebar layar
       dan utuh - tidak terpotong kiri-kanan, tidak pula muncul bidang
       kosong di samping. Kalau banner diganti dengan rasio lain, sesuaikan
       nilai ini: tinggi = 100 / (lebar gambar : tinggi gambar) vw. -->
  <div id="layerslider" style="width:100%;height:50vw;">
    <!-- hero 1: banner Bupati dan Wakil Bupati 2025-2030 -->
    <div class="ls-slide" data-ls="slidedelay: 2500; transition2d:85; bgsize:contain; bgposition:center center;">
      <img src="<?= Url::base(true) ?>/udema/bappeda/hero-bupati-2025-2030.jpg" class="ls-bg" alt="Bupati dan Wakil Bupati Kabupaten Deli Serdang periode 2025-2030" data-ls="fillmode:fit;">
      <h3 class="ls-l slide_typo" style="top: 47%; left: 50%;" data-ls="offsetxin:0;durationin:2000;delayin:1000;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotatexout:90;transformoriginout:50% bottom 0;"><strong></strong></h3>
      <p class="ls-l slide_typo_2" style="top:55%; left:50%;" data-ls="durationin:2000;delayin:1000;easingin:easeOutElastic;">
      </p>
      <a class="ls-l" style="top:65%; left:50%;white-space: nowrap;" data-ls="durationin:2000;delayin:1400;easingin:easeOutElastic;" href='courses-grid.html'></a>
    </div>
    <!-- second slide -->
    <!-- <div class="ls-slide" data-ls="slidedelay:2500; transition2d:103;">
      <img src="<?= Url::base(true) ?>/udema/bappeda/ds-new2025_remus.png" class="ls-bg" alt="Slide background">
      <h3 class="ls-l slide_typo" style="top: 47%; left: 50%;" data-ls="offsetxin:0;durationin:2000;delayin:1000;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotatexout:90;transformoriginout:50% bottom 0;"><strong></strong></h3>
      <p class="ls-l slide_typo_2" style="top:55%; left:50%;" data-ls="durationin:2000;delayin:1000;easingin:easeOutElastic;">
      </p>
      <a class="ls-l" style="top:65%; left:50%;white-space: nowrap;" data-ls="durationin:2000;delayin:1400;easingin:easeOutElastic;" href='courses-grid.html'></a>
    </div> -->
    <!-- Thirf Slide -->
    <!-- <div class="ls-slide" data-ls="slidedelay:2500; transition2d:103;">
      <img src="<?= Url::base(true) ?>/udema/bappeda/profil-1.jpeg" class="ls-bg" alt="Slide background">
      <h3 class="ls-l slide_typo" style="top: 47%; left: 50%;" data-ls="offsetxin:0;durationin:2000;delayin:1000;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotatexout:90;transformoriginout:50% bottom 0;"><strong></strong></h3>
      <p class="ls-l slide_typo_2" style="top:55%; left:50%;" data-ls="durationin:2000;delayin:1000;easingin:easeOutElastic;">
      </p>
      <a class="ls-l" style="top:65%; left:50%;white-space: nowrap;" data-ls="durationin:2000;delayin:1400;easingin:easeOutElastic;" href='courses-grid.html'></a>
    </div> -->
    <!-- Fourth Slide -->
    <!-- <div class="ls-slide" data-ls="slidedelay:2500; transition2d:103; bgsize:contain;">
      <img src="<?= Url::base(true) ?>/udema/bappeda/profil-2.jpeg" class="ls-bg" alt="Slide background" data-ls="fillmode:fit;">
      <h3 class="ls-l slide_typo" style="top: 47%; left: 50%;" data-ls="offsetxin:0;durationin:2000;delayin:1000;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotatexout:90;transformoriginout:50% bottom 0;"><strong></strong></h3>
      <p class="ls-l slide_typo_2" style="top:55%; left:50%;" data-ls="durationin:2000;delayin:1000;easingin:easeOutElastic;">
      </p>
      <a class="ls-l" style="top:65%; left:50%;white-space: nowrap;" data-ls="durationin:2000;delayin:1400;easingin:easeOutElastic;" href='courses-grid.html'></a>
    </div> -->
    <!-- hero 2: banner website Bappedalitbang -->
    <div class="ls-slide" data-ls="slidedelay: 2500; transition2d:85; bgsize:contain; bgposition:center center;">
      <img src="<?= Url::base(true) ?>/udema/bappeda/hero-kepala-bappedalitbang.jpg" class="ls-bg" alt="Website Bappedalitbang Deli Serdang" data-ls="fillmode:fit;">
      <h3 class="ls-l slide_typo" style="top: 47%; left: 50%;" data-ls="offsetxin:0;durationin:2000;delayin:1000;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotatexout:90;transformoriginout:50% bottom 0;"><strong></strong></h3>
      <p class="ls-l slide_typo_2" style="top:55%; left:50%;" data-ls="durationin:2000;delayin:1000;easingin:easeOutElastic;">
      </p>
      <a class="ls-l" style="top:65%; left:50%;white-space: nowrap;" data-ls="durationin:2000;delayin:1400;easingin:easeOutElastic;" href='courses-grid.html'></a>
    </div>
    <!-- hero 3: promo eSakip SIMONALISA (punya tombol "Explore") -->
    <div class="ls-slide" data-ls="slidedelay: 2500; transition2d:85; bgsize:contain; bgposition:center center;">
      <img src="<?= Url::base(true) ?>/udema/bappeda/hero-esakip-simona.jpg" class="ls-bg" alt="Aplikasi eSakip SIMONALISA" data-ls="fillmode:fit;">
      <h3 class="ls-l slide_typo" style="top:47%; left: 50%; background-color:black;" data-ls="offsetxin:0;durationin:2000;delayin:1000;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotatexout:90;transformoriginout:50% bottom 0;"><strong>Aplikasi</strong> eSakip SIMONALISA</h3>
      <p class="ls-l slide_typo_2" style="top:55%; left:50%; background-color:black;" data-ls="durationin:2000;delayin:1000;easingin:easeOutElastic;">
        Sistem Akuntabilitas Kinerja Instansi Pemerintah secara elektronik dan Monitoring Analisa
      </p>
      <a class="ls-l btn_1 rounded" style="top:65%; left:50%; background-color:#4974b1" data-ls="durationin:2000;delayin:1400;easingin:easeOutElastic;" href='https://esakipsimonalisa.deliserdangkab.go.id/' target="_blank" rel="noopener noreferrer">Explore</a>
    </div>
  </div>
</div>
<!-- End layerslider -->
<marquee class="pt-1 pb-1 text-muted bg-light">
  <strong class="text-info d-flex mx-5 gap-5">
    <div style="color: black;">
      <i class="bi bi-browser-edge"></i> Selamat datang di Website Bappedalitbang Deli Serdang
    </div>
    <!-- <div style="color: black;">
      <i class="bi bi-browser-edge"></i> Selamat Hari Ulang Tahun Deli Serdang ke - 79
    </div> -->  </strong>
</marquee>

<div class="features clearfix">

  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <figure class="text-center">
          <a href="https://dokrenbang.deliserdangkab.go.id/">
            <img src="<?= Url::base(true) ?>/udema/bappeda/icons8-planner-100.png" alt="">
          </a>
        </figure>
        <div class="text-center">
          <a class="btn btn-primary" href="https://dokrenbang.deliserdangkab.go.id/frontend/web/index.php?r=site%2Findex#pedoman" target="_blank" rel="noreferrer noopener">
            <strong>RKPD</strong>
          </a>
        </div>
        <p class="text-center small-font-size">Rencana Kerja Pemerintah Daerah</p>
        <div style="height:20px;" aria-hidden="true" class="spacer"></div>
      </div>
      <div class="col-md-3">
        <figure class="text-center">
          <a href="https://dokrenbang.deliserdangkab.go.id/">
            <img src="<?= Url::base(true) ?>/udema/bappeda/icons8-goal-100.png" alt="">
          </a>
        </figure>
        <div class="text-center">
          <a class="btn btn-primary" href="https://dokrenbang.deliserdangkab.go.id/frontend/web/index.php?r=site%2Findex#pedoman" target="_blank" rel="noreferrer noopener">
            <strong>RENSTRA</strong>
          </a>
        </div>
        <p class="text-center small-font-size">Rencana Strategis Pemerintah Daerah</p>
        <div style="height:20px;" aria-hidden="true" class="spacer"></div>
      </div>
      <div class="col-md-3">
        <figure class="text-center">
          <a href="https://dokrenbang.deliserdangkab.go.id/">
            <img src="<?= Url::base(true) ?>/udema/bappeda/icons8-document-100.png" alt="">
          </a>
        </figure>
        <div class="text-center">
          <a class="btn btn-primary" href="https://dokrenbang.deliserdangkab.go.id/frontend/web/index.php?r=site%2Findex#pedoman" target="_blank" rel="noreferrer noopener">
            <strong>RPJMD</strong>
          </a>
        </div>
        <p class="text-center small-font-size">Rencana Pembangunan Jangka Menengah Pemerintah Daerah</p>
        <div style="height:20px;" aria-hidden="true" class="spacer"></div>
      </div>
      <div class="col-md-3">
        <figure class="text-center">
          <a href="https://dokrenbang.deliserdangkab.go.id/">
            <img src="<?= Url::base(true) ?>/udema/bappeda/icons8-graph-100.png" alt="">
          </a>
        </figure>
        <div class="text-center">
          <a class="btn btn-primary" href="https://dokrenbang.deliserdangkab.go.id/frontend/web/index.php?r=site%2Findex#pedoman" target="_blank" rel="noreferrer noopener">
            <strong>RPJPD</strong>
          </a>
        </div>
        <p class="text-center small-font-size">Rencana Pembangunan Jangka Panjang Pemerintah Daerah</p>
        <div style="height:20px;" aria-hidden="true" class="spacer"></div>
      </div>
    </div>
  </div>
</div>
<!-- /features -->

<style>
  .sp_banner_section {
    padding: 30px 0;
  }

  .sp_banner {
    background: linear-gradient(135deg, #2c467d 0%, #4974b1 100%);
    border-radius: 12px;
    padding: 45px 50px;
    color: #fff;
    box-shadow: 0 10px 30px rgba(44, 70, 125, 0.25);
  }

  .sp_banner h3 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 15px;
  }

  .sp_banner h3 i {
    margin-right: 10px;
  }

  .sp_banner p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
  }

  .sp_banner .btn_sp {
    display: inline-block;
    background: #fff;
    color: #2c467d;
    font-weight: 700;
    padding: 14px 32px;
    border-radius: 30px;
    text-decoration: none;
    transition: transform .2s ease, box-shadow .2s ease;
    white-space: nowrap;
  }

  .sp_banner .btn_sp:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
    color: #2c467d;
  }

  @media (max-width: 991px) {
    .sp_banner {
      padding: 35px 30px;
      text-align: center;
    }

    .sp_banner .btn_sp {
      margin-top: 25px;
    }
  }
</style>
<div class="sp_banner_section">
  <div class="container">
    <div class="sp_banner">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h3><i class="fa fa-file-circle-check"></i>Standar Pelayanan</h3>
          <p>
            Bappedalitbang Kabupaten Deli Serdang berkomitmen memberikan pelayanan publik yang
            transparan, akuntabel, dan berkualitas. Untuk melihat dokumen Standar Pelayanan kami
            &mdash; mulai dari asistensi perencanaan, verifikasi dokumen perencanaan, rekomendasi
            izin penelitian, hingga konsultasi &mdash; silakan menuju ke halaman Standar Pelayanan
            melalui tombol berikut.
          </p>
        </div>
        <div class="col-lg-4 text-center">
          <a href="<?= Url::to(['/standar-pelayanan/index']) ?>" class="btn_sp">Lihat Standar Pelayanan &rarr;</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /sp_banner_section -->

<div class="bg_color_1">
  <div class="container margin_120_95">
    <div class="main_title_2">
      <span><em></em></span>
      <h2>Berita Perencanaan</h2>
      <p>Berita Perencanaan Bidang Bidang Bappedalitbang Deli Serdang</p>
    </div>
    <div class="row">
      <?php foreach ($latestBerita as $berita): ?>
        <div class="col-lg-6">
          <a class="box_news" href="<?= Url::to(['berita/view', 'id' => $berita->id]) ?>">
            <figure>
              <img src="<?= Url::base(true) ?>/uploads/berita/<?= Html::encode($berita->file) ?>" alt="">
              <figcaption><strong><?= Yii::$app->formatter->asDate($berita->tgl_berita, 'php:d') ?></strong><?= Yii::$app->formatter->asDate($berita->tgl_berita, 'php:M') ?></figcaption>
            </figure>
            <ul>
              <li><?= Html::encode($berita->bidang->bidang) ?></li>
              <li><?= Yii::$app->formatter->asDate($berita->tgl_berita) ?></li>
            </ul>
            <h4><?= Html::encode($berita->judulBerita) ?></h4>
            <p><?= Html::encode(mb_strimwidth(strip_tags($berita->isiBerita), 0, 150, '...')) ?></p>
          </a>
        </div>
        <!-- /box_news -->
      <?php endforeach; ?>
    </div>
    <!-- /row -->
    <p class="btn_home_align"><a href="<?= Url::to(['berita/index']) ?>" class="btn_1 rounded">Lihat Semua Berita</a></p>
  </div>
  <!-- /container -->
</div>
<!-- /bg_color_1 -->

<div class="call_section">
  <div class="container clearfix">
    <div class="col-lg-5 col-md-6 float-right wow position-relative" data-wow-offset="250">
      <div class="block-reveal">
        <div class="block-vertical"></div>
        <div class="box_1">
          <h3><?= Html::decode($visiMisi->visiJudul) ?></h3>
          <p><?= Html::decode($visiMisi->visiTeks) ?></p>
          <a href="<?= Url::to(['visimisi/index']) ?>" class="btn_1 rounded">Lihat Visi Misi &rarr;</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/call_section-->

<!-- /main -->