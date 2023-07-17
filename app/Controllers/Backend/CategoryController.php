<?php

namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Route;
use App\Form\CategorieForm;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryModel $categoryModel = new CategoryModel  // propriété
    ) {
    }

    // #[Route('/admin/categories/articles', 'admin.categories.articles', ['GET', 'POST'])]
    // public function category(): void
    // {
    //     $this->isAdmin();
        
    //     $articles = $this->categoryModel->getArticlesFromCategory(6);
    //     // var_dump($articles);
    //     $_SESSION['token'] = bin2hex(random_bytes(35));

    //     $this->render('Backend/Categories/index.php', [
    //         'articles' => $articles,
    //     ]);
    // }

    #[Route('/admin/categories', 'admin.categories', ['GET', 'POST'])]  // pas besoin de methode POST ici (car on ne soumet pas de formulaire en méthode POST sur cette page)
    public function read(): void
    {
        $this->isAdmin();
        
        $categories = $this->categoryModel->findAll();

        $_SESSION['token'] = bin2hex(random_bytes(35));

        $this->render('Backend/Categories/index.php', [
            'categories' => $categories,
        ]);
    }
    
    #[Route('/admin/categories/create', 'admin.categories.create', ['GET', 'POST'])]
    public function create(): void
    {
        // On vérifie l'admin
        $this->isAdmin();

        // Instance du formulaire
        $form = new CategorieForm();

        // Validation du form
        if($form->validate($_POST, ['nom'])){
            // Nettoyage des données
            $nom = strip_tags($_POST['nom']);
            $actif = isset($_POST['actif']) ? true : false;
            // On envoie en BDD
            $this->categoryModel
            ->setNom($nom)
            ->setActif($actif)
            ->create()
            ;
            $_SESSION['messages']['success'] = "Catégorie créée avec succès";
           
            http_response_code(301);  // redirection permanente

            header('Location: /admin/categories');
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_SESSION['messages']['error'] = "Veuillez remplir tous les champs obligatoires";
        }

        // Vue
        $this->render('Backend/Categories/create.php', [
            'form' => $form->create(),  // permet de renvoyer le form en HTML
        ]);
    }

    #[Route('/admin/categories/edit/([0-9]+)', 'admin.categories.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        $this->isAdmin();

        $category = $this->categoryModel->find($id);  // on récupère un obj de type standard avec la fonction "find"

        if(!$category){
            $_SESSION['messages']['error'] = "Catégorie non trouvée";

            http_response_code(404);

            header('Location: /admin/categories');
            exit();
        }

        $category = $this->categoryModel->hydrate($category);  // pour récupérer un obj de type categoryModel (et plus un obj standard)

        $form =  new CategorieForm($category);  // on passe $category en paramètre du form pour récupérer les infos de l'objet et pourvoir pré-remplir les champs du formulaire

        if($form->validate($_POST, ['nom'])){
            $nom = strip_tags($_POST['nom']);
            $actif = isset($_POST['actif']) ? true : false;
            
            /** @var CategoryModel $category */
            $category
                ->setNom($nom)
                ->setActif($actif)
                ->update();
            
            $_SESSION['messages']['success'] = "Catégorie modifiée avec succès";
            
            http_response_code(301);

            header('Location: /admin/categories');
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_SESSION['messages']['error'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('Backend/Categories/edit.php', [
            'form' => $form->create(),
        ]);
    }

    #[Route('/admin/categories/delete', 'admin.categories.delete', ['POST'])]
    public function delete(): void
    {
        $this->isAdmin();

        $category = $this->categoryModel->find(isset($_POST['id']) ? $_POST['id'] : 0);

        if($category && hash_equals($_SESSION['token'], $_POST['token'])){
            $category = $this->categoryModel
            ->hydrate($category)
            ->delete();

            $_SESSION['messages']['success'] = "Catégorie supprimée avec succès";   
            
            header('Location: /admin/categories');
            exit();
        }

        $_SESSION['messages']['error'] = "Catégorie non trouvée ou token invalide";

        header('Location: /admin/categories');
        exit();
    }

    #[Route('/admin/categories/switch/([0-9]+)', 'admin.categories.switch', ['GET'])] // le numero de l'url est récup/et passé en paramètre dans $id de la fonction 
    public function switch(int $id): void
    {
        $this->isAdmin();

        $category = $this->categoryModel->find($id);

        if(!$category) {
            http_response_code(404);
            echo json_encode([
                'data' => [
                    'status' => 'Error',
                    'message' => 'Catégorie non trouvée, veuillez vérifier l\'id',
                ]
            ]);

            return;
        }

        $category = $this->categoryModel->hydrate($category);
        
        /** @var CategoryModel $category */
        $category
            ->setActif(!$category->getActif()) // i.e toggle
            ->update();
        
        http_response_code(201);

        echo json_encode([
            'data' => [
                'status' => 'Success',
                'message' => 'Catégorie modifiée',
                'actif' => $category->getActif(),
            ]
        ]);

        return; // ou exit();
    }
    
}