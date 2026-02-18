<?php

//Admin protection
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../models/customer.php';
require_once __DIR__ . '/../models/products.php';
require_once __DIR__ . '/../models/technicians.php';
require_once __DIR__ . '/../models/incident.php';

// If form submitted → create incident
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    Incident::create(
        $_POST['customerID'],
        $_POST['productCode'],
        $_POST['techID'] ?? null,
        $_POST['title'],
        $_POST['description']
    );

    header('Location: index.php?action=display_incidents');
    exit();
}

// Otherwise → show form

$customers   = Customer::getAll();
$products    = Product::getAll();
$technicians = Technician::getAll();

require __DIR__ . '/../views/admin/create_incident.php';
