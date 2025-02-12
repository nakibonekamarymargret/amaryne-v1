<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<div class="top d-flex justify-content-between">
    <h1 class="h3 mb-3"><strong>Hi</strong>
        <span class="text-uppercase fw-semibold text-dark">
            <?php if ($model): ?>
                <?= Html::encode($model->username) ?>
            <?php endif; ?>
        </span>
        <i class="fa-solid fa-hands-clapping text-warning mx-3"></i>
    </h1>
    <h2 class="fw-semibold fs-3  "><?= $salonName ?></h2>

</div>



<div class="row">
    <div class="col-xl-12 col-xxl-12 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
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
                            <h1 class="mt-1 mb-3"><?= Html::encode($activeClientsCount) ?></h1>
                            <div class="mb-0">
                                <span class="text-success">
                                    <i class="mdi mdi-arrow-bottom-right" data-feather="eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Active -->
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
                            <h1 class="mt-1 mb-3"><?= Html::encode($activeClientsCount) ?></h1>
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
                            <h1 class="mt-1 mb-3"><?= Html::encode($appointmentsCount) ?></h1>
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
                            <h1 class=" mb-3">
                                <?= Html::encode($productsCount) ?>
                            </h1>
                            <div class="mb-0">
                                <span class="text-danger">
                                    <i class="mdi mdi-arrow-bottom-right" data-feather="eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 5: orders -->
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
                            <h1 class="mt-0 mb-3">
                                <?= Html::encode($ordersCount) ?>

                            </h1>
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
                            <h1 class="mt-1 mb-3"><?= Html::encode($servicesCount) ?></h1>
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
                <h5 class="card-title mb-0">Orders</h5>
            </div>
            <table class="table table-hover my-0 w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Customer Name</th>
                        <th>Total Price</th>
                        <th>Total Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $index => $order): ?>
                            <tr>
                                <td><?= $pagination->offset + $index + 1 ?></td>
                                <td><?= Html::encode($order['customer_name']) ?></td>
                                <td><?= Html::encode(number_format($order['total_price'], 2)) ?></td>
                                <td><?= Html::encode($order['total_quantity']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="pagination-container d-flex justify-content-end mt-3">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                ]) ?>
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
                    <?php if (!empty($clients)): ?>
                        <?php foreach ($clients as $index => $client): ?>
                            <tr>
                                <td><?= $pagination->offset + $index + 1 ?></td>
                                <td><?= Html::encode($client['name']) ?></td>
                                <td><?= Html::encode($client['email']) ?></td>
                                <td><?= Html::encode($client['contact']) ?></td>
                                <td><?= Html::encode($client['status'] ? 'Active' : 'Inactive') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No clients found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="pagination-container d-flex justify-content-end mt-3">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                ]) ?>
            </div>
        </div>
    </div>
</div>
