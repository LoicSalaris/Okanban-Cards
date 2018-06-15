<?php

// 1 classe correspondant au modèle pour la table list
// M de MVC = Model
// 1 table = 1 Model = 1 Classe

class CardModel
{
    // 1 champ de la table = 1 propriété de la classe
    public $id = 'NULL';
    public $content;
    public $list_id; // correspond à list_id : le type de casse doit être le même (ici snake_case)

    /**
     * Méthode pour créer une carte avec son nom
     */
    public function save()
    {
        // Injection de $name comme ceci, pas secure, à voir plus tard
        $sql = "REPLACE INTO card (id, content, list_id) VALUES (".$this->id.", '".$this->content."', '".$this->list_id."')";
        // Exécution de la requête
        $success = Database::getPDO()->exec($sql);
        // En cas de create ou d'update réussi
        if($success) {
            // On récupère l'id de la ligne en question
            $lastInsertId = Database::getPDO()->lastInsertId();
            // On renvoie cet id
            return $lastInsertId;
        } else {
            // Retourne false
            return false;
        }
    }

    /**
     * Méthode pour aller chercher une carte par son id
     */
    public function read($id)
    {

    }

    public function editPos($cardId, $pos)
    {
        // On modifie le champ pos de la card concernée
        echo $sql = 'UPDATE card SET pos='.$pos.' WHERE id='.$cardId;
        // Exécution de la requête
        $success = Database::getPDO()->exec($sql);
    }

    /**
     * Méthode pour supprimer une carte
     */
    public function delete($id)
    {
        $sql = 'DELETE FROM card WHERE id='.$id;
        // Exécution de la requête
        $success = Database::getPDO()->exec($sql);

        return $success;
    }

    /**
     * Méthode pour récupérer toutes les cartes
     */
    public function findAll()
    {
        $sql = '
          SELECT *
          FROM card
          ORDER BY pos ASC
        ';
        // Database::getPDO() est une méthode statique de la classe Database fournie dans "inc/Database.php"
        $pdoStatement = Database::getPDO()->query($sql);
        // Retourne tous les résultats sous forme d'array d'objets Product
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'CardModel');
    }
}
