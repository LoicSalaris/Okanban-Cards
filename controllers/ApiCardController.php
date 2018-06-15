<?php

class ApiCardController
{
    /**
     * Retourne toutes les cartes
     * sous forme de JSON
     */
    public function getAll()
    {
        // Requête pour récupérer les listes
        $cardModel = new CardModel;
        $cards = $cardModel->findAll();

        // On précise au navigateur que l'on est bien en application/json
        header('Content-Type: application/json');
        // En envoie en JSON
        echo json_encode($cards);
    }

    public function order()
    {
        // Liste id pas utile pour le moment
        // car on ne peut changer de liste à ce stade
        $listId = $_POST['list_id'];
        $cards = $_POST['cards'];
        // On instancie notre modèle
        $cardModel = new CardModel;
        // On update les cards
        // (
        //     [0] => 8
        //     [1] => 11
        //     [2] => 9
        //     [3] => 12
        // )
        foreach ($cards as $pos => $cardId) {
            $cardModel->editPos($cardId, $pos);
        }
    }

    /**
     * Create card
     */
    public function create()
    {
        // Récupération du content posté
        $content = $_POST['content'];
        $list_id = $_POST['list_id'];
        // Nouvelle liste
        $cardModel = new CardModel;
        $cardModel->content = $content;
        $cardModel->list_id = $list_id;
        // On l'enregistre
        $insertId = $cardModel->save();
        // Message de retour
        $return = [
            'id' => $insertId,
            'content' => $content,
            'list_id' => $list_id,
        ];
        // On précise au navigateur que l'on est bien en application/json
        header('Content-Type: application/json');
        // Un retour
        echo json_encode($return);
    }

    /**
     * Delete card
     * @var $params Array
     */
    public function delete($params)
    {
        $cardModel = new CardModel;
        $success = $cardModel->delete($params['id']);

        if($success) {
            $return = ['id' => $params['id']];
        } else {
            $return = ['id' => false];
        }
        // On précise au navigateur que l'on est bien en application/json
        header('Content-Type: application/json');
        // Un retour
        echo json_encode($return);
    }

    /**
     * Update card
     */
    public function update()
    {
    }
}
