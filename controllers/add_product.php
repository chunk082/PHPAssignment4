<?php

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../models/products.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    Product::add(
        $_POST['productCode'],
        $_POST['name'],
        $_POST['version'],
        $_POST['releaseDate']
    );

    header('Location: index.php?action=manage_products');
    exit();
}
