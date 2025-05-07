<?php
require_once '../models/Activite.php';
require_once '../core/Response.php';

class ActiviteController
{
    public function getAll()
    {
        $activite = new Activite();
        $data = $activite->getAll();
        Response::json($data);
    }

    public function getActiviteById($id)
    {
        $activite = new Activite();
        $data = $activite->getActiviteById($id);
        Response::json($data);
    }

    // 🔨 Création d'une nouvelle activité
    public function create()
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);

            if (!isset($input['titre'], $input['description'], $input['lieu'], $input['date'], $input['capacite'], $input['statut'], $input['organisateur_id'])) {
                Response::json(['error' => 'Champs manquants'], 400);
                return;
            }

            $activite = new Activite();
            $result = $activite->create([
                'titre' => $input['titre'],
                'description' => $input['description'],
                'lieu' => $input['lieu'],
                'date' => $input['date'],
                'capacite' => $input['capacite'],
                'statut' => $input['statut'],
                'organisateur_id' => $input['organisateur_id']
            ]);

            if ($result) {
                Response::json(['success' => true]);
            } else {
                Response::json(['error' => "Insertion échouée"], 500);
            }
        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 500);
        }
    }

    // 🗑️ Suppression d'une activité
    public function delete($id)
    {
        $activite = new Activite();
        $success = $activite->delete($id);

        if ($success) {
            Response::json(['success' => true]);
        } else {
            Response::json(['error' => 'Suppression échouée'], 500);
        }
    }
}
