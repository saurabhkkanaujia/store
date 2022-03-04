<?php
    class Validation
    {
        public function check($username, $name, $email, $password, $rePassword, $role){
            if(strlen($username)!=0 && strlen($name)!=0 && strlen($email)!=0 && strlen($password)!=0 && strlen($rePassword)!=0 && strlen($role)!=0){
                $_SESSION['check']=0;
                return true;
            }else{
                $_SESSION['check']=1;
                return false;
            }
        }
        public function alreadyExists($email)
        {
            $sql = "SELECT email FROM users WHERE email = '".$this->email."'";

            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if (count($stmt->fetchAll())>=1){
                $_SESSION['msg']="Email Id Already Exists";
                $_SESSION['check']=-1;
                return true;
            }else{
                return false;
            }
        }
    }