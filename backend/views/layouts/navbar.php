<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
// Hitung jumlah daftar masuk hari ini
$countNotification = \backend\models\Berita::find()
  ->count();
$countBeritaBaru = \backend\models\Berita::find()
  ->where(['status' => 0])
  ->andWhere(['>=', 'tgl_berita', date('Y-m-d 00:00:00')])
  ->andWhere(['<=', 'tgl_berita', date('Y-m-d 23:59:59')])
  ->count();

$countBeritaReview = \backend\models\Berita::find()
  ->where(['status' => 0])
  ->count();
?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
  <a class="navbar-brand" href="https://bappedalitbang.deliserdangkab.go.id/"><img src="<?= Url::base(true) ?>/udema/bappeda/bappeda.png" data-retina="true" alt="Logo Deli Serdang" width="36"> Admin Bappedalitbang</a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
        <a class="nav-link" href="<?= Url::to(['/site/index']) ?>">
          <i class="fa fa-fw fa-dashboard"></i>
          <span class="nav-link-text">Dashboard</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Messages">
        <a class="nav-link" href="<?= Url::to(['/berita/index']) ?>">
          <i class="fa fa-fw fa-book"></i>
          <span class="nav-link-text">Berita Perencanaan</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tahapan Perencanaan">
        <a class="nav-link" href="<?= Url::to(['/tahapan/index']) ?>">
          <i class="fa fa-fw fa-list"></i>
          <span class="nav-link-text">Tahapan Perencanaan</span>
        </a>
      </li>
      <?php
      $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
      if (isset($assignments['superadmin']) || isset($assignments['admin'])) {
      ?>
        <!-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Bookings">
          <a class="nav-link" href="courses.html">
            <i class="fa fa-fw fa-archive"></i>
            <span class="nav-link-text">Courses <span class="badge badge-pill badge-primary">6 New</span></span>
          </a>
        </li> -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseUnduhan" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-download"></i>
            <span class="nav-link-text">Bappeda Unduhan</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseUnduhan">
            <li>
              <a href="<?= Url::to(['/unduhan/index']) ?>">Berkas Unduhan</a>
            </li>
            <li>
              <a href="<?= Url::to(['/profil/index']) ?>">Berkas Profil</a>
            </li>

          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Reviews">
          <a class="nav-link" href="<?= Url::to(['/galeri/index']) ?>">
            <i class="fa fa-fw fa-image"></i>
            <span class="nav-link-text">Galeri</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Standar Pelayanan">
          <a class="nav-link" href="<?= Url::to(['/standar-pelayanan/index']) ?>">
            <i class="fa fa-fw fa-file-text"></i>
            <span class="nav-link-text">Standar Pelayanan</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Bookmarks">
          <a class="nav-link" href="<?= Url::to(['/visimisi/index']) ?>">
            <i class="fa fa-fw fa-bullseye"></i>
            <span class="nav-link-text">Visi Misi</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Add listing">
          <a class="nav-link" href="<?= Url::to(['/struktur/index']) ?>">
            <i class="fa fa-fw fa-users"></i>
            <span class="nav-link-text">Struktur</span>
          </a>
        </li>
        <li class="nav-header ms-3">ADMIN MENU</li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseProfile" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">User</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseProfile">
    <?php
      $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
      if (isset($assignments['superadmin'])) {
      ?>

            <li>
              <a href="<?= Url::to(['/user/index']) ?>">Data User</a>
            </li>
 <?php } ?>
            <li>
              <a href="<?= Url::to(['/pegawai/index']) ?>">Data Pegawai</a>
            </li>
            <li>
              <a href="<?= Url::to(['/title/index']) ?>">Data Title</a>
            </li>
            <li>
              <a href="<?= Url::to(['/pegawai-eselon/index']) ?>">Data Kategori Eselon</a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <?php
      $assignments = Yii::$app->authManager->getAssignments(Yii::$app->user->getId());
      if (isset($assignments['superadmin'])) {
      ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-gear"></i>
            <span class="nav-link-text">RBAC</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
              <a href="<?= Url::to(['/admin/assignment']) ?>">Assignment</a>
            </li>
            <li>
              <a href="<?= Url::to(['/admin/role']) ?>">Roles</a>
            </li>
            <li>
              <a href="<?= Url::to(['/admin/route']) ?>">Routes</a>
            </li>
            <li>
              <a href="<?= Url::to(['/admin/rule']) ?>">Rules</a>
            </li>
            <li>
              <a href="<?= Url::to(['/admin/menu']) ?>">Menu</a>
            </li>
            <li>
              <a href="<?= Url::to(['/admin/user']) ?>">User</a>
            </li>
          </ul>
        </li>
      <?php } ?>
    </ul>
    <ul class="navbar-nav sidenav-toggler">
      <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler">
          <i class="fa fa-fw fa-angle-left"></i>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell"></i>
          <span class="d-lg-none">Notifikasi Baru
            <span class="badge badge-pill badge-warning"><?= $countNotification ?></span>
          </span>
          <span class="indicator text-warning d-none d-lg-block">
            <i class="fa fa-fw fa-circle"></i>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"> Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-book"></i> <?= $countBeritaBaru ?> Berita Baru
            <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <i class="fa fa-book ms-4"></i> <?= $countBeritaReview ?> Berita Review
          <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
          </a>
          <div class="dropdown-divider"></div>
          <!-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div> -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-user"></i>
          <span class="d-lg-none"> Akun - <?= Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username ?>

            <span class="badge badge-pill badge-warning"></span>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Pengaturan Akun - <?= Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username ?>
          </span>
          <div class="dropdown-divider"></div>
          <a href="<?= Url::to(['site/change-profile', 'id' => Yii::$app->user->id]) ?>" class="dropdown-item">
            <i class="fa fa-key"></i> Ganti Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= Url::to(['/site/logout']) ?>" class="dropdown-item dropdown-footer" data-method="post"><i class="fa fa-power-off"></i> Keluar</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
          <i class="fa fa-fw fa-sign-out"></i>Logout</a>
      </li>
    </ul>
  </div>
</nav>
<!-- /Navigation-->