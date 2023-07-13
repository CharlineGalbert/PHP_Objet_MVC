<?php
namespace App\Models;

class CategoryModel extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $nom = null,
        protected ?bool $actif = null,
        protected ?\Datetime $created_at = null,
    )
    {
        $this->table = 'categories';
    }

    public function getArticlesFromCategory(int $categoryId): array
    {
        // "SELECT * FROM articles WHERE category_id = 2"
        $sql = "SELECT a.*, c.nom FROM articles a JOIN categories c ON a.category_id = c.id WHERE category_id = $categoryId ";
        return $this->runQuery($sql)->fetchAll();
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
         * Get the value of nom
         *
         * @return ?string
         */
        public function getNom(): ?string
        {
                return $this->nom;
        }

        /**
         * Set the value of nom
         *
         * @param ?string $nom
         *
         * @return self
         */
        public function setNom(?string $nom): self
        {
                $this->nom = $nom;

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
}
    