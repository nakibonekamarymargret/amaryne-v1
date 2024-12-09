<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<h1 class="h3 mb-3"><strong>Welcome</strong> <i class="align-middle fs-5 text-warning" data-feather="smile"></i></h1>

<div class="row">
    <div class="col-xl-12 col-xxl-12 d-flex">
        <div class="w-100">
            <div class="row">
                <!-- Card 1: Total Salons -->

                <div class="col-md-4">
                    <?= Html::a(
                        '<div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Salons</h5>
                                        </div>
                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="home"></i>
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
                                    <h5 class="card-title">Customers</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">35</h1>
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
                                        <i class="align-middle" data-feather="calendar"></i>
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
                                        <i class="align-middle" data-feather="shopping-cart"></i>
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
                                        <i class="align-middle" data-feather="briefcase"></i>
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
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">10</h1>
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
                <h5 class="card-title mb-0">Popular Salons</h5>
            </div>
            <table class="table table-hover my-0 w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Salon Name</th>
                        <th>Category</th>
                        <th>Address</th>
                        <th>Working Days</th>
                        <th>Owner</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($salons as $data) { ?>
                        <tr class="table-light text-start fs-6" style="font-family:tahoma">
                            <td><?= $no ?></td>
                            <td><?= $data['name'] ?></td>
                            <td><?= $data->getFormattedTypes() ?></td>
                            <td><?= $data['address'] ?></td>
                            <td><?= $data->getFormattedWorkingDays() ?></td>
                            <td><?= $data->owner ? $data->owner->username : 'N/A' ?></td>
                            <td><?= $data['status'] ?></td>
                            <td class="d-block">
                                <button id="view-salon" data-id="<?= $data['id'] ?>">
                                    <i data-feather="eye" class="me-2 text-primary view"></i>
                                </button>
                                <a href="<?= Yii::$app->urlManager->createUrl(['admin/update', 'id' => $data['id']]) ?>">
                                    <i data-feather="edit" class=" me-2 text-success update"></i>
                                </a>
                                <a href="#" class="delete-user" data-id="<?= $data['id'] ?>"><i data-feather="trash-2" class="text-danger"></i></a>
                            </td>
                        </tr>
                    <?php $no++;
                    } ?>
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