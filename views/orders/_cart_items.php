<!-- _cart_items.php -->
<?php if (!empty($cart)): ?>
    <?php foreach ($cart as $index => $item): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><img src="<?= Url::to('@web/' . Html::encode($item['image'])) ?>" alt="Product Image"></td>
            <td><?= Html::encode($item['name']) ?></td>
            <td><?= Html::encode($item['quantity']) ?></td>
            <td><?= Html::encode($item['price']) ?></td>
            <td>
                <button class="btn btn-danger remove-product" data-id="<?= $item['id'] ?>">Remove</button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="text-center">No items in the cart.</td>
    </tr>
<?php endif; ?>
