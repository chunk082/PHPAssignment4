<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once __DIR__ . '/db/database.php';

$action = filter_input(INPUT_GET, 'action')
        ?? filter_input(INPUT_POST, 'action')
        ?? 'home';

switch ($action) {

    /* ---- Administation Section --- */

    case 'admin_login':
    case 'admin_menu':
    case 'admin_logout':
        require 'controllers/admin_login.php';
        break;

    case 'manage_products':
        require 'controllers/manage_products.php';
        break;

    case 'manage_technicians':
        require 'controllers/manage_technicians.php';
        break;

    case 'manage_customers':
        require 'controllers/manage_customer.php';
        break;

    case 'create_incident':
        require 'controllers/create_incidents.php';
        break;

    case 'assign_incident':
        require 'controllers/assign_incident.php';
        break;

    case 'display_incident':
        require 'controllers/display_incident.php';
        break;

     /* --- Technicians Section --- */   

    case 'tech_login':
    case 'tech_select_incident':
    case 'tech_logout':
        require 'controllers/tech_login.php';
        break;

    case 'update_incidents':
        require 'controllers/update_incident.php';
        break;

    /* --- Customer Product Registration --- */

    case 'customer_login':
    case 'customer_logout':
        require 'controllers/customer_login.php';
        break;

    case 'register_product':
        require 'controllers/register_product.php';
        break;
    

    default:
        require 'views/home.php';
}
