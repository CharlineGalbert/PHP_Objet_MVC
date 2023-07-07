<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Route;
use App\Form\LoginForm;

class UserController extends Controller
{
    #[Route('/login', 'app.user.login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = new LoginForm();
        
        $this->render('Frontend/login.php', [
            'form' => $form->create(),
        ]);
    }
}