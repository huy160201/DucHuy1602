<!DOCTYPE html>
<html>
<head>
    <!--    fanpage-->

</head>
<body>
<!--    PRODUCT-->
<div class="product-wrap">
    <div class="product-container">
        <form action="" method="GET">
            <div class="form-group">
                <label for="title">Nhập tên sản phẩm</label>
                <input type="text" name="title" value="<?php echo isset($_GET['title']) ? $_GET['title'] : '' ?>" id="title"
                       class="form-control"/>
            </div>
            <div class="form-group">
                <label for="title">Chọn danh mục</label>
                <select name="category_id" class="form-control">
                    <option value="" selected>--- Chọn danh mục ---</option>
                    <?php foreach ($categories as $category):
                        //giữ trạng thái selected của category sau khi chọn dựa vào
//                tham số category_id trên trình duyệt
                        $selected = '';
                        if (isset($_GET['category_id']) && $category['id'] == $_GET['category_id']) {
                            $selected = 'selected';
                        }
                        ?>
                        <option value="<?php echo $category['id'] ?>" <?php echo $selected; ?>>
                            <?php echo $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <b>Khoảng giá</b> <br/>
                <?php
                //cần đổ lại dữ liệu ra form search
                $price1_checked = '';
                $price2_checked = '';
                $price3_checked = '';
                $price4_checked = '';
                if (isset($_GET['price'])) {
                    if ($_GET['price'] == 1) {
                        $price1_checked = 'checked';
                    }
                    if ($_GET['price'] == 2) {
                        $price2_checked = 'checked';
                    }
                    if ($_GET['price'] == 3) {
                        $price3_checked = 'checked';
                    }
                    if ($_GET['price'] == 4) {
                        $price4_checked = 'checked';
                    }
                }
                ?>
                <input type="radio" name="price" value="1" <?php echo $price1_checked; ?> /> Dưới 1tr &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="price" value="2" <?php echo $price2_checked; ?> /> Từ 1 - 5tr
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="price" value="3" <?php echo $price3_checked; ?> /> Từ 5 - 10tr
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="price" value="4" <?php echo $price4_checked; ?> /> Trên 10tr

            </div>
            <input type="hidden" name="controller" value="product"/>
            <input type="hidden" name="action" value="index"/>
            <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary"/>
            <a href="index.php?controller=product" class="btn btn-default">Xóa filter</a>
        </form>
        <div class="product-field">
      <?php if (!empty($products)): ?>
          <h1 class="post-list-title">
              <a href="index.php?controller=product&action=index" class="link-category-item">Danh mục sản phẩm</a>
          </h1>
          <div class="link-secondary-wrap row">
              <?php foreach ($products AS $product):
                    $product_link = "index.php?controller=product&action=detail&id=" . $product['id'];
                    $product_cart_add = "index.php?controller=cart&action=add&id=" . $product['id'];
                    ?>
                    <div class="service-link col-md-3 col-sm-6 col-xs-12">
                        <a href="<?php echo $product_link; ?>">
                            <img class="secondary-img img-responsive" title="<?php echo $product['title'] ?>"
                                 src="../backend/assets/uploads/<?php echo $product['avatar'] ?>"
                                 alt="<?php echo $product['title'] ?>"/>
                            <span class="shop-title">
                                <?php echo $product['title'] ?>
                            </span>
                        </a>
                        <span class="shop-price">
                            <?php echo number_format($product['price']) ?>
                        </span>
                        <!--                    Tạo dấu hiệu nhận biết để khi gọi ajax
                                            sẽ lấy đc đúng id của sp vừa click-->
                        <span class="add-to-cart" data-id="<?php echo $product['id']?>">
                            <a href="#" style="color: inherit">Thêm vào giỏ</a>
                        </span>
                    </div>
              <?php endforeach; ?>
          </div>
      <?php else: ?>
            <br>
          <h2>
              <td colspan="9">No data found</td>
          </h2>
      <?php endif; ?>
        </div>
        <br>
        <br>
        <?php echo $pages; ?>
    </div>
</div>
</body>
</html>


