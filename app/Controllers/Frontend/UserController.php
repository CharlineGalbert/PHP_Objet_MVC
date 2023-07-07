<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Route;
use App\Form\LoginForm;
use App\Models\UserModel;

class UserController extends Controller
{
    #[Route('/login', 'app.user.login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = new LoginForm();

        // On vérifie que le formulaire est soumis et valide
        if($form->validate($_POST, ['email', 'password'])) {
            // Je noettoie mes données
            $email = strip_tags($_POST['email']);
            $password = $_POST['password'];

            // On cherche si l'email existe en BDD
            $user = (new UserModel())->findByEmail($email);

            if($user && password_verify($password, $user->password)) {
                $_SESSION['LOGGED_USER'] = [
                    'id' => $user->id,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'email' => $user->email,
                ];

                header('Location: /');
                exit();
            } else {
                $_SESSION['messages']['error'] = 'Identifiants invalides';
            }
        }
        
        $this->render('Frontend/login.php', [
            'form' => $form->create(),
        ]);
    }
}