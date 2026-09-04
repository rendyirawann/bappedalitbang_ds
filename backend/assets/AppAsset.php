<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800',
        'udema/vendor/bootstrap/css/bootstrap.min.css',
        'udema/css/admin.css',
        'udema/vendor/font-awesome/css/font-awesome.min.css',
        'udema/vendor/datatables/dataTables.bootstrap4.css',
        'udema/css/custom.css',
    ];
    public $js = [
        // 'udema/vendor/jquery/jquery.min.js',
        'udema/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'udema/vendor/jquery-easing/jquery.easing.min.js',
        'udema/vendor/chart.js/Chart.js',
        'udema/vendor/datatables/jquery.dataTables.js',
        'udema/vendor/datatables/dataTables.bootstrap4.js',
        'udema/vendor/jquery.selectbox-0.2.js',
        'udema/vendor/retina-replace.min.js',
        'udema/vendor/jquery.magnific-popup.min.js',
        'udema/js/admin.js',
        'udema/js/admin-charts.js',
        'udema/js/admin-datatables.js',
        'udema/js/admin-charts-all.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
