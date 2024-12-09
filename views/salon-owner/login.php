<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Login';

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container {
            background: url('<?= Yii::getAlias("@web/images/bg2.jpg") ?>') no-repeat fixed center/cover;
            position: relative;
            height: 100vh;
            max-width: 100%;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .container>* {
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>

        <div class="login-container d-flex justify-content-center align-items-center vh-100">
            <div class="login-card p-5 rounded shadow"
                style="max-width: 400px; background-color: #f5f5f5; color: #6b4f30;">
                <div class="text-center mb-4">
                    <?= Html::img('@web/images/logo.png', [
                        'alt' => 'amaryne logo',
                        'width' => '50',
                        'height' => '50',
                        'class' => 'rounded-circle'
                    ]) ?>
                    <h4 class="mt-2" style="color:#a04a1b;">Welcome to Amaryne Beauties</h4>
                    <p class="fs-5" style="color:#f4a300;">Login to continue</p>
                </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                ]); ?>
                <div class="mt-3 mb-3">
                    <?= $form->field($model, 'email')->input('email', [
                        'class' => 'form-control border border-2 rounded-pill',
                        'id' => 'email',
                        'required' => true,
                    ])->label('Email', ['class' => 'form-label']) ?>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="mt-3 mb-3">
                    <?= $form->field($model, 'password')->passwordInput([
                        'class' => 'form-control border border-2 rounded-pill',
                        'id' => 'pass',
                        'required' => true,
                    ])->label('Password', ['class' => 'form-label']) ?>
                    <div class="invalid-feedback">Password is required.</div>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div class="form-check">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'class' => 'form-check-input',
                            'id' => 'rememberMe'
                        ]) ?>
                    </div>
                    <?= Html::a('Forgot Password?', '#', [
                        'class' => 'text-decoration-none',
                        'style' => 'color:#f4a300;'
                    ]) ?>
                </div>

                <div class="other-options text-center mb-3">
                    <p>Or login with</p>
                    <div class="d-flex justify-content-around">
                        <!-- Google Button -->
                        <?= Html::button(Html::img('https://glovoapp.com/images/icons/social/google.svg', [
                            'alt' => 'Google',
                            'style' => 'width: 24px; height: 24px;'
                        ]), [
                            'class' => 'btn btn-outline-secondary rounded-circle',
                            'style' => 'width: 50px; height: 50px;'
                        ]) ?>

                        <!-- Facebook Button -->
                        <?= Html::button(Html::img('https://glovoapp.com/images/icons/social/facebook.svg', [
                            'alt' => 'Facebook',
                            'style' => 'width: 24px; height: 24px;'
                        ]), [
                            'class' => 'btn btn-outline-secondary rounded-circle',
                            'style' => 'width: 50px; height: 50px;'
                        ]) ?>

                        <!-- Email Button -->
                        <?= Html::button('<svg width="24" height="24" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5.70703" width="18.0098" height="13.5" rx="2" stroke="#292929" stroke-width="1.5" stroke-linejoin="round"></rect><path d="M20.2445 6.46289L12.0073 13.4053L3.68555 6.46289" stroke="#292929" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>', [
                            'class' => 'btn btn-outline-dark rounded-circle',
                            'style' => 'width: 50px; height: 50px;'
                        ]) ?>
                    </div>
                </div>

                <?= Html::submitButton('Login', [
                    'class' => 'btn btn-outline-light mt-4 w-100 rounded-pill',
                    'style' => 'background-color: #a04a1b;'
                ]) ?>

                <div class="text-center text-muted mt-4">
                    <p>Don’t have an account?
                        <?= Html::a('Sign up', ['salon-owner/register'], [
                            'class' => 'text-decoration-underline',
                            'style' => 'color:#f4a300;'
                        ]) ?>
                    </p>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>