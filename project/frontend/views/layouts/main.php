<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo $_SERVER['SCRIPT_NAME'] ?>" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MVC Frontend</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- tích hợp thư viện bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-3.4.1.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css"/>
    <!--  main css  -->
    <link rel="stylesheet" href="assets/css/style.css"/>

    <!-- tích hợp jQuery và các thư viện js mà nó yêu cầu -->
    <script type="text/javascript" src="assets/js/jquery-3.4.1.min.js"></script>
    <!-- file bundle-->
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="assets/js/script.js"></script>

</head>
<body>
<?php require_once 'header.php'; ?>
<div id="main">
    <div class="shell">
        <div class="options">
            <span class="left"><a href="#">Welcome to our Shop</a></span>
            <div class="right">
                <span class="header-navigation">
                    <a href="index.php?controller=cart&action=index" class="cart-link">
                            <i class="fa fa-cart-plus"></i>
                        <?php
                        $cart_total = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] AS $cart) {
                                $cart_total += $cart['quantity'];
                            }
                        }
                        ?>
                        <span class="cart-amount">
                                <?php echo $cart_total; ?>
                            </span>
                        </a>
                    <a href="index.php?controller=cart&action=index">Details</a>
                </span>
                <span class="ajax-message">Thêm vào giỏ thành công</span>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($this->error)): ?>
                <div class="alert alert-danger">
                    <?php
                    echo $this->error;
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <!--    hiển thị nội dung động -->
        <?php echo $this->content; ?>
    </div>
    <ul class="icon-service-wrap">
        <li data-toggle="tooltip" data-placement="left" title="Gọi ngay cho chúng tôi">
            <a href="tel:0999999999">
                <img src="assets/images/icon-phone.png" class="icon-service-img">
            </a>
        </li>
        <li data-toggle="tooltip" data-placement="left" title="Gửi mail cho chúng tôi">
            <a href="mailto:abc@gmail.com">
                <img src="assets/images/icon-mail.png" class="icon-service-img">
            </a>
        </li>
    </ul>
</div>

<?php require_once 'footer.php'; ?>

</body>

</html>