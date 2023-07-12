<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Core\Route;
use App\Form\LoginForm;
use App\Form\RegisterForm;
use App\Models\UserModel;

class UserController extends Controller
{
    public function __construct(
        private UserModel $userModel = new UserModel
    ){ 
    }

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
            $user = $this->userModel->findByEmail($email);

            if($user && password_verify($password, $user->password)) {
                $_SESSION['LOGGED_USER'] = [
                    'id' => $user->id,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'email' => $user->email,
                    'roles' => json_decode($user->roles ?: "[]"),
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

    #[Route('/logout', 'app.user.logout', ['GET'])]
    public function logout(): void
    {
        unset($_SESSION['LOGGED_USER']);
        
        header('Location: /');
        exit();
    }

    #[Route('/register', 'app.user.register', ['GET', 'POST'])]
    public function register(): void
    {
        $form = new RegisterForm();

        if($form->validate($_POST, ['nom', 'prenom', 'email', 'password'])){
            // Nettoyer des données
            $nom = strip_tags($_POST['nom']);
            $prenom = strip_tags($_POST['prenom']);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_ARGON2I);

            if($email){
                $this->userModel
                    ->setNom($nom)
                    ->setPrenom($prenom)
                    ->setEmail($email)
                    ->setPassword($password)
                    ->create();
                
                $_SESSION['messages']['success'] = "Vous êtes bien inscrit à notre application";

                header('Location: /login');
                exit();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['messages']['error'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('Frontend/register.php', [
            'form' => $form->create(),
        ]);
    }
}