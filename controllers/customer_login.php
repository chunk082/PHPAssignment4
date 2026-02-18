<?php 

if ($action === 'customer_login') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $query = "SELECT * FROM customers WHERE email = :email";
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $customer = $statement->fetch();
        $statement->closeCursor();

        if ($customer && $password === $customer['password']) {

            session_unset();
            session_regenerate_id(true);

            $_SESSION['role'] = 'customer';
            $_SESSION['customerID'] = $customer['customerID'];
            $_SESSION['email'] = $customer['email'];

            header('Location: index.php');
            exit();

        } else {

            $error = "Invalid login.";
            require 'views/home.php';
        }
    }
}

elseif ($action === 'customer_logout') {

    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}
