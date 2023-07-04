<?php

namespace App\Core;

#[\Attribute]
class Route
{
    public function __construct(
        private ?string $url = null,
        private ?string $nom = null,
        private ?array $methods = ['GET'],
        private ?string $controller = null,
        private ?string $action = null,
    ){

    }

        /**
         * Get the value of url
         *
         * @return ?string
         */
        public function getUrl(): ?string
        {
                return $this->url;
        }

        /**
         * Set the value of url
         *
         * @param ?string $url
         *
         * @return self
         */
        public function setUrl(?string $url): self
        {
                $this->url = $url;

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
         * Get the value of methods
         *
         * @return ?array
         */
        public function getMethods(): ?array
        {
                return $this->methods;
        }

        /**
         * Set the value of methods
         *
         * @param ?array $methods
         *
         * @return self
         */
        public function setMethods(?array $methods): self
        {
                $this->methods = $methods;

                return $this;
        }

        /**
         * Get the value of controller
         *
         * @return ?string
         */
        public function getController(): ?string
        {
                return $this->controller;
        }

        /**
         * Set the value of controller
         *
         * @param ?string $controller
         *
         * @return self
         */
        public function setController(?string $controller): self
        {
                $this->controller = $controller;

                return $this;
        }

        /**
         * Get the value of action
         *
         * @return ?string
         */
        public function getAction(): ?string
        {
                return $this->action;
        }

        /**
         * Set the value of action
         *
         * @param ?string $action
         *
         * @return self
         */
        public function setAction(?string $action): self
        {
                $this->action = $action;

                return $this;
        }
}