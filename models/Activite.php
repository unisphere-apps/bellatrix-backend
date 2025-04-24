<?php
require_once '../config/database.php';

class Activite {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $query = "SELECT * FROM bel_activites";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiviteById($id){
        $query = "SELECT * FROM bel_activites WHERE id_activite = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO bel_activites (titre, description, lieu, date, capacite, statut, organisateur_id)
                  VALUES (:titre, :description, :lieu, :date, :capacite, :statut, :organisateur_id)";
    
        $stmt = $this->conn->prepare($query);
    
        // ⚠️ On passe chaque valeur dans une variable intermédiaire
        $titre = $data['titre'];
        $description = $data['description'];
        $lieu = $data['lieu'];
        $date = $data['date'];
        $capacite = $data['capacite'];
        $statut = $data['statut'];
        $organisateurId = $data['organisateur_id'];
    
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':lieu', $lieu);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':capacite', $capacite, PDO::PARAM_INT);
        $stmt->bindParam(':statut', $statut);
        $stmt->bindParam(':organisateur_id', $organisateurId, PDO::PARAM_INT);
    
        return $stmt->execute();
    }      
}
