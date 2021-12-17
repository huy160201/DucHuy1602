<?php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';
require_once 'models/Category.php';
require_once 'models/Pagination.php';
class ProductController extends Controller
{
    public function index()
    {
        $product_model = new Product();
        //lấy tổng số bản ghi đang có trong bảng products
        $count_total = $product_model->countTotal();
        //        xử lý phân trang

        $arr_params = [
            'total' => $count_total,
            'limit' => 8,
            'query_string' => 'page',
            'controller' => 'product',
            'action' => 'index',
            'full_mode' => FALSE,
            'page' => isset($_GET['page']) ? $_GET['page'] : 1
        ];

        $products = $product_model->getAllPagination($arr_params);
        $pagination = new Pagination($arr_params);

        $pages = $pagination->getPagination();

        //lấy danh sách category đang có trên hệ thống để phục vụ cho search
        $category_model = new Category();
        $categories = $category_model->getAll();

        $this->content = $this->render('views/homes/index.php', [
            'products' => $products,
            'categories' => $categories,
            'pages' => $pages,
        ]);
        require_once 'views/layouts/main.php';
    }

    public function detail()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=product');
            exit();
        }

        $id = $_GET['id'];
        $product_model = new Product();
        $product = $product_model->getById($id);

        $this->content = $this->render('views/products/detail.php', [
            'product' => $product
        ]);
        require_once 'views/layouts/main.php';
    }
}