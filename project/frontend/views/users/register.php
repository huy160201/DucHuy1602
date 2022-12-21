<?php
?>
<div class="container" style="margin-top: 20px; margin-left: 150px;">
    <h1>Đăng ký</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Nhập tài khoản</label>
            <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="password">Nhập mật khẩu</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="password_confirm">Nhập lại mật khẩu</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" name="register" value="Đăng ký" class="btn btn-primary">
            <p style="margin-top: 20px;">
                Nếu đã có tài khoản, vui lòng đăng nhập
                <a href="index.php?controller=user&action=login"> tại đây</a>
            </p>
        </div>
    </form>
</div>
