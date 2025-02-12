<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>


<?php if (!empty($products)):?>
    <?php foreach ($products as $product):?>
        <div class="col-md-4 mb-4">
            <div class="product-card">
                <div class="card-body">
                    <div class="d-flex image-name">
                        <img src="<?= Url::to('@web/'. Html::encode($product->image))?>" 
                             alt="<?= Html::encode($product->name)?>" class="card-img-top product-image">
                        <h5 class="product-title">
                            <?= Html::encode($product->name)?>
                        </h5>
                    </div>

                    <div class="product-lower">
                        <p class="card-text product-price">
                            <?= Html::encode($product->price)?>/=
                        </p>
                        <div class="cart-options d-flex justify-content-space-around">
                            <p class="text-dark increment ">
                                <i class="bi bi-cart-plus fs-4 mb-3 text-success add-product" 
                                   data-id="<?= Html::encode($product->id)?>" 
                                   data-name="<?= Html::encode($product->name)?>"
                                   data-price="<?= Html::encode($product->price)?>"></i>
                            </p>
                            <p class="text-dark  ">
                                <i class="bi bi-cart-dash  text-danger fs-4 mb-3 ml-2 remove-product"
                                   data-id="<?= Html::encode($product->id)?>" 
                                   data-name="<?= Html::encode($product->name)?>"
                                   data-price="<?= Html::encode($product->price)?>"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
<?php else:?>
    <div class="col-12 text-center">
        <p>No products yet.</p>
    </div>
<?php endif;?>
