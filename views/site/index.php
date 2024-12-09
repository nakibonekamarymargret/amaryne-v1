<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>


<div class="background-image">
    <div class="welcome-text mt-5">
        <p>Welcome to Amaryne Beauties </p>
        <p>Indulge in beauty and relaxation</p>
        <button class="explore-btn">Explore Services</button>
    </div>
</div>
<hr class="pt-2 fw-bold">
<div class="row justify-content-center">
    <div class="col-lg-8">
        <p class="lead text-center">Amaryne Beauties provides high-quality beauty and wellness services just for you.
            Enjoy professional treatments from certified stylists in a relaxing, luxurious environment.</p>
    </div>
</div>
<hr class="mb-4">
<div class="row">
    <!-- Each column will take 4 units out of 12 on large screens -->
    <div class="col-lg-4 mb-4">
        <div class="card-index">
            <div class="card-body">
                <div class="col-md-8">
                    <h5 class="card-title">Hair Salons</h5>
                </div>
                <hr class="text-black">
                <div class="mt-3 mb-3 d-flex">
                    <div class="text me-3">
                        <p class="card-text">Find top-rated salons dedicated to quality and elegance. Book appointments
                            with ease.</p>
                        <a href="<?= Url::to(['/salons/index']) ?>" class="card-btn custom-btn" style="margin-bottom: -2px;">View Salons</a>
                    </div>
                    <div class="col-md-4">
                        <?= Html::img('@web/images/hair1.png', ['alt' => ' Salon', 'class' => 'img-fluid ']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card-index">
            <div class="card-body d-flex">
                <div class="col mt-0">
                    <h5 class="card-title">Skin Care</h5>
                </div>
                <hr class="text-black">
                <div class="mt-3 mb-3 d-flex">
                    <div class="col-md-4">
                        <?= Html::img('@web/images/skincare.jpeg', ['alt' => 'Bridal Salon', 'class' => 'img-fluid rounded-end']) ?>
                    </div>
                    <div class="text mx-2">
                        <p class="card-text">Glow and get classy with Amaryne. Get connected to perfect skin care
                            doctors.
                        </p>
                        <a href="#" class="card-btn custom-btn" style="margin-left: 3em">Aesthetic Skin
                            Care Clinics</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card-index">
            <div class="card-body d-flex">
                <div class="col mt-0">
                    <h5 class="card-title">Mani + Pedi Salons</h5>
                </div>
                <hr class="text-black">
                <div class="mt-3 mb-3 d-flex">
                    <div class="col-md-4">
                        <?= Html::img('@web/images/manipedi.jpeg', ['alt' => 'Bridal Salon', 'class' => 'img-fluid rounded']) ?>
                    </div>
                    <div class="text mx-2">
                        <p class="card-text">Life is not perfect, but your nails can be. Trust us for the best Manicure
                            &
                            Pedicure salons.</p>
                        <a href="#" class="card-btn custom-btn " style="margin-left:15em">View</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card-index">
            <div class="card-body d-flex">
                <div class="col mt-0">
                    <h5 class="card-title">Barber Shops</h5>
                </div>
                <hr class="text-black">
                <div class="mt-3 mb-3 d-flex">

                    <div class="text mx-2">
                        <p class="card-text">Find top-rated salons dedicated to quality and elegance. Book appointments
                            with
                            ease.</p>
                        <a href="#" class="card-btn  custom-btn" style="">View
                            Salons</a>
                    </div>
                    <div class="col-md-4">
                        <?= Html::img('@web/images/barber.jpeg', ['alt' => 'Bridal Salon', 'class' => 'img-fluid rounded-end']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card-index">
            <div class="card-body d-flex">
                <div class="col mt-0">
                    <h5 class="card-title">Quality Products</h5>
                </div>
                <hr class="text-black">
                <div class="mt-3 mb-3 d-flex">
                    <div class="col-md-4">
                        <?= Html::img('@web/images/wig1.jpg', ['alt' => 'Bridal Salon', 'class' => 'img-fluid rounded-start']) ?>
                    </div>
                    <div class="text mx-2">
                        <p class="card-text">Purchase salon-grade products to maintain your look at home. Get exclusive
                            discounts.</p>
                        <a href="<?= Url::to(['/products/index']) ?>" class="card-btn custom-btn" style="margin-left:8rem">Shop
                            Products</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
    <div class="card-index">
        <div class="card-body d-flex">
            <div class="col mt-0">
                <h5 class="card-title">Bridal Salons</h5>
            </div>
            <hr class="text-black">
            <div class="mt-3 mb-3 d-flex w-100">
                <div class="col-md-4">
                    <?= Html::img('@web/images/bridal.jpg', ['alt' => 'Bridal Salon', 'class' => 'img-fluid ']) ?>
                </div>
                <div class="text mx-2">
                    <p class="card-text">Make your day glamorous with us by finding a good bridal salon.</p>
                    <a href="#" class=" card-btn custom-btn ml-auto " style=" margin-left:9rem">View Salons</a>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<hr>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const images = [
            '<?= Url::to('@web/images/beauty-saloon.jpg') ?>',
            '<?= Url::to('@web/images/beauty-salons.jpg') ?>',
            '<?= Url::to('@web/images/makeup.jpg') ?>',

        ];
        let currentImageIndex = 0;
        const backgroundImage = document.querySelector('.background-image');
        const dots = document.getElementsByClassName("dot");

        function changeImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            backgroundImage.style.backgroundImage = `url(${images[currentImageIndex]})`;

            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
            }
            dots[currentImageIndex].classList.add("active");
        }

        // Set interval for image change every 4 seconds
        setInterval(changeImage, 4000); // Change every 4 seconds
    });
</script>
</body>

</html>