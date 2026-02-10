<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../models/products.php');

$productCode = filter_input(INPUT_POST, 'productCode');

if ($productCode) {
    Product::delete($productCode);
}

header("Location: ../views/admin/product_manager.php");
exit();
