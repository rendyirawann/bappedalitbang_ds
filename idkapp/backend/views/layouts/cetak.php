<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use backend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="bappedalitbang, idkapp, web bappeda, bappeda, web idkapp">
    <meta name="description" content="BIDANG INFRASTRUKTUR">
    <meta name="author" content="BAPPEDALITBANG">
    <?php $this->registerCsrfMetaTags() ?>
    <link rel="icon" href="/backend/web/images/bappeda.png" type="image/x-icon">
    <link rel="shortcut icon" href="/backend/web/images/bappeda.png" type="image/x-icon">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
  <!-- Footer -->
  <?= $this->render('f-cetak')?>
    <!-- /.footer -->
</body>
</html>
<?php $this->endPage();
