<?php

//Protect route (Admin only)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

//Load model
require_once __DIR__ . '/../models/technicians.php';

//Get data
$technicians = Technician::getAll();

//Load view
require __DIR__ . '/../views/admin/manage_technicians.php';
