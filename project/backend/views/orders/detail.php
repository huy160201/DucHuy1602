<?php
?>

<h2>Chi tiết Order</h2>

<table class="table table-bordered">
    <tr>
        <th>Order Id</th>
        <th>Product Name</th>
        <th>Product Price</th>
        <th>Quantity</th>
    </tr>

    <?php if(!empty($detail)) : ?>
        <?php foreach ($detail as $product) : ?>
            <tr>
                <td><?php echo $product['order_id'] ?></td>
                <td><?php echo $product['product_name'] ?></td>
                <td><?php echo number_format($product['product_price']) ?></td>
                <td><?php echo $product['quantity'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>
<a href="index.php?controller=order&action=index" class="btn btn-default">Back</a>
