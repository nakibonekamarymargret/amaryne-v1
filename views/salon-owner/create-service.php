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
               

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card border-0">

                                    <div class="card-body">
                                        <?php $form = ActiveForm::begin([ 'options' => ['enctype' => 'multipart/form-data']
                                        ]) ?>
                                        <?= $form->field($model, 'salon_id')->hiddenInput()->label(false) ?>

                                        <div class="pt-3 mb-3">
                                            <?= $form->field($model, 'service_image')->fileInput()->label('Service Image') ?>
                                        </div>
                                        <div class="pt-3">
                                            <?= $form->field($model, 'name')->textInput(['class' => 'form-floating border mx-4 rounded'])->label('Service Name:') ?>
                                        </div>
                                        <div class="pt-3">
                                            <?= $form->field($model, 'description')->textarea(['class' => 'form-floating border mx-4 rounded'])->label('Description:') ?>
                                        </div>
                                        <div class="pt-3">
                                            <?= $form->field($model, 'price')->input('number', ['class' => 'form-floating border mx-4 rounded'])->label('Service Price:') ?>
                                        </div>
                                        <div class="pt-3">
                                            <?= $form->field($model, 'discount')->input('number', ['class' => 'form-floating border mx-4 rounded'])->label('Discount:') ?>
                                        </div>

                                        <div class="form-group d-flex justify-content-between">
                                            <?= Html::submitButton('Create Service', ['class' => 'btn btn-success text-black']) ?>
                                            <?= Html::a('Cancel', ['dashboard'], ['class' => 'btn btn-danger']) ?>
                                        </div>
                                        <?php ActiveForm::end() ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>