<?php
?>
<div class="container">

    <h1>Đăng nhập</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Nhập username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="password">Nhập password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="login" value="Đăng nhập" class="btn btn-success">
            <h4 style="color: red">
                <?php
                if (isset($_SESSION['error'])) {
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                }
                ?>
            </h4>
            <h4 style="color: green">
                <?php
                if (isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                }
                ?>
            </h4>
            <p>
                Nếu chưa có tài khoản, vui lòng đăng ký
                <a href="index.php?controller=user&action=register"> tại đây</a>
            </p>
        </div>
    </form>
</div>
