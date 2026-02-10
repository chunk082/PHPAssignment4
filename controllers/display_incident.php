<?php
require_once '../models/incident.php';

// fetch incidents from the model
$incidents = Incident::getAll();

// load the view and pass $incidents
require '../views/admin/display_incident.php';
