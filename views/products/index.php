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
          <input type="text" name="search" placeholder="Search products" class="form-control">
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
    <div class="col-12 col-md-2 sidebar-content">
      <?php
      echo $this->render('/partialviews/_sidenav', [
        'sidebarData' => $this->params['sidebarData'] ?? []
      ]);
      ?>
    </div>
    <div class="col-12 col-md-8 mt-3">
      <div class="row">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $index => $product): ?>
            <div class="col-12 col-md-4 mb-4">
              <div class="product-card">
                <div class="card-body">
                  <div class="d-flex image-name">
                    <img src="<?= Url::to('@web/' . Html::encode($product->image)) ?>"
                         alt="<?= Html::encode($product->name) ?>" class="card-img-top product-image">
                    <h5 class="product-title">
                      <?= Html::encode($product->name) ?>
                    </h5>
                  </div>

                  <div class="product-lower">
                    <p class="card-text product-price">
                      <?= Html::encode($product->price) ?>/=
                    </p>
                    <div class="cart-options d-flex justify-content-between">
                      <p class="text-dark increment ">
                        <i class="bi bi-cart-plus fs-4 mb-3 text-success add-product mx-5"
                           data-id="<?= Html::encode($product->id) ?>" data-name="<?= Html::encode($product->name) ?>"
                           data-price="<?= Html::encode($product->price) ?>"></i>
                      </p>
                      <p class="text-dark  ">
                        <i class="bi bi-cart-dash text-danger fs-4 mb-3 ml-2 remove-product"
                           data-id="<?= Html::encode($product->id) ?>" data-name="<?= Html::encode($product->name) ?>"
                           data-price="<?= Html::encode($product->price) ?>"></i>
                      </p>
                    </div>
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

    <div class="col-12 col-md-2 shopping-cart">
      <div class="cart-card">
        <div>
          <div class="cart-icon">
            <i class="bi bi-cart-check fs-2"></i>
            <span
              class="text-success mx-1 mt-2 fs-5 cart-count position-absolute top-1 start-100 translate-middle  cart-total-items">0</span>
          </div>
          <h3 class="cart-title">Your Cart</h3>
          <span class="quantity badge bg-secondary fs-6 mb-3 mt-2 cart-total-items"
                id="quantity-<?= $product->id ?>">0</span>

          <p class="mb-1"><i class="fa-solid fa-money-bill"></i>:
            <span class="fw-bold text-success">Shs. <span class="cart-total-price">0</span></span>
          </p>
          <button class="btn btn-cart col-6 mb-3 mt-3" data-bs-toggle="modal"
                  data-bs-target="#orderModal">Proceed</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Order Confirmation -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs-5" id="orderModalLabel">Thank you for choosing us</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="payment-options mx-4 justify-content-center align-items-center">
          <h6>Please select  your  Payment Option</h6>
            <?= Html::img('@web/images/mtn.png', [
              'alt' => 'Amaryne Beauties Logo',
              'width' => '70',
              'height' => '65',
            ]) ?>
            <?= Html::img('@web/images/airtel.jpeg', [
              'alt' => 'airtel',
              'width' => '70',
              'height' => '65',
            ]) ?>
        </div>
      <div class="mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  const cart = {};

  $(document).ready(function () {
    // Add product to cart
    $(".add-product").on("click", function () {
      const productId = $(this).data("id");
      const productName = $(this).data("name");
      const productPrice = parseInt($(this).data("price")) || 0;
      const productImage = $(this).data("image");

      if (!cart[productId]) {
        cart[productId] = { id: productId, name: productName, price: productPrice, image: productImage, quantity: 0 };
      }
      cart[productId].quantity++;
      updateCartDisplay();
    });

    // Remove product from cart
    $(document).on("click", ".remove-product", function () {
      const productId = $(this).data("id");
      if (cart[productId]) {
        cart[productId].quantity--;
        if (cart[productId].quantity <= 0) {
          delete cart[productId];
        }
        updateCartDisplay();
      }
    });

    // Handle cart purchase button
    $(".btn-cart").on("click", function () {
      if (Object.keys(cart).length === 0) {
        alert("Your cart is empty. Please add products before purchasing.");
        return;
        $('#orderModal').modal('hide');

      }

      // Show the modal with order detailsadd-to-cart
      const product = Object.values(cart)[0]; 
      $("#order-product-name").text(product.name);
      $("#order-price").text(product.price);

      $('#orderModal').modal('show');
    });

    // Handle payment option selection
    $(".payment-option").on("click", function () {
      const paymentMethod = $(this).data("payment");
      console.log("Selected Payment Method: " + paymentMethod);
    });

    // Confirm purchase
    $("#confirm-purchase-btn").on("click", function () {
      if (Object.keys(cart).length === 0) {
        alert("Your cart is empty.");
        return;
      }

      // Process the purchase logic (example: AJAX request)
      processPurchase();
    });

    // Cancel the purchase or modal action
    $(".btn-secondary").on("click", function () {
    alert("Are you sure you want to cancel this order")
      $('#orderModal').modal('hide'); 
      clearCart(); 
    });
  });

  // Update cart display and modal contents
  function updateCartDisplay() {
    const $cartCount = $(".cart-total-items");
    const $cartTotalPrice = $(".cart-total-price");
    const $modalBody = $(".modal-body");

    let totalItems = 0;
    let totalPrice = 0;

    // Clear existing modal content
    $modalBody.empty();

    // Populate cart and modal
    for (const id in cart) {
        const item = cart[id];
        totalItems += item.quantity;
        totalPrice += item.price * item.quantity;

        // Add item to modal
        $modalBody.append(`
            <div class="d-flex align-items-center mb-3">
                <p>${item.name} - Shs. ${item.price}/= x ${item.quantity}</p>
                <p class="btn btn-sm remove-item mx-2" data-id="${id}">
                    <i class="bi bi-trash text-danger fs-6 mx-1"></i>
                </p>
            </div>
        `);
    }

    // Update cart count and total price
    $cartCount.text(totalItems);
    $cartTotalPrice.text(totalPrice);

    // Attach event listener for removing items in modal
    $(".remove-item").on("click", function () {
        const productId = $(this).data("id");
        if (cart[productId]) {
            cart[productId].quantity--;
            if (cart[productId].quantity <= 0) {
                delete cart[productId];
            }
            updateCartDisplay();
        }
    });
  }

  // Process purchase
  function processPurchase() {
    const firstProduct = cart[Object.keys(cart)[0]]; // Get first product to display order details (assuming all cart items are similar)
    const totalPrice = Object.values(cart).reduce((sum, item) => sum + item.price * item.quantity, 0);

    // Show the modal with order details
    $("#order-name").text(firstProduct.name);
    $("#order-image").attr("src", '<?= Url::to('@web/') ?>' + firstProduct.image); // Assuming 'image' field contains the correct image URL
    $("#order-price").text('Shs. ' + totalPrice);

    // Show the modal with payment options
    $("#orderModal").modal('show');
  }

  // Confirm the purchase and process payment
  $("#confirm-purchase").on("click", function () {
    const paymentMethod = $("#payment-method").val(); // Get the selected payment method
    alert("You selected " + paymentMethod + " as your payment method.");

    // Proceed with the actual purchase process (e.g., sending the payment data to the server)
    $.ajax({
      url: '<?= Url::to(['/orders/purchase']) ?>',
      method: 'POST',
      data: { cart, paymentMethod },
      success: function (response) {
        if (response.success) {
          alert('Purchase successful! Your Order ID: ' + response.orderId);
          clearCart();
          $("#orderModal").modal('hide');
        } else {
          alert('Purchase failed: ' + response.message);
        }
      },
      error: function () {
        alert('An error occurred while processing your purchase. Please try again.');
      }
    });
  });

  // Fetch order summary after purchase
  function fetchOrderSummary(orderId) {
    $.ajax({
      url: '<?= Url::to(['/orders/view']) ?>',
      method: 'GET',
      data: { id: orderId },
      success: function (response) {
        if (response.success) {
          const order = response.order;
          const items = response.items;

          $("#summary-items").empty();
          items.forEach(item => {
            $("#summary-items").append(`
              <li>${item.name} - ${item.price}/= x ${item.quantity}</li>
            `);
          });

          $("#summary-total").text(order.total_price);
          $("#order-summary").show();
        }
      },
      error: function () {
        alert('An error occurred while fetching order details.');
      }
    });
  }

  // Clear cart after purchase
  function clearCart() {
    Object.keys(cart).forEach(key => delete cart[key]);
    updateCartDisplay();
  }
</script>
