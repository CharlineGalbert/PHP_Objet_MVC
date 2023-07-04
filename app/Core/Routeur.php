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
            if($url === $route['url'] && in_array($method, $route['methods'])){
                // On récupère le controller de la route
                $controllerName = $route['controller'];

                // On récupère l'action
                $actionName = $route['action'];

                // On instancie le controller
                $controller = new $controllerName();

                // On éxecute laméthode du controller pour afficher la page
                $controller->$actionName();

                return;
            }

            http_response_code(404);
            echo "Page non trouvée";
        }
    }
}