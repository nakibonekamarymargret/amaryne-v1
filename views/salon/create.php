<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SalonModel $model */

$this->title = 'Create Salon Model';
$this->params['breadcrumbs'][] = ['label' => 'Salon Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salon-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
