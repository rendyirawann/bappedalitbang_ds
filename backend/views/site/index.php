<?php
use yii\helpers\Url;
/** @var yii\web\View $this */

$this->title = 'Website Bappedalitbang Deli Serdang';
// Register JS for the Bar Chart
$labels = json_encode($bidangLabels);
$data = json_encode($bidangCounts);

$this->registerJs("
$('#activityLogTable').DataTable({
        'order': [[ 0, 'desc' ]], 
        'pageLength': 5,
        'lengthMenu': [5, 10, 25, 50]
    });    // -- Bar Chart Example
    var ctx = document.getElementById('myBarChart');
    var myLineChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: $labels,
        datasets: [{
          label: 'Jumlah Berita',
          backgroundColor: 'rgba(2,117,216,1)',
          borderColor: 'rgba(2,117,216,1)',
          data: $data,
        }],
      },
      options: {
        scales: {
          xAxes: [{
            ticks: {
              fontSize: 10, // Mengatur ukuran font label x-axis menjadi lebih kecil
              maxRotation: 45, // Rotasi label agar lebih terlihat
              minRotation: 45, // Menjaga label tetap horizontal
              autoSkip: false, // Menampilkan semua label meskipun rapat
            },
            gridLines: {
              display: false
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              maxTicksLimit: 5
            },
            gridLines: {
              display: true
            }
          }],
        },
        tooltips: {
          callbacks: {
            title: function(tooltipItem, data) {
              return data.labels[tooltipItem[0].index]; // Menampilkan label lengkap di tooltip
            }
          }
        },
        legend: {
          display: false
        }
      }
    });
");
?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>
	  <!-- Icon Cards-->
      <div class="row">
      <?php if (Yii::$app->session->hasFlash('success')): ?>
              <div class="alert alert-success">
                  <?= Yii::$app->session->getFlash('success') ?>
              </div>
          <?php endif; ?>

          <?php if (Yii::$app->session->hasFlash('error')): ?>
              <div class="alert alert-danger">
                  <?= Yii::$app->session->getFlash('error') ?>
              </div>
          <?php endif; ?>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card dashboard text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-book"></i>
              </div>
              <div class="mr-5"><h5><?= $countBeritaPerencanaan ?> Berita Perencanaan</h5></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?= Url::to(['berita/index']) ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card dashboard text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-book"></i>
              </div>
              <div class="mr-5"><h5><?= $countBeritaReview ?> Berita Perlu di Review</h5></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?= Url::to(['berita/index']) ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card dashboard text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-book"></i>
              </div>
              <div class="mr-5"><h5><?= $countBeritaPublish ?> Berita Publish</h5></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?= Url::to(['berita/index']) ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card dashboard text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-image"></i>
              </div>
              <div class="mr-5"><h5><?= $countGaleri ?> Galeri Kegiatan</h5></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?= Url::to(['galeri/index']) ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

		</div>
		<!-- /cards -->
<!-- Area Chart Example-->
<div class="row">
        <div class="col-lg-12">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> Data Berita Bidang</div>
            <div class="card-body">
              <canvas id="myBarChart" width="100" height="50"></canvas>
            </div>
            <div class="card-footer small text-muted">Data Table</div>
          </div>
        </div>
        <div class="col-lg-12">
        <div class="card mb-3">
  <div class="card-header"><i class="fa fa-history"></i> Log Aktivitas Terakhir</div>
  <div class="card-body">
    <div class="table-responsive">
     <table class="table table-bordered" id="activityLogTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Waktu</th>
            <th>User</th>
            <th>Aksi</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentLogs as $log): ?>
          <tr>
            <td><?= Yii::$app->formatter->asDatetime($log->created_at) ?></td>
            <td><?= $log->username ?></td>
            <td>
                <?php 
                $cls = ($log->action=='DELETE')?'danger':(($log->action=='CREATE')?'success':'info');
                echo "<span class='badge badge-$cls'>$log->action</span>"; 
                ?>
            </td>
            <td>
                <b><?= $log->model ?>:</b> <?= $log->description ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
          </div>
		</div>
	  </div>
	  <!-- /.container-fluid-->
   	</div>
    <!-- /.container-wrapper-->

    