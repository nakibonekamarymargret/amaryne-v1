<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <div class="container-fluid salon-index ">
        <div class="row pt-5">
            <div class="col-lg-3">
            <!-- < ?= $this->render('/partialviews/_sidenav', [
            'popularHairSalons' => $popularHairSalons,
            'popularNailClinics' => $popularNailClinics,
            'beautyShops' => $beautyShops,
            'otherSalons'=>$otherSalons
            ]); ?> -->
            <?php
                echo $this->render('/partialviews/_sidenav', [
                    'sidebarData' => $this->params['sidebarData'] ?? []
                ]);
                ?>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-4 col-xs-6">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Salons</li>
                    </ol>
                </nav>
                <div class="top-saloons">
                    <h4>Top Salons</h4>
                    <div class="lead d-flex justify-content-between">
                        <p>Promotions</p>
                        <p class="text-warning">View all</p>
                    </div>
                    <div class="promotions row">
                        <?php foreach ($salons as $index => $salon): ?>
                            <div class="col-md-4 mb-4">
                                <a href="<?= Url::to(['salons/view', 'id' => $salon->id]) ?>" class="card-link"
                                    style="text-decoration: none; display: block;">
                                    <div class="card-body">
                                        <img src="<?= Url::to('@web/' . Html::encode($salon->salon_image)) ?>"
                                            alt="<?= Html::encode($salon->name) ?>"
                                            style="width:100%; height:200px; object-fit:cover">
                                        <div class="d-flex justify-content-between mt-3">
                                            <p class="text-uppercase text-dark fs-6 fw-bolder">
                                                <?= Html::encode($salon->name) ?></p>
                                            <p class="fw-3 mx-2 "><?= Html::encode($salon->formattedTypes) ?></p>
                                        </div>
                                        <p class="mb-2 text-dark">
                                            <i class="bi bi-pin-map-fill mx-2"></i><?= Html::encode($salon->address) ?>
                                            <i class="text-danger mx-3">
                                                <i
                                                    class="bi bi-calendar-check-fill mx-2 text-black"></i><?= Html::encode($salon->formattedWorkingDays) ?>
                                            </i>
                                        </p>
                                    </div>
                                </a>
                            </div>

                            <?php if (($index + 1) % 3 === 0): ?>
                                <div class="w-100"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <hr>
                <div class="all">
                    <p>All Salons</p>
                    <div class="promotions row">
                        <?php foreach ($salons as $index => $salon): ?>
                            <div class="col-md-4 mb-4">
                                <a href="<?= Url::to(['salons/view', 'id' => $salon->id]) ?>" class="card-link"
                                    style="text-decoration: none; display: block;">
                                    <div class="card-body">
                                        <img src="<?= Url::to('@web/' . Html::encode($salon->salon_image)) ?>"
                                            alt="<?= Html::encode($salon->name) ?>"
                                            style="width:100%; height:200px; object-fit:cover">
                                        <div class="d-flex justify-content-between mt-3">
                                            <p class="text-uppercase text-dark fs-6 fw-bolder">
                                                <?= Html::encode($salon->name) ?></p>
                                            <p class="fw-4 mx-2"><?= Html::encode($salon->formattedTypes) ?></p>
                                        </div>
                                        <p class="mb-2 text-dark">
                                            <i class="bi bi-pin-map-fill mx-2"></i><?= Html::encode($salon->address) ?>
                                            <i class="text-danger mx-3">
                                                <i
                                                    class="bi bi-calendar-check-fill mx-2 text-black"></i><?= Html::encode($salon->formattedWorkingDays) ?>
                                            </i>
                                        </p>
                                    </div>
                                </a>
                            </div>

                            <?php if (($index + 1) % 3 === 0): ?>
                                <div class="w-100"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
