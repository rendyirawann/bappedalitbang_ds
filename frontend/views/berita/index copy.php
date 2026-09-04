<?php

use frontend\models\Berita;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\search\BeritaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Beritas';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="hero_in" class="general">
			<div class="wrapper">
				<div class="container">
					<h1 class="fadeInUp"><span></span>Berita Perencanaan</h1>
				</div>
			</div>
		</section>
		<!--/hero_in-->

		<div class="container margin_60_35">
			<div class="row">
				<div class="col-lg-9">
                    foreach disini
					<article class="blog wow fadeIn">
						<div class="row g-0">
							<div class="col-lg-7">
								<figure>
									<a href="blog-post.html"><img src="<?= Url::base(true) ?>/uploads/berita/<?= Html::encode($berita->file) ?>" alt="">
										<div class="preview"><span>Baca Lebih Lanjut</span></div>
									</a>
								</figure>
							</div>
							<div class="col-lg-5">
								<div class="post_info">
									<small>tgl_berita</small>
									<h3><a href="blog-post.html">judulBerita</a></h3>
									<p>isiBerita(limit kata kata dari isiBerita)</p>
									<ul>
										<li>
											<i class="fa fa-user"></i>bidang_id
										</li>
									</ul>
								</div>
							</div>
						</div>
					</article>
                    end foreach
					<!-- /article -->

                    buat agar paginationnya berfungsi dengan registerJS
					<nav aria-label="...">
						<ul class="pagination pagination-sm">
							<li class="page-item disabled">
								<a class="page-link" href="#" tabindex="-1">Previous</a>
							</li>
							<li class="page-item"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item">
								<a class="page-link" href="#">Next</a>
							</li>
						</ul>
					</nav>
					<!-- /pagination -->
				</div>
				<!-- /col -->

				<aside class="col-lg-3">
					<!-- /widget -->
					<div class="widget">
						<div class="widget-title">
							<h4>Berita Terbaru</h4>
						</div>
						<ul class="comments-list">
                            foreach disini
							<li>
								<div class="alignleft">
									<a href="#0"><img src="<?= Url::base(true) ?>/uploads/berita/<?= Html::encode($berita->file) ?>" alt=""></a>
								</div>
								<small>tgl_berita</small>
								<h3><a href="#" title="">judulBerita</a></h3>
							</li>
						</ul>
					</div>
					<!-- /widget -->
					<div class="widget">
						<div class="widget-title">
							<h4>Kategori Bidang Berita</h4>
						</div>
						<ul class="cats">
							<li><a>bidang_id = 1 <span>(count berita yang memiliki bidang_id = 1)</span></a></li>
							<li><a>bidang_id = 2 <span>(count berita yang memiliki bidang_id = 2)</span></a></li>
							<li><a>bidang_id = 3 <span>(count berita yang memiliki bidang_id = 3)</span></a></li>
							<li><a>bidang_id = 4 <span>(count berita yang memiliki bidang_id = 4)</span></a></li>
							<li><a>bidang_id = 5 <span>(count berita yang memiliki bidang_id = 5)</span></a></li>
							<li><a>bidang_id = 6 <span>(count berita yang memiliki bidang_id = 6)</span></a></li>
							<li><a>bidang_id = 7 <span>(count berita yang memiliki bidang_id = 7)</span></a></li>
							<li><a>bidang_id = 8 <span>(count berita yang memiliki bidang_id = 8)</span></a></li>
						</ul>
					</div>
					<!-- /widget -->
				</aside>
				<!-- /aside -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
