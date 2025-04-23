<?php
require_once '../models/Activite.php';
require_once '../core/Response.php';

class ActiviteController {
    public function getAll() {
        $activite = new Activite();
        $data = $activite->getAll();
        Response::json($data);
    }

    public function getActiviteById($id) {
        $activite = new Activite();
        $data = $activite->getActiviteById($id);
        Response::json($data);
    }
}
