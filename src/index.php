<?php

    include('config.php');
    include('classes/DB.php');
    include('classes/User.php');

    if (isset($_POST['submit']) && ($_POST['submit']=='signup')){
        $username = $_POST['username'];
        $fullName = $_POST['full_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rePassword = $_POST['re_password'];
        if($password == $rePassword){
            $user = new User($username, $fullName, $email, $password, $rePassword, 'customer', 'Not Approved');
            $user->addUser();
            header("Location: admin/login.php");

        }else{
            $msg = "Password and Confirm Password Do Not Match";
            echo User::error($msg);
            header("Location: admin/signup.php");
        }
        
    }

    if (isset($_POST['submit']) && ($_POST['submit']=='signin')){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "";
        $user->addUser();
        header("Location: admin/login.php");
        
        
        
    }