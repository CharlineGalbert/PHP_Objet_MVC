<?php

use App\Autoloader;
use App\Models\ArticleModel;
use App\Models\UserModel;

require_once './Autoloader.php';

Autoloader::register();

$user = (new UserModel())
    ->setNom('Bertrand')
    ->setPrenom('Pierre')
    ->setEmail('pierre@test.com')
    ->setPassword(password_hash('Test1234', PASSWORD_ARGON2I));

$user->create($user);

// $articleModel = new ArticleModel();
// var_dump($articleModel->find(1));

// $article = new ArticleModel();
    // ->setTitre('Mon super Article')
    // ->setDescription('Un super Article')
    // ->setCreatedAt(new \DateTime())
    // ->setActif(false);

// $article->delete(5);

// $article
//     ->setTitre('Nouveau Titre');
// $article->update(4, $article);

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