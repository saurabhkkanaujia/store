<?php
    session_start();
    include('config.php');
    include('classes/DB.php');
    include('classes/User.php');
    include('classes/Login.php');
    
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
            }else{
                $_SESSION['msg'] = "Invalid Credentials";
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