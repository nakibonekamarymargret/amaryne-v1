<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\helpers\Url;


AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset]);
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerCssFile('@web/web/font-awesome/css/all.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [
    'crossorigin' => 'anonymous',
]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', [
    'crossorigin' => 'anonymous',
]);
$this->registerCssFile('@web/web/bootstrap-icons/font/bootstrap-icons.css', [
    'depends' => [\yii\web\YiiAsset::class],
]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <header id="header">
            <?= $this->render('/partialviews/_navbar', ['bgColor' => 'bg-warning']); ?>
        </header>

        <main id="main" class=" content">
            <div class="container-fluid p-0">
                <?= $content ?>
            </div>
        </main>

        <footer id="footer" class="mt-auto py-3 bg-light">
            <div class="container">
                <div class="row text-muted">
                    <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                    <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
                </div>
            </div>
        </footer>
    </div>


    <!-- External scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>

    <script>
        feather.replace();
        document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('appointmentModal');
        const serviceIdInput = document.getElementById('service-id');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const serviceId = button.getAttribute('data-service-id');
            serviceIdInput.value = serviceId;
        });
        $(document).ready(function() {
            $('.salon-card').on('click', function() {
                var salonId = $(this).data('salon-id');

                $.ajax({
                    url: '<?= Url::to(['salons/view']) ?>',
                    type: 'GET',
                    data: {
                        id: salonId
                    },
                    success: function(response) {
                        $('main').html(response);
                    },
                    error: function() {
                        alert('An error occurred while loading the salon details.');
                    }
                });
            });
        });
    
    });
    </script>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>