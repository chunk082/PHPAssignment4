<?php

if ($action === 'admin_login') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $query = 'SELECT * FROM administrators WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $admin = $statement->fetch();
        $statement->closeCursor();

        if ($admin && $password === $admin['password']) {

            session_unset();
            session_regenerate_id(true);

            $_SESSION['role'] = 'admin';
            $_SESSION['admin_username'] = $admin['username'];

            header('Location: index.php');
            exit();

        } else {
            $error = "Invalid login.";
            require __DIR__ . '/../views/home.php';
        }

    } else {
        require __DIR__ . '/../views/home.php';
    }
}

if ($action === 'admin_logout') {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}
