<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="<?= Url::to(['/site/index']) ?>">
            <?= Html::img('@web/images/logo.png', [
                'alt' => 'amaryne logo',
                'width' => '50',
                'height' => '50',
                'class' => 'rounded-circle'
            ]) ?>
            <span class="ms-2">Amaryne Beauties</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/site/index']) ?>">
                        <i class="bi bi-house-fill text-black px-2"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['/site/about']) ?>">About Us</a>
                </li>
                <li class="nav-item">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <a class="nav-link" href="<?= Url::to(['/site/login']) ?>">
                            <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i> Log In
                        </a>
                    <?php else: ?>
                        <div class="dropdown">
                            <a class=" dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?= Html::img(
                                    '@web/' . (Yii::$app->user->identity->profileimage ?: 'images/default-user.png'),
                                    [
                                        'alt' => 'User Image',
                                        'class' => 'rounded-circle',
                                        'style' => 'width: 40px; height: 40px; object-fit: cover;'
                                    ]
                                ) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
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
                        </div>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>