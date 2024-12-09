<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="row justify-content-center">
    <div class="col-8 mx-auto">
        <div class="card border-0">
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data'],
                    'action' => ['admin/create'],
                ]) ?>
                <div class="pt-3 mb-3">
                    <?= $form->field($salon, 'salon_image')->fileInput()->label('Salon Image') ?>
                </div>
                <div class="pt-3">
                    <?= $form->field($salon, 'name')->textInput(['class' => 'form-floating border    mx-4 rounded'])->label('Salon Name : ') ?>
                </div>
                <div class="pt-3">
                    <?= $form->field($salon, 'address')->textInput(['class' => 'form-floating border    mx-4 rounded'])->label('Salon Location :') ?>
                </div>
                <div class="pt-3">
                    <?= $form->field($salon, 'owner_id')->textInput(['class' => 'form-floating border    mx-4 rounded'])->label('Salon Owner') ?>
                </div>
                <div class="pt-3">
                    <?= $form->field($salon, 'type')->checkboxList([
                        1 => 'Bridal Salon',
                        2 => 'Hair Salon',
                        3 => 'MANI + PEDI SALON',
                        4 => 'Barber Shop',
                        5 => 'Skin Care Clinic',
                    ])->label('Type :') ?>
                </div>
                <div class="pt-3 mb-3">
                    <?= $form->field($salon, 'description')->textarea(['class' => 'form-floating border    mx-4', 'rows' => '3'])->label('Description : ') ?>
                </div>
                <div class="pt-3 mb-3">
                    <?= $form->field($salon, 'working_days')->checkboxList(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'])->label('Working Days') ?>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <?= Html::submitButton('Create Salon', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Cancel', ['dashboard'], ['class' => 'btn btn-danger']) ?>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>