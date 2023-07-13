<?php

namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Route;
use App\Models\CategoryModel;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryModel $categoryModel = new CategoryModel
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

    #[Route('/admin/categories', 'admin.categories', ['GET', 'POST'])]
    public function read(): void
    {
        $this->isAdmin();
        
        $categories = $this->categoryModel->findAll();

        $_SESSION['token'] = bin2hex(random_bytes(35));

        $this->render('Backend/Categories/index.php', [
            'categories' => $categories,
        ]);
    }
}