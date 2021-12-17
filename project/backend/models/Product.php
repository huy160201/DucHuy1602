<?php
require_once 'models/Model.php';
class Product extends Model {
    public $id;
    public $category_id;
    public $title;
    public $avatar;
    public $price;
    public $amount;
    public $summary;
    public $content;
    public $seo_title;
    public $seo_description;
    public $seo_keywords;
    public $status;
    public $created_at;
    public $updated_at;

    public $str_search = '';

    public function __construct(){
        parent::__construct();
        if (isset($_GET['title']) && !empty($_GET['title'])) {
            $this->str_search .= " AND products.title LIKE '%{$_GET['title']}%'";
        }
        if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
            $this->str_search .= " AND products.category_id = {$_GET['category_id']}";
        }
    }

    public function countTotal() {
        $obj_select = $this->connection->prepare("SELECT COUNT(id) FROM products WHERE TRUE $this->str_search");
        $obj_select->execute();

        return $obj_select->fetchColumn();
    }

    public function getAllPagination($params) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;
        $obj_select = $this->connection
            ->prepare("SELECT products.*, categories.name AS category_name FROM products
                                INNER JOIN categories ON products.category_id = categories.id
                                WHERE TRUE $this->str_search
                                ORDER BY products.updated_at DESC, products.created_at DESC 
                                LIMIT $start, $limit");

        $obj_select->execute();
        $products = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    public function insert() {
        $obj_insert = $this->connection->prepare("INSERT INTO products(`category_id`, `title`, `avatar`, `price`, `amount`, `summary`, `content`, `seo_title`, `seo_description`, `seo_keywords`, `status`)
                                                           VALUES (:category_id, :title, :avatar, :price, :amount, :summary, :content, :seo_title, :seo_description, :seo_keywords, :status)");
        $arr_insert = [
            ':category_id' => $this->category_id,
            ':title' => $this->title,
            ':avatar' => $this->avatar,
            ':price' => $this->price,
            ':amount' => $this->amount,
            ':summary' => $this->summary,
            ':content' => $this->content,
            ':seo_title' => $this->seo_title,
            ':seo_description' => $this->seo_description,
            ':seo_keywords' => $this->seo_keywords,
            ':status' => $this->status
        ];
        return $obj_insert->execute($arr_insert);
    }

    public function getAll() {
        $obj_select_all = $this->connection->prepare("SELECT products.*, categories.name AS category_name FROM products
                                                              INNER JOIN categories
                                                              ON products.category_id = categories.id
                                                              WHERE TRUE $this->str_search
                                                              ORDER BY products.created_at");
        $arr_select = [];
        $obj_select_all->execute($arr_select);
        return $obj_select_all->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $obj_select_one = $this->connection->prepare("SELECT products.*, categories.name AS category_name
                                                               FROM products INNER JOIN categories ON products.category_id = categories.id
                                                               WHERE products.id = $id");
        $obj_select_one->execute();
        return $obj_select_one->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $obj_update = $this->connection->prepare("UPDATE products SET category_id=:category_id, title=:title, avatar=:avatar, price=:price, amount=:amount, summary=:summary, content=:content, seo_title=:seo_title, seo_description=:seo_description, seo_keywords=:seo_keywords, status=:status, updated_at=:updated_at
                                                          WHERE id = $id");
        $arr_update = [
            ':category_id' => $this->category_id,
            ':title' => $this->title,
            ':avatar' => $this->avatar,
            ':price' => $this->price,
            ':amount' => $this->amount,
            ':summary' => $this->summary,
            ':content' => $this->content,
            ':seo_title' => $this->seo_title,
            ':seo_description' => $this->seo_description,
            ':seo_keywords' => $this->seo_keywords,
            ':status' => $this->status,
            ':updated_at' => $this->updated_at
        ];
        return $obj_update->execute($arr_update);
    }

    public function delete($id) {
        $obj_delete = $this->connection->prepare("DELETE FROM products WHERE id = $id");
        return $obj_delete->execute();
    }
}