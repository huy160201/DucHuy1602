<!DOCTYPE html>
<html>
<head>
    <!--    comment fb-->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0&appId=261233472276059&autoLogAppEvents=1" nonce="DNpjBbvP"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/star-rating-svg.css">
    <link rel="stylesheet" type="text/css" href="assets/css/demo-star.css">

    <script type="text/javascript" src="assets/js/jquery.star-rating-svg.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</head>
<body>
<?php
    $cmt_id = '';
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $cmt_id = $_GET['id'];
    }
?>
<div class="container">
    <div class="row">
        <div class="detail-content-wrap con-md-8 col-sm-8 col-xs-12">
            <div class="product-info-wrap">
                <div class="product-image-info">
                    <img src="../backend/assets/uploads/<?php echo $product['avatar'] ?>" width="260"
                         title="<?php echo $product['title']; ?>">
                </div>
                <div class="my-rating-4" data-rating="0"></div>
                <div class="product-info">
                    <h3 class="product-title">
                      <?php echo $product['title']; ?>
                    </h3>
                    <div class="product-price">
                      <?php echo number_format($product['price'], 0, '.', ','); ?>₫
                    </div>
                    <div class="product-cart">
                        <span data-id="<?php echo $product['id']; ?>" class="add-to-cart">
                            <i class="fa fa-cart-plus"></i> Thêm vào giỏ
                        </span>
                    </div>
                </div>
            </div>

            <!--Timeline items end -->
            <div class="detail-content-wrap">
                <div class="detail-summary">
                    <strong><?php echo $product['summary']; ?></strong>
                </div>
                <div class="detail-description">
                    <div class="description-productdetail">
                      <?php echo $product['content']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product container">
    <!--comment fb-->
    <div class="fb-comments" data-href="http://localhost//project/frontend/index.php?controller=product&action=detail&id=<?php echo $cmt_id; ?>" data-width="1000" data-numposts="5"></div>
</div>
</body>
</html>