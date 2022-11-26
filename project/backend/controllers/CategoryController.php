<?php
require_once  'controllers/Controller.php';
require_once  'models/Category.php';
require_once  'models/Pagination.php';

class CategoryController extends Controller {
    public function index() {
        $category_model = new Category();
        $params = [
          'limit' => 5,
          'query_string' => 'page',
          'controller' => 'category',
          'action' => 'index',
          'full_mode' => FALSE
        ];

        $page = 1;
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        if (isset($_GET['name']) && isset($_GET['submit'])) {
            $params['query_additional'] = '&name=' . $_GET['name'];
        }
        $count_total = $category_model->countTotal();
        $params['total'] = $count_total;
        if (isset($_GET['name'])) {
            $params['name'] = $_GET['name'];
        }
        $params['page'] = $page;
        $pagination = new Pagination($params);

        $pages = $pagination->getPagination();

        $categories = $category_model->getAllPagination($params);

        $this->content = $this->render('views/categories/index.php', [
            'categories' => $categories,
            'pages' => $pages,
        ]);

        require_once 'views/layouts/main.php';
    }

    public function create() {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $avatar_files = $_FILES['avatar'];

            if(empty($name)) {
                $this->error = 'Vui lòng nhập tên';
            } elseif ($avatar_files == 0) {
                $extension_arr = ['jpg', 'jpeg', 'gif', 'png'];
                $extension = pathinfo($avatar_files['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $file_size_mb = $avatar_files['size'] / 1024 / 1024;
                $file_size_mb = round($file_size_mb, 2);

                if (!in_array($extension, $extension_arr)) {
                    $this->error = 'Cần upload file ảnh';
                } elseif ($file_size_mb > 2) {
                    $this->error = 'File ảnh phải nhỏ hơn 2MB';
                }
            }

            $avatar = '';
            if (empty($this->error)) {
                if ($avatar_files['error'] == 0) {
                    $dir_uploads = 'assets/uploads';
                    if (!file_exists($dir_uploads)) {
                        mkdir($dir_uploads);
                    }
                    $avatar .= time() . '-' . $avatar_files['name'];
                    move_uploaded_file($avatar_files['tmp_name'], $dir_uploads . '/' . $avatar);
                }

                $category_model = new Category();
                $category_model->name = $name;
                $category_model->avatar = $avatar;
                $category_model->description = $description;
                $category_model->status = $status;

                $is_insert = $category_model->insert();
                if($is_insert) {
                    $_SESSION['success'] = "Thêm mới thành công";
                } else {
                    $_SESSION['error'] = "Thêm mới thất bại";
                }
                header('Location: index.php?controller=category&action=index');
                exit();
            }
        }
        $this->content = $this->render('views/categories/create.php');
        require_once 'views/layouts/main.php';
    }

    public function update() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID category không hợp lệ";
            header('Location: index.php?controller=category&action=index');
            exit();
        }

        $id = $_GET['id'];
        $category_model = new Category();
        $category = $category_model->getCategoryById($id);

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $avatar_files = $_FILES['avatar'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            if (empty($name)) {
                $this->error = 'Vui lòng nhập tên';
            } elseif ($avatar_files['error'] == 0) {
                $extension_arr = ['jpg', 'jpeg', 'gif', 'png'];
                $extension = pathinfo($avatar_files['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                $files_avatar_mb = $avatar_files['size'] / 1024 / 1024;
                if (!in_array($extension, $extension_arr)) {
                    $this->error = "Vui lòng nhập file ảnh";
                } elseif ($files_avatar_mb > 2) {
                    $this->error = "File ảnh phải nhỏ hơn 2MB";
                }
            }

            $avatar = $category['avatar'];
            if (empty($this->error)) {
                if ($avatar_files['error'] == 0) {
                    $dir_uploads = 'assets/uploads';
                    if (!file_exists($dir_uploads)) {
                        mkdir($dir_uploads);
                    }
                    unlink("$dir_uploads . '/' . $avatar");

                    $avatar = time() . '-' . $avatar_files['name'];

                    move_uploaded_file($avatar_files['tmp_name'], $dir_uploads . '/' . $avatar);
                }

                $category_model = new Category();

                $category_model->name = $name;
                $category_model->avatar = $avatar;
                $category_model->description = $description;
                $category_model->status = $status;

                $is_update = $category_model->update($id);
                if ($is_update) {
                    $_SESSION['success'] = "Cập nhật Category thành công";
                } else {
                    $_SESSION['error'] = "Cập nhật Category thất bại";
                }
                header('Location: index.php?controller=category&action=index');
                exit();
            }
        }

        $this->content = $this->render('views/categories/update.php', ['category' => $category]);
        require_once "views/layouts/main.php";
    }

    public function delete() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID Category không hợp lệ";
            header('Location: index.php?controller=category&action=index');
            exit();
        }

        $id = $_GET['id'];
        $category_model = new Category();
        $is_delete = $category_model->delete($id);
        if ($is_delete) {
            $_SESSION['success'] = 'Xóa Category thành công';
        } else {
            $_SESSION['error'] = 'Xóa Category thất bại';
        }

        header('Location: index.php?controller=category&action=index');
        exit();
    }

    public function detail() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = 'ID Category không hợp lệ';
            header('Location: index.php?controller=category&action=index');
            exit();
        }

        $id = $_GET['id'];
        $category_model = new Category();
        $category = $category_model->getCategoryById($id);

        $this->content = $this->render('views/categories/detail.php', ['category' => $category]);
        require_once "views/layouts/main.php";
    }
}