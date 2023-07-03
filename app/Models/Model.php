<?php
namespace App\Models;

use App\Db\Db;

class Model extends Db
{
    /**
     * Va stocker le nom de la table
     *
     * @var string|null
     */
    protected ?string $table = null;
    /**
     * Va stocker la connexion en BDD
     *
     * @var Db|null
     */
    protected ?Db $database = null;

    /**
     * Trouve toutes les entrées d'une table
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->runQuery("SELECT * FROM $this->table");

        return $query->fetchAll();
    }
    
    /**
     * Trouve une entrée en BDD de par son ID
     *
     * @param integer $id
     * @return array|boolean
     */
    public function find(int $id): array|bool
    {
        return $this->runQuery("SELECT * FROM $this->table WHERE id = :id", ['id' => $id])->fetch();
    }

    /**
     * Recherche des entrées en BDD avec un tableau de filtres
     *
     * @param array $criteres critère de filtre ex: ['id' => 1]
     * @return array
     */
    public function findBy(array $criteres): array
    {
        // SELECT * FROM articles WHERE actif = :actif AND id = :id
        // On prépare la récupération des champs et des valeurs de manière séparée
        $champs = [];
        $valeurs = [];

        // On parcourt le tableau de critères pour récupérer les champs et les valeurs
        // Exemple du tableau ['actif' => true, 'id' => 1]
        foreach($criteres as $champ => $valeur){
            // "actif = :actif"
            $champs[] = "$champ = :$champ";
            $valeurs[$champ] = $valeur;
        }
        
        // On transforme le tableau de champs en chaine de caractères pour l'intégrer
        // à la requête SQL
        $strChamps = implode(' AND ', $champs);
        // var_dump($strChamps);

        // On execute la requete SQL
        return $this->runQuery("SELECT * FROM $this->table WHERE $strChamps", $valeurs)->fetchAll();
    }

    /**
     * Fonction pour envoyer n'importe quelle requête SQL en BDD
     *
     * @param string $sql Requête SQL à envoyer
     * @param array|null $parametres Tableau associatif avec les marqueurs SQL (facultatif)
     * @return \PDOStatement|boolean
     */
    public function runQuery(string $sql, ?array $parametres = null): \PDOStatement|bool
    {
        // On récupère la connexion en BDD
        $this->database = Db::getInstance();

        // On vérifie s'il y a des paramètres à la requête SQL
        if($parametres !== null) {
            // Requête préparée (avec marqueur dans la requête)
            $query = $this->database->prepare($sql);
            $query->execute($parametres);

            return $query;
        } else {
            // Requête simple (sans marqueur)
            return $this->database->query($sql);  // query = fonction de PDO
        }
            
    }
}