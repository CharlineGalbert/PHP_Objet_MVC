<?php

use App\Autoloader;
use App\Models\ArticleModel;

require_once './Autoloader.php';

Autoloader::register();

// $articleModel = new ArticleModel();
// var_dump($articleModel->find(1));

$article = new ArticleModel();
    // ->setTitre('Mon super Article')
    // ->setDescription('Un super Article')
    // ->setCreatedAt(new \DateTime())
    // ->setActif(false);


$article
    ->setTitre('Nouveau Titre');
$article->update(4, $article);
// var_dump($article);

// $data = [
//     'titre' => 'Article avec hydratation',
//     'description' => 'Description de test',
//     'actif' => true,
// ];

// $article->hydrate($data);
// var_dump($article);
// $article->create($article);

// $article->create($article);
// var_dump($article->findAll());