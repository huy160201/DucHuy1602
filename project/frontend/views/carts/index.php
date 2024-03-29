<div class="timeline-items container">
    <h2>Giỏ hàng của bạn</h2>
    <form action="" method="post">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th width="40%">Tên sản phẩm</th>
                    <th width="12%">Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>
                <?php if (isset($_SESSION['cart'])) : ?>
                    <?php
                    // Khai báo tổng giá trị đơn hàng
                    $total_cart = 0;
                    foreach ($_SESSION['cart'] as $product_id => $cart) : ?>
                        <tr>
                            <td>
                                <img class="product-avatar img-responsive" src="../backend/assets/uploads/<?php echo $cart['avatar'] ?>" width="80">
                                <div class="content-product">
                                    <a href="index.php?controller=product&action=detail&id=<?php echo $product_id ?>" class="content-product-a">
                                        <?php echo $cart['title']; ?>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <!--  cần khéo léo đặt name cho input số lượng, để khi xử lý submit form update lại giỏ hànTin nổi bậtg sẽ đơn giản hơn    -->
                                <input type="number" min="0" name="<?php echo $product_id; ?>" class="product-amount form-control" value="<?php echo $cart['quantity']; ?>">
                            </td>
                            <td>
                                <?php echo number_format($cart['price']) ?>
                            </td>
                            <td>
                                <?php
                                $total_item = $cart['price'] * $cart['quantity'];
                                // Cộng dồn để lấy ra tổng giá trị đơn hàng
                                $total_cart += $total_item;
                                echo number_format($total_item);
                                ?>
                            </td>
                            <td class="trash-icon">
                                <a href="index.php?controller=cart&action=delete&id=<?php echo $product_id; ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm khỏi giỏ hàng ?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="5" style="text-align: right">
                            Tổng giá trị đơn hàng:
                            <span class="product-price">
                                <?php echo number_format($total_cart); ?> vnđ
                            </span>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="5" class="product-payment">
                        <input type="submit" name="submit" value="Cập nhật lại giá" class="btn btn-primary">
                        <a href="<?php echo isset($_SESSION['user']) ? '
                            index.php?controller=payment&action=index
                            ' : '
                            index.php?controller=user&action=login
                            ' ?>" class="btn btn-success">
                            Đến trang thanh toán
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<!--Timeline items end -->