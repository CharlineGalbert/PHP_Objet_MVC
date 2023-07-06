<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Route;
use App\Models\ArticleModel;

class ArticleController extends Controller
{
    #[Route('/articles/details/([0-9]+)', 'app.article.show', ['GET'])]
    public function show(int $id): void
    {
        $article = (new ArticleModel())->find($id);

        $this->render('Frontend/Articles/show.php', [
            'article' => $article,
        ]);
    }
}