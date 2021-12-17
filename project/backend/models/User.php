<?php
require_once 'models/Model.php';
class User extends Model {
    public function isExistsUsername($username) {
        $obj_select_one = $this->connection->prepare("SELECT * FROM users WHERE username = :username");
        $obj_select_one->execute($selects = ['username' => $username]);
        $user = $obj_select_one->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {
            return TRUE;
        }
        return FALSE;
    }

    public function Register($username, $password) {
        $obj_insert = $this->connection->prepare("INSERT INTO users(username, password) VALUES (:username, :password)");
        $is_insert = $obj_insert->execute($inserts = ['username' => $username, 'password' => $password]);
        return $is_insert;
    }

    public function getUser($username, $password) {
        $obj_select_one = $this->connection->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $obj_select_one->execute($selects = ['username' => $username, 'password' => $password]);
        return $obj_select_one->fetch(PDO::FETCH_ASSOC);
    }

    public  function timeLogin($username, $last_login) {
        $obj_update = $this->connection->prepare("UPDATE users SET last_login = :last_login
                                                           WHERE username = '$username'");
        return $obj_update->execute([':last_login' => $last_login]);
    }
}