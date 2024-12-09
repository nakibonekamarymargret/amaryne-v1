<?php

use app\models\SalonModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Salon Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salon-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Salon Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'owner_id',
            'status',
            'type',
            //'address',
            //'description:ntext',
            //'working_days',
            //'created_at',
            //'updated_at',
            //'salon_image',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SalonModel $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
