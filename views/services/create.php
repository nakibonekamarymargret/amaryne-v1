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
    <title>Create Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 mx-auto">
                <div class="card border-0">
                    <div class="card-body">
                        <?php $form = ActiveForm::begin([
                            'options' => ['enctype' => 'multipart/form-data']
                        ]) ?>
                        <?= $form->field($service, 'salon_id')->hiddenInput()->label(false) ?>

                        <div class="pt-3 mb-3">
                            <?= $form->field($service, 'service_image')->fileInput()->label('Service Image') ?>
                        </div>
                        <div class="pt-3">
                            <?= $form->field($service, 'name')->textInput(['class' => 'form-floating border mx-4 rounded'])->label('Service Name:') ?>
                        </div>
                        <div class="pt-3">
                            <?= $form->field($service, 'description')->textarea(['class' => 'form-floating border mx-4 rounded'])->label('Description:') ?>
                        </div>
                        <div class="pt-3">
                            <?= $form->field($service, 'price')->input('number', ['class' => 'form-floating border mx-4 rounded'])->label('Service Price:') ?>
                        </div>
                        <div class="pt-3">
                            <?= $form->field($service, 'discount')->input('number', ['class' => 'form-floating border mx-4 rounded'])->label('Discount:') ?>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <?= Html::submitButton('Create Service', ['class' => 'btn btn-success']) ?>
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