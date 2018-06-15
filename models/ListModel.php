<?php

// 1 classe correspondant au modèle pour la table list
// M de MVC = Model
// 1 table = 1 Model = 1 Classe

class ListModel
{
    // 1 champ de la table = 1 propriété de la classe
    public $id = 'NULL';
    public $name;

    /**
     * Méthode pour créer une liste avec son nom
     */
    public function save()
    {
        // Injection de $name comme ceci, pas secure, à voir plus tard
        $sql = "REPLACE INTO list (id, name) VALUES (".$this->id.", '".$this->name."')";
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
     * Méthode pour aller chercher une liste par son id
     */
    public function read($id)
    {

    }

    /**
     * Méthode pour supprimer une liste
     */
    public function delete($id)
    {

    }

    /**
     * Méthode pour récupérer toutes les listes
     */
    public function findAll()
    {
        $sql = '
          SELECT *
          FROM list
        ';
        // Database::getPDO() est une méthode statique de la classe Database fournie dans "inc/Database.php"
        $pdoStatement = Database::getPDO()->query($sql);
        // Retourne tous les résultats sous forme d'array d'objets Product
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'ListModel');
    }
}
