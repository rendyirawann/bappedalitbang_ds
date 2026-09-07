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
   slider yang tingginya 50vw, sehingga gambar mengisi penuh sampai
   tepi kiri-kanan.

   Dua banner Bupati dan Website memang sudah 2:1 sejak dari desainnya,
   jadi utuh apa adanya. Foto eSakip aslinya 16:9 (simona.jpg) dan
   diproses jadi hero-esakip.jpg dengan pemotongan tengah: hilang
   sekitar 5,5% di atas dan di bawah, tidak ada teks yang terkena
   karena judul dan tombol slide berasal dari overlay slider.

   Banner baru sebaiknya dibuat langsung 2:1 agar tidak perlu diproses.

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

<?php
/* ------------------------------------------------------------------
   Slider halaman depan - sejak 7 September 2026 isinya diambil dari
   tabel hero_slider, bukan lagi ditulis satu per satu di berkas ini.
   Menambah, mengubah, dan menghapus banner dilakukan lewat menu
   "Banner Halaman Depan" di backend (akun developer dan admin).

   Ukuran gambar sudah diseragamkan menjadi 2400x1200 (2:1) oleh
   common\components\HeroImage saat diunggah, sehingga cocok dengan
   tinggi slider 50vw dan tidak pernah terpotong atau ter-zoom.

   Slide tanpa judul ditampilkan sebagai gambar polos - dipakai banner
   yang tulisannya sudah menyatu di dalam gambar. Slide yang mengisi
   judul akan mendapat lapisan teks di atas gambarnya, seperti eSakip.
   ------------------------------------------------------------------ */
$heroSlides = \common\models\HeroSlider::yangTampil();
?>
<?php if (!empty($heroSlides)): ?>
<!-- Slider -->
<div id="full-slider-wrapper">
  <div id="layerslider" style="width:100%;height:50vw;">
    <?php foreach ($heroSlides as $slide): ?>
    <div class="ls-slide" data-ls="slidedelay: 2500; transition2d:85; bgsize:contain; bgposition:center center;">
      <img src="<?= Html::encode($slide->urlGambarFrontend()) ?>"
           class="ls-bg"
           alt="<?= Html::encode($slide->judul ?: 'Banner Bappedalitbang Deli Serdang') ?>"
           data-ls="fillmode:fit;">

      <?php if ($slide->punyaTeks()): ?>
        <h3 class="ls-l slide_typo" style="top:47%; left:50%; background-color:black;" data-ls="offsetxin:0;durationin:2000;delayin:1000;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotatexout:90;transformoriginout:50% bottom 0;"><?= Html::encode($slide->judul) ?></h3>

        <?php if (!empty($slide->subjudul)): ?>
          <p class="ls-l slide_typo_2" style="top:55%; left:50%; background-color:black;" data-ls="durationin:2000;delayin:1000;easingin:easeOutElastic;"><?= Html::encode($slide->subjudul) ?></p>
        <?php endif; ?>

        <?php if ($slide->punyaTombol()): ?>
          <a class="ls-l btn_1 rounded" style="top:65%; left:50%; background-color:#4974b1" data-ls="durationin:2000;delayin:1400;easingin:easeOutElastic;" href="<?= Html::encode($slide->url_tombol) ?>" target="_blank" rel="noopener noreferrer"><?= Html::encode($slide->teks_tombol) ?></a>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<!-- End layerslider -->
<?php endif; ?>
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