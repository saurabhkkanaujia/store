<?php
    class Products
    {
        public function fetchProducts($query)
        {
            $sql = "SELECT * FROM products ".$query;

            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();  
        }
        public function addProduct($name, $category, $price){
            $checkProd = new Validation();
            $checkRes = $checkProd->checkProduct($name, $category, $price);
            if($checkRes == true && !($checkProd->prodAlreadyExists($name))){
                $sql = "INSERT INTO products (name, category, price)
                        VALUES ('".$name."', '".$category."', ".$price." )";
                DB::getInstance()->exec($sql);
                $_SESSION['error'] = 0;
            }
        }
        public function updateProduct($id, $name, $category, $price){
            $sql = "UPDATE products SET name = '".$name."', category = '".$category."', price = ".$price." WHERE id = ".$id." ";
            DB::getInstance()->exec($sql);
        }
    }