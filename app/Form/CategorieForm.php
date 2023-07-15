<?php

namespace App\Form;

use App\Core\Form;
use App\Models\CategoryModel;

class CategorieForm extends Form
{
    public function __construct(?CategoryModel $category = null)
    {
        $this
        ->startForm('POST', '#', [
            'class' => 'form card p-3 w-75 mx-auto',
            ])
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('nom', "Nom :", ['class' => 'form-label'])
        ->addInput('text', 'nom', [
            'class' => 'form-control',
            'placeholder' => 'Titre de la catégorie',
            'id' => 'nom',
            'required' => true,
            'value' => $category ? $category->getNom() : null,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3 form-check'])
        ->addInput('checkbox', 'actif', [
            'class' => 'form-check-input',
            'id' => 'actif',
            'checked' => $category ? $category->getActif() : false
        ])
        ->addLabel('actif', "Actif", ['class' => 'form-check-label'])
        ->endDiv()
        ->addButton($category ? 'Modifier' : 'Créer', ['class' => 'btn btn-primary'])
        ->endForm()
        ;
    }
}