<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model app\models\Services */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="edit-form">
    <div class="row mb-3">
        <div class="col-lg-6">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'description')->textarea(['cols' => 50, 'rows' => 10, 'class' => 'form-control']) ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-4">
            <?= $form->field($model, 'price') ?>
        </div>
    </div>
    <div class="text-end">
        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>

<?php ActiveForm::end(); ?>
