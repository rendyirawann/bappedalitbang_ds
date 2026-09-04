<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAssetFront;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAssetFront::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
      <!-- Favicons-->
  <link rel="shortcut icon" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png" type="image/x-icon">
  <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?= Url::base(true)?>/udema/bappeda/bappeda.png">
    <?php $this->head() ?>
</head>
<body id="login_bg">
<?php $this->beginBody() ?>

        <?= $content ?>

<?php $this->endBody() ?>
  <!-- Footer -->
  <?= $this->render('blank-footer')?>
    <!-- /.footer -->
</body>
</html>
<?php $this->endPage();