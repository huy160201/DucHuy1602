<?php
?>
<table class="table table-bordered">
    <tr>
        <th>Avatar</th>
        <td>
            <?php if (!empty($profile['avatar'])) : ?>
                <img height="100" src="assets/uploads/<?php echo $profile['avatar']; ?>">
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>First Name</th>
        <td><?php echo $profile['first_name']; ?></td>
    </tr>
    <tr>
        <th>Last Name</th>
        <td><?php echo $profile['last_name']; ?></td>
    </tr>
    <tr>
        <th>Phone</th>
        <td><?php echo $profile['phone']; ?></td>
    </tr>
    <tr>
        <th>Address</th>
        <td><?php echo $profile['address']; ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $profile['email']; ?></td>
    </tr>
    <tr>
        <th>Jobs</th>
        <td><?php echo $profile['jobs']; ?></td>
    </tr>
    <tr>
        <th>Last Login</th>
        <td>
            <?php echo date('d-m-Y H:i:s',strtotime($profile['last_login'])); ?>
        </td>
    </tr>
    <tr>
        <th>Facebook</th>
        <td><?php echo $profile['facebook']; ?></td>
    </tr>
    <tr>
        <th>Status</th>
        <td>Active</td>
    </tr>
    <tr>
        <th>Created At</th>
        <td><?php echo date('d-m-Y H:i:s',strtotime($profile['created_at'])); ?></td>
    </tr>
    <tr>
        <th>Updated At</th>
        <td>
            <?php if(!empty($profile['updated_at'])) {
                echo date('d-m-Y H:i:s',strtotime($profile['updated_at']));
            } ?>
        </td>
    </tr>
</table>
<a class="btn btn-primary" href="index.php?controller=user&action=modify">Modify</a>
<a class="btn btn-default" href="index.php?controller=product&action=index">Back</a>

