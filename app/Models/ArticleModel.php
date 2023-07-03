<?php
namespace App\Models;

class ArticleModel extends Model
{
    public function __construct()
    {
        $this->table = 'articles';
    }
}