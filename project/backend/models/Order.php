<?php
require_once 'models/Model.php';
class Order extends Model {
    public $id;
    public $user_id;
    public $fullname;
    public $address;
    public $mobile;
    public $email;
    public $note;
    public $price_total;
    public $payment_status;
    public $created_at;
    public $updated_at;

    public function countTotal() {
        $obj_select = $this->connection->prepare("SELECT COUNT(id) FROM orders");
        $obj_select->execute();

        return $obj_select->fetchColumn();
    }

    public function getAllPagination($params) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;

        $obj_select = $this->connection->prepare("SELECT orders.* FROM orders
                                                           ORDER BY updated_at DESC, created_at DESC 
                                                           LIMIT $start, $limit");
        $obj_select->execute();
        $orders = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $orders;
    }

    public  function getById($id) {
        $obj_selected_id = $this->connection->prepare("SELECT order_details.* FROM order_details INNER JOIN orders
                                                                ON order_details.order_id = orders.id
                                                                WHERE order_details.order_id = $id");
        $obj_selected_id->execute();
        $products = $obj_selected_id->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}