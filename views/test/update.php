<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SalonModel $model */

$this->title = 'Update Salon Model: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Salon Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="salon-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
