<?php
//controllers/CartController.php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';

class CartController extends Controller
{
    // Thêm sp vào giỏ hàng từ ajax
    public function add() {
        $product_id = $_GET['product_id'];
        // Gọi model để lấy sp theo id
        $product_model = new Product();
        $product = $product_model->getById($product_id);

        // Tạo mảng chứa các thông tin sp sẽ lưu trong
        //giỏ
        $product_cart = [
            'title' => $product['title'],
            'price' => $product['price'],
            'avatar' => $product['avatar'],
            // Số lượng sp mặc định trong giỏ
            'quantity' => 1
        ];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'][$product_id] = $product_cart;
        }
        else {
            // TH1: SP đang thêm đã tồn tại trong giỏ
            if (array_key_exists
            ($product_id, $_SESSION['cart'])) {
                // TĂng số lượng sp hiện tại lên 1
                $_SESSION['cart'][$product_id]['quantity']++;
            }
            // TH2: SP đang thêm chưa tồn tại trong giỏ
            else {
                $_SESSION['cart'][$product_id] = $product_cart;
            }
        }

    }

    //Giỏ hàng của bạn
    public function index() {

        // Xử lý submit form, cập nhật giỏ hàng
        // + Xử lý submit
        if (isset($_POST['submit'])) {
            // Xử lý với trường hợp số lượng là số âm
            foreach ($_POST AS $product_id => $quantity) {
                if ($quantity < 0) {
                    $_SESSION['error'] = 'Số lượng phải > 0';
                    header('Location: index.php?controller=cart&action=index');
                    exit();
                }
            }

            // Debug mảng giỏ hàng
            // Lặp giỏ hàng, gán lại số lượng của sp
            //bằng số lượng gửi lên từ form, dựa theo
            //product_id
            foreach ($_SESSION['cart'] AS $product_id => $cart){
                // Update lại số lượng tương ứng
                $_SESSION['cart'][$product_id]['quantity']  = $_POST[$product_id];
            }
            $_SESSION['success'] = 'Cập nhật giỏ thành công';
        }

        // Gọi layout để hiển thị view
        $this->content =
            $this->render('views/carts/index.php');
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        // Xóa sản phẩm khỏi giỏ
        $product_id = $_GET['id'];
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['success'] = 'Xóa sản phẩm thành công';
        header('Location: index.php?controller=cart&action=index');
        exit();
    }
}