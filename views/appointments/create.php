<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Appointments $model */

$this->title = 'Create Appointments';
$this->params['breadcrumbs'][] = ['label' => 'Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
