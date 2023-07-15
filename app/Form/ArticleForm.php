<?php

namespace App\Form;

use App\Core\Form;
use App\Models\ArticleModel;
use App\Models\CategoryModel;

class ArticleForm extends Form
{
    public function __construct(?ArticleModel $article = null)
    {
        $category = new CategoryModel();
        $activesCategories = $category->getActivesCategories();

        // préparation du tabelau d'options pour le addselect
        $tabActivesCategories = [];

        foreach ($activesCategories as $cat) {
            $tabActivesCategories[$cat->id] = [
                'label' => $cat->nom,
                'attributs' =>  ['selected' => $article ? ($article->getCategoryId() == $cat->id ? true : null) : null]
            ];
        }

        // if article->getCat == inactive => rajouter dans tableau cette cat

        $this
        ->startForm('POST', '#', [
            'class' => 'form card p-3 w-75 mx-auto',
            'enctype' => 'multipart/form-data',
            ])
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('titre', "Titre :", ['class' => 'form-label'])
        ->addInput('text', 'titre', [
            'class' => 'form-control',
            'placeholder' => 'Titre de votre article',
            'id' => 'titre',
            'required' => true,
            'value' => $article ? $article->getTitre() : null,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('description', "Description :", ['class' => 'form-label'])
        ->addTextarea('description', $article ? $article->getDescription() : '', [
            'class' => 'form-control',
            'id' => 'description',
            'placeholder' => 'Description de votre article',
            'rows' => 5,
            'required' => true,
        ])
        ->endDiv()
        ->startDiv(['class' => 'mb-3'])
        ->addLabel('image', "Image :", ['class' => 'form-label'])
        ->addInput('file', 'image', [
            'class' => 'form-control',
        ])
        ->endDiv()
        // ternaire dans un ternaire
        ->addImage($article ? ($article->getImage() ? "/images/articles/{$article->getImage()}" :  null) : null,[
            'class' => 'img-fluid rounded mt-2 img-form-preview',
            'loading' => "lazy",
            'alt' => $article ? ($article->getImage() ? $article->getTitre() : null) : null,
        ])
        ->startDiv(['class' => 'mb-3'])
            ->addLabel('roles', "Catégorie :", ['class' => 'form-label'])
            ->addSelect('roles', $tabActivesCategories,
            [
                'class' => 'form-control'
            ]
        )
        ->endDiv()
        ->startDiv(['class' => 'mb-3 form-check'])
        ->addInput('checkbox', 'actif', [
            'class' => 'form-check-input',
            'id' => 'actif',
            'checked' => $article ? $article->getActif() : false
        ])
        ->addLabel('actif', "Actif", ['class' => 'form-check-label'])
        ->endDiv()
        ->addButton($article ? 'Modifier' : 'Créer', ['class' => 'btn btn-primary'])
        ->endForm()
        ;
    }
}