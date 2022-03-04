<?php
    class User extends DB
    {
        public string $username;
        public string $name;
        public string $email;
        public string $password;
        public string $rePassword;

        public function __construct($username, $name, $email, $password, $rePassword, $role, $status)
        {
            $this->username = $username;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->rePassword = $rePassword;
            $this->role = $role;
            $this->status = $status;
        }
        public function check(){
            if(strlen($this->username)!=0 && strlen($this->name)!=0 && strlen($this->email)!=0 && strlen($this->password)!=0 && strlen($this->rePassword)!=0 && strlen($this->role)!=0 && strlen($this->password)!=0 ){
                $_SESSION['check']=0;
                return true;
            }else{
                $_SESSION['check']=1;
                return false;
            }
        }

        public function addUser(){
            if($this->check()){
                $sql = "INSERT INTO users (username, full_name, email, password, role, status)
                        VALUES ('".$this->username."', '".$this->name."', '".$this->email."', '".$this->password."', '".$this->role."', '".$this->status."' )";
                DB::getInstance()->exec($sql);
            }
        }
        public static function error($msg){
            return $msg;
        }
    }