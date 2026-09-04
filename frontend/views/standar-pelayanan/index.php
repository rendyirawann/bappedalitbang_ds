<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var frontend\models\search\StandarPelayananSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Standar Pelayanan';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.sp-file-list {
		max-width: 900px;
		margin: 0 auto;
	}

	.sp-year-header {
		display: flex;
		align-items: center;
		gap: 15px;
		margin: 30px 0 15px 0;
	}

	.sp-year-header h4 {
		margin: 0;
		font-weight: 600;
		color: #2c467d;
		white-space: nowrap;
	}

	.sp-year-header:after {
		content: '';
		flex: 1;
		height: 2px;
		background: #e1e8f0;
	}

	.sp-file-item {
		display: flex;
		align-items: center;
		gap: 18px;
		background: #fff;
		border: 1px solid #e1e8f0;
		border-radius: 8px;
		padding: 18px 22px;
		margin-bottom: 12px;
		transition: box-shadow .2s ease, transform .2s ease;
	}

	.sp-file-item:hover {
		box-shadow: 0 6px 18px rgba(44, 70, 125, 0.12);
		transform: translateY(-2px);
	}

	.sp-file-icon {
		flex-shrink: 0;
		width: 52px;
		height: 52px;
		border-radius: 8px;
		background: #eef3fa;
		color: #4974b1;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 1.5rem;
	}

	.sp-file-info {
		flex: 1;
		min-width: 0;
	}

	.sp-file-info h5 {
		margin: 0 0 4px 0;
		font-size: 1rem;
		font-weight: 600;
		color: #333;
	}

	.sp-file-info .sp-file-year {
		font-size: .85rem;
		color: #777;
	}

	.sp-file-actions {
		flex-shrink: 0;
		display: flex;
		gap: 8px;
	}

	.sp-btn {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		border: none;
		border-radius: 25px;
		padding: 8px 18px;
		font-size: .85rem;
		font-weight: 600;
		cursor: pointer;
		text-decoration: none;
		transition: background .2s ease;
	}

	.sp-btn-view {
		background: #4974b1;
		color: #fff;
	}

	.sp-btn-view:hover {
		background: #2c467d;
		color: #fff;
	}

	.sp-btn-download {
		background: #eef3fa;
		color: #2c467d;
	}

	.sp-btn-download:hover {
		background: #dbe6f5;
		color: #2c467d;
	}

	@media (max-width: 575px) {
		.sp-file-item {
			flex-direction: column;
			align-items: flex-start;
		}

		.sp-file-actions {
			width: 100%;
			justify-content: flex-end;
		}
	}

	/* ---------- Modal Viewer ---------- */
	#sp-viewer-overlay {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(0, 0, 0, 0.75);
		z-index: 99999;
		padding: 20px;
	}

	#sp-viewer-overlay.open {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.sp-viewer-dialog {
		background: #fff;
		border-radius: 10px;
		width: 100%;
		max-width: 950px;
		max-height: calc(100vh - 40px);
		display: flex;
		flex-direction: column;
		overflow: hidden;
	}

	.sp-viewer-header {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 14px 20px;
		border-bottom: 1px solid #e1e8f0;
		background: #f7f9fc;
	}

	.sp-viewer-header h5 {
		flex: 1;
		margin: 0;
		font-size: 1rem;
		font-weight: 600;
		color: #2c467d;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	.sp-viewer-close {
		flex-shrink: 0;
		border: none;
		background: transparent;
		font-size: 1.6rem;
		line-height: 1;
		color: #555;
		cursor: pointer;
		padding: 0 4px;
	}

	.sp-viewer-close:hover {
		color: #000;
	}

	.sp-viewer-body {
		overflow-y: auto;
		padding: 20px;
		background: #525659;
		text-align: center;
	}

	.sp-viewer-body canvas,
	.sp-viewer-body img {
		max-width: 100%;
		height: auto;
		display: block;
		margin: 0 auto 15px auto;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
		background: #fff;
	}

	.sp-viewer-loader {
		display: none;
		margin: 40px auto;
		width: 44px;
		height: 44px;
		border: 4px solid rgba(255, 255, 255, 0.3);
		border-top-color: #fff;
		border-radius: 50%;
		animation: sp-spin 1s linear infinite;
	}

	@keyframes sp-spin {
		to {
			transform: rotate(360deg);
		}
	}

	.sp-viewer-error {
		color: #ffd7d7;
		padding: 30px 10px;
	}
</style>

<section id="hero_in" class="general">
	<div class="wrapper">
		<div class="container">
			<h1 class="fadeInUp"><span></span>Standar Pelayanan</h1>
		</div>
	</div>
</section>
<!--/hero_in-->

<div class="container margin_60_35">
	<div class="main_title_2">
		<span><em></em></span>
		<h2>Standar Pelayanan</h2>
		<p>Dokumen Standar Pelayanan Bappedalitbang Kabupaten Deli Serdang</p>
	</div>

	<div class="sp-file-list">
		<?php $currentTahun = null; ?>
		<?php foreach ($dataProvider->getModels() as $model): ?>
			<?php if ($model->tahun !== $currentTahun): $currentTahun = $model->tahun; ?>
				<div class="sp-year-header">
					<h4><i class="fa fa-calendar"></i> Tahun <?= Html::encode($model->tahun) ?></h4>
				</div>
			<?php endif; ?>
			<?php
			$fileUrl = Url::base(true) . '/uploads/standar-pelayanan/' . rawurlencode($model->file);
			$downloadUrl = Url::to(['standar-pelayanan/download', 'id' => $model->id]);
			?>
			<div class="sp-file-item">
				<div class="sp-file-icon">
					<i class="fa <?= $model->isPdf ? 'fa-file-pdf' : 'fa-file-image' ?>"></i>
				</div>
				<div class="sp-file-info">
					<h5><?= Html::encode($model->namaFile) ?></h5>
					<span class="sp-file-year"><i class="fa fa-calendar"></i> Tahun <?= Html::encode($model->tahun) ?></span>
				</div>
				<div class="sp-file-actions">
					<button type="button" class="sp-btn sp-btn-view"
						data-url="<?= Html::encode($fileUrl) ?>"
						data-title="<?= Html::encode($model->namaFile) ?>"
						data-type="<?= $model->isPdf ? 'pdf' : 'image' ?>">
						<i class="fa fa-eye"></i> View
					</button>
					<a class="sp-btn sp-btn-download" href="<?= $downloadUrl ?>">
						<i class="fa fa-download"></i> Download
					</a>
				</div>
			</div>
		<?php endforeach; ?>

		<?php if (count($dataProvider->getModels()) === 0): ?>
			<p class="text-center">Belum ada dokumen Standar Pelayanan.</p>
		<?php endif; ?>
	</div>
</div>
<!-- /container -->

<!-- Modal Viewer Standar Pelayanan -->
<div id="sp-viewer-overlay">
	<div class="sp-viewer-dialog">
		<div class="sp-viewer-header">
			<h5 id="sp-viewer-title"></h5>
			<a id="sp-viewer-download" class="sp-btn sp-btn-download" href="#"><i class="fa fa-download"></i> Download</a>
			<button type="button" class="sp-viewer-close" aria-label="Close">&times;</button>
		</div>
		<div class="sp-viewer-body">
			<div class="sp-viewer-loader"></div>
			<div id="sp-viewer-content"></div>
		</div>
	</div>
</div>

<?php
$js = <<<JS
(function () {
    // --- STANDAR PELAYANAN VIEWER LOGIC (PDF.JS INTEGRATION) ---
    var overlay = document.getElementById('sp-viewer-overlay');
    var titleEl = document.getElementById('sp-viewer-title');
    var contentEl = document.getElementById('sp-viewer-content');
    var downloadEl = document.getElementById('sp-viewer-download');
    var loader = overlay.querySelector('.sp-viewer-loader');
    var closeBtn = overlay.querySelector('.sp-viewer-close');
    var pdfLibLoaded = false;
    var renderToken = 0;

    function loadPdfLib(callback) {
        if (pdfLibLoaded && window.pdfjsLib) {
            callback();
            return;
        }
        var scriptPdf = document.createElement('script');
        scriptPdf.src = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js";
        scriptPdf.onload = function () {
            pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
            pdfLibLoaded = true;
            callback();
        };
        scriptPdf.onerror = function () {
            showError('Gagal memuat library PDF.');
        };
        document.head.appendChild(scriptPdf);
    }

    function showError(message) {
        loader.style.display = 'none';
        contentEl.innerHTML = '<div class="sp-viewer-error">' + message + '</div>';
    }

    function renderPdf(url, token) {
        loadPdfLib(function () {
            if (token !== renderToken) return;
            pdfjsLib.getDocument(url).promise.then(function (pdf) {
                if (token !== renderToken) return;
                loader.style.display = 'none';

                var renderPage = function (num) {
                    if (token !== renderToken || num > pdf.numPages) return;
                    pdf.getPage(num).then(function (page) {
                        if (token !== renderToken) return;
                        var viewport = page.getViewport({ scale: 3 }); // Scale 3 untuk kualitas HD ultra-tajam
                        var canvas = document.createElement('canvas');
                        var ctx = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        contentEl.appendChild(canvas);

                        page.render({ canvasContext: ctx, viewport: viewport }).promise.then(function () {
                            renderPage(num + 1); // render halaman berikutnya (tampil full dokumen)
                        });
                    });
                };

                renderPage(1);
            }).catch(function (err) {
                console.error("PDF Load Error:", err);
                if (token === renderToken) showError('Gagal memuat PDF.');
            });
        });
    }

    function openViewer(url, title, type) {
        renderToken++;
        var token = renderToken;

        titleEl.textContent = title;
        contentEl.innerHTML = '';
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';

        if (type === 'pdf') {
            loader.style.display = 'block';
            renderPdf(url, token);
        } else {
            loader.style.display = 'block';
            var img = document.createElement('img');
            img.alt = title;
            img.onload = function () {
                if (token === renderToken) loader.style.display = 'none';
            };
            img.onerror = function () {
                if (token === renderToken) showError('Gagal memuat gambar.');
            };
            img.src = url;
            contentEl.appendChild(img);
        }
    }

    function closeViewer() {
        renderToken++;
        overlay.classList.remove('open');
        contentEl.innerHTML = '';
        loader.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.sp-btn-view').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.sp-file-item');
            var downloadLink = item ? item.querySelector('.sp-btn-download') : null;
            downloadEl.href = downloadLink ? downloadLink.href : '#';
            openViewer(btn.dataset.url, btn.dataset.title, btn.dataset.type);
        });
    });

    closeBtn.addEventListener('click', closeViewer);
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeViewer();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('open')) closeViewer();
    });
})();
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
