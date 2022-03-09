<?php

use App\Admin;
use App\Cart;
use App\Login;
use App\Order;
use App\Products;
use App\User;
use App\Validation;

session_start();
include('config.php');

require ("vendor/autoload.php");
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
            $path = $_SESSION['path'];
            if ($path == 'frontend/single-product.php') {
                $path = "frontend/single-product.php?id=" . $_POST['prodID'] . "";
            }
            $quan = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

            addToCart($_POST['prodID'], $quan);
            header("Location: " . $path . "");
            break;
        case "upload":
            $fileName = $_FILES['imgToUpload']['tmp_name'];
            $destination = 'uploads/' . basename($_FILES['imgToUpload']['name']);
            $imgFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));

            break;
    }
}

function totalSum($productArr)
{
    $sum = 0;
    foreach ($productArr as $key => $value) {
        $sum += $value[1] * $value[0]['price'];
    }
    return $sum;
}

if (isset($_POST['placeOrder'])) {
    $billing_country = $_POST['billing_country'];
    $billing_first_name = $_POST['billing_first_name'];
    $billing_last_name = $_POST['billing_last_name'];
    $billing_address_1 = $_POST['billing_address_1'];
    $billing_address_2 = $_POST['billing_address_2'];
    $billing_postcode = $_POST['billing_postcode'];
    $billing_state = $_POST['billing_state'];
    $billing_email = $_POST['billing_email'];
    $payment_method = $_POST['payment_method'];
    $billing_phone = $_POST['billing_phone'];
    $cardName = $_POST['cardName'];
    $cardNumber = $_POST['cardNumber'];
    $cardExpiry = $_POST['cardExpiry'];
    $cvv = $_POST['cvv'];

    $orderObj = new Order(
        $billing_country,
        $billing_first_name,
        $billing_last_name,
        $billing_address_1,
        $billing_address_2,
        $billing_postcode,
        $billing_state,
        $billing_email,
        $payment_method,
        $billing_phone,
        $cardName,
        $cardNumber,
        $cardExpiry,
        $cvv
    );
    
    $orderObj->placeOrder();
    
    header("Location: frontend/checkout.php");
}
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePassword = $_POST['re_password'];
    if ($password == $rePassword) {
        $user = new User($username, $fullName, $email, $password, $rePassword, 'customer', 'Not Approved');
        $user->addUser();
        if ($_SESSION['check'] == 0) {
            $_SESSION['msg'] = "You have successfully Signed Up";
            header("Location: admin/login.php");
        } elseif ($_SESSION['check'] == 1) {
            $_SESSION['msg'] = "Invalid Credentials";
            header("Location: admin/signup.php");
        } else {
            header("Location: admin/signup.php");
        }
    } else {
        $_SESSION['msg'] = "Password and Confirm Password Do Not Match";
        header("Location: admin/signup.php");
    }
}

if (isset($_POST['signin'])) {
    $_SESSION['user'] = [];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = new Login($email, $password);
    $userData = $user->authenticate();

    if (count($userData) >= 1) {
        if ($userData[0]['status'] == 'admin' || $userData[0]['status'] == 'Approved') {
            $_SESSION['user'] = $userData[0];
            $_SESSION['msg'] = '';
            if (!isset($_SESSION['loginRedirect'])) {
                header("Location: dashboard.php");
            } else {
                header("Location: ".$_SESSION['loginRedirect']."");
            }
        } else {
            $_SESSION['msg'] = 'You have Not been Approved';
            header("Location: admin/login.php");
        }
    } else {
        $_SESSION['msg'] = "Invalid Login Credentials";
        header("Location: admin/login.php");
    }
}

if (isset($_POST['approve'])) {
    $status = new Admin();
    $status->changeStatus($_POST['approve'], 'approve');
    header("Location: customers.php");
}
if (isset($_POST['restrict'])) {
    $status = new Admin();
    $status->changeStatus($_POST['restrict'], 'restrict');
    header("Location: customers.php");
}
if (isset($_POST['deleteUser'])) {
    $del = new Admin();
    $del->delete($_POST['deleteUser'], 'users');
    header("Location: customers.php");
}
if (isset($_POST['deleteProd'])) {
    $status = new Admin();
    $status->delete($_POST['deleteProd'], 'products');
    header("Location: products.php");
}

if (isset($_POST['add'])) {
    // For Image Upload
    if (strlen($_FILES['imgToUpload']['name']) != 0) {
        $imgName = $_FILES['imgToUpload']['name'];
        $fileName = $_FILES['imgToUpload']['tmp_name'];
        $destination = './uploads/' . basename($_FILES['imgToUpload']['name']);
        $imgFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));
        // Image Upload End

        $prod = new Products();
        $prod->addProduct($_POST['name'], $_POST['category'], $_POST['price'], $fileName, $destination, $imgName);
        if ($_SESSION['error'] == 1) {
            header("Location: add-product.php");
        } elseif ($_SESSION['error'] == 0) {
            $_SESSION['prodArr'] = [];
            $_SESSION['prodMsg'] = "Product Added Successfully";
            header("Location: products.php");
        }
    } else {
        $_SESSION['prodMsg'] = "Please Upload Image";
        header("Location: add-product.php");
    }
}

if (isset($_POST['addUser'])) {
    $username = $_POST['username'];
    $fullName = $_POST['name'];
    $email = $_POST['email'];
    $password = "null";
    $rePassword = "null";
    $role = $_POST['role'];
    $status = $_POST['status'];

    $user = new User($username, $fullName, $email, $password, $rePassword, $role, $status);
    $user->addUser();
    if ($_SESSION['check'] == 0) {
        $_SESSION['msg'] = "User Added Successfully";
        header("Location: customers.php");
    } elseif ($_SESSION['check'] == 1) {
        $_SESSION['msg'] = "Invalid Input";
        header("Location: add-user.php");
    } else {
        header("Location: add-user.php");
    }
}

if (isset($_POST['signOut'])) {
    session_destroy();
    header("Location: admin/login.php");
}

if (isset($_POST['updateProduct'])) {
    $check = new Validation();
    if ($check->checkProduct($_POST['name'], $_POST['category'], $_POST['price'])) {
        $updateProd = new Products();
        $updateProd->updateProduct($_POST['updateProduct'], $_POST['name'], $_POST['category'], $_POST['price']);
        $_SESSION['prodArr'] = [];
        header("Location: products.php");
        $_SESSION['prodMsg'] = "Product Updated Successfully";
    } else {
        $_SESSION['prodMsg'] = "Invalid Input";
        header("Location: edit-product.php?id=" . $_POST['updateProduct']);
    }
}

if (isset($_POST['pending'])) {
    $status = new Admin();
    $status->changeOrderStatus($_POST['pending'], 'pending');
    header("Location: orders.php");
}
if (isset($_POST['delivered'] )) {
    $status = new Admin();
    $status->changeOrderStatus($_POST['delivered'], 'delivered');
    header("Location: orders.php");
}
