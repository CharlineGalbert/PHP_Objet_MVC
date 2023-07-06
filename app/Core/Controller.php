<?php

namespace App\Core;

abstract class Controller  // classe abstraite -> elle ne peut pas être instanciée
{
    protected function render(string $template, array $data)
    {
        
        // On extrait toutes les valeurs du tableau en créant une variable par entrée du tableau
        extract($data);  // tranforme la clé du tableau associatif en variable avec le meme nom que la clé

        // var_dump($articles);
        
        // On démarre le buffer de sortie
        ob_start();

        require_once ROOT . '/Views/' . $template;

        $contenu = ob_get_clean();

        require_once ROOT . '/Views/base.php';
    }
}