<?php
require_once '../models/Activite.php';
require_once '../core/Response.php';

class ActiviteController {
    public function getAll() {
        $activite = new Activite();
        $data = $activite->getAll();
        Response::json($data);
    }
}
