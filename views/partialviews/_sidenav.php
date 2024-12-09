<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="row">
    <!-- Sidenav -->
    <div class="col-md-3">
        <div class="sidenav">
            <ul class="nav flex-column">
                <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Welcome back <span></span></h5>

                <?php if (!empty($sidebarData['popularHairSalons'])): ?>
                    <li class="sidenav-item">
                        <div class="popularSalons">
                            <h3 class="mt-2 nav-title">Popular Hair Salons</h3>
                            <?php foreach ($sidebarData['popularHairSalons'] as $salon): ?>
                                <a href="<?= Url::to(['salons/view', 'id' => $salon->id]) ?>" class="nav-link text-dark">
                                    <img src="<?= Url::to('@web/' . Html::encode($salon->salon_image)) ?>"
                                         alt="<?= Html::encode($salon->name) ?>" class="nav-image">
                                    <span class="ms-2"><?= Html::encode($salon->name) ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if (!empty($sidebarData['popularNailClinics'])): ?>
                    <li class="sidenav-item">
                        <div class="popularSalons">
                            <h3 class="mt-2 nav-title">Popular Nail Clinics</h3>
                            <?php foreach ($sidebarData['popularHairSalons'] as $salon): ?>
                                <a href="<?= Url::to(['salons/view', 'id' => $salon->id]) ?>" class="nav-link text-dark">
                                    <img src="<?= Url::to('@web/' . Html::encode($salon->salon_image)) ?>"
                                         alt="<?= Html::encode($salon->name) ?>" class="nav-image">
                                    <span class="ms-2"><?= Html::encode($salon->name) ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if (!empty($sidebarData['beautyShops'])): ?>
                    <li class="sidenav-item">
                        <div class="popularSalons">
                            <h3 class="mt-2 nav-title">Beauty Shops</h3>
                            <?php foreach ($sidebarData['popularHairSalons'] as $salon): ?>
                                <a href="<?= Url::to(['salons/view', 'id' => $salon->id]) ?>" class="nav-link text-dark">
                                    <img src="<?= Url::to('@web/' . Html::encode($salon->salon_image)) ?>"
                                         alt="<?= Html::encode($salon->name) ?>" class="nav-image">
                                    <span class="ms-2"><?= Html::encode($salon->name) ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if (!empty($sidebarData['beautyShops'])): ?>
                    <li class="sidenav-item">
                        <div class="popularSalons">
                            <h3 class="mt-2 nav-title">Other Salons</h3>
                            <?php foreach ($sidebarData['otherSalons'] as $salon): ?>
                                <a href="<?= Url::to(['salons/view', 'id' => $salon->id]) ?>" class="nav-link text-dark">
                                    <img src="<?= Url::to('@web/' . Html::encode($salon->salon_image)) ?>"
                                         alt="<?= Html::encode($salon->name) ?>" class="nav-image">
                                    <span class="ms-2"><?= Html::encode($salon->name) ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if (!empty($sidebarData['topSellers'])): ?>
                    <li class="sidenav-item">
                        <div class="topSellers">
                            <h4 class="mt-4 nav-title">Top Products</h4>
                            <?php foreach ($sidebarData['topSellers'] as $seller): ?>
                                <a href="<?= Url::to(['products/view', 'id' => $seller->id]) ?>" class="nav-link text-dark">
                                    <img src="<?= Url::to('@web/' . Html::encode($seller->image)) ?>"
                                         alt="<?= Html::encode($seller->name) ?>" class="nav-image">
                                    <span class="ms-2"><?= Html::encode($seller->name) ?></span>
                                </a>
                                <hr class="product">
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>

    
</div>
