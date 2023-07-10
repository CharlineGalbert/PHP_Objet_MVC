<?php

namespace App\Form;

use App\Core\Form;
use App\Models\UserModel;

class UserForm extends Form
{
    public function __construct(UserModel $user)
    {
        $this
            ->startForm('POST', '#', [
                'class' => 'form card p-3 w-75 mx-auto'
            ])
            ->startDiv(['class' => 'row mb-3'])
            ->startDiv(['class' => 'col-md-6'])
            ->addLabel('nom', "Nom :", ['class' => 'form-label'])
            ->addInput('text', 'nom', [
                'class' => 'form-control',
                'id' => 'nom',
                'placeholder' => 'Doe',
                'value' => $user->getNom(),
            ])
            ->endDiv()
            ->startDiv(['class' => 'col-md-6'])
            ->addLabel('prenom', "Prénom :", ['class' => 'form-label'])
            ->addInput('text', 'prenom', [
                'class' => 'form-control',
                'id' => 'prenom',
                'placeholder' => 'John',
                'value' => $user->getPrenom(),
            ])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', "Email :", ['class' => 'form-label'])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'johndoe@exemple.com',
                'value' => $user->getEmail(),
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addSelect('select', 
            [
                'ROLE_USER' => [
                                'label' => 'Utilisateur',
                                // 'attributs' =>  ['selected' => in_array('ROLE_USER',$user->getRoles()) ? true : null]
                            ],
                'ROLE_ADMIN' => [
                                'label' => 'Admin',
                                // 'attributs' =>  ['selected' => in_array('ROLE_ADMIN',$user->getRoles()) ? true : null]
                            ],
                'ROLE_EDITOR' => [
                                    'label' => 'Editeur',
                                    // 'attributs' =>  ['selected' => in_array('ROLE_EDITOR',$user->getRoles()) ? true : null]
                                ]
            ],
            [
                'class' => 'form-control'
            ]
        )
            ->endDiv()
            ->addButton('Modifier', ['class' => 'btn btn-primary'])
            ->endForm()
        ;
    }
}
