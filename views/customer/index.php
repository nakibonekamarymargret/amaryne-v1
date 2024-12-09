<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amaryne Beauties</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        body,
        html {
            height: 100%;

        }

        .background-image {
            background-image: url('/amaryne/images/beauty-saloon.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
            height: 100vh;
            min-height: 500px;
            transition: background-image 1s ease-in-out;
        }

        /* Styling for overlay text and button */
        .welcome-text {
            text-align: center;
            color: #fff;
            padding-top: 300px;
            position: relative;
            margin-top: 100px;
            z-index: 1;
            font-weight: bold;
            font-size: 30px;
        }

        .explore-btn {
            background-color: #e57e00;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.25rem;
            text-transform: uppercase;
        }

        .explore-btn:hover {
            background-color: #c06600;
        }

        /* Dot indicators for slideshow */
        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active {
            background-color: #717171;
        }
    </style>
</head>

<body>
    <header>
        <?= $this->render('partialviews/_navbar', [
            'bgColor' => 'bg-warning',

        ]); ?>
    </header>
    <main class="p-5">
        <div class="background-image">
            <div class="welcome-text mt-5">
                <p>Welcome to Amaryne Beauties
                <p>Indulge in beauty and relaxation</p>
                <button class="explore-btn">Explore Services</button>
            </div>
        </div>
        <br>
        <div style="text-align:center; position: absolute; bottom: 20px; width: 100%;">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>

        <hr class="text-warning fw-bold" style="height: 3px; background-color: currentColor; border: none;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="lead text-center">Amaryne Beauties provides high-quality beauty and wellness services just for you. Enjoy professional treatments from certified stylists in a relaxing, luxurious environment.</p>
            </div>
        </div>
        <hr class="text-warning fw-bold" style="height: 3px; background-color: currentColor; border: none;">

        <div class="row mb-3 p-5">
            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-header bg-light text-dark">
                        <h5 class="text-uppercase fw-semibold text-center text-warning">Hair Saloons</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="inner">
                            <p>Find top-rated salons dedicated to quality and elegance. Book appointments with ease.</p>
                            <a href="<?= Url::to(['/salons/index']) ?>" class="btn custom-btn"
                                style="background-color: #c06600; color: #fff;">
                                View Salons
                            </a>
                        </div>

                        <div class="col-4 p-2">
                            <?= Html::img('@web/images/hairsaloon.jpeg', ['alt' => 'Hair Salon', 'class' => 'img-fluid rounded-start']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-header bg-light text-dark">
                        <h5 class="text-uppercase fw-semibold text-center text-warning">Mani + Pedi saloons</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="inner">
                            <p>Life is not perfect, but your nails can be. Trust us for the best <b> <u>Manicure</u></b> & <b><u>Pedicure</u></b> salons</p>
                            <button class="btn custom-btn" style="background-color: #c06600;color: #fff;">View</button>
                        </div>
                        <div class="col-md-4 p-2">
                            <?= Html::img('@web/images/manicure.jpg', ['alt' => 'Manicure Salon', 'class' => 'img-fluid rounded-start', 'style' => 'width:160px; height: 120px']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-header bg-light text-dark">
                        <h5 class="text-uppercase fw-semibold text-center text-warning">Quality Products</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="inner ">
                            <p>Purchase salon-grade products to maintain your look at home. Get exclusive discounts.</p>
                            <button class="btn custom-btn" style="background-color: #c06600;color: #fff;">Shop Products</button>
                        </div>
                        <div class="col-md-4">
                            <?= Html::img('@web/images/wig1.jpg', ['alt' => 'Quality Products', 'class' => 'img-fluid rounded-start']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-5 parallax">
            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-header  text-uppercase fw-semibold text-center text-warning">
                        <h5>Barber Shops</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="inner">
                            <p>Find top-rated salons dedicated to quality and elegance. Book appointments with ease.</p>
                            <button class="btn custom-btn" style="background-color: #c06600;color: #fff;">View Salons</button>
                        </div>
                        <div class="col-md-4">
                            <?= Html::img('@web/images/barber.jpeg', ['alt' => 'Barber Shop', 'class' => 'img-fluid rounded-start', 'style' => 'width:350px; height:150px']) ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-header text-uppercase fw-semibold text-center text-warning">
                        <h5>Bridal Salons</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="inner">
                            <p>Make your day glamourous with us by finding a good bridal saloon</p>
                            <button class="btn custom-btn" style="background-color: #c06600;color: #fff;">View Salons</button>
                        </div>
                        <div class="col-md-4">
                            <?= Html::img('@web/images/bridal.jpg', ['alt' => 'Bridal Salon', 'class' => 'img-fluid rounded-start', 'style' => 'width:250px;height:150px']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card">
                    <div class="card-header text-uppercase fw-semibold text-center text-warning">
                        <h5 class=""> Skin Care </h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="inner ">
                            <p>Glow and get classy with <i>Amaryne</i>. Get connected to perfect skin care doctors.</p>
                            <button class="btn custom-btn" style="background-color: #c06600;color: #fff;">Aesthetic Skin Care Clinics</button>
                        </div>
                        <div class="col-md-4">
                            <?= Html::img('@web/images/skincare.jpeg', ['alt' => 'Skin Care', 'class' => 'img-fluid rounded-start', 'style' => 'width: 150px; height:150px']) ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <hr>

 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        // JavaScript to handle background image slideshow
        document.addEventListener('DOMContentLoaded', function() {
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