<?php
?>
<div class="container">
    <h1>Đăng ký</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Nhập username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="password">Nhập password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="password_confirm">Nhập lại password</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="register" value="Đăng ký" class="btn btn-primary">
            <p>
                Nếu đã có tài khoản, vui lòng đăng nhập
                <a href="index.php?controller=user&action=login"> tại đây</a>
            </p>
        </div>
    </form>
</div>
