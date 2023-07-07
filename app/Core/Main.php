<?php
namespace App\Core;

class Main
{
    public function __construct(
        private Routeur $routeur = new Routeur(),
    ){
    }

    private function initRouter():void
    {
        // On veut récupérer dynamiquement tous less fichiers
        // dans le dossier Controllers
        $files = glob(\dirname(__DIR__) . "/Controllers/*.php"); // on récupère tous les fichiers qui ont l'extension .php dans le dossier Controllers
        
        // On récupère tous les fichiers placés dans un sous-dossier du dossier Controllers
        $files = array_merge_recursive(glob(\dirname(__DIR__) . "/Controllers/**/*.php"), $files);  // pour fusionner le 2eme tableau $files avec le précédant - ceuli-ci permet de récup. les fichiers .php dans les sous dossiers de Controllers

        // var_dump($files);

        // On boucle sur tous les chemins de fichiers Controllers
        foreach($files as $file){
            //On retire le 1er '/'
            $file = substr($file, 1);

            // On veut remplacer les / par des \
            $file = str_replace('/', '\\', $file);

            // On enlève l'extension .php
            $file = substr($file, 0, -4);  // on part de la fin et on enlève 4 caractères
            
            // On met 'app' avec A majuscule
            $file = ucfirst($file);
            
            // On stock tous les namespaces dans un tableau pour boucler dessus
            $classes[] = $file;
        }
        // var_dump($classes);

        // On boucle sur toutes les classes qu'on a récupérées et on récup. les méthodes
        foreach($classes as $class){
            $methods = get_class_methods(new $class());
            // var_dump($methods);

            //On boucle sur chaque méthode
            foreach($methods as $method){
                // On récupère dans un tableau tous les attributs PHP 8 de chaque méthode
                $attributes = (new \ReflectionMethod($class, $method))->getAttributes(Route::class);  // permet de récupérer toutes les infos sur une méthode
                // var_dump($attributes);

                // On boucle sur le tableau d'attribut PHP 8
                foreach($attributes as $attribute){
                    // On crée une Instance de la classe Route
                    $route = $attribute->newInstance();

                    // On définit le controller de la route (LA CLASS)
                    $route->setController($class);

                    // On définit la méthode
                    $route->setAction($method);
                    // var_dump($route);
                    
                    // On ajoute la route dans le tableau de routes
                    $this->routeur->addRoute([
                        'url' => $route->getUrl(),
                        'nom' => $route->getNom(),
                        'methods' => $route->getMethods(),
                        'controller' => $route->getController(),
                        'action' => $route->getAction(),
                    ]);
                }
            }
        }
    }

    public function start()
    {
        session_start();

        // On retire le trailing /
        $uri = $_SERVER['REQUEST_URI'];

        // On vérifie que l'uri n'est pas vide et qu'elle se termine par un "/"
        if(!empty($uri) && $uri !== '/' && $uri[-1] === '/'){
            $uri = substr($uri, 0, -1); // On enlève le "/"

            http_response_code(301);

            header('Location: ' . $uri);

            exit();
        }

        $this->initRouter();

        $this->routeur->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}