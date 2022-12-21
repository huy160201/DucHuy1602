<?php
?>
<div style="margin-left: 150px; margin-top: 20px;">
    <h2>Cập nhật thông tin cá nhân</h2>
    <form action="" method="post" enctype="multipart/form-data" style="width: 500px;">
        <div class="form-group">
            <label for="avatar">Ảnh đại diện</label>
            <input type="file" name="avatar" value="" class="form-control" id="avatar"/>
            <img src="#" id="img-preview" style="display: none" width="100" height="100">
            <?php if(!empty($profile['avatar'])): ?>
                <img src="assets/uploads/<?php echo $profile['avatar']; ?>">
            <?php endif;?>
        </div>
        <div class="form-group">
            <label for="first_name">Họ</label>
            <input type="text" name="first_name"
                   value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : $profile['first_name'] ?>"
                    class="form-control" id="first_name">
        </div>
        <div class="form-group">
            <label for="last_name">Tên</label>
            <input type="text" name="last_name"
                    value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : $profile['last_name'] ?>"
                    class="form-control" id="last_name">
        </div>
        <div class="form-group">
            <label for="phone">Điện thoại</label>
            <input type="text" name="phone"
                    value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $profile['phone'] ?>"
                    class="form-control" id="phone">
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <input type="text" name="address"
                   value="<?php echo isset($_POST['address']) ? $_POST['address'] : $profile['address'] ?>"
                   class="form-control" id="address">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email"
                   value="<?php echo isset($_POST['email']) ? $_POST['email'] : $profile['email'] ?>"
                   class="form-control" id="email">
        </div>
        <div class="form-group">
            <label for="jobs">Công việc</label>
            <input type="text" name="jobs"
                   value="<?php echo isset($_POST['jobs']) ? $_POST['jobs'] : $profile['jobs'] ?>"
                   class="form-control" id="jobs">
        </div>
        <div class="form-group">
            <label for="facebook">Facebook</label>
            <input type="text" name="facebook"
                   value="<?php echo isset($_POST['facebook']) ? $_POST['facebook'] : $profile['facebook'] ?>"
                   class="form-control" id="facebook">
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Save" class="btn btn-primary">
            <a class="btn btn-default" href="index.php?controller=user&action=profile">Back</a>
        </div>
    </form>
</div>
