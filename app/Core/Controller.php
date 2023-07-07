<?php

namespace App\Core;

abstract class Controller  // classe abstraite -> elle ne peut pas être instanciée
{
    protected function render(string $template, array $data)
    {
        
        // On extrait toutes les valeurs du tableau en créant une variable par entrée du tableau
        extract($data);  // tranforme la clé du tableau associatif en variable avec le meme nom que la clé

        // var_dump($articles);
        
        // On démarre le buffer de sortie (on met la suite dans le buffer)
        ob_start(); // pour avoir le contenu de la page après la navbar
        require_once ROOT . '/Views/' . $template; // idem
        $contenu = ob_get_clean();  // idem (on vide le buffer de sortie et on récupère ce qu'on avait mis dedans dans la variable $contenu)

        require_once ROOT . '/Views/base.php';
    }
    /**
     * Méthode de vérification si utilisateur admin ou non
     * 
     * @return void
     */
    protected function isAdmin(): void
    {
        if(!isset($_SESSION['LOGGED_USER']) || !in_array('ROLE_ADMIN', $_SESSION['LOGGED_USER']['roles'])){
            $_SESSION['messages']['error'] =  "Vous n'avez pas les droits";

            header('Location: /login');
            exit();
        };
    }
}