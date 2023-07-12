<?php
namespace App\Models;

use App\Core\Db;
use DateTime;
use PDOStatement;

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
     * @return object|boolean
     */
    public function find(int $id): object|bool
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
     * Fonction de création d'une entrée en BDD
     *
     * @return \PDOStatement|null
     */
    public function create(): ?\PDOStatement
    {
        // Requête SQL à faire :
        // "INSERT INTO articles (titre, description, created_at, actif)
        // VALUES (:titre, :description, :created_at, :actif)"

        // Initialiser les tableaux vides pour récupérer les données
        $champs = [];
        $valeurs = [];
        $marqueurs = [];
        
        // On boucle sur l'objet pour récupérer tous les champs et les valeurs
        foreach($this as $champ => $valeur) {
            if($valeur !== null && $champ !== 'table'){
                // actif
            $champs[] = $champ;  // tableau à index
            
            // ['actif' => true]
            if(gettype($valeur) === 'boolean'){
                $valeurs[$champ] = (int) $valeur;  // tableau associatif
            } elseif (gettype($valeur) === 'array'){
                $valeurs[$champ] = json_encode($valeur);
            }
             elseif($valeur instanceof \DateTime) {
                $valeurs[$champ] = date_format($valeur, 'Y-m-d H:i:s');
            } else {
                $valeurs[$champ] = $valeur;  // tableau associatif
            }
            
            // :actif
            $marqueurs[] = ":$champ";
            }
        }
        // var_dump($champs, $valeurs, $marqueurs);
        $strChamps = implode(', ', $champs);
        $strMarqueurs = implode(', ', $marqueurs);
        // var_dump($strChamps, $strMarqueurs);

        return $this->runQuery("INSERT INTO $this->table ($strChamps) VALUES ($strMarqueurs)", $valeurs);
    }

    /**
     * Méthode de mise à jour d'un objet en BDD
     *
     * @return \PDOStatement|null
     */
    public function update(): ?\PDOStatement
    {
        // Requête SQL à faire :
        // "UPDATE articles SET titre = :titre, 
        // description = :description WHERE id = :id"

        // Initialiser les tableaux vides pour récupérer les données
        $champs = [];
        $valeurs = [];
        
        // On boucle sur l'objet pour récupérer tous les champs et les valeurs
        foreach($this as $champ => $valeur) {
            if($valeur !== null && $champ !== 'table' && $champ !== 'id'){
                // actif
                $champs[] = "$champ = :$champ";
                
                // ['actif' => true]
                if(gettype($valeur) === 'boolean'){
                    $valeurs[$champ] = (int) $valeur;  // tableau associatif
                } elseif (gettype($valeur) === 'array'){
                    $valeurs[$champ] = json_encode($valeur);
                } elseif($valeur instanceof \DateTime) {
                    $valeurs[$champ] = date_format($valeur, 'Y-m-d H:i:s');
                } else {
                    $valeurs[$champ] = $valeur;  // tableau associatif
                }
            }
        }
        /** @var UserModel|ArticleModel $this */
        $valeurs['id'] = $this->id;

        $strChamps = implode(', ', $champs);
        
        return $this->runQuery("UPDATE $this->table SET $strChamps WHERE id = :id", $valeurs);
    }

    /**
     * Méthode de suppression d'une entrée en BDD
     *
     * @return \PDOStatement|null
     */
    public function delete(): ?\PDOStatement
    {
        /** @var UserModel|ArticleModel $this */
        if($this->image) {
            $this->deleteImage(ROOT . "/public/images/$this->table/$this->image");
        }
        
        return $this->runQuery("DELETE FROM $this->table WHERE id = :id", ['id' => $this->id]);
    }

    /**
     * Méthode d'upload d'une image
     *
     * @param array $image Superglobal $_FILES
     * @param boolean $remove Si on veut supprimer une image déjà existante
     * @return string|boolean Si ok, retourne le nom de l'image, sinon retourne false
     */
    public function uploadImage(array $image, bool $remove = false): string|bool
    {
        if(!empty($image['name']) && $image['error'] === 0) {
            if($image['size'] <= 10000000) {
                $fileInfo = pathInfo($image['name']);
                $extension = $fileInfo['extension'];
                $extensionAllowed = ['jpeg','jpg', 'png', 'gif', 'svg','wepb'];

                if(in_array($extension, $extensionAllowed)){
                    $nom = $fileInfo['filename'] . date_format(new DateTime, 'Y-m-d_H_i_s') . '.' . $extension;
                    
                    if(!is_dir(ROOT . "/public/images/$this->table")) {
                        mkdir(ROOT . "/public/images/$this->table");
                    }

                    move_uploaded_file($image['tmp_name'], ROOT . "/public/images/$this->table/$nom");
                    
                    if($remove) {
                        /** @var UserModel|ArticleModel $this */
                        $this->deleteImage(ROOT . "/public/images/$this->table/$this->image");
                    }

                    return $nom;
                }
            }
        }

        return false;
    }

    /**
     * Méthode de suppression d'une image
     *
     * @param string $path
     * @return boolean
     */
    public function deleteImage(string $path): bool
    {
        if(file_exists($path)) {
            unlink($path);

            return true;  // arrête l'execution de la fonction s'il arrive ici
        }
        return false;
    }

    /**
     * Méthode d'hydratation d'un objet à partir d'un tableau associatif
     *   $donnees = [
     *         'titre' => "Titre de l'objet",
     *         'description' => "Desc",
     *         'actif' => true,
     *      ];
     * 
     *    RETOURNE :
     *      $article->setTitre('Titre de l'objet')
     *              ->SetDescription('Desc')
     *              ->SetActif(true);
     *
     * @param array|object $donnees
     * @return self
     */
    public function hydrate(array|object $donnees): self
    {
        // On parcourt le tableau de données
        foreach($donnees as $key => $valeur){
            // On récupère les setters
            $setter = 'set' . ucfirst($key);  // ucfirst = mettre la première lettre en majuscule
            
            // On vérifie que la méthode existe
            if(method_exists($this, $setter)) {
                // $this->setTitre('Test')
                $this->$setter($valeur);
            }
        }

        return $this;
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