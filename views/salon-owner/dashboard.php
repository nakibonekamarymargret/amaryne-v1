<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<div class="top d-flex justify-content-between">
    <h1 class="h3 mb-3"><strong>Welcome</strong>
        <span class="text-uppercase fw-semibold text-warning">
            <?php if ($model): ?>
                <?= Html::encode($model->username, ) ?>
            <?php endif; ?>
        </span> 
            <i class="fa-solid fa-hands-clapping text-warning mx-3"></i>
    </h1>
</div>


<div class="row">
    <div class="col-xl-12 col-xxl-12 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-md-4">
                    <?= Html::a(
                        '<div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Clients</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="users"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">' . Html::encode($salonsCount) . '</h1>
                                    <div class="mb-0">
                                        <span class="text-danger">
                                            <i class="text-dark" data-feather="eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>',
                        ['admin/total-salons'],
                        [
                            'class' => 'card-link',
                            'style' => 'text-decoration: none;',
                        ]
                    ) ?>

                </div>

                <!-- Card 2: Customers -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Active Clients</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">0</h1>
                            <div class="mb-0">
                                <span class="text-success">
                                    <i class="mdi mdi-arrow-bottom-right" data-feather="eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Appointments -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Appointments</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                       <i class="fa-solid fa-calendar-check"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">0</h1>
                            <div class="mb-0">
                                <span class="text-success">
                                    <i class="mdi mdi-arrow-bottom-right" data-feather="eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Products -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Products</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="fa-brands fa-product-hunt"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">6</h1>
                            <div class="mb-0">
                                <span class="text-danger">
                                    <i class="mdi mdi-arrow-bottom-right" data-feather="eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Services -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Orders</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">0</h1>
                            <div class="mb-0">
                                <span class="text-success">
                                    <i class="mdi mdi-arrow-bottom-right" data-feather="eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Services</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="fa-solid fa-hand-holding-heart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">4</h1>
                            <div class="mb-0">
                                <span class="text-danger">
                                    <i class="mdi mdi-arrow-bottom-right" data-feather="eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Clients</h5>
            </div>
            <table class="table table-hover my-0 w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                 
                </tbody>
            </table>
        </div>
        <div class="pagination-container d-flex justify-content-end mt-3">
            <div class="pagination">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<div class="col-6 ">
    <div class="card flex-fill w-100">
        <div class="card-header">
            <h5 class="card-title mb-0">Services Distribution</h5>
        </div>
        <div class="card-body py-3">
            <canvas id="servicesPieChart"></canvas>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('servicesPieChart').getContext('2d');
        var servicesPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Hair', 'Nails', 'Bridal', 'Skincare', 'Mani+Pedi'],
                datasets: [{
                    label: 'Services Distribution',
                    data: [40, 25, 15, 10, 10], // Adjust values based on actual data
                    backgroundColor: [
                        '#4e73df', // Hair
                        '#1cc88a', // Nails
                        '#36b9cc', // Bridal
                        '#f6c23e', // Skincare
                        '#e74a3b' // Mani+Pedi
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    });
</script>