<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'product';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$controller = ucfirst($controller);
$controller .= "Controller";
$controller_path = "controllers/$controller.php";
if (!file_exists($controller_path)) {
    die('Trang bạn tìm không tồn tại');
}
require_once "$controller_path";
$obj = new $controller();
if (!method_exists($obj, $action)) {
    die("Không tồn tại phương thức $action của class $controller");
}
$obj->$action();
