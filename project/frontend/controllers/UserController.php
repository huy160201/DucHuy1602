<?php
require_once 'controllers/Controller.php';
require_once 'models/User.php';
class UserController extends Controller {
    public function register() {
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            if (empty($password) || empty($username) || empty($password_confirm)) {
                $this->error = 'Phải nhập đầy đủ các trường';
            } elseif ($password != $password_confirm) {
                $this->error = 'Mật khẩu nhập lại chưa đúng';
            }
            if (empty($this->error)) {
                $user_model = new User();
                $is_username_exists = $user_model->isExistsUsername($username);
                if ($is_username_exists) {
                    $this->error = 'Tên đăng nhập này đã tồn tại, vui lòng chọn tên đăng nhập khác';
                } else {
                    $password = md5($password);
                    $is_register = $user_model->Register($username, $password);
                    if ($is_register) {
                        $_SESSION['success'] = 'Đăng ký thành công';
                        header('Location: index.php?controller=user&action=login');
                    }
                }
            }
        }

        $this->content = $this->render('views/users/register.php');
        require_once 'views/layouts/main_login.php';
    }

    public function login() {
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (empty($username) || empty($password)) {
                $this->error = 'Vui lòng nhập đầy đủ các trường';
            }
            if (empty($this->error)) {
                $user_model = new User();
                $password = md5($password);
                $user = $user_model->getUser($username, $password);
                if (empty($user)) {
                    $this->error = 'Sai tài khoản hoặc mật khẩu';
                } else {
                    $_SESSION['success'] = 'Đăng nhập thành công';
                    $_SESSION['user'] = $user;
                    $last_login = date('Y-m-d H:i:s');
                    $isGetTime = $user_model->timeLogin($username, $last_login);
                    header('Location: index.php?controller=product');
                    exit();
                }
            }
        }

        $this->content = $this->render('views/users/login.php');
        require_once 'views/layouts/main_login.php';
    }

    public function logout() {
        unset($_SESSION['user']);
        $_SESSION['success'] = 'Đăng xuất thành công';
        header('Location: index.php?controller=user&action=login');
        exit();
    }

    public function profile() {
        $profile = $_SESSION['user'];
        $this->content = $this->render('views/users/profile.php', [
            'profile' => $profile
        ]);
        require_once 'views/layouts/main.php';
    }

    public function modify() {
        $id = $_SESSION['user']['id'];
        $profile = $_SESSION['user'];
        $user_model = new User();

        if(isset($_POST['submit']))
        {
            $pattern = '#^\(?[\d]{3}\)?-\(?[\d]{2}\)?-[\d]{2}\.[\d]{3}-[\d]{3}$#';

            $avatar = $_FILES['avatar'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $jobs = $_POST['jobs'];
            $facebook = $_POST['facebook'];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error = 'Email không hợp lệ';
            } elseif (preg_match($pattern, $phone, $match) == 1) {
                $this->error = 'Phone không hợp lệ';
            } elseif ($avatar['error'] == 0) {
                $extension = pathinfo($avatar['name'],PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $arr_extension = ['jpg','png','jpeg','gif'];
                $size_mb = $avatar['size']/1024/1024;
                $size_mb = round($size_mb, 2);

                if(!in_array($extension, $arr_extension)) {
                    $this->error = 'Avatar không hợp lệ';
                } elseif ($size_mb > 2) {
                    $this->error = 'Avatar phải có kích thước dưới 2Mb';
                }
            }

            if(empty($this->error)) {
                // lấy tên ảnh cũ
                $file_name = $_SESSION['avatar'];
                if($avatar['error'] == 0) {
                    $dir_upload = 'assets/uploads';
                    // xóa file ảnh cũ nếu reupload
                    @unlink($dir_upload . '/' . $file_name);
                    if(!file_exists($dir_upload)) {
                        mkdir($dir_upload);
                    }
                    $filename = time() . '-user-' . $avatar['name'];
                    move_uploaded_file($avatar['tmp_name'],$dir_upload . '/' . $filename);
                }

                $user_model->avatar = $filename;
                $user_model->first_name = $first_name;
                $user_model->last_name = $last_name;
                $user_model->phone = $phone;
                $user_model->address = $address;
                $user_model->email = $email;
                $user_model->jobs = $jobs;
                $user_model->facebook = $facebook;
                $user_model->updated_at = date('d-m-Y H:i:s');

                $_SESSION['user']['avatar'] = $filename;
                $_SESSION['user']['first_name'] = $first_name;
                $_SESSION['user']['last_name'] = $last_name;
                $_SESSION['user']['phone'] = $phone;
                $_SESSION['user']['address'] = $address;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['jobs'] = $jobs;
                $_SESSION['user']['facebook'] = $facebook;
                $_SESSION['user']['updated_at'] = date('d-m-Y H:i:s');

                $is_modify = $user_model->modify($id);
                if($is_modify) {
                    $_SESSION['success'] = 'Cập nhật thành công';
                } else {
                    $_SESSION['error'] = 'Cập nhật thất bại';
                }
                header('Location: index.php?controller=user&action=profile');
                exit();
            }
        }

        $this->content = $this->render('views/users/modify.php', [
            'profile' => $profile
        ]);
        require_once 'views/layouts/main.php';
    }
}