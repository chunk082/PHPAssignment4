<?php

//Admin protection
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require __DIR__ . '/../models/incident.php';

// fetch incidents from the model
$incidents = Incident::getAll();

// Load the view
require __DIR__ . '/../views/admin/display_incident.php';
