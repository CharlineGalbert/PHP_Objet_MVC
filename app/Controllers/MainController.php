<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Route;
use App\Models\ArticleModel;

class MainController extends Controller
{
    #[Route('/', 'homepage', ['GET'])]
    public function homepage(): void
    {
        $articles = (new ArticleModel())->findBy(['actif'=> true]);

        $this->render('/Frontend/Main/index.php', [
            'articles' => $articles,
            'titlePage' => "Page d'accueil"
        ]);
    }
}