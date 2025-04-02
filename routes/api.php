<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
require_once '../core/Auth.php';
Auth::check();

// Nettoyage du chemin selon la structure locale
$uri = str_replace("/bellatrix-backend/public", "", $uri); // adapter si besoin

// === ROUTES PUBLIQUES (pas besoin de token) ===
if ($uri === "/login" && $method === 'POST') {
    require_once '../controllers/AuthController.php';
    $controller = new AuthController();
    $controller->login();
    exit;
}

if ($uri === "/register" && $method === 'POST') {
    require_once '../controllers/AuthController.php';
    $controller = new AuthController();
    $controller->register();
    exit;
}

// ✅ Toutes les autres routes sont protégées
require_once '../core/Auth.php';
Auth::check(); // Stoppe ici si token invalide

// === ACTIVITÉS ===
if ($uri === "/activites" && $method === 'GET') {
    require_once '../controllers/ActiviteController.php';
    $controller = new ActiviteController();
    $controller->getAll();
}

// === RÉSERVATIONS ===
elseif ($uri === "/reservations" && $method === 'GET') {
    require_once '../controllers/ReservationController.php';
    $controller = new ReservationController();
    $controller->getAll();
}

elseif ($uri === "/reservations" && $method === 'POST') {
    require_once '../controllers/ReservationController.php';
    $controller = new ReservationController();
    $controller->create();
}

elseif (preg_match("#^/reservations/user/(\d+)$#", $uri, $matches) && $method === 'GET') {
    require_once '../controllers/ReservationController.php';
    $controller = new ReservationController();
    $controller->getByUser($matches[1]);
}

elseif (preg_match("#^/reservations/(\d+)$#", $uri, $matches) && $method === 'DELETE') {
    require_once '../controllers/ReservationController.php';
    $controller = new ReservationController();
    $controller->delete($matches[1]);
}

// === ROUTE NON TROUVÉE ===
else {
    http_response_code(404);
    echo json_encode([
        "error" => "Route non trouvée",
        "uri" => $uri // debug utile
    ]);
}
