<?php
require_once '../models/User.php';
require_once '../core/Response.php';

class AuthController {
    public function login() {
        $input = json_decode(file_get_contents("php://input"), true);
        $email = $input['email'];
        $password = $input['password'];
    
        $user = (new User())->findByEmail($email);
    
        // Comparaison en clair (attention : temporaire seulement)
        if ($user && $user['mdp'] === $password) {
            $token = bin2hex(random_bytes(32));
            (new User())->storeToken($user['id_user'], $token);
    
            Response::json([
                'token' => $token,
                'user_id' => $user['id_user'],
                'role_id' => $user['role_id']
            ]);
        } else {
            Response::json(["error" => "Identifiants invalides"], 401);
        }
    }

    public function register() {
        $input = json_decode(file_get_contents("php://input"), true);
    
        $nom = $input['nom'];
        $prenom = $input['prenom'] ?? null;
        $etablissement = $input['etablissement'] ?? null;
        $email = $input['email'];
        $password = $input['password'];
    
        $userModel = new User();
    
        // Vérifie si l'email existe déjà
        if ($userModel->findByEmail($email)) {
            Response::json(["error" => "Email déjà utilisé"], 409);
            return;
        }
    
        $created = $userModel->create($nom, $prenom, $etablissement, $email, $password);
    
        if ($created) {
            Response::json(["message" => "Utilisateur enregistré avec succès"], 201);
        } else {
            Response::json(["error" => "Erreur lors de l'inscription"], 500);
        }
    }
    
    
}