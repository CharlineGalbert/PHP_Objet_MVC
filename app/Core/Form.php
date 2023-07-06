<?php
namespace App\Core;

/**
 * Classe de génération automatique de formulaire
 */
class Form
{
    protected string $formCode = '';

    /**
     * Méthode de validation d'un formulaire
     *
     * @param array $form Tableau associatif avec les valeurs soumises ($_POST)
     * @param array $champsObligatoires Tableau à index avec le nom des champs obligatoires
     * @return boolean Retourne false si formulaire invalide sinon true
     */
    public function validate(array $form, array $champsObligatoires): bool
    {
        // On parcourt le tableau de champs obligatoires
        foreach($champsObligatoires as $champ){
            if(!isset($form[$champ]) || empty($form[$champ]) || strlen(trim($form[$champ])) === 0){
                return false;
            }
        }
        return true;
    }

    /**
     * Méthode de génération de la balise d'ouverture HTML du formulaire
     *
     * @param string $method
     * @param string $action
     * @param array $attributs
     * @return self
     */
    public function startForm(string $method = 'POST', string $action = '#', array $attributs = []): self
    {
        $this->formCode .= "<form action=\"$action\" method=\"$method\"";

        // On ajoute les attributs HTML
        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '>' : '>';

        return $this;
    }
    
    /**
     * Méthode de génération de la balise de fermeture HTML du formulaire
     *
     * @return self
     */
    public function endForm(): self
    {
        $this->formCode .= '</form>';

        return $this;
    }

    /**
     * Méthode d'ajout d'attributs HTML
     *
     * @param array $attributs Tableau associatif ex: ['class' => 'form-control', 'required' => true]
     * @return string
     */
    public function addAttributes(array $attributs): string
    {
        // On initialise une chaine de caractères vide
        $str = '';

        // On liste les attributs HTML "courts"
        $courts = ['checked', 'required', 'disabled', 'autofocus', 'readonly', 'multiple', 'novalidate', 'formnovalidate'];

        // On parcourt le tableau d'attribut
        foreach($attributs as $attribut => $value) {
            // Vérification de l'attribut court ou non
            if(in_array($attribut, $courts) && $value == true) {
                $str .= "$attribut ";
            } else {
                // On ajoute l'attribut = la valeur
                $str .= " $attribut='$value'";
            }
        }

        return $str;
    }

   /**
    * Méthode qui renvoie tout le code HTML du formulaire
    *
    * @return string
    */
    public function create(): string
    {
        return $this->formCode;
    }

}