<?php

//Only technicians allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'technician') {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../models/incident.php';
require_once __DIR__ . '/../models/technicians.php';

$techID = $_SESSION['techID'];

//Handle update submission
if ($action === 'tech_update_incident' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $incidentID = filter_input(INPUT_POST, 'incidentID', FILTER_VALIDATE_INT);
    $description = trim($_POST['description'] ?? '');
    $closeIncident = isset($_POST['closeIncident']);

    if ($incidentID) {

        $incident = Incident::getByID($incidentID);

        if ($incident && (int)$incident['techID'] === (int)$techID) {

            Incident::updateDescription($incidentID, $description);

            if ($closeIncident) {
                Incident::close($incidentID);
            }
        }
    }

    header('Location: index.php?action=tech_dashboard');
    exit();
}

//Load open incidents for technician
$incidents = Incident::getOpenByTechnician($techID);

//Load dashboard view
require __DIR__ . '/../views/technicians/update_incidents.php';
