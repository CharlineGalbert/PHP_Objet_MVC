<?php

namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Route;
use App\Form\RegisterForm;
use App\Form\UserForm;
use App\Models\UserModel;

class UserController extends Controller
{
    #[Route('/admin/users', 'admin.users', ['GET', 'POST'])]
    public function user(): void
    {
        $this->isAdmin();

        $users = (new UserModel())->findAll();

        $_SESSION['token'] = bin2hex(random_bytes(35));

        $this->render('Backend/Users/index.php', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/users/edit/([0-9]+)', 'admin.users.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        $this->isAdmin();

        $user = (new UserModel)->find($id);

        if(!$user){
            $_SESSION['messages']['error'] = "Utilisateur non trouvé";

            header('Location: /admin/users');
            exit();
        }

        $user = (new UserModel)->hydrate($user);

        $form =  new UserForm($user);

        if($form->validate($_POST, ['nom', 'prenom','email'])){
          
            $nom = strip_tags($_POST['nom']);
            $prenom = strip_tags($_POST['prenom']);
            $email = strip_tags($_POST['email']);
            
            /** @var UserModel $user */
            $user
                ->setNom($nom)
                ->setPrenom($prenom)
                ->setEmail($email)
                ->update();
            
            $_SESSION['messages']['success'] = "Utilisateur modifié avec succès";
            
            header('Location: /admin/users');
            exit();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_SESSION['messages']['error'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('Backend/Users/edit.php', [
            'user' => $user,
            'form' => $form->create(),
        ]);
    }

    #[Route('/admin/users/delete', 'admin.users.delete', ['POST'])]
    public function delete(): void
    {
        $this->isAdmin();

        $user = (new UserModel())->find(isset($_POST['id']) ? $_POST['id'] : 0);

        if($user && hash_equals($_SESSION['token'], $_POST['token'])){
            $user = (new UserModel())
            ->hydrate($user)
            ->delete();

            $_SESSION['messages']['success'] = "Utilisateur supprimé avec succès";   
            
            header('Location: /admin/users');
            exit();
        }

        $_SESSION['messages']['error'] = "Utilisateur non trouvé ou token invalide";

        header('Location: /admin/users');
        exit();
    }
}