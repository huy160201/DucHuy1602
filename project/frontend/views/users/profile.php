<h1 style="margin-top: 50px; margin-left: 150px;">Thông tin tài khoản</h1>
<table class="table table-bordered" style="width: 500px; margin-left: 150px;">
    <tr>
        <th>Ảnh đại diện</th>
        <td>
            <?php if (!empty($profile['avatar'])) : ?>
                <img height="100" src="assets/uploads/<?php echo $profile['avatar']; ?>">
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Họ</th>
        <td><?php echo $profile['first_name']; ?></td>
    </tr>
    <tr>
        <th>Tên</th>
        <td><?php echo $profile['last_name']; ?></td>
    </tr>
    <tr>
        <th>Điện thoại</th>
        <td><?php echo $profile['phone']; ?></td>
    </tr>
    <tr>
        <th>Địa chỉ</th>
        <td><?php echo $profile['address']; ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $profile['email']; ?></td>
    </tr>
    <tr>
        <th>Công việc</th>
        <td><?php echo $profile['jobs']; ?></td>
    </tr>
    <tr>
        <th>Lần cuối đăng nhập</th>
        <td>
            <?php echo date('d-m-Y H:i:s',strtotime($profile['last_login'])); ?>
        </td>
    </tr>
    <tr>
        <th>Facebook</th>
        <td><?php echo $profile['facebook']; ?></td>
    </tr>
    <tr>
        <th>Trạng thái</th>
        <td>Active</td>
    </tr>
    <tr>
        <th>Ngày tham gia</th>
        <td><?php echo date('d-m-Y H:i:s',strtotime($profile['created_at'])); ?></td>
    </tr>
    <tr>
        <th>Cập nhật cuối</th>
        <td>
            <?php if(!empty($profile['updated_at'])) {
                echo date('d-m-Y H:i:s',strtotime($profile['updated_at']));
            } ?>
        </td>
    </tr>
</table>
<div style="margin-left: 150px; margin-bottom: 20px;">
    <a class="btn btn-primary" href="index.php?controller=user&action=modify">Chỉnh sửa</a>
    <a class="btn btn-default" href="index.php?controller=product&action=index">Quay lại</a>
</div>

