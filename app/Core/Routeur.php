<?php

namespace App\Core;

class Routeur
{
    public function __construct(
        private array $routes = []
    ){
    }

    public function addRoute(array $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    public function handleRequest(string $url, string $method): void
    {
        // On parcourt le tableau de routes pour vérifier si
        // l'url du navigateur correspond à l'url d'une route existante
        foreach($this->routes as $route){
            // On vérifie que l'url du navigateur match avec l'url d'une
            // route existante
            // On vérifie également que la méthode est autorisée sur la route
            // preg_match => pour vérifier le regex de l'url
            if(preg_match("#^" . $route['url'] . "$#", $url, $matches) && in_array($method, $route['methods'])){
                // On récupère le controller de la route
                $controllerName = $route['controller'];

                // On récupère l'action
                $actionName = $route['action'];

                // On instancie le controller
                $controller = new $controllerName();

                // On récupère seulement les paramètres potentiels
                $matches = array_slice($matches, 1);  // on récup. le tableau matches et on garde à partir de l'index 1
                // var_dump($matches);

                // On éxecute la méthode du controller pour afficher la page
                // ArticleController->edit();
                $controller->$actionName(...$matches); //... récupère toutes les valeurs du tableau $matches
                
                return;
            }
        }
        http_response_code(404);
        echo "Page non trouvée";
    }
}