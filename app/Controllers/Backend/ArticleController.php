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
    
}