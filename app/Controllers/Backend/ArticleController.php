<?php

namespace App\Controllers\Backend;

use App\Core\Route;

class ArticleController
{
    #[Route('/admin/articles', 'admin.articles', ['GET', 'POST'])]
    public function article(): void
    {
        echo "Page admin article";
    }

    #[Route('/admin/articles/edit/([0-9]+)', 'admin.articles.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        echo "Page de modification de l'article avec l'id : $id";
    }
}