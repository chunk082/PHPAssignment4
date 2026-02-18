<?php

//Protect route (Admin only)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../models/customer.php';

$customerModel = new Customer($db);
$customers = $customerModel->getAll();

//Load view
require __DIR__ . '/../views/admin/manage_customer.php';
?>