<?php
namespace App\Core;

class Main
{
    public function __construct(
        private Routeur $router = new Routeur(),
    ){
    }

    private function initRouter():void
    {
    }

    public function start(){
        // On retire le trailing /
        $uri = $_SERVER['REQUEST_URI'];

        // On vérifie que l'uri n'est pas vide et qu'elle se termine par un "/"
        if(!empty($uri) && $uri !== '/' && $uri[-1] === '/'){
            $uri = substr($uri, 0, -1); // On enlève le "/"

            http_response_code(301);

            header('Location: ' . $uri);

            exit();
        }

        $this->router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}