<?php

namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Route;
use App\Form\UserForm;
use App\Models\UserModel;

class UserController extends Controller
{
    #[Route('/admin/users', 'admin.users', ['GET', 'POST'])]
    public function index(): void
    {
        $this->isAdmin();

        // $users = (new UserModel())->findAll();

        $_SESSION['token'] = bin2hex(random_bytes(35));

        $this->render('Backend/Users/index.php', [
            'users' => (new UserModel())->findAll(),
        ]);
    }

    #[Route('/admin/users/edit/([0-9]+)', 'admin.users.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        $this->isAdmin();

        $user = (new UserModel)->find($id);

        if(!$user){
            $_SESSION['messages']['error'] = "Utilisateur non trouvé";

            http_response_code(404);

            header('Location: /admin/users');
            exit();
        }

        $user = (new UserModel)->hydrate($user); //pour avoir accès aux méthodes de la class UserModel

        $form =  new UserForm($user);

        if($form->validate($_POST, ['nom', 'prenom','email','roles'])){
          
            $nom = strip_tags($_POST['nom']);
            $prenom = strip_tags($_POST['prenom']);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $roles = $_POST['roles'];


            if($email) {
                /** @var UserModel $user */
                $user
                    ->setNom($nom)
                    ->setPrenom($prenom)
                    ->setEmail($email)
                    ->setRoles("[\"$roles\"]")
                    ->update();
                
                $_SESSION['messages']['success'] = "Utilisateur modifié avec succès";
                
                header('Location: /admin/users');
                exit();
            } else {
                $_SESSION['messages']['error'] = "Veuillez rentrer un email valide";
            }
            
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

        $user = (new UserModel())->find(isset($_POST['id']) ? $_POST['id'] : 0);  // objet standard (stdClass)

        if($user && hash_equals($_SESSION['token'], $_POST['token'])){
            $user = (new UserModel())
            ->hydrate($user)  // objet de la class UserModel
            ->delete();

            $_SESSION['messages']['success'] = "Utilisateur supprimé avec succès";   
            
            header('Location: /admin/users');
            exit();
        } else {
            $_SESSION['messages']['error'] = "Utilisateur non trouvé ou token invalide";

            header('Location: /admin/users');
            exit();
        }
    }
}