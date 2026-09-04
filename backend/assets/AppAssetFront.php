<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAssetFront extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap',
        'udemafront/css/bootstrap.min.css',
        'udemafront/css/style.css',
        'udemafront/css/vendors.css',
        'udemafront/css/icon_fonts/css/all_icons.min.css',
        'udemafront/css/custom.css',
        'udemafront/layerslider/css/layerslider.css',
        'udemafront/css/blog.css',
        'udemafront/vendor/font-awesome/css/font-awesome.min.css',
    ];
    public $js = [
        'udemafront/js/modernizr.js',
        'udemafront/js/jquery-3.7.1.min.js',
        'udemafront/js/common_scripts.js',
        'udemafront/js/main.js',
        'udemafront/assets/validate.js',
        'udemafront/js/video_header.js',
        'udemafront/layerslider/js/greensock.js',
        'udemafront/layerslider/js/layerslider.transitions.js',
        'udemafront/layerslider/js/layerslider.kreaturamedia.jquery.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
