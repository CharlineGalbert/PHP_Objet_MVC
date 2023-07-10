<?php

namespace App\Form;

use App\Core\Form;

class ArticleForm extends Form
{
    public function __construct()
    {
        $this
        ->startForm('POST', '#', ['class' => 'form card p-3 w-75 mx-auto'])
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('titre', "Titre :", ['class' => 'form-label'])
        ->addInput('text', 'titre', [
            'class' => 'form-control',
            'placeholder' => 'Titre de votre article',
            'id' => 'titre',
            'required' => true,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('description', "Description :", ['class' => 'form-label'])
        ->addTextarea('description', '', [
            'class' => 'form-control',
            'id' => 'description',
            'placeholder' => 'Description de votre article',
            'rows' => 5,
            'required' => true,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3 form-check'])
        ->addInput('checkbox', 'actif', [
            'class' => 'form-check-input',
            'id' => 'actif'
        ])
        ->addLabel('actif', "Actif :", ['class' => 'form-check-label'])
        ->endDiv()
        ->addButton('Créer', ['class' => 'btn btn-primary'])
        ->endForm()
        ;
    }
}