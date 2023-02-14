-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 12 déc. 2022 à 17:07
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pub_g4`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `ordre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `ordre`) VALUES
(1, 'Entrées', 1),
(2, 'Plats principaux', 2),
(3, 'Desserts', 3);

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions_infolettre`
--

CREATE TABLE `inscriptions_infolettre` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `courriel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

CREATE TABLE `plats` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`id`, `nom`, `description`, `prix`, `image`, `categorie_id`) VALUES
(1, 'Salade du jour', 'Fermentum lacinia lorem amet sit. Nunc et ipsum ut nisl ultricies vestibulum sit amet quis nisi. Fusce dignissim magna eu ante tincidunt consectetur.', 10.99, 'public/uploads/salade_du_jour.jpg', 1),
(2, 'Potage du moment', 'Fermentum lacinia lorem amet sit. Nunc et ipsum ut nisl ultricies vestibulum sit amet quis nisi. Fusce dignissim magna eu ante tincidunt consectetur.', 8.99, 'public/uploads/potage_du_moment.jpg', 1),
(3, 'Ailes de lapin', 'Ut interdum viverra lacinia. Pellentesque ac nunc a nulla rutrum dictum ac ac diam. Cras vel justo ligula.  Proin ut ex et elit dapibus tempus vitae vitae magna. Nam a arcu sed ante efficitur semper.', 16.49, 'public/uploads/ailes_lapin.jpg', 1),
(4, 'Calamar', 'Proin ut ex et elit dapibus tempus vitae vitae magna. Nam a arcu sed ante efficitur semper. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 16.99, 'public/uploads/calamar.jpg', 1),
(5, 'Nachos', 'Nunc et ipsum ut nisl ultricies fermentum lacinia lorem amet sit. Nunc et ipsum ut nisl ultricies vestibulum sit amet quis nisi. Fusce dignissim magna eu ante tincidunt consectetur.', 18.99, NULL, 1),
(6, 'Poutine', 'Morbi tincidunt fermentum lacinia. Nunc et ipsum ut nisl ultricies vestibulum sit amet quis nisi. Fusce dignissim magna eu ante tincidunt consectetur.', 14.99, NULL, 1),
(7, 'Burger double classique avec frites', 'Deux galettes de bœuf, cheddar, bacon, tomate, laitue romaine, ognon rouge, sauce maison, servi avec frites', 15.99, 'public/uploads/burger.jpg', 2),
(8, 'Filets de poulet avec frites', 'Filets de poulet pané avec un mélange d’épices maison, servis avec frites', 13.99, 'public/uploads/filets_de_poulet.jpg', 2),
(9, 'Burger au poulet', 'Morbi tincidunt fermentum lacinia. Nunc et ipsum ut nisl ultricies vestibulum sit amet quis nisi.', 15.99, NULL, 2),
(10, 'Salade grecque', 'Donec at nisi tortor. Interdum et malesuada fames ac ante ipsum primis in faucibus. In vitae rutrum arcu.', 15.99, 'public/uploads/salade_grecque.jpg', 2),
(11, 'Salade végétarienne', 'Donec et neque quis purus cursus mattis eu pulvinar velit. Praesent commodo rutrum nisl, at ultrices sem iaculis tincidunt. Nunc molestie accumsan porta. ', 14.99, NULL, 2),
(12, 'Tartare de bœuf', 'Proin faucibus quam lorem, non condimentum turpis blandit non. ', 24.99, 'public/uploads/tartare_boeuf.jpg', 2),
(13, 'Tartare de légume', 'Etiam ut tincidunt lectus. Curabitur gravida est in finibus ultricies. Vestibulum volutpat erat vel libero ultrices placerat.', 22.99, 'public/uploads/tartare_legume.jpg', 2),
(14, 'Côtes levées (Ribs)', 'Etiam dictum purus justo, at mattis justo bibendum in. In aliquam elementum enim, quis pretium purus efficitur ac. Curabitur in pretium leo.', 19.99, NULL, 2),
(15, 'Un bon p’tit steak', 'Praesent aliquam a dolor eu rutrum. Sed at efficitur enim. Morbi quis placerat risus. Aenean ipsum massa, hendrerit eu molestie sit amet, mollis quis ante.', 14.99, NULL, 2),
(16, 'Brownie', 'Vestibulum vel ex dolor. Maecenas et turpis nibh. Aliquam in imperdiet tortor. Interdum et malesuada fames ac ante ipsum primis in faucibus.', 7.99, 'public/uploads/brownie.jpg', 3),
(17, 'Cupcake style ferrero', 'Suspendisse id fringilla turpis. Aenean eleifend vulputate lacus, a pharetra metus. Sed eget pharetra sem. Proin tristique fringilla urna id pharetra. Vivamus sed pellentesque orci.', 8.99, 'public/uploads/cupcake_ferrero.jpg', 3),
(18, 'Gâteau au fromage et caramel', 'Proin tristique fringilla urna id pharetra. Vivamus sed pellentesque orci.', 10.99, 'public/uploads/gateau_fromage_caramel.jpg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `types_utilisateurs`
--

CREATE TABLE `types_utilisateurs` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `types_utilisateurs`
--

INSERT INTO `types_utilisateurs` (`id`, `type`) VALUES
(1, 'administrateur'),
(2, 'régulier');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `courriel` varchar(255) NOT NULL,
  `mot_de_passe` varchar(100) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `prenom`, `nom`, `courriel`, `mot_de_passe`, `type`) VALUES
(1, 'Gaston', 'Leclient', 'gaston.leclient@outlook.com', '$2y$10$1wPzBoirIzWpIrKRiiHK3.HwbMw9wchLpgarlhLe1x.cfPGjdOgri', 1),
(2, 'Patricia', 'Massie', 'patricia.massie@outlook.com', '$2y$10$VI37H3IDTxRMjmszMjYmmeNSvNctwCUs0tQgA1Pl8R3iyeNZmzBHW', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inscriptions_infolettre`
--
ALTER TABLE `inscriptions_infolettre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courriel` (`courriel`);

--
-- Index pour la table `plats`
--
ALTER TABLE `plats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `types_utilisateurs`
--
ALTER TABLE `types_utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courriel` (`courriel`),
  ADD KEY `type_utilisateur` (`type`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `inscriptions_infolettre`
--
ALTER TABLE `inscriptions_infolettre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `plats`
--
ALTER TABLE `plats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `types_utilisateurs`
--
ALTER TABLE `types_utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `plats`
--
ALTER TABLE `plats`
  ADD CONSTRAINT `plats_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`type`) REFERENCES `types_utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
