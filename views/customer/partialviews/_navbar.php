<?php

use yii\helpers\Html;
use yii\helpers\Url;



?>

<style>
    .text-muted a:hover {
        color: #b08d57;
    }

    .form-control:focus {
        border-color: #f4a300;
        box-shadow: 0 0 5px #f4a300;
    }

    .navbar-nav .nav-link {
        color: #000;
    }

    .navbar-nav .nav-link:hover {
        background-color: #f4a300;
        color: white;
        border-radius: 50rem;
    }

    .navbar-nav {
        margin-right: 4%;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <?= Html::img('@web/images/logo.png', ['alt' => 'amaryne logo', 'width' => '50', 'height' => '50', 'class' => 'rounded-circle']) ?>
            <span class="ms-2">Amaryne Beauties</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-house-fill text-black px-2"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">About Us</a>
                </li>
                <li class="nav-item">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <a class="nav-link" href="<?= Url::to(['site/login']) ?>">
                            <i class="bi bi-person-fill" style="width:48px;height:48px;"></i> Log In
                        </a>
                    <?php else: ?>
                        <div class="dropdown">
                    <li class="nav-item dropdown user-image">
                        <?= Html::a(
                            Yii::$app->user->identity->profileimage
                            ? '<img src="' . Url::to('@web/' . Yii::$app->user->identity->profileimage) . '"
                                    class="rounded-circle" 
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; margin-top: 1%;" 
                                    alt="User Image">'
                            : '<i class="bi bi-person-circle" style="width: 50px; height: 50px; font-size: 2rem; color: #000;"></i>',
                            '#',
                            [
                                'class' => 'align-self-center',
                                'id' => 'navbarDropdown',
                                'data-bs-toggle' => 'dropdown',
                                'aria-expanded' => 'false'
                            ]
                        ) ?>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <?= Html::beginForm(['/user/profile']) ?>
                                <?= Html::submitButton('<i class="align-middle text-dark px-2" data-feather="at-sign" style="width:36px; height:24px"></i>' . Yii::$app->user->identity->email, ['class' => 'dropdown-item']) ?>
                                <?= Html::submitButton('(' . Yii::$app->user->identity->username . ')', ['class' => 'dropdown-item text-warning']) ?>
                                <?= Html::endForm() ?>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?= Html::a('<i class="align-middle text-success px-2" data-feather="sliders" style="width:36px; height:24px"></i> Dashboard', ['/site/dashboard'], ['class' => 'dropdown-item']) ?>
                            </li>

                            <li>
                                <?= Html::a('<i class="align-middle px-2 text-dark" data-feather="settings" style="width:36px; height:36px"></i> Settings', ['/site/settings'], ['class' => 'dropdown-item']) ?>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?= Html::beginForm(['/site/logout']) ?>
                                <?= Html::submitButton('<i class="align-middle px-2 text-danger" data-feather="log-out" style="width:36px; height:36px"></i> Logout', ['class' => 'dropdown-item']) ?>
                                <?= Html::endForm() ?>
                            </li>
                        </ul>
                    </li>


            </div>
        <?php endif; ?>
        </li>

        </ul>
    </div>
    </div>
</nav>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>

<script>
    feather.replace();
</script>