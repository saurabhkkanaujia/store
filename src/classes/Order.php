<?php

namespace App;

use PDO;

session_start();

class Order
{
    public function __construct(
        $billing_country,
        $billing_first_name,
        $billing_last_name,
        $billing_address_1,
        $billing_address_2,
        $billing_postcode,
        $billing_state,
        $billing_email,
        $payment_method,
        $billing_phone,
        $cardName,
        $cardNumber,
        $cardExpiry,
        $cvv
    ) {
        $this->billing_country = $billing_country;
        $this->billing_first_name = $billing_first_name;
        $this->billing_last_name = $billing_last_name;
        $this->billing_address_1 = $billing_address_1;
        $this->billing_address_2 = $billing_address_2;
        $this->billing_postcode = $billing_postcode;
        $this->billing_state = $billing_state;
        $this->billing_email = $billing_email;
        $this->payment_method = $payment_method;
        $this->billing_phone = $billing_phone;
        $this->cardName = $cardName;
        $this->cardNumber = $cardNumber;
        $this->cardExpiry = $cardExpiry;
        $this->cvv = $cvv;
    }

    public function placeOrder()
    {
        $sql = "INSERT INTO user_billing_details (
            billing_country, billing_first_name, billing_last_name, 
            billing_address_1, billing_address_2, billing_postcode, billing_state, billing_email, billing_phone)
                VALUES ('" . $this->billing_country . "','" . $this->billing_first_name . "',
                '" . $this->billing_last_name . "', '" . $this->billing_address_1 . "',
                '" . $this->billing_address_2 . "', '" . $this->billing_postcode . "' ,
                '" . $this->billing_state . "', '" . $this->billing_email . "','" . $this->billing_phone . "' ) ";

        DB::getInstance()->exec($sql);

        $sql = "SELECT DISTINCT pid FROM user_billing_details WHERE billing_email = '" . $this->billing_email . "'";

        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $pid_array = $stmt->fetchAll();

        foreach ($_SESSION['cart'] as $key => $value) {
            $sql = "INSERT INTO order_table (user_id, product_id, billing_id,quantity, status)
                VALUES (" . $_SESSION['user']['id'] . ", " . $value['id'] . ",
                " . $pid_array[0]['pid'] . ", " . $value['qty'] . ", 'Order Placed')";
            DB::getInstance()->exec($sql);
        }

        $sql = "INSERT INTO payment_details (cardName, cardNumber, cardExpiry, cvv)
                VALUES ('" . $this->cardName . "', " . $this->cardNumber . ",
                " . $this->cardExpiry . ", " . $this->cvv . ")";
        DB::getInstance()->exec($sql);
        unset($_SESSION['cart']);
    }
}
