<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductsModel $model */

$this->title = 'Create Products Model';
$this->params['breadcrumbs'][] = ['label' => 'Products Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
