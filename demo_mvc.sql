-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : lun. 17 juil. 2023 à 12:13
-- Version du serveur : 8.0.32
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `demo_mvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actif` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `titre`, `description`, `created_at`, `actif`, `user_id`, `image`, `category_id`) VALUES
(1, 'Développeur MVC', 'article sur le design pattern', '2023-07-03 12:55:38', 0, 1, 'plums-3560078_12802023-07-12_12_26_10.jpg', 1),
(2, 'un_titre_', 'une_description', '2023-07-03 13:29:44', 1, 1, 'orange-1117645_12802023-07-12_12_26_32.jpg', 3),
(3, 'Mon Article', 'Un Article', '2023-07-04 08:21:17', 1, 1, 'beach12023-07-12_13_45_44.jpg', 6),
(4, 'Nouveau Titre', 'Un super Article', '2023-07-04 08:23:47', 0, 1, 'beach32023-07-12_13_45_53.jpg', 2),
(6, 'Mon super Article', 'Un super Article', '2023-07-04 11:00:15', 1, 1, 'peach-2632182_12802023-07-12_11_46_44.jpg', 4),
(7, 'Article avec hydratation', 'Description de test', '2023-07-04 09:32:10', 1, 1, 'fruits-1534494_12802023-07-12_11_47_48.jpg', 5),
(10, 'azerty', 'poiu', '2023-07-12 08:24:33', 1, 1, 'beach22023-07-12_14_02_21.jpg', 7),
(13, 'test', 'abc', '2023-07-17 09:50:04', 1, 2, 'blank-gfe59c582e_19202023-07-17_11_51_40.jpg', 2);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `nom` varchar(150) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `actif`, `created_at`) VALUES
(1, 'News', 1, '2023-07-12 14:58:52'),
(2, 'People', 0, '2023-07-13 09:11:34'),
(3, 'Culture', 1, '2023-07-13 11:39:27'),
(4, 'Musique', 0, '2023-07-13 11:39:40'),
(5, 'Sport', 1, '2023-07-13 11:39:59'),
(6, 'IT', 1, '2023-07-13 11:40:18'),
(7, 'Litterature', 1, '2023-07-15 20:26:14'),
(11, 'Actu', 0, '2023-07-17 09:35:09');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `roles`) VALUES
(1, 'Bertrand', 'Pierre', 'pierre@test.com', '$argon2i$v=19$m=65536,t=4,p=1$RnFXQm1xQUFRaFZZOXphYQ$ePAv9B03Vi1nCAbEsnzFihLtCeek0tQvLXF8RsQgt/k', '[\"ROLE_ADMIN\"]'),
(2, 'Meme', 'Moi', 'moi@meme.com', '$argon2i$v=19$m=65536,t=4,p=1$RnFXQm1xQUFRaFZZOXphYQ$ePAv9B03Vi1nCAbEsnzFihLtCeek0tQvLXF8RsQgt/k', '[\"ROLE_ADMIN\"]'),
(7, 'ab', 'cd', 'ab@cd.com', '$argon2i$v=19$m=65536,t=4,p=1$STdVdTNNS29MeGgueDUvbA$2TJqwa9qLJhWcE64BjaWJ4fexouOfgqRqtgIP7bsKBs', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
