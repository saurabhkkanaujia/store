<?php

namespace App;

use PDO;
use App\Validation;

class Products
{
    public function fetchProducts($query)
    {
        $sql = "SELECT * FROM products " . $query;

        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
    public function addProduct($name, $category, $price, $fileName, $destination, $imgName)
    {
        $checkProd = new Validation();
        $checkRes = $checkProd->checkProduct($name, $category, $price);
        if ($checkRes == true && !($checkProd->prodAlreadyExists($name))) {
            move_uploaded_file($fileName, $destination);
            $sql = "INSERT INTO products (name, category, price, imgName)
                VALUES ('" . $name . "', '" . $category . "', " . $price . ", '" . $imgName . "' )";
            DB::getInstance()->exec($sql);
            $_SESSION['error'] = 0;
        }
    }
    public function updateProduct($id, $name, $category, $price)
    {
        $sql = "UPDATE products SET name = '" . $name . "', category = '" . $category . "',
        price = " . $price . " WHERE id = " . $id . " ";
        DB::getInstance()->exec($sql);
    }
}
