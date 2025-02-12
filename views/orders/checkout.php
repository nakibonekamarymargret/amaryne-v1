<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container">
    <h2>Order Summary</h2>
    <div class="row">
        <div class="col-8">
            <ul class="list-group">
                <?php foreach ($cart as $productId => $product): ?>
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <img src="<?= Url::to('@web/' . Html::encode($product['image'])) ?>" alt="<?= Html::encode($product['name']) ?>" class="img-thumbnail me-3" width="50">
                            <div>
                                <p><?= Html::encode($product['name']) ?> - Shs. <?= Html::encode($product['price']) ?>/= x <?= Html::encode($product['quantity']) ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-4">
            <h4>Total: Shs. <?= Html::encode($totalPrice) ?></h4>
            <button class="btn btn-primary" id="confirm-purchase-btn">Confirm Purchase</button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="orderModalLabel">Order Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Cart items will be shown dynamically here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirm-purchase">Confirm Purchase</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    // Confirm purchase and process payment
    $("#confirm-purchase-btn").on("click", function () {
      const cart = <?= json_encode($cart) ?>; // Pass the cart data to JS
      let totalPrice = <?= $totalPrice ?>;

      // Show order details in modal
      let modalContent = '';
      for (const productId in cart) {
        const product = cart[productId];
        modalContent += `
            <div class="d-flex align-items-center mb-3">
                <img src="<?= Url::to('@web/') ?>${product.image}" alt="${product.name}" class="img-thumbnail me-3" width="50">
                <div>
                    <p>${product.name} - Shs. ${product.price} x ${product.quantity}</p>
                </div>
            </div>
        `;
      }

      $(".modal-body").html(modalContent);
      $("#orderModal").modal('show');
    });

    $("#confirm-purchase").on("click", function () {
      alert("Purchase confirmed!");
      // Handle the actual purchase logic, possibly with an AJAX request
    });
  });
</script>
