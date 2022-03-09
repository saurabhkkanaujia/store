<?php
namespace App;

use PDO;

class Admin
{
    public function fetchAllUsers($amount)
    {
        $sql = "SELECT * FROM users WHERE NOT role = 'admin' " . $amount . "";

        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
    public function changeStatus($id, $action)
    {
        if ($action == 'approve') {
            $sql = "UPDATE users SET status = 'Approved' WHERE id = " . $id . "";
        } else {
            $sql = "UPDATE users SET status = 'Not Approved' WHERE id = " . $id . "";
        }
        DB::getInstance()->exec($sql);
    }
    public function delete($id, $table)
    {
        $sql = "DELETE FROM " . $table . " WHERE id = " . $id . "";
        DB::getInstance()->exec($sql);
    }
    public function getIndex($arr, $index)
    {
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i] == $index) {
                return $i;
            }
        }
    }
    public function fetchOrders()
    {
        $sql = "SELECT o.order_id, u.id, u.username, u.email, p.name,
            p.category, o.quantity, b.billing_address_1,b.billing_address_2,
            b.billing_postcode, b.billing_phone, o.status
            FROM `order_table` as o INNER JOIN  user_billing_details as b ON o.billing_id = b.pid
            INNER JOIN users as u ON u.id = o.user_id
            INNER JOIN products as p ON p.id = o.product_id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function changeOrderStatus($id, $action)
    {
        if ($action == 'pending') {
            $sql = "UPDATE order_table SET status = 'Pending' WHERE order_id = " . $id . "";
        } else {
            $sql = "UPDATE order_table SET status = 'Delivered' WHERE order_id = " . $id . "";
        }
        DB::getInstance()->exec($sql);
    }
}
