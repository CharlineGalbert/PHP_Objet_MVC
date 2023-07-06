<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Form;
use App\Core\Route;

class UserController extends Controller
{
    #[Route('/login', 'app.user.login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = (new Form())
            ->startForm('POST', '#', [
                'class' => 'form'
            ])
            ->endForm();
        
        var_dump($form->create());
    }
}