<?php

if ($action === 'tech_login') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $query = "SELECT * FROM technicians WHERE email = :email";
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $technician = $statement->fetch();
        $statement->closeCursor();

        if ($technician && $password === $technician['password']) {

            session_unset();
            session_regenerate_id(true);

            $_SESSION['role'] = 'technician';
            $_SESSION['techID'] = $technician['techID'];

            header('Location: index.php');
            exit();
        } else {
            $error = "Invalid login.";
            require 'views/home.php';
        }
    }
}

elseif ($action === 'tech_logout') {

    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}
