<?php
    class Admin
    {
        public function fetchAllUsers($amount)
        {
            $sql = "SELECT * FROM users WHERE NOT role = 'admin' ".$amount."";

            $stmt = DB::getInstance()->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();  
        }
        public function changeStatus($id, $action){
            if ($action == 'approve'){
                $sql = "UPDATE users SET status = 'Approved' WHERE id = ".$id."";
            }else{
                $sql = "UPDATE users SET status = 'Not Approved' WHERE id = ".$id."";
            }
            DB::getInstance()->exec($sql);
        }
        public function delete($id, $table){
            $sql = "DELETE FROM ".$table." WHERE id = ".$id."";
            DB::getInstance()->exec($sql);
        }
        public function getIndex($arr, $index){
            for($i=0; $i<count($arr); $i++){
                if ($arr[$i] == $index){
                    return $i;
                }
            }
        }
        
    }