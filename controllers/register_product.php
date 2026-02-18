<?php

require_once './db/database.php';
require __DIR__ . '/../models/customer.php';
require __DIR__ . '/../models/products.php';

// Security: Must be logged in as customer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header('Location: ../index.php?action=customer_login');
    exit();
}

$customerID = $_SESSION['customerID'];
$error_message = '';
$success_message = '';

// Load customer + products
$customer = Customer::getByID($customerID);
$products = Product::getAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productCode = $_POST['productCode'] ?? '';

    if (empty($productCode)) {
        $error_message = "Please select a product.";
    } else {
        Product::register($customerID, $productCode);
        $success_message = "Product <strong>" . htmlspecialchars($productCode) . "</strong> registered successfully.";
    }
}

// Load the view
require __DIR__ . '/../views/customers/register_product.php';
