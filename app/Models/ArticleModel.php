<?php
namespace App\Models;

class ArticleModel extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $titre = null,
        protected ?string $description = null,
        protected ?\Datetime $created_at = null,
        protected ?bool $actif = null,
        protected ?int $user_id = null,
        protected ?string $image = null,
        protected ?int $category_id = null,
        )
    {
        $this->table = 'articles';
    }

    /**
     * Méthode pour récupérer la catégorie d'un article
     *
     * @return object|boolean
     */
    public function getCategory(): object|bool
    {
        $sql = "SELECT c.* FROM categories c JOIN $this->table a ON c.id = a.category_id WHERE a.id = $this->id";  // mettre un marqueur à la place de $this->id

        return $this->runQuery($sql)->fetch();
    }

    /**
     * Méthode pour récupérer un nombre limité d'articles triés du plus récent au plus ancien (created_at)
     *
     * @param integer $limit Nombre d'articles à récupérer
     * @param boolean|null $active Si true, renvoie les articles actifs
     * @return array
     */
    public function findWithLimit(int $limit, ?bool $active = false): array
    {
        $sql = "SELECT * FROM $this->table";

        $valeurs = [];

        if($active) {
                $sql .= " WHERE actif = :actif";
                $valeurs['actif'] = true;
        }

        $sql .= " ORDER BY created_at DESC LIMIT :limit";
        $valeurs['limit'] = $limit;

        return $this->runQuery($sql, $valeurs)->fetchAll();
    }

        /**
         * Get the value of id
         *
         * @return ?int
         */
        public function getId(): ?int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @param ?int $id
         *
         * @return self
         */
        public function setId(?int $id): self
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of titre
         *
         * @return ?string
         */
        public function getTitre(): ?string
        {
                return $this->titre;
        }

        /**
         * Set the value of titre
         *
         * @param ?string $titre
         *
         * @return self
         */
        public function setTitre(?string $titre): self
        {
                $this->titre = $titre;

                return $this;
        }

        /**
         * Get the value of description
         *
         * @return ?string
         */
        public function getDescription(): ?string
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @param ?string $description
         *
         * @return self
         */
        public function setDescription(?string $description): self
        {
                $this->description = $description;

                return $this;
        }

        /**
         * Get the value of created_at
         *
         * @return ?\Datetime
         */
        public function getCreatedAt(): ?\Datetime
        {
                return $this->created_at;
        }

        /**
         * Set the value of created_at
         *
         * @param ?\Datetime $created_at
         *
         * @return self
         */
        public function setCreatedAt(?\Datetime $created_at): self
        {
                $this->created_at = $created_at;

                return $this;
        }

        /**
         * Get the value of actif
         *
         * @return ?bool
         */
        public function getActif(): ?bool
        {
                return $this->actif;
        }

        /**
         * Set the value of actif
         *
         * @param ?bool $actif
         *
         * @return self
         */
        public function setActif(?bool $actif): self
        {
                $this->actif = $actif;

                return $this;
        }

        /**
         * Get the value of user_id
         *
         * @return ?int
         */
        public function getUserId(): ?int
        {
                return $this->user_id;
        }

        /**
         * Set the value of user_id
         *
         * @param ?int $user_id
         *
         * @return self
         */
        public function setUserId(?int $user_id): self
        {
                $this->user_id = $user_id;

                return $this;
        }

        /**
         * Get the value of image
         *
         * @return ?string
         */
        public function getImage(): ?string
        {
                return $this->image;
        }

        /**
         * Set the value of image
         *
         * @param null|string|array $image
         *
         * @return self
         */
        public function setImage(null|string|array $image): self
        {
                if($image && is_array($image)) {
                        $imageName = $this->uploadImage($image, $this->image ? true : false);
                } elseif (is_string($image)) {
                        $imageName = $image;
                } else {
                        $imageName = null;
                }
                $this->image = $imageName;

                return $this;
        }

        /**
         * Get the value of category_id
         *
         * @return ?int
         */
        public function getCategoryId(): ?int
        {
                return $this->category_id;
        }

        /**
         * Set the value of category_id
         *
         * @param ?int $category_id
         *
         * @return self
         */
        public function setCategoryId(?int $category_id): self
        {
                $this->category_id = $category_id;

                return $this;
        }
}