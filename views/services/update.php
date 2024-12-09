<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ServicesModel $model */

$this->title = 'Update Services Model: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Services Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="services-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
