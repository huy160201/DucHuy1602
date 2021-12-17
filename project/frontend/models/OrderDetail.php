<?php
require_once 'models/Model.php';
class OrderDetail extends Model {
    public $order_id;
    public $product_name;
    public $product_price;
    public $quantity;

    public function insert() {
        // + viết truy vấn:
        $obj_insert = $this->connection->prepare("INSERT INTO order_details(order_id, product_name, product_price, quantity) VALUES(:order_id, :product_name, :product_price, :quantity)");
        $inserts = [
            ':order_id' => $this->order_id,
            ':product_name' => $this->product_name,
            ':product_price' => $this->product_price,
            ':quantity' => $this->quantity
        ];
        $is_insert = $obj_insert->execute($inserts);
        return $is_insert;
    }
}