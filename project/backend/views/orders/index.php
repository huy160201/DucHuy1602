<?php
?>

<h2>Danh sách đơn hàng</h2>

<table class="table table-bordered">
    <tr>
        <th>Id</th>
        <th>User Id</th>
        <th>Fullname</th>
        <th>Address</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Note</th>
        <th>Price_total</th>
        <th>Payment_status</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th></th>
    </tr>
    <?php if(!empty($orders)) : ?>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['user_id']; ?></td>
                <td><?php echo $order['fullname']; ?></td>
                <td><?php echo $order['address']; ?></td>
                <td><?php echo $order['mobile']; ?></td>
                <td><?php echo $order['email']; ?></td>
                <td><?php echo $order['note']; ?></td>
                <td><?php echo number_format($order['price_total']); ?></td>
                <td><?php echo $order['payment_status']; ?></td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
                <td><?php echo !empty($order['updated_at']) ? date('d-m-Y H:i:s', strtotime($order['updated_at'])) : '--' ?></td>
                <td>
                    <?php
                        $url_detail = "index.php?controller=order&action=detail&id=" . $order['id'];
                    ?>
                    <a title="Chi tiết" href="<?php echo $url_detail?>"><i class="fa fa-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>

    <?php else: ?>
        <tr>
            <td colspan="11">Không có bản ghi nào</td>
        </tr>
    <?php endif; ?>
</table>
<?php echo $pages; ?>