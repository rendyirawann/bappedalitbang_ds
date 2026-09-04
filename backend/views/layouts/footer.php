<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>
<!-- <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Bappedalitbang 2024</small>
        </div>
      </div>
    </footer> -->
    <footer>
          <div class="pull-right mr-3">
          Copyright © <a href="<?= Url::to(['/site/index']) ?>">Bappedalitbang </a>2024
          </div>
          <div class="clearfix"></div>
        </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin Ingin Keluar?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?= Url::to(['/site/logout']) ?>"  data-method="post">Logout</a>
          </div>
        </div>
      </div>
    </div>