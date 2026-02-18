<?php

//Admin protection
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../models/incident.php';
require_once __DIR__ . '/../models/technicians.php';

$error_message = '';
$incident = null;
$technicians = [];

//Handles Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $incidentID = filter_input(INPUT_POST, 'incidentID', FILTER_VALIDATE_INT);
    $techID     = filter_input(INPUT_POST, 'techID', FILTER_VALIDATE_INT);
    $close      = isset($_POST['closeIncident']) ? date('Y-m-d H:i:s') : null;

    if (!$incidentID || !$techID) {
        $error_message = "Invalid assignment data.";
    } else {
        Incident::assign($incidentID, $techID, $close);

        // Redirect through router
        header('Location: index.php?action=display_incidents');
        exit();
    }
}

// Loads Incidents
$incidentID = filter_input(INPUT_GET, 'incidentID', FILTER_VALIDATE_INT);

if (!$incidentID) {
    $error_message = "No incident selected.";
} else {
    $incident = Incident::getByID($incidentID);

    if (!$incident) {
        $error_message = "Incident not found.";
    } else {
        $technicians = Technician::getAll();
    }
}

// Load the view
require __DIR__ . '/../views/admin/assign_incident.php';
