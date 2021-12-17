<?php
class Controller {
    public function __construct() {
        if (!isset($_SESSION['user']) && $_GET['controller'] != 'user' && !in_array($_GET['action'], ['login', 'register', 'logout'])) {
            $_SESSION['error'] = 'Bạn chưa đăng nhập';
            header('Location: index.php?controller=user&action=login');
            exit();
        }
    }

    public $error;
    public $content;
    public $page_title;

    public function render($file_path, $variable = []) {
        extract($variable);
        ob_start();
        require "$file_path";
        return ob_get_clean();
    }
}