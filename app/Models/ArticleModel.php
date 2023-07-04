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
        )
    {
        $this->table = 'articles';
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
}