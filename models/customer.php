<?php
require_once __DIR__ . '/../db/database.php';

class Customer
{

    public static function getByID($customerID)
{
    global $db;

    $sql = "SELECT * FROM customers
            WHERE customerID = :customerID";

    $stmt = $db->prepare($sql);
    $stmt->execute([':customerID' => $customerID]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public static function getAll()
    {
        global $db;

        $sql = "SELECT customerID, firstName, lastName, email, phone FROM customers ORDER BY lastName, firstName";

        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByEmail($email)
    {
        global $db;

        $sql = "SELECT * FROM customers WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function add($firstName, $lastName, $email, $phone = null, $address = null, $city = null, $state = null, $postalCode = null, $countryCode = null) {
        
        global $db;

        $sql = "INSERT INTO customers (firstName, lastName, email, phone, address, city, state, postalCode, countryCode) VALUES (:firstName, :lastName, :email, :phone, :address, :city, :state, :postalCode, :countryCode)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':firstName'   => $firstName,
            ':lastName'    => $lastName,
            ':email'       => $email,
            ':phone'       => $phone,
            ':address'     => $address,
            ':city'        => $city,
            ':state'       => $state,
            ':postalCode'  => $postalCode,
            ':countryCode' => $countryCode
        ]);
    }

    public static function update($customerID, $firstName, $lastName, $email, $phone = null, $address = null, $city = null, $state = null, $postalCode = null, $countryCode = null) {
        
        global $db;

        $sql = "UPDATE customers SET
                    firstName   = :firstName,
                    lastName    = :lastName,
                    email       = :email,
                    phone       = :phone,
                    address     = :address,
                    city        = :city,
                    state       = :state,
                    postalCode  = :postalCode,
                    countryCode = :countryCode
                WHERE customerID = :customerID";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':firstName'   => $firstName,
            ':lastName'    => $lastName,
            ':email'       => $email,
            ':phone'       => $phone,
            ':address'     => $address,
            ':city'        => $city,
            ':state'       => $state,
            ':postalCode'  => $postalCode,
            ':countryCode' => $countryCode,
            ':customerID'  => $customerID
        ]);
    }
}
