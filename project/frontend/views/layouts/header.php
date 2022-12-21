<?php
$year = '';
$username = '';
$jobs = '';
$avatar = '';
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['username'];
    $jobs = $_SESSION['user']['jobs'];
    $avatar = $_SESSION['user']['avatar'];
    $year = date('Y', strtotime($_SESSION['user']['created_at']));
}
?>

<div id="top">
    <div class="shell">
        <!-- Header -->
        <div id="header">
            <div id="logo"><a href="index.php?controller=product&action=index"><img src="assets/images/logo.gif"></a></div>
            <div id="navigation">
                <ul>
                    <li><a href="index.php?controller=product&action=index">Trang chủ</a></li>
                    <li><a href="#">Hỗ trợ</a></li>
                    <li><a href="#">Tin tức</a></li>
                    <?php if ($username === '') { ?>
                        <li><a href='index.php?controller=user&action=login'>Đăng nhập</a></li>
                    <?php } else { ?>
                        <li><a href='index.php?controller=user&action=Logout' onclick="return confirm('Bạn có chắc muốn đăng xuất không ?')">Đăng xuất</a></li>
                    <?php } ?>
                    <?php
                    // echo $username === '' ? "
                    //         <li><a href='index.php?controller=user&action=login'>Đăng nhập</a></li>
                    //     " : "
                    //         <li><a href='index.php?controller=user&action=Logout' onclick='return confirm('')'>Đăng xuất</a></li>
                    //     "
                    ?>
                    <?php echo $username !== '' ? "<li class='last'><a href='index.php?controller=user&action=profile'>$username</a></li>" : "<li class='last'><a href='#'>tài khoản</a></li>" ?>
                </ul>
            </div>
        </div>
        <!-- End Header -->
        <!-- Slider -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="assets/images/slide3.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/images/slide2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="assets/images/slide1.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <!-- End Slider -->
    </div>
</div>