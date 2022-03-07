<?php
session_start();

define("DBHOST", "mysql-server");
define("DBUSER", "root");
define("DBPASS", "secret");
define("DBNAME", "store");


include('classes/Cart.php');

function addToCart($id, $qty)
{
    $cartData = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $cart = new Cart($cartData);
    $cart->addToCart($id, $qty);


    $returnedCart = $cart->getCart();
    $_SESSION['cart'] = $returnedCart;
}

function getProduct($products, $id)
{
    for ($i = 0; $i < count($products); $i++) {
        if ($id == $products[$i]['id']) {
            return $products[$i];
        }
    }
}
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case "addToCart":
            // echo $_POST['prodID'];
            $path= $_SESSION['path'];
            if($path == 'frontend/single-product.php'){
                $path = "frontend/single-product.php?id=".$_POST['prodID']."";
            }
            $quan = isset($_POST['quantity'])?$_POST['quantity']:1;
            addToCart($_POST['prodID'], $quan);
            header("Location: ".$path."");
            break;
    }
}

function totalSum($productArr){
    $sum=0;
    foreach ($productArr as $key => $value){
        $sum+=$value[1]*$value[0]['price'];
    }
    return $sum;
}