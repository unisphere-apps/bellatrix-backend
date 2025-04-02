<?php
require_once '../config/database.php';

class Reservation {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function create($utilisateur_id, $activite_id) {
        $query = "INSERT INTO bel_reservations (utilisateur_id, activite_id, date, statut)
                  VALUES (:utilisateur_id, :activite_id, NOW(), 'confirmée')";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':utilisateur_id', $utilisateur_id);
        $stmt->bindParam(':activite_id', $activite_id);

        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM bel_reservations";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser($userId) {
        $query = "SELECT * FROM bel_reservations WHERE utilisateur_id = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM bel_reservations WHERE id_reservation = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
}
