<?php

namespace App;

class User extends DB
{
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

    public function addUser()
    {
        $check = new Validation();
        $checkUser = $check->check(
            $this->username,
            $this->name,
            $this->email,
            $this->password,
            $this->rePassword,
            $this->role
        );

        if ($checkUser == true && !($check->alreadyExists($this->email))) {
            $sql = "INSERT INTO users (username, full_name, email, password, role, status)
                        VALUES ('" . $this->username . "', '" . $this->name . "', '" . $this->email . "',
                         '" . $this->password . "', '" . $this->role . "', '" . $this->status . "' )";
            DB::getInstance()->exec($sql);
        }
    }
    public static function error($msg)
    {
        return $msg;
    }
}
