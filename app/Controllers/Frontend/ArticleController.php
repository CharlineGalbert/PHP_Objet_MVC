<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Route;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleModel $articleModel = new ArticleModel
    ){  
    }
    
    #[Route('/articles/details/([0-9]+)', 'app.article.show', ['GET'])]
    public function show(int $id): void
    {
        $article = $this->articleModel->find($id);

        $this->render('Frontend/Articles/show.php', [
            'article' => $article,
        ]);
    }
}