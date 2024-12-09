<?php

use yii\helpers\Html;

/* @var $ser app\models\Service */

?>

<div class="service-view">
    <h4><?= Html::encode($service->name) ?></h4>
    <p><strong>Price:</strong> <?= Html::encode($service->price) ?></p>
    <p><strong>Discount:</strong> <?= Html::encode($service->discount) ?></p>
    <p><strong>Description:</strong> <?= Html::encode($service->description) ?></p>
</div>