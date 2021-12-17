<?php
require_once 'controllers/Controller.php';
require_once 'models/Order.php';
require_once 'models/OrderDetail.php';
require_once 'libraries/PHPMailer/src/PHPMailer.php';
require_once 'libraries/PHPMailer/src/SMTP.php';
require_once 'libraries/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PaymentController extends Controller {
    public function index() {
        if (isset($_POST['submit'])) {
            // tạo biến
            $fullname = $_POST['fullname'];
            $address = $_POST['address'];
            $mobile = $_POST['mobile'];
            $email = $_POST['email'];
            $note = $_POST['note'];
            $method = $_POST['method'];
            // - validate
            // - xử lý logic thanh toán chỉ khi k có lỗi xảy ra
            if (empty($this->error)) {
                $order_model = new Order();
                // do cần lưu tiếp vào bảng order_details, nên cần trả về id của order vừa insert
                // + gán giá trị form cho thuộc tính model
                $order_model->fullname = $fullname;
                $order_model->address = $address;
                $order_model->mobile = $mobile;
                $order_model->email = $email;
                $order_model->note = $note;
                // + tính tổng giá trị đơn hàng từ giỏ hàng
                $price_total = 0;

                foreach ($_SESSION['cart'] AS $cart) {
                    $price_total += $cart['quantity'] * $cart['price'];
                }
                $order_model->price_total = $price_total;
                // + tính trạng thái đơn hàng, giả sử đơn hàng khi mới đặt ở trạng thái chưa thanh toán
                $order_model->payment_status = 0;

                $order_id = $order_model->insert();

                // - insert tiếp vào order_details
                // 1 orders có thể có nhiều order_details
                $order_detail_model = new OrderDetail();
                foreach ($_SESSION['cart'] AS $cart) {
                    // gán các giá trị cho model
                    $order_detail_model->order_id = $order_id;
                    $order_detail_model->product_name = $cart['title'];
                    $order_detail_model->product_price = $cart['price'];
                    $order_detail_model->quantity = $cart['quantity'];
                    // lưu vào bảng order_details
                    $is_insert = $order_detail_model->insert();

                }
                // - gửi mail cho user vừa đặt hàng
                $mail = new PHPMailer(true);
                // + cần có các thông tin cấu hình để có thể gửi mail

                try {
                    //Server settings
                    // + cấu hình gửi mail có dấu
                    $mail->CharSet = 'UTF-8';
                    // + bật/tắt debug khi gửi mail
                    $mail->SMTPDebug = SMTP::DEBUG_OFF;
                    $mail->isSMTP();
                    // Server của gmail
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    // Username chính là tên đăng nhập gmail của bạn
                    $mail->Username   = 'duc4422@gmail.com';
                    // k phải là mk gmail, là mật khẩu ứng dụng của gmail
                    $mail->Password   = 'kpxbyvubvlajeppa';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    //Recipients
                    // + email đc gửi từ ai
                    $mail->setFrom('duc4422@gmail.com', 'Duc Huy');
                    // + thêm các email người nhận
                    $mail->addAddress("$email", "$fullname");     // Add a recipient

                    // Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                    // Content
                    $mail->isHTML(true);                              // Set email format to HTML
                    $mail->Subject = 'Thông tin thanh toán đơn hàng';
                    $mail->Body    = $this->render("views/payments/mail_template_order.php", [

                        'fullname' => $fullname,
                        'order_id' => $order_id,
                        'mobile' => $mobile,
                        'email' => $email,
                        'address' => $address
                    ]);
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                // - dựa vào phương thức thanh toán để chuyển hướng cho phù hợp
                // + nếu là thanh toán trực tuyến, chuyển hướng sang Ngân lượng
                // demo: chạy thẳng file: libraries/nganluong/index.php
                if ($method == 0) {
                    // tạo session để lưu tt cần thiết
                    $_SESSION['payment_info'] = [
                        'price_total' => $price_total,
                        'fullname' => $fullname,
                        'mobile' => $mobile,
                        'email' => $email
                    ];
                    header('Location: index.php?controller=payment&action=online');
                    exit();
                }
                // + nếu chọn COD
                else {
                    // chuyển hướng về trang cảm ơn
                    header('Location: index.php?controller=payment&action=thank');
                    exit();
                }
            }
        }


        // - lấy nd view
        $this->content = $this->render('views/payments/index.php');
        // - gọi layout để hiển thị view
        require_once 'views/layouts/main.php';
    }

    public function online() {
        // - lấy nd view
        $this->content = $this->render('libraries/nganluong/index.php');
        // - k gọi layout vì giao diện của trang thanh toán là của bên thứ 3
        echo $this->content;
    }

    public function thank() {
        // tại trang thank, cần xóa tất cả thông tin về giỏ hàng
        unset($_SESSION['cart']);
        $this->content = $this->render('views/payments/thank.php');
        require_once 'views/layouts/main.php';
    }
}