<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">Amaryne Beauties</span>
        </a>
        <span class="align-middle"><?= Html::encode($salonName) ?>nn</span>
        <hr>
        <ul class="sidebar-nav">
            <li class="sidebar-item active">
                <a class="sidebar-link" href="<?= Url::to(['salon-owner/dashboard'])?>">
                    <i class="fa-solid fa-gauge"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['salon-owner/total-clients']) ?>">
                    <i class="fa-solid fa-users"></i>
                    <span class="align-middle">Clients</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['salon-owner/services']) ?>">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <span class="align-middle">Services</span>
                 </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['salon-owner/products']) ?>">
                <i class="fa-brands fa-product-hunt"></i>
                <span class="align-middle">Products</span>
                 </a>
            </li>
            <li class="sidebar-item ">
                <a class="sidebar-link" href="<?= Url::to(['salon-owner/orders']) ?>">
                    <i class="fa-solid fa-cart-plus"></i>
                    <span class="align-middle">Orders</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['salon-owner/appointments']) ?>">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="align-middle">Appoitments</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-cta">
            <ul style=" list-style-type: none"> 
                <li class="sidebar-item">
                    <a class="sidebar-link" href="pages-sign-in.html">
                        <i class="align-middle" data-feather="settings"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>