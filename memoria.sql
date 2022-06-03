SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `memoria`
--
DROP DATABASE IF EXISTS `memoria`;
CREATE DATABASE IF NOT EXISTS `memoria` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `memoria`;

-- --------------------------------------------------------

--
-- Structure de la table `cartes_questions`
--

DROP TABLE IF EXISTS `cartes_questions`;
CREATE TABLE IF NOT EXISTS `cartes_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `matiere` text NOT NULL,
  `question` text NOT NULL,
  `id_paquet` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_paquet` (`id_paquet`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cartes_questions`
--

INSERT INTO `cartes_questions` (`id`, `id_user`, `matiere`, `question`, `id_paquet`) VALUES
(1, 6, 'MathÃ©matiques', 'Vrai ou faux ? Si a divise b, a divise b+c.', 1),
(2, 6, 'Concept infomatique', 'Comment Ã©jecte-on une Ã©lÃ©ment au-dessus d\'une pile p?', 1),
(3, 6, 'Initiation Ã  la programmation', 'Est-ce correct ? Â« A (String a) { this.nom=a+a;} ; A() { this(\"a\");} Â»', 1),
(4, 6, 'Internet et Outils', 'OÃ¹ est-il conseillÃ© de placer le code CSS ?', 1),
(5, 4, 'Internet et Outils', 'Le html...', 2),
(6, 4, 'Initiation Ã  la programmation', 'On souhaite Ã©crire une classe publique A possÃ©dant un attribut \"nom\" de type chaÃ®ne de caractÃ¨res. OÃ¹ convient- il de l\'Ã©crire ?', 2),
(7, 4, 'Initiation Ã  la programmation', 'Que contient chaque case du tableau t crÃ©Ã© par l\'instruction suivante: Â« int t[] = new int[10] Â»', 2),
(8, 4, 'Concept infomatique', 'Combien d\'octet est un int ?', 2),
(9, 4, 'MathÃ©matiques', 'Dans une matrice A n,m , que dÃ©signe le n pour la matrice A ?', 2),
(10, 1, 'geographie', 'La capitale du Japon est:', 3),
(11, 1, 'geographie', 'Quel(s) pays ne partage(nt) pas de frontiÃ¨re avec la France?', 3),
(12, 1, 'geographie', 'Luanda est la capitale ...', 3),
(13, 1, 'geographie', 'Quel(s) pays possÃ¨de(nt) un drapeau Ã  bandes tricolores?', 3),
(14, 1, 'geographie', 'La capitale du Kazakhstan est ?', 3),
(15, 1, 'geographie', 'Combien il y a t-il de pays dont le nom se termine par -stan ?', 3);

-- --------------------------------------------------------

--
-- Structure de la table `cartes_reponses`
--

DROP TABLE IF EXISTS `cartes_reponses`;
CREATE TABLE IF NOT EXISTS `cartes_reponses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT 0,
  `proposition` text NOT NULL,
  `explication` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_question` (`id_question`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cartes_reponses`
--

INSERT INTO `cartes_reponses` (`id`, `id_question`, `correct`, `proposition`, `explication`) VALUES
(1, 1, 1, 'Vrai', NULL),
(2, 1, 0, 'Faux', NULL),
(3, 2, 0, 'p.push()', NULL),
(4, 2, 1, 'p.pop()', NULL),
(5, 2, 0, 'p.empty()', NULL),
(6, 2, 0, 'p.pile()', NULL),
(7, 3, 1, 'Oui', 'C\'est correct !'),
(8, 3, 0, 'Non', NULL),
(9, 4, 0, 'Dans le <body>', NULL),
(10, 4, 0, 'Entre les balises <head>', NULL),
(11, 4, 1, 'Dans un fichier externe utilisable pour plusieurs pages', NULL),
(12, 5, 0, 'Est dÃ©rivÃ© du JavaScript', NULL),
(13, 5, 1, 'Est dÃ©rivÃ© du SGML', NULL),
(14, 5, 0, 'N\'est pas dÃ©rivÃ© mais crÃ©Ã© par le World Wide Web', NULL),
(15, 6, 0, 'Dans un fichier Nom.java', NULL),
(16, 6, 0, 'Dans un fichier a.java', NULL),
(17, 6, 1, 'Dans un fichier A.java', NULL),
(18, 6, 0, 'Dans un fichier A.class', NULL),
(19, 7, 1, 'La valeur 0', NULL),
(20, 7, 0, 'La valeur Â« null Â»', NULL),
(21, 7, 0, 'Rien', NULL),
(22, 7, 0, 'Les entiers de 0 Ã  9', NULL),
(23, 8, 0, '1', NULL),
(24, 8, 0, '2', NULL),
(25, 8, 1, '4', 'Un int est 4 octets'),
(26, 8, 0, '8', NULL),
(27, 9, 1, 'le nombre de lignes', 'n est le nombre de lignes'),
(28, 9, 0, 'le nombre de colonne', NULL),
(29, 10, 0, 'Melbourne', NULL),
(30, 10, 0, 'Ottawa', NULL),
(31, 10, 1, 'Tokyo', NULL),
(32, 10, 0, 'Strasbourg', NULL),
(33, 11, 0, 'BrÃ©sil', NULL),
(34, 11, 0, 'Allemagne', NULL),
(35, 11, 1, 'Pologne', 'On oublie pas l\'Outre-mer !!'),
(36, 11, 1, 'Chine', 'On oublie pas l\'Outre-mer !!'),
(37, 12, 0, ' de l\'IndonÃ©sie', NULL),
(38, 12, 0, 'du Guatemala', NULL),
(39, 12, 0, 'de la Moldavie', NULL),
(40, 12, 1, 'de l\'Angola', 'C\'est un pays en Afrique'),
(41, 13, 1, 'la Lituanie', NULL),
(42, 13, 1, 'la France', NULL),
(43, 13, 0, 'l\'Albanie', NULL),
(44, 13, 0, 'L\'algÃ©rie', NULL),
(45, 14, 0, 'Sofia', NULL),
(46, 14, 0, 'Busan', NULL),
(47, 14, 0, 'Tunis', NULL),
(48, 14, 1, 'Astana', NULL),
(49, 15, 0, '5', NULL),
(50, 15, 0, '6', NULL),
(51, 15, 1, '7', ' Alors dans l\'ordre Ã§a fait: Afghanistan,Kazakhstan,OuzbÃ©kistan,Tadjikistan,TurkmÃ©nistan'),
(52, 15, 0, '8', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `paquets`
--

DROP TABLE IF EXISTS `paquets`;
CREATE TABLE IF NOT EXISTS `paquets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `paquets`
--

INSERT INTO `paquets` (`id`, `nom`, `id_user`) VALUES
(1, 'revise la L1 avec nous ', 6),
(2, 'Encore plus de rÃ©vision', 4),
(3, 'Un petit tour du monde', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `age` int(3) UNSIGNED NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `mdp` text NOT NULL,
  `email` varchar(70) NOT NULL,
  `admin` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `age`, `pseudo`, `mdp`, `email`, `admin`) VALUES
(1, 'NODIN', 'AurÃ©lie', 19, 'aurelieN', '$2y$10$vuvJ.Qxum3rcEnub8LkqBOoR9dOqa/w440krgbUGR23hcBZWymogm', 'aurelie@gmail.com', 1),
(2, 'Doe', 'Jane', 30, 'JaneD', '$2y$10$csvMMOZYoOpm4Uim2aP9gOOfucm9wxOrcBGHptqG3E5XIIcBUONdu', 'Jane@mail.com', 0),
(3, 'Martin', 'Marie', 40, 'MartinMarie', '$2y$10$nN8dNO1mO.ma3EIFWdrpiegKygMveftd..KG/RVy2HoilR6VyfyLW', 'martin@hotmail.fr', 0),
(4, 'MIKIA', 'Benidy', 18, 'benidyM', '$2y$10$HW0W45kqLsRafgdpNJTQWeqL3kLWPvTB5/5/xvbZBIoBPHK01FEM.', 'benidy@gmail.com', 1),
(5, 'MonsieurX', 'MonsieurX', 50, 'supprimezMoi', '$2y$10$RHgQWH5WyWm2SLiUwn0.4eOb4ZV.YR5cK0CYgrIvb3sgS7fbvbVVa', 'monsieurx@yahoo.fr', 0),
(6, 'memoria', 'admin', 100, 'memoriaAdmin', '$2y$10$aM3xMF9q43hbTicTIQuZrO6EP1KUAMXKcQvWx1cmuCPhqB24oRyR6', 'memoria.admin@contact.com', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cartes_questions`
--
ALTER TABLE `cartes_questions`
  ADD CONSTRAINT `fk_id_paquet` FOREIGN KEY (`id_paquet`) REFERENCES `paquets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cartes_reponses`
--
ALTER TABLE `cartes_reponses`
  ADD CONSTRAINT `fk_id_question` FOREIGN KEY (`id_question`) REFERENCES `cartes_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
