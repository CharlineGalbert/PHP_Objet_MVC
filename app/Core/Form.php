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
     * Méthode de génération d'un balise d'ouverture HTML de div
     *
     * @param array $attributs Tableau associatif avec les attributs HTML et les valeurs
     * @return self
     */
    public function startDiv(array $attributs = []): self
    {
        $this->formCode .= "<div";

        // On ajoute les attributs HTML potentiels
        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '>' : '>';

        return $this;
    }

    /**
     * Méthode de génération de balise de fermeture HTML de div
     *
     * @return self
     */
    public function endDiv(): self
    {
        $this->formCode .= '</div>';

        return $this;
    }

    /**
     * Méthode de génération HTML de balise label
     *
     * @param string $for
     * @param string $text
     * @param array $attributs
     * @return self
     */
    // <label for='toto' class="form-label"> Toto </label>
    public function addLabel(string $for, string $text, array $attributs = []): self
    {
        $this->formCode .= "<label for=\"$for\"";

        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '>' : '>';

        $this->formCode .= "$text</label>";

        return $this;
    }

    // <input type="text" name="toto" class="toto"/>
    /**
     * Méthode de génération d'une balise HTML input
     *
     * @param string $type
     * @param string $name
     * @param array $attributs
     * @return self
     */
    public function addInput(string $type, string $name, array $attributs = []): self
    {
        $this->formCode .= "<input type=\"$type\" name=\"$name\"";

        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '/>' : '/>';
        
        return $this;
    }

    /**
     * Méthode de génération HTML de la balise button
     *
     * @param string $text
     * @param array $attributs
     * @return self
     */
    public function addButton(string $text, array $attributs = []): self
    {
        $this->formCode .= "<button type=\"submit\"";

        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '>' : '>';

        $this->formCode .= "$text</button>";

        return $this;
    }

    /**
     * Méthode de génération d'une balise HTML textarea
     *
     * @param string $name
     * @param string $value
     * @param array $attributs
     * @return self
     */
    // <textarea name="toto">Tfzfgkg</texarea>
    public function addTextarea(string $name, string $value = '', array $attributs = []): self
    {
        $this->formCode .= "<textarea name=\"$name\"";

        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '>' : '>';

        $this->formCode .= "$value</textarea>";

        return $this;
    }

    /**
     * Méthode de génération de balise HTML select
     *
     * @param string $name
     * @param array $options
     * @param array $attributs
     * @return self
     */
    /* [
            ['ROLE_ADMIN' => [
                'label' => 'Administrateur',
                'attributs' => [
                    'class => 'toto',
                    'checked' => true
                ]
            ],
            ['ROLE_EDITOR' => 'Editeur'],
        ]*/
    public function addSelect(string $name, array $options, array $attributs = []): self
    {
        $this->formCode .= "<select name=\"$name\"";

        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '>' : '>';

        foreach($options as $value => $option){
            $this->formCode .= "<option value=\"$value\"";

            $this->formCode .= isset($option['attributs']) ? $this->addAttributes($option['attributs']) . '>' : '>';
            
            $this->formCode .= "$option[label]</option>";
        }

        $this->formCode .= "</select>";

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
            if($value) {
                if(in_array($attribut, $courts)) {
                    $str .= "$attribut ";
                } else {
                    // On ajoute l'attribut = la valeur
                    $str .= " $attribut='$value'";
                }
            }
        }

        return $str;
    }

    /**
     * Méthode de génération de balise HTML img
     *
     * @param ?string $path
     * @param array|null $attributs
     * @return self
     */
    public function addImage(?string $path, ?array $attributs = []): self
    {
        $this->formCode .= "<img src=\"$path\"";

        $this->formCode .= $attributs ? $this->addAttributes($attributs) . '>' : '>';

        return $this;
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