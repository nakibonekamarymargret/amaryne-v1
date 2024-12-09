<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Products</title>
    <style>
        .product-description {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            display: block;
        }

        .product-description.expanded {
            white-space: normal;
        }

        .product-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .action-buttons button {
            width: 48%;
        }
    </style>
</head>

<body>
    <div class="products-section container">
        <div class="header d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3"><strong>My Products</strong></h1>
            <div class="options d-flex gap-2">
                <a href="#" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    <i class="fa-solid fa-plus"></i>
                </a>
                <a href="#">
                    <i class="fa-solid fa-angle-down"></i>
                </a>
                <a href="#">
                    <i class="fa-solid fa-list"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $index => $product): ?>
                    <div class="col-md-4 mb-4">
                        <h5 class="text-center text-uppercase font-monospace">
                            <?= Html::encode($product->name) ?>
                        </h5>
                        <div class="product-card border p-3 rounded">
                            <div class="product-image mb-3" data-id="<?= Html::encode($product->id) ?>">
                                <img src="<?= Url::to('@web/' . Html::encode($product->image)) ?>"
                                    alt="<?= Html::encode($product->name) ?>">
                            </div>
                            <p class="mb-3">
                                <span class="product-description" id="product-description-<?= $index ?>">
                                    <?= Html::encode($product->description) ?>
                                </span>
                                <a href="#" id="toggle-link-<?= $index ?>" class="toggleDescription text-primary">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </a>
                            </p>
                            <div class="action-buttons d-flex justify-content-between">
                                <button type="button" class="btn btn-primary edit-button" data-id="<?= $product->id ?>">
                                    Edit
                                </button>

                                <button type="button" class="btn btn-danger delete-button" data-id="<?= $product->id ?>">Delete</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No products yet.</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createProductModal" class="btn btn-primary">
                        Add Product
                    </a>
                    <button class="btn btn-secondary">Add Later</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Create Product Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin([
                        'action' => ['salon-owner/create-products'],
                        'options' => ['enctype' => 'multipart/form-data']
                    ]) ?>
                    <?= $form->field($model, 'image')->fileInput([
                        'class' => 'form-control',
                        'onchange' => 'previewImage(event)'
                    ])->label('Product Image') ?>
                    <img id="imagePreview" class="img-fluid mt-2 mb-3 d-none" alt="Product Preview">
                    <?= $form->field($model, 'name')->textInput(['class' => 'form-control'])->label('Product Name') ?>
                    <?= $form->field($model, 'description')->textarea(['class' => 'form-control'])->label('Description') ?>
                    <?= $form->field($model, 'price')->input('number', ['class' => 'form-control'])->label('Product Price') ?>
                    <?= $form->field($model, 'discount')->input('number', ['class' => 'form-control'])->label('Discount') ?>
                    <div class="text-end mt-3">
                        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editProductContent">
                    <!-- Content loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle description visibility
            const toggleLinks = document.querySelectorAll('.toggleDescription');

            toggleLinks.forEach(link => {
                link.addEventListener('click', event => {
                    event.preventDefault();
                    const description = link.previousElementSibling;
                    description.classList.toggle('expanded');
                    link.innerHTML = description.classList.contains('expanded')
                        ? '<i class="fa-solid fa-chevron-up"></i>'
                        : '<i class="fa-solid fa-chevron-down"></i>';
                });
            });

        })
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-button');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-id');
                    $.ajax({
                        url: '<?= Yii::$app->urlManager->createUrl(['salon-owner/update-product']) ?>',
                        type: 'GET',
                        data: { id: productId },
                        success: function (response) {
                            $('#editProductContent').html(response);
                            $('#editProductModal').modal('show');
                        },
                        error: function () {
                            alert('Error loading edit form.');
                        }
                    });
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            
            if (confirm('Are you sure you want to disable this product?')) {
                $.ajax({
                    url: '<?= Yii::$app->urlManager->createUrl(['salon-owner/disable-product']) ?>',
                    type: 'POST',
                    data: { id: productId },
                    success: function (response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            alert(data.message);
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function () {
                        alert('An error occurred while disabling the product.');
                    }
                });
            }
        });
    });
});

    </script>
</body>

</html>