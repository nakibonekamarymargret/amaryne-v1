<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container-fluid">
  <div class="header">
    <div class="search">
      <form action="#">
        <div class="input-container">
          <i class="fa fa-search"></i>
          <input type="text" name="search" placeholder="Search products">
        </div>
      </form>
    </div>
    <div class="options d-flex gap-2">
      <a href="#">
        <i class="fa-solid fa-angle-down"></i>
      </a>
      <a href="#">
        <i class="fa-solid fa-list"></i>
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-2 sidebar-content">
      <?php
      echo $this->render('/partialviews/_sidenav', [
        'sidebarData' => $this->params['sidebarData'] ?? []
      ]);
      ?>
    </div>
    <div class="col-8 mt-3">
      <div class="row">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $index => $product): ?>
            <div class="col-md-4 mb-4">
              <div class="product-card">
                <div class="card-body">
                  <div class="d-flex image-name">
                    <img src="<?= Url::to('@web/' . Html::encode($product->image)) ?>"
                      alt="<?= Html::encode($product->name) ?>" class="card-img-top product-image">
                    <h5 class="product-title ">
                      <?= Html::encode($product->name) ?>
                    </h5>
                  </div>

                  <div class="product-lower">
                    <p class="card-text product-price">
                      <?= Html::encode($product->price) ?>/=
                    </p>

                    <p class=" text-dark increment ms-5" data-id="<?= Html::encode($product->id) ?>"
                      data-price="<?= Html::encode($product->price) ?>">
                      <i class="fa-solid fa-plus"></i>
                    </p>
                  </div>

                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12 text-center">
            <p>No products yet.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-2 shopping-cart">
      <div class="cart-card">
        <div>
          <div class=" cart-icon ">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="text-dark  mx-2 cart-count position-absolute top-0 start-100 translate-middle rounded-circle">
              0
            </span>
          </div>
          <h3 class="cart-title">Your cart</h3>
          <div class="cart-actions">
            <p class="price-decrement me-2" data-id="<?= $product->id ?>" data-price="<?= $product->price ?>">
              <i class="fa-solid fa-minus"></i>
            </p>
            <span class="quantity badge bg-secondary fs-6 mb-3" id="quantity-<?= $product->id ?>">0</span>
            <p class="price-increment " data-id="<?= Html::encode($product->id) ?>"
              data-price="<?= Html::encode($product->price) ?>">
              <i class="bi bi-plus-lg"></i>
            </p>

          </div>
          <p class="mb-1"> Items: <span class="fw-bold cart-total-items">0</span></p>
        <p class="mb-1"><i class="fa-solid fa-money-bill"></i>: <span class="fw-bold text-success">Shs.
            <span class="cart-total-price">0</span></span></p>
        <button class="btn btn-primary  col-6 mb-3mt-3">Purchase</button>
        </div>
      </div>
    </div>
  </div>
</div>