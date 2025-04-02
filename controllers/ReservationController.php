<?php
require_once '../models/Reservation.php';
require_once '../core/Response.php';

class ReservationController {
    
    public function create() {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['utilisateur_id'], $input['activite_id'])) {
            Response::json(["error" => "Champs requis manquants"], 400);
        }

        $reservation = new Reservation();
        $result = $reservation->create($input['utilisateur_id'], $input['activite_id']);

        if ($result) {
            Response::json(["message" => "Réservation créée avec succès"], 201);
        } else {
            Response::json(["error" => "Échec de la réservation"], 500);
        }
    }

    public function getAll() {
        $reservation = new Reservation();
        $data = $reservation->getAll();
        Response::json($data);
    }

    public function getByUser($userId) {
        $reservation = new Reservation();
        $data = $reservation->getByUser($userId);
        Response::json($data);
    }

    public function delete($id) {
        $reservation = new Reservation();
        $success = $reservation->delete($id);
    
        if ($success) {
            Response::json(["message" => "Réservation annulée"], 200);
        } else {
            Response::json(["error" => "Suppression échouée"], 500);
        }
    }
    
}
