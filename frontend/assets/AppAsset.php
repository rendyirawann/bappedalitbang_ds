<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap',
        'udema/css/bootstrap.min.css',
        'udema/css/style.css',
        'udema/css/vendors.css',
        'udema/css/icon_fonts/css/all_icons.min.css',
        'udema/css/custom.css',
        'udema/layerslider/css/layerslider.css',
        'udema/css/blog.css',
        'udema/vendor/font-awesome/css/font-awesome.min.css',
    ];
    public $js = [
        'udema/js/modernizr.js',
        'udema/js/jquery-3.7.1.min.js',
        'udema/js/common_scripts.js',
        'udema/js/main.js',
        'udema/assets/validate.js',
        'udema/js/video_header.js',
        'udema/layerslider/js/greensock.js',
        'udema/layerslider/js/layerslider.transitions.js',
        'udema/layerslider/js/layerslider.kreaturamedia.jquery.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
