<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Navbar-->
<?= $this->render('navbar', ['assetDir' => '@web']) ?>
<!-- /.navbar-->

<main>
        <?= $content ?>
</main>



<?php $this->endBody() ?>
  <!-- Footer -->
  <?= $this->render('footer')?>
    <!-- /.footer -->
</body>
</html>
<?php $this->endPage();
