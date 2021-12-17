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
                    //var_dump($isGetTime);
                    //die();
                    header('Location: index.php?controller=category');
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
}