<?php
require_once 'controllers/Controller.php';
require_once 'models/Product.php';
require_once 'models/Category.php';
require_once 'models/Pagination.php';

class ProductController extends Controller {
    public function index() {
        $product_model = new Product();

        $count_total = $product_model->countTotal();

        $query_additional = '';
        if (isset($_GET['title'])) {
            $query_additional .= '&title=' . $_GET['title'];
        }
        if (isset($_GET['category_id'])) {
            $query_additional .= '&category_id=' . $_GET['category_id'];
        }

        $params = [
            'total' => $count_total,
            'limit' => 5,
            'query_string' => 'page',
            'controller' => 'product',
            'action' => 'index',
            'full_mode' => FALSE,
            'query_additional' => $query_additional,
            'page' => isset($_GET['page']) ? $_GET['page'] : 1
        ];

        $products = $product_model->getAllPagination($params);

        $pagination = new Pagination($params);

        $pages = $pagination->getPagination();

        $category_model = new Category();
        $categories = $category_model->getAll($params);

        $this->content = $this->render('views/products/index.php', [
            'products' => $products,
            'categories' => $categories,
            'pages' => $pages
        ]);

        require_once 'views/layouts/main.php';
    }

    public function create() {
        if (isset($_POST['submit'])) {
            $category_id = $_POST['category_id'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $amount = $_POST['amount'];
            $summary = $_POST['summary'];
            $content = $_POST['content'];
            $seo_title = $_POST['seo_title'];
            $seo_description = $_POST['seo_description'];
            $seo_keywords = $_POST['seo_keywords'];
            $status = $_POST['status'];
            $avatar = $_FILES['avatar'];

            if (empty($title)) {
                $this->error = 'Không được để trống title';
            } elseif ($avatar['error'] == 0) {
                $extension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $arr_extension = ['jpg', 'jpeg', 'png', 'gif'];

                $file_size_mb = $avatar['size'] / 1024 / 1024;
                $file_size_mb = round($file_size, 2);

                if (!in_array($extension, $arr_extension)) {
                    $this->error = 'Vui lòng upload file ảnh';
                } elseif ($file_size_mb > 2) {
                    $this->error = 'Vui lòng upload file ảnh có kích thước nhỏ hơn 2MB';
                }
            }

            if (empty($this->error)) {
                $file_name = '';
                if ($avatar['error'] == 0) {
                    $dir_upload = 'assets/uploads';
                    if (!file_exists($dir_upload)) {
                        mkdir($dir_upload);
                    }
                    $file_name = time() . '-product-' . $avatar['name'];
                    move_uploaded_file($avatar['tmp_name'], $dir_upload . '/' . $file_name);
                }
                $product_model = new Product();
                $product_model->category_id = $category_id;
                $product_model->title = $title;
                $product_model->avatar = $file_name;
                $product_model->price = $price;
                $product_model->amount = $amount;
                $product_model->summary = $summary;
                $product_model->content = $content;
                $product_model->seo_title = $seo_title;
                $product_model->seo_description = $seo_description;
                $product_model->seo_keywords = $seo_keywords;
                $product_model->status = $status;
                $is_insert = $product_model->insert();
                if ($is_insert) {
                    $_SESSION['success'] = 'Thêm mới sản phẩm thành công';
                } else {
                    $_SESSION['error'] = 'Thêm mới thất bại';
                }
                header('Location: index.php?controller=product');
                exit();
            }
        }

        $category_model = new Category();
        $categories = $category_model->getAll();

        $this->content = $this->render('views/products/create.php', [
            'categories' => $categories
        ]);
        require_once 'views/layouts/main.php';
    }

    public function detail() {
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

    public function update() {
        if (!is_numeric($_GET['id']) || !isset($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=product');
            exit();
        }
        $id = $_GET['id'];

        $product_model = new Product();
        $product = $product_model->getById($id);

        if (isset($_POST['submit'])) {
            $category_id = $_POST['category_id'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $amount = $_POST['amount'];
            $summary = $_POST['summary'];
            $content = $_POST['content'];
            $seo_title = $_POST['seo_title'];
            $seo_description = $_POST['seo_description'];
            $seo_keywords = $_POST['seo_keywords'];
            $status = $_POST['status'];
            $avatar = $_FILES['avatar'];

            if (empty($title)) {
                $this->error = 'Không được để trống Title';
            } elseif ($avatar['error'] == 0) {
                $extension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $arr_extension = ['jpg', 'jpeg', 'png', 'gif'];
                $size_mb = $avatar['size'] / 1024 / 1024;
                $size_mb = round($size_mb, 2);

                if (!in_array($extension, $arr_extension)) {
                    $this->error = 'File upload phải là ảnh';
                } elseif ($size_mb > 2) {
                    $this->error = 'File ảnh phải nhỏ hơn 2MB';
                }
            }

            if (empty($this->error)) {
                $filename = $product['avatar'];
                if ($avatar['error'] == 0) {
                    $dir_upload = 'assets/uploads';
                    @unlink($dir_upload . '/' . $filename);
                    if (!file_exists($dir_upload)) {
                        mkdir($dir_upload);
                    }
                    $filename = time() . '-product-' . $avatar['name'];
                    move_uploaded_file($avatar['tmp_name'], $dir_upload . '/' . $filename);
                }

                $product_model->category_id = $category_id;
                $product_model->title = $title;
                $product_model->avatar = $filename;
                $product_model->price = $price;
                $product_model->amount = $amount;
                $product_model->summary = $summary;
                $product_model->content = $content;
                $product_model->seo_title = $seo_title;
                $product_model->seo_description = $seo_description;
                $product_model->seo_keywords = $seo_keywords;
                $product_model->status = $status;
                $product_model->updated_at = date('Y-m-d H:i:s');

                $is_update = $product_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = 'Cập nhật thành công';
                } else {
                    $_SESSION['error'] = 'Cập nhật thất bại';
                }
                header('Location: index.php?controller=product');
                exit();
            }
        }

        $category_model = new Category();
        $categories = $category_model->getAll();

        $this->content = $this->render('views/products/update.php', [
            'categories' => $categories,
            'product' => $product
        ]);
        require_once 'views/layouts/main.php';
    }

    public function delete() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID không hợp lệ';
            header('Location: index.php?controller=product');
            exit();
        }

        $id = $_GET['id'];
        $product_model = new Product();
        $is_delete = $product_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa sản phẩm thành công';
        } else {
            $_SESSION['error'] = 'Xóa sản phẩm thất bại';
        }
        header('Location: index.php?controller=product');
        exit();
    }
}