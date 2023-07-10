<?php

namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Route;
use App\Form\ArticleForm;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    #[Route('/admin/articles', 'admin.articles', ['GET', 'POST'])]
    public function article(): void
    {
        $this->isAdmin();
        $articles = (new ArticleModel())->findAll();

        $_SESSION['token'] = bin2hex(random_bytes(35));

        $this->render('Backend/Articles/index.php', [
            'articles' => $articles,
        ]);
    }

    #[Route('/admin/articles/create', 'admin.articles.create', ['GET', 'POST'])]
    public function create(): void
    {
        // On vérifie l'admin
        $this->isAdmin();

        // Instance du formulaire
        $form = new ArticleForm();

        // Validation du form
        if($form->validate($_POST, ['titre', 'description'])){
            // Nettoyage des données
            $titre = strip_tags($_POST['titre']);
            $description = strip_tags($_POST['description']);
            $actif = isset($_POST['actif']) ? true : false;

            // On envoie en BDD
            (new ArticleModel())
            ->setTitre($titre)
            ->setDescription($description)
            ->setActif($actif)
            ->setUserId($_SESSION['LOGGED_USER']['id'])
            ->create()
            ;
            $_SESSION['messages']['success'] = "Article créé avec succès";

            header('Location: /admin/articles');
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_SESSION['messages']['error'] = "Veuillez remplir tous les champs obligatoires";

        }

        // Vue
        $this->render('Backend/Articles/create.php', [
            'form' => $form->create(),
        ]);
    }

    #[Route('/admin/articles/edit/([0-9]+)', 'admin.articles.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        echo "Page de modification de l'article avec l'id : $id";
    }
}