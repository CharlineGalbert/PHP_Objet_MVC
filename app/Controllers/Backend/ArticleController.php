<?php

namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Route;
use App\Form\ArticleForm;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleModel $articleModel = new ArticleModel
    ) {
    }

    #[Route('/admin/articles', 'admin.articles', ['GET', 'POST'])]
    public function article(): void
    {
        $this->isAdmin();

        $articles = $this->articleModel->findAll();

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
            $this->articleModel
            ->setTitre($titre)
            ->setDescription($description)
            ->setActif($actif)
            ->setUserId($_SESSION['LOGGED_USER']['id'])
            ->setImage($_FILES['image'])
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
        $this->isAdmin();

        $article = $this->articleModel->find($id);

        if(!$article){
            $_SESSION['messages']['error'] = "Article non trouvé";

            header('Location: /admin/articles');
            exit();
        }

        $article = $this->articleModel->hydrate($article);

        $form =  new ArticleForm($article);

        if($form->validate($_POST, ['titre', 'description'])){
          
            $titre = strip_tags($_POST['titre']);
            $description = strip_tags($_POST['description']);
            $actif = isset($_POST['actif']) ? true : false;
            
            /** @var ArticleModel $article */
            $article
                ->setTitre($titre)
                ->setDescription($description)
                ->setActif($actif)
                ->setImage(!empty($_FILES['image']['name']) ? $_FILES['image'] : null)
                ->update();
            
            $_SESSION['messages']['success'] = "Article modifié avec succès";
            
            header('Location: /admin/articles');
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_SESSION['messages']['error'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('Backend/Articles/edit.php', [
            'article' => $article,
            'form' => $form->create(),
        ]);
    }

    #[Route('/admin/articles/delete', 'admin.articles.delete', ['POST'])]
    public function delete(): void
    {
        $this->isAdmin();

        $article = $this->articleModel->find(isset($_POST['id']) ? $_POST['id'] : 0);

        if($article && hash_equals($_SESSION['token'], $_POST['token'])){
            $article = $this->articleModel
            ->hydrate($article)
            ->delete();

            $_SESSION['messages']['success'] = "Article supprimé avec succès";   
            
            header('Location: /admin/articles');
            exit();
        }

        $_SESSION['messages']['error'] = "Article non trouvé ou token invalide";

        header('Location: /admin/articles');
        exit();
    }

    #[Route('/admin/articles/switch/([0-9]+)', 'admin.articles.switch', ['GET'])] // le numero de l'url est récup/et passé en paramètre dans $id de la fonction 
    public function switch(int $id): void
    {
        $this->isAdmin();

        $article = $this->articleModel->find($id);

        if(!$article) {
            http_response_code(404);
            echo json_encode([
                'data' => [
                    'status' => 'Error',
                    'message' => 'Article non trouvé, veuillez vérifier l\'id',
                ]
            ]);

            return;
        }

        $article = $this->articleModel->hydrate($article);
        
        /** @var ArticleModel $article */
        $article
            ->setActif(!$article->getActif()) // i.e toggle
            ->update();
        
        http_response_code(201);

        echo json_encode([
            'data' => [
                'status' => 'Success',
                'message' => 'Article modifié',
                'actif' => $article->getActif(),
            ]
        ]);

        return; // ou exit();
    }
}