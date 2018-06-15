<?php

class ApiListController
{
    /**
     * Retourne toutes les listes
     * sous forme de JSON
     */
    public function getAll()
    {
        // Requête pour récupérer les listes
        $listModel = new ListModel;
        $lists = $listModel->findAll();

        // On précise au navigateur que l'on est bien en application/json
        header('Content-Type: application/json');
        // En envoie en JSON
        echo json_encode($lists);
    }

    /**
     * Create list
     */
    public function create()
    {
        // Récupération du name posté
        $name = $_POST['name'];
        // Nouvelle liste
        $listModel = new ListModel;
        $listModel->name = $name;
        // On l'enregistre
        $insertId = $listModel->save();
        // Message de retour
        $return = [
            'id' => $insertId,
            'name' => $name,
        ];
        // On précise au navigateur que l'on est bien en application/json
        header('Content-Type: application/json');
        // Un retour
        echo json_encode($return);
    }

    /**
     * Update list
     */
    public function update()
    {
        // Récupération du id posté
        $id = $_POST['id'];
        // Récupération du name posté
        $name = $_POST['name'];
        // Nouvelle liste
        $listModel = new ListModel;
        $listModel->id = $id;
        $listModel->name = $name;
        // On l'enregistre
        $success = $listModel->save();
        // Message de retour
        $return = [
            'success' => $success, // true ou false
            'id' => $id,
            'name' => $name,
        ];
        // On précise au navigateur que l'on est bien en application/json
        header('Content-Type: application/json');
        // Un retour
        echo json_encode($return);
    }
}
