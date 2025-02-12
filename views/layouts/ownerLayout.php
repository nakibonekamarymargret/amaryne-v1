<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\OwnerAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\web\View;


OwnerAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerCssFile('@web/web/font-awesome/css/all.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/web/bootstrap-icons/font/bootstrap-icons.css', [
    'depends' => [\yii\web\YiiAsset::class],
]);
$this->registerJsFile('@web/js/jquery-3.7.1.min.js', ['position' => View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()],])

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5" />
        <meta name="author" content="AdminKit" />
        <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web" />

        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

        <link rel="canonical" href="https://demo-basic.adminkit.io/" />

        <title>Admin</title>

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
    </head>
</head>

<body>
    <?php $this->beginBody() ?>
    <div class="wrapper">
    <?= $this->render('/salon-owner/partials/_sidenav', ['salonName' => isset($salon) ? $salon->name : null]) ?>
        <div class="main">
            <?php echo $this->render('/salon-owner/partials/_navbar') ?>
            <main class="content">
                <div class="container-fluid p-0">

                    <?= $content ?>
                </div>
            </main>
            
        </div>

    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>