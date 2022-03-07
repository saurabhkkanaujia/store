<?php
    session_start();
    include('config.php');
    include('classes/DB.php');
    include('classes/User.php');
    include('classes/Login.php');
    include('classes/Admin.php');
    include('classes/Products.php');
    
    if (isset($_POST['signup'])){
        $username = $_POST['username'];
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rePassword = $_POST['re_password'];
        if($password == $rePassword){
            $user = new User($username, $fullName, $email, $password, $rePassword, 'customer', 'Not Approved');
            $user->addUser();
            if($_SESSION['check']==0){
                $_SESSION['msg'] = "You have successfully Signed Up";
                header("Location: admin/login.php");
            }elseif($_SESSION['check']==1){
                $_SESSION['msg'] = "Invalid Credentials";
                header("Location: admin/signup.php");
            }else{
                header("Location: admin/signup.php");
            }
            
        }else{
            $_SESSION['msg'] = "Password and Confirm Password Do Not Match";
            header("Location: admin/signup.php");
        }
    }

    if (isset($_POST['signin'])){
        $_SESSION['user']=[];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = new Login($email, $password);   
        $userData = $user->authenticate();
        
        if(count($userData)>=1){
            if($userData[0]['status'] == 'admin' || $userData[0]['status'] == 'Approved'){
                $_SESSION['user'] = $userData[0];
                $_SESSION['msg'] = '';
                header("Location: dashboard.php");
            }else{
                $_SESSION['msg'] = 'You have Not been Approved';
                header("Location: admin/login.php");
            }
        
        }else{
            $_SESSION['msg'] = "Invalid Login Credentials";
            header("Location: admin/login.php");
        }
    }

    if (isset($_POST['approve'])){
        $status = new Admin();
        $status->changeStatus($_POST['approve'], 'approve');
        header("Location: customers.php");
    }
    if (isset($_POST['restrict'])){
        $status = new Admin();
        $status->changeStatus($_POST['restrict'], 'restrict');
        header("Location: customers.php");
    }
    if (isset($_POST['deleteUser'])){
        $del = new Admin();
        $del->delete($_POST['deleteUser'], 'users');
        header("Location: customers.php");
    }
    if (isset($_POST['deleteProd'])){
        $status = new Admin();
        $status->delete($_POST['deleteProd'], 'products');
        header("Location: products.php");
    }

    if (isset($_POST['add'])){
        $prod = new Products();
        $prod->addProduct($_POST['name'], $_POST['category'], $_POST['price']);
        if($_SESSION['error'] == 1){
            header("Location: add-product.php");
        }elseif($_SESSION['error'] == 0){
            // $obj = new Admin();
            // $index = $obj->getIndex($_SESSION, 'prodArr');
            // array_splice($_SESSION, $index, 1);
            $_SESSION['prodArr']=[];
            header("Location: products.php");
        }
    }

    if (isset($_POST['addUser'])){
        $username = $_POST['username'];
        $fullName = $_POST['name'];
        $email = $_POST['email'];
        $password = "null";
        $rePassword = "null";
        $role = $_POST['role'];
        $status = $_POST['status'];

        $user = new User($username, $fullName, $email, $password, $rePassword, $role, $status);
        $user->addUser();
        if($_SESSION['check']==0){
            $_SESSION['msg'] = "User Added Successfully";
            header("Location: customers.php");
        }elseif($_SESSION['check']==1){
            $_SESSION['msg'] = "Invalid Input";
            header("Location: add-user.php");
        }else{
            header("Location: add-user.php");
        }
        
    }

    if (isset($_POST['signOut'])){
        session_destroy();
        header("Location: admin/login.php");
    }

    if (isset($_POST['updateProduct'])){
        $check = new Validation();
        if ($check->checkProduct($_POST['name'], $_POST['category'], $_POST['price'])){
            $updateProd = new Products();
            $updateProd->updateProduct($_POST['updateProduct'], $_POST['name'], $_POST['category'], $_POST['price']);
            header("Location: products.php");
            $_SESSION['prodMsg'] = "Product Updated Successfully";
        }else{
            $_SESSION['prodMsg'] = "Invalid Input";
            header("Location: edit-product.php?id=".$_POST['updateProduct']);
        }
        
    }