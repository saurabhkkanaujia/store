<?php

namespace App;

use PDO;

class Validation
{
    public function check($username, $name, $email, $password, $rePassword, $role)
    {
        if (strlen($username) != 0 && strlen($name) != 0 && strlen($email) != 0
        && strlen($password) != 0 && strlen($rePassword) != 0 && strlen($role) != 0) {
            $_SESSION['check'] = 0;
            return true;
        } else {
            $_SESSION['check'] = 1;
            return false;
        }
    }
    public function alreadyExists($email)
    {
        $sql = "SELECT email FROM users WHERE email = '" . $email . "'";

        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if (count($stmt->fetchAll()) >= 1) {
            $_SESSION['msg'] = "Email Id Already Exists";
            $_SESSION['check'] = -1;
            return true;
        } else {
            return false;
        }
    }
    public function prodAlreadyExists($name)
    {
        $sql = "SELECT name FROM products WHERE name = '" . $name . "'";

        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        if (count($stmt->fetchAll()) >= 1) {
            $_SESSION['msg'] = "Product Already Exists";
            $_SESSION['check'] = -1;
            return true;
        } else {
            return false;
        }
    }
    public function checkProduct($name, $category, $price)
    {
        if (strlen($name) != 0 && strlen($category) != 0 && strlen($price) != 0) {
            $_SESSION['checkProd'] = 0;
            return true;
        }
    }
}
