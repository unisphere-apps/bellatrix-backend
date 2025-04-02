<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Nettoyage du chemin si besoin (ex: /bellatrix-backend/public)
$uri = str_replace("/bellatrix-backend/public", "", $uri);  // à adapter selon ta structure

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

// Exemple : /reservations/user/3
elseif (preg_match("#^/reservations/user/(\d+)$#", $uri, $matches) && $method === 'GET') {
    require_once '../controllers/ReservationController.php';
    $controller = new ReservationController();
    $controller->getByUser($matches[1]);
}

// Exemple : DELETE /reservations/5 (annuler une réservation)
elseif (preg_match("#^/reservations/(\d+)$#", $uri, $matches) && $method === 'DELETE') {
    require_once '../controllers/ReservationController.php';
    $controller = new ReservationController();
    $controller->delete($matches[1]);
}

// 404 fallback
else {
    http_response_code(404);
    echo json_encode(["error" => "Route non trouvée"]);
}
