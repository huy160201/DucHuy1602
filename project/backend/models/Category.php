<?php
require_once 'models/Model.php';
class Category extends Model {
    public $id;
    public $name;
    public $avatar;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;

    public function getAll($params = []) {
        $str_search = 'WHERE TRUE';
        //check mảng param truyền vào để thay đổi lại chuỗi search
        if (isset($params['name']) && !empty($params['name'])) {
            $name = $params['name'];
            //nhớ phải có dấu cách ở đầu chuỗi
            $str_search .= " AND `name` LIKE '%$name%'";
        }
        if (isset($params['status'])) {
            $status = $params['status'];
            $str_search .= " AND `status` = $status";
        }

        $obj_select_all = $this->connection->prepare("SELECT * FROM categories $str_search");
        $obj_select_all->execute();
        $categories = $obj_select_all
            ->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function getById($id) {
        $obj_select_one = $this->connection->prepare("SELECT * FROM categories WHERE id = $id");
        $obj_select_one->execute();
        $category = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        return $category;
    }

    public function insert() {
        $sql_insert = "INSERT INTO categories(`name`, `avatar`, `description`, `status`) VALUES (:name, :avatar, :description, :status)";
        $obj_insert = $this->connection->prepare($sql_insert);
        $arr_insert = [
            ':name' => $this->name,
            ':avatar' => $this->avatar,
            ':description' => $this->description,
            ':status' => $this->status
        ];
        return $obj_insert->execute($arr_insert);
    }

    public function update($id) {
        $sql_update = "UPDATE categories SET `name` = :name, `avatar` = :avatar, description = :description, `status` = :status WHERE id = $id";
        $obj_update = $this->connection->prepare($sql_update);
        $arr_update = [
            ':name' => $this->name,
            ':avatar' => $this->avatar,
            ':description' => $this->description,
            ':status' => $this->status
        ];
        return $obj_update->execute($arr_update);
    }

    public function delete($id) {
        $sql_delete = "DELETE FROM categories WHERE id = $id";
        $obj_delete = $this->connection->prepare($sql_delete);
        $is_delete = $obj_delete->execute();
        // xóa product tương ứng
        $obj_delete_product = $this->connection->prepare("DELETE FROM products WHERE category_id = $id");
        $obj_delete_product->execute();
        return $is_delete;
    }

    public function getCategoryById($id) {
        $obj_select = $this->connection->prepare("SELECT * FROM categories WHERE id = $id");
        $obj_select->execute();
        $category = $obj_select->fetch(PDO::FETCH_ASSOC);
        return $category;
    }

    public function countTotal() {
        $obj_select = $this->connection->prepare("SELECT COUNT(id) FROM categories");
        $obj_select->execute();

        return $obj_select->fetchColumn();
    }

    public function getAllPagination($params = []) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;

        $str_where = 'WHERE TRUE';
        if (isset($params['name'])) {
            $name = $params['name'];
            $str_where .= " AND name LIKE '%$name%'";
        }

        $obj_select = $this->connection->prepare("SELECT * FROM categories $str_where ORDER BY created_at DESC LIMIT $start, $limit");

        $obj_select->bindParam(':limit', $limit, PDO::PARAM_INT);
        $obj_select->bindParam(':start', $start,PDO::PARAM_INT);

        $obj_select->execute();
        return $categories = $obj_select->fetchAll(PDO::FETCH_ASSOC);

    }


}