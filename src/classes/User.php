<?php
    require ('Validation.php');
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

        public function addUser(){
            // $userExists = new Login($this->email);
            $check=new Validation();
            $check->check($this->username, $this->name, $this->email,$this->password, $this->rePassword, $this->role);

            
            if($check == true && !($check->alreadyExists($this->email))){
                $sql = "INSERT INTO users (username, full_name, email, password, role, status)
                        VALUES ('".$this->username."', '".$this->name."', '".$this->email."', '".$this->password."', '".$this->role."', '".$this->status."' )";
                DB::getInstance()->exec($sql);
            }
        }
        public static function error($msg){
            return $msg;
        }
    }