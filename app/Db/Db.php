<?php
// DESIGN PATTERN SINGLETON --> on ne pourra jamais avoir 2 instances de cette classe
namespace App\Db;

class Db extends \PDO
{
    // Instance UNIQUE de la connection en BDD
    // $instance = new Db();
    private static $instance;

    // Constantes avec les informations en BDD
    private const DB_HOST = 'mvc_debut_exo-db-1';
    private const DB_NAME = 'demo_mvc';
    private const DB_USER = 'root';
    private const DB_PASS = 'root';

    public function __construct()
    {
        // DSN de connexion (Data Source Name === URL de la base de données)
        $dsn = 'mysql:dbname='. self::DB_NAME. ';host=' . self::DB_HOST . ';charset=utf8';
        
        try{
            parent::__construct($dsn, self::DB_USER, self::DB_PASS);  // on appelle le constructeur de la classe parent = PDO
            // options
            $this->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');  // caractères spéciaux pris en compte
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);  // pour que PDO renvoie les erreurs eventuelles
            $this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);  // retour des requêtes sous format de tableau associatif
            $this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); // pour gérer le tinyint du champ actif
        
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        // On vérifie si aucune instance n'existe pas déjà
        if(self::$instance === null) {
            // Si elle n'existe pas déjà, on crée l'instance pour 
            //créer la connection en BDD
            self::$instance = new Db();
        }
        // On renvoie l'instance (La connection en BDD)
        return self::$instance;
    }
}