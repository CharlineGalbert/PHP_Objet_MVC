<?php

use App\Autoloader;
use App\Models\ArticleModel;

require_once './Autoloader.php';

Autoloader::register();

// $articleModel = new ArticleModel();
// var_dump($articleModel->find(1));

$article = (new ArticleModel())
    ->setTitre('Mon super Article')
    ->setDescription('Un super Article')
    ->setCreatedAt(new \DateTime())
    ->setActif(false);

// $article->create($article);
var_dump($article->findAll());