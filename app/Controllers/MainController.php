<?php

namespace App\Controllers;

use App\Core\Route;

class MainController
{
    #[Route('/', 'homepage', ['GET'])]
    public function homepage(): void
    {
        echo "Page d'accueil";
    }
}