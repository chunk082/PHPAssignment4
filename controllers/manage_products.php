<?php

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../models/products.php';

$products = Product::getAll();

require __DIR__ . '/../views/admin/product_manager.php';
