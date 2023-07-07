<?php

namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Route;
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

    #[Route('/admin/articles/edit/([0-9]+)', 'admin.articles.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        echo "Page de modification de l'article avec l'id : $id";
    }
}