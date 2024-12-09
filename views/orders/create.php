<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\OrdersModel */
?>

<div class="order-form">
    <?php $form = ActiveForm::begin([
        'id' => 'order-form',
        'enableAjaxValidation' => true,
        'action' => ['orders/create'], // Adjust the action route as needed
    ]); ?>

    <?= $form->field($model, 'product_id')->hiddenInput(['value' => $productId])->label(false) ?>

    <?= $form->field($model, 'quantity')->textInput(['type' => 'number', 'min' => 1]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        'Pending' => 'Pending',
        'Processing' => 'Processing',
        'Completed' => 'Completed',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Place Order', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
