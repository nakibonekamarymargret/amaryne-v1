<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container-fluid {
            background: url('<?= Yii::getAlias("@web/images/bg2.jpg") ?>') no-repeat fixed center/cover;
            position: relative;
            height: 100vh;
            max-width: 100%;
        }

        .container-fluid::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .container-fluid>* {
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row login-container d-flex justify-content-center align-items-center vh-100">
            <div class="col-8 mt-5 p-5 rounded shadow"
                style="max-width:800px;background-color: #f5f5f5; color: #6b4f30;">
                <div class="text-center mb-4">
                    <?= Html::img('@web/images/logo.png', ['alt' => 'amaryne logo', 'width' => '50', 'height' => '50', 'class' => 'rounded-circle']) ?>
                    <h4 class="mt-2" style="color:#a04a1b;">Welcome to Amaryne Beauties</h4>
                    <p class="fs-5" style="color:#f4a300;">Create Your Account to Continue</p>
                </div>

                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data'],
                    'action' => ['admin/register'],
                    'validateOnSubmit' => true
                ]); ?>

                <div class="image form-floating mb-3">
                    <?= $form->field($model, 'profileimage')
                        ->fileInput(['class' => 'form-control border border-2 rounded-pill'])
                        ->label('Profile Image') ?>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-floating mt-3 mb-3">
                            <?= $form->field($model, 'name')->hint('Please enter your name')->textInput([
                                'class' => 'form-control border border-2 rounded-pill',
                                'id' => 'name',
                                'required' => true,
                            ])->label('Name', ['class' => 'form-label']) ?>
                            <div class="invalid-feedback">Please enter your name here.</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-3 mb-3">
                            <?= $form->field($model, 'username')->textInput([
                                'class' => 'form-control border border-2 rounded-pill',
                                'id' => 'username',
                                'required' => true,
                            ])->label('Username', ['class' => 'form-label']) ?>
                            <div class="invalid-feedback">Please enter a unique username.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mt-3 mb-3">
                            <?= $form->field($model, 'contact')->textInput([
                                'class' => 'form-control border border-2 rounded-pill',
                                'id' => 'contact',
                                'required' => true,
                            ])->label('Contact', ['class' => 'form-label']) ?>
                            <div class="invalid-feedback">Please enter a valid phone number.</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-3 mb-3">
                            <?= $form->field($model, 'email')->input('email', [
                                'class' => 'form-control border border-2 rounded-pill',
                                'id' => 'email',
                                'required' => true,
                            ])->label('Email', ['class' => 'form-label']) ?>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mt-3 mb-3">
                            <?= $form->field($model, 'password')->passwordInput([
                                'class' => 'form-control border border-2 rounded-pill',
                                'id' => 'pass',
                                'required' => true,
                            ])->label('Password', ['class' => 'form-label']) ?>
                            <div class="invalid-feedback">Password is required.</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3 mt-3">
                            <label for="confirmPassword" class="form-label ">Confirm Password</label>
                            <input type="password" class="form-control  border border-2 rounded-pill"
                                id="confirmPassword">
                            <div id="passwordError" style="display: none; color: red;">Passwords do not match.</div>
                        </div>
                    </div>
                    <div class="form-group mt-4 col-12">
                        <?= Html::submitButton('Sign Up', ['class' => 'btn rounded-pill w-100', 'style' => 'background-color: #a04a1b']) ?>
                    </div>
                    <div class="mt-3 text-center text-muted">
                        <p>Already have an account?
                            <?= Html::a('Sign up', ['admin/login'], [
                                'class' => 'text-decoration-underline',
                                'style' => 'color:#f4a300;'
                            ]) ?>
                        </p>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        const form = document.querySelector('form');
        form.addEventListener('submit', function (event) {
            const password = document.getElementById('pass').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const passwordError = document.getElementById('passwordError');

            if (password !== confirmPassword) {
                event.preventDefault();
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });
    </script>
</body>

</html>