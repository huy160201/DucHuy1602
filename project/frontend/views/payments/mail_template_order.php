<div class="wrap">
    <h2>Cảm ơn bạn đã đặt hàng, <b><?php echo $fullname; ?></b></h2>
    <p>
        Mã đơn hàng của bạn: <b><?php echo $order_id; ?></b>
    </p>
    <div>
        <p>
            - Để thanh toán đơn hàng, bạn hãy chuyển khoản theo thông tin sau:
            <br>
            <b>
                Sacombank NGUYEN DUC HUY <br>
                01234567890 <br>
                Chi nhánh Hà Nội <br>
            </b>
            Nội dung chuyển khoản: Thanh toán đơn hàng <?php echo $order_id; ?> </p>
        <p>
            - Hoặc bạn có thể liên hệ trực tiếp với chúng tôi qua số điện thoại:
            <a href="tel:036123123">0362274026</a>
        </p>
    </div>
    <h4>Thông tin người mua hàng</h4>
    <table border="1" cellpadding="8" cellspacing="0">
        <tbody>
        <tr>
            <th>Họ tên</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Địa chỉ</th>
        </tr>
        <tr>
            <td><?php echo $fullname; ?></td>
            <td><?php echo $mobile; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $address; ?></td>
        </tr>
        </tbody>
    </table>
    <br>
    <h4>Thông tin đơn hàng</h4>
    <?php if (isset($_SESSION['cart'])) : ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <tbody>
        <tr>
            <th width="40%">Tên sản phẩm</th>
            <th width="12%">Số lượng</th>
            <th>Giá</th>
            <th>Thành tiền</th>
        </tr>
        <?php
        $total_cart = 0;
        foreach ($_SESSION['cart'] AS $product_id => $cart) : ?>
        <tr>
            <td>
                <img class="product-avatar img-responsive"
                     src="../backend/assets/uploads/<?php echo $cart['avatar']; ?>"
                         height="60">
                <span class="content-product"><?php echo $cart['title']; ?></span>
            </td>
            <td>
                <?php echo $cart['quantity']; ?>
            </td>
            <td>
                <?php echo number_format($cart['price']); ?>
            </td>
            <td>
                <?php
                $total_item = $cart['price'] * $cart['quantity'];
                $total_cart += $total_item;
                echo number_format($total_item);
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5" style="text-align: right">
                Tổng giá trị đơn hàng:
                <span class="product-price"><?php echo number_format($total_cart); ?> vnđ</span>
            </td>
        </tr>
        </tbody>
    </table>
    <?php endif; ?>
</div>