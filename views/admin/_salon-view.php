<?php

use yii\helpers\Html;

/* @var $salon app\models\Salon */

?>

<div class="salon-view">
    <h4><?= Html::encode($salon->name) ?></h4>
    <p><strong>Category:</strong> <?= Html::encode($salon->getFormattedTypes()) ?></p>
    <p><strong>Address:</strong> <?= Html::encode($salon->address) ?></p>
    <p><strong>Working Days:</strong> <?= Html::encode($salon->getFormattedWorkingDays()) ?></p>
    <p><strong>Owner:</strong> <?= Html::encode($salon->owner ? $salon->owner->username : 'N/A') ?></p>
    <p><strong>Services:</strong> <?= Html::encode($salon->getServices()->count()) ?></p>
    <p><strong>Status:</strong> <?= Html::encode($salon->status) ?></p>
</div>