<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../routes/api.php';

echo "URI demandée : " . $_SERVER['REQUEST_URI'];
