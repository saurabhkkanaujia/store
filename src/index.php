<?php

    include('config.php');
    include('classes/DB.php');
    include('classes/User.php');
    include('classes/Login.php');
    
    if ($_POST['submit']=='signup'){
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

    if (isset($_POST['signin'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = new Login($email, $password);   
        $userData = $user->authenticate();
        
        if(count($userData)>=1){
            if($userData[0]['role'] == 'admin'){
                header("Location: dashboard.php");
            }else{
                if ($userData[0]['status'] == 'Approved'){
                    header("Location: dashboard.html");
                }else{
                    $msg = "You have not been approved";
                }
            }
        }else{
            $msg = "Invalid Login Credentials";
        }
    }