<?php

use App\Autoloader;
use App\Models\ArticleModel;

require_once './Autoloader.php';

Autoloader::register();

$articleModel = new ArticleModel();

var_dump($articleModel->find(1));