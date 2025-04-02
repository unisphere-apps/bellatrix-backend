<?php
require_once '../config/database.php';

class User {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function storeToken($id_user, $token) {
        $stmt = $this->conn->prepare("UPDATE user SET token = :token WHERE id_user = :id");
        return $stmt->execute([
            ':token' => $token,
            ':id' => $id_user
        ]);
    }

    public function create($nom, $prenom, $etablissement, $email, $password, $role_id = 1) {
        $stmt = $this->conn->prepare("
            INSERT INTO user (nom, prenom, etablissement, email, mdp, role_id)
            VALUES (:nom, :prenom, :etablissement, :email, :mdp, :role_id)
        ");
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':etablissement' => $etablissement,
            ':email' => $email,
            ':mdp' => $password,
            ':role_id' => $role_id
        ]);
    }

    public function verifyToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // false si token invalide
    }    

}
