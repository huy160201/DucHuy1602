<?php
require_once 'controllers/Controller.php';
require_once 'models/Order.php';
require_once 'models/Pagination.php';

class OrderController extends Controller {
    public function index() {
        $order_model = new Order();

        $coun_total = $order_model->countTotal();

        $params = [
            'total' => $coun_total,
            'limit' => 8,
            'controller' => 'order',
            'action' => 'index',
            'full_mode' => FALSE,
            'page' => isset($_GET['page']) ? $_GET['page'] : 1
        ];

        $orders = $order_model->getAllPagination($params);

        $pagination = new Pagination($params);
        $pages = $pagination->getPagination();

        $this->content = $this->render('views/orders/index.php', [
           'orders' => $orders,
           'pages' => $pages
        ]);

        require_once 'views/layouts/main.php';
    }

    public function detail()
    {
        if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "Id không hợp lệ";
            header('Location: index.php?controller=order');
            exit();
        }
        $id = $_GET['id'];
        $detail_model = new Order();
        $detail = $detail_model->getById($id);

        $this->content = $this->render('views/orders/detail.php', [
            'detail' => $detail
        ]);

        require_once 'views/layouts/main.php';
    }
}