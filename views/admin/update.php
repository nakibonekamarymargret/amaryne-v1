<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Salon</title>
    <!-- Include Bootstrap CSS if not already included -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 mx-auto">
                <h1>Update <?= Html::encode($salon->name) ?> </h1>

                <div class="card border border-rounded">
                    <div class="card-body">
                        <?php $form = ActiveForm::begin([
                            'options' => ['enctype' => 'multipart/form-data']
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
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Cancel', ['dashboard'], ['class' => 'btn btn-danger']) ?>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>