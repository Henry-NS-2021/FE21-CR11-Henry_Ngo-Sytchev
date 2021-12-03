-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Nov 2021 um 15:28
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `fswd14_cr11_petadoption_henryngosytchev`
--
CREATE DATABASE IF NOT EXISTS `fswd14_cr11_petadoption_henryngosytchev` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fswd14_cr11_petadoption_henryngosytchev`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `animals`
--

CREATE TABLE `animals` (
  `animal_id` int(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `breed` varchar(50) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `size` float DEFAULT NULL,
  `age` float DEFAULT NULL,
  `hobbies` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `animals`
--

INSERT INTO `animals` (`animal_id`, `name`, `breed`, `picture`, `location`, `description`, `size`, `age`, `hobbies`) VALUES
(1, 'Johnny', 'Terrier', 'logo_pets.jpg', 'Kerntnerstrasse 13/23', 'Dummy data', 34.85, 2.15, 'Play freesbee'),
(2, 'Josie', 'Chausie Cat', 'chausie.jpg', 'Am Tabor 2/12', 'Elegant Cat', 21, 5, 'Spying on neighbours'),
(3, 'Kallen', 'elkhound', 'elkhound.jpg', 'Praterstrasse 235/5/4', 'Mountain dog who loves hiking', 56.7, 14, 'Reading newspapers'),
(4, 'Snoop', 'Rottweiler', 'rottweiler.jpg', 'Tierengasse 54/7', 'The Rottweiler is a robust working breed of great strength descended from the mastiffs of the Roman legions. A gentle playmate and protector within the family circle, the Rottie observes the outside world with a self-assured aloofness. A male Rottweiler will stand anywhere from 24 to 27 muscular inches at the shoulder; females run a bit smaller and lighter. The glistening, short black coat with smart rust markings add to the picture of imposing strength. A thickly muscled hindquarters powers the Rottie\'s effortless trotting gait. A well-bred and properly raised Rottie will be calm and confident, courageous but not unduly aggressive. The aloof demeanor these world-class guardians present to outsiders belies the playfulness, and downright silliness, that endear Rotties to their loved ones. (No one told the Rottie he\'s not a toy breed, so he is liable plop onto your lap for a cuddle.) Early training and socialization will harness a Rottie\'s territorial instincts in a positive way.\r\n', 37.15, 1.6, '-love swimming\r\n- walking, and trotting... especially with MY people\r\n'),
(5, 'Ali', 'Borzoi', 'borzoi.jpg', 'Tierengasse 54/7', 'Among the most impressively beautiful of all dogs, the aristocratic Borzoi is cherished for his calm, agreeable temperament. In full stride, he is a princely package of strength, grace, and glamour flying by at 35 to 40 miles per hour. Borzoi are large, elegant sighthounds. A mature male stands at least 28 inches at the shoulder and weighs 75 to 105 pounds. Females will be smaller. Beneath the luxurious silky coat, Borzoi construction follows the ancient Greyhound template. One known as the Russian Wolfhound, Borzoi were bred to be swift and tough enough to pursue and pin their ferocious lupine quarry. In their quiet, catlike way they can be stubborn, and training is best accomplished with patience, consistency, and good humor. Affectionate family dogs, Borzoi are nonetheless a bit too dignified to wholeheartedly enjoy a lot of roughhousing. The sight of a cat or squirrel on the run will quickly stir their pursuit instinct, and fenced-in running room is a must.', 31.4, 1.8, '- Chase anything that moves\r\n- Any dog sports\r\n'),
(6, 'Siami', 'Shih Tzu', 'shihtzu.jpg', 'Tierengasse 54/7', 'That face! Those big dark eyes looking up at you with that sweet expression! It\'s no surprise that Shih Tzu owners have been so delighted with this little \'Lion Dog\' for a thousand years. Where Shih Tzu go, giggles and mischief follow. Shi Tsu (pronounced in the West \'sheed-zoo\' or \'sheet-su\'; the Chinese say \'sher-zer\'), weighing between 9 to 16 pounds, and standing between 8 and 11 inches, are surprisingly solid for dogs their size. The coat, which comes in many colors, is worth the time you will put into it\'¿few dogs are as beautiful as a well-groomed Shih Tzu. Being cute is a way of life for this lively charmer. The Shih Tzu is known to be especially affectionate with children. As a small dog bred to spend most of their day inside royal palaces, they make a great pet if you live in an apartment or lack a big backyard. Some dogs live to dig holes and chase cats, but a Shih Tzu\'s idea of fun is sitting in your lap acting adorable as you try to watch TV.\r\n', 22.7, 8.5, '- Watch TV series\r\n- Short walks\r\n'),
(7, 'Hunter', 'Giant Schnauzer', 'schnauzer.jpg', 'Tierengasse 54/7', 'The Giant Schnauzer is a larger and more powerful version of the Standard Schnauzer, and he should, as the breed standard says, be a \'bold and valiant figure of a dog.\' Great intelligence and loyalty make him a stellar worker and companion. A well-bred Giant Schnauzer closely resembles the Standard Schnauzer\'¿only bigger. As their name suggests, Giants are imposing. A male might stand as high as 27.5 inches at the shoulder and weigh 95 pounds. The muscular, substantial body is, as the breed\'s fanciers put it, a \'bold and valiant figure of a dog.\' The double coat is either solid black or \'pepper and salt.\' Familiar characteristics of the Mini, Standard, and Giant are a harsh beard and eyebrows, accentuating a keen, sagacious expression.\r\n', 70.2, 10, '- Watch out for the house at night\r\n- Run in forest\r\n- Work out with my owner\r\n'),
(8, 'Gondalf', 'Norwegian Elkhound', 'elkhound.jpg', 'Vierbeinen Weg 4/1', 'The Norwegian Elkhound is a robust spitz type known for his lush silver-gray coat and dignified but friendly demeanor. The durable Elkhound is among Europe\'s oldest dogs. They sailed with the Vikings and figure in Norse art and legend. Norwegian Elkhounds are hardy, short-bodied dogs standing about 20 inches at the shoulder. They have a dense silver-gray coat and a tail curling tightly over the back. The deep chest, sturdy legs, and muscular thighs belong to a dog built for an honest day\'s work. The eyes are a dark brown and the ears mobile and erect. Overall, an Elkhound is the picture of an alert and steadfast dog of the north. Elkhounds are famously fine companions and intelligent watchdogs. Agility and herding trials are good outlets for their natural athleticism and eagerness. Reserved until introductions are made, an Elkhound is a trustworthy friend ever after. These strong, confident dogs are truly sensitive souls, with a dash of houndy independence.\r\n', 47.3, 3, 'Hiking the mountains'),
(9, 'Speedy', 'Azawakh', 'azawakh.jpg', 'Vierbeinen Weg 4/1', '\"Tall and elegant, the Azawakh is a West African sighthound who originates from the countries of Burkina Faso, Mali, and Niger. The Azawakh has a short, fine coat which may come in any color or color combinations: red, clear sand to fawn, brindled, parti-color (which may be predominantly white), blue, black and brown. The head may have a black mask and there may be white markings on the legs, bib and at the tip of tail. There are no color or marking disqualifications in the breed. Befitting its heritage, the Azawakh excels as a companion, guardian and a lure courser in the United States.\r\n\r\nThis ancient hunting hound is so lean and rangy that his bone structure and musculature can plainly be seen beneath his skin. The smooth S-shaped contours, deep chest, and aerodynamic head mark the Azwakh as a member of the sighthound family, canine sprinters that rely on keen vision and blazing speed to fix and course their prey. The ultrafine coat comes in several colors and patterns. The overall look of this leggy hound is one of elegance and fineness, but don\'t be fooled: This is a tough, durable hunter who\'s been chasing gazelle across the scorching sands of the Sahara for more than a thousand years.\"\r\n', 69.9, 9.8, 'Running, running, running and runnin. LOVE running!'),
(10, 'Pooky', 'American Bobtail Cat', 'bobtail.jpg', 'Zooland 5', '\"I am is renowned for its friendly, almost doglike personality as well as its wild appearance. Also I do have wild ancestors, but no worries, my behavior is fully domesticated ;).\r\n\r\nIt is also said that I am highly intelligent, with a reputation for being talkative. In addition, I developed wide vocabularies that include a variety of meows, chirps, and purrs.\"\r\n', 35, 11.6, 'Playing with pearls\r\n'),
(11, 'Anda', 'Balinese Cat', 'balinese.jpg', 'Zooland 5', '\"While I do not require a special diet, yet I loooove high-quality food with real meat or fish as the first ingredient. Natural diets are beneficial to all felines, and this breed is no exception!\r\n\r\nSince Omega-3 essential fatty acids can help keep the my coat soft, supple, and silky, it’s a good idea to ensure that I \r\n am getting enough, either from my food or from additional supplements.\"\r\n', 25, 2.5, 'Spying on the neighborhood through the window\r\n'),
(12, 'Jolly', 'Chausie Cat', 'chausie.jpg', 'Familienplatz 1', '\"If the Chausie cat reminds you of an extra-large Abyssinian, you\'re on the right track! These incredible felines were developed by crossing jungle cats – also known as swamp cats or reed cats – from Southeast Asia with domesticated Abyssinians.\r\n\r\nWeighing in at up to 30 pounds, Chausies are among the largest domesticated cats in existence. As a hybrid, every Chausie cat is a unique individual, with a big personality to matChausie it\'s size. Chausie cats develop strong bonds with their families and do not like to be left alone.\"\r\n', 26.8, 1, '- Hunting mice and insects\r\n- Climing trees\r\n'),
(13, 'Walim', 'Bombay Cat', 'bombay.jpg', 'Familienplatz 1', 'Stunning looks and an intriguing personality make the Bombay cat a charming addition to any household. These medium-sized shorthair cats are absolutely gorgeous thanks to their pure black coats and their brilliant copper-colored eyes.\r\n', 34.2, 4.2, 'Playing with anything what rolls\r\n');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `adoption_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `adoption_status` enum('not adopted','adopted') NOT NULL DEFAULT 'not adopted',
  `adoption_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` int(20) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_status` enum('adm','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `picture`, `password`, `user_status`) VALUES
(1, 'Gary', 'Holmes', 'gholmes@mail.at', 675602558, 'Passeti Strasse 32/2/8', 'avatar.png', '123123', 'user'),
(2, 'Helmut', 'Kohler', 'hkohler@mail.at', 660502165, 'Handelskai 9/4/36', 'avatar.png', '123123', 'user'),
(3, 'Joshua', 'Smith', 'jsmith@mail.at', 665502465, 'Am Tabor 63/7', 'avatar.png', '123123', 'user'),
(4, 'Laura', 'Leroux', 'lleroux@mail.at', 669653265, 'Wienzeile 5/14', 'avatar.png', '123123', 'user'),
(5, 'Aleksandar', 'Vuk', 'avuk@mail.at', 675978546, 'Kangranerweg 11a', 'avatar.png', '123123', 'user'),
(6, 'Viktoria', 'Retti', 'vretti@mail.at', 685055232, 'Kettenbruekegasse 2/2/21', 'avatar.png', '123123', 'user'),
(7, 'Alina', 'Comu', 'acomu@mail.at', 674856584, 'Innsbruker Alee 4b', 'avatar.png', '123123', 'user'),
(8, 'Jaqueline', 'Cimpinard', 'jcimpinard@mail.at', 665555886, 'Meidlingerstrasse 241/5', 'avatar.png', '123123', 'user'),
(9, 'Malik', 'Wahed', 'mwahed@mail.at', 662565696, 'Grinzingergasse 51b/1/6', 'avatar.png', '123123', 'user'),
(10, 'Yasmina', 'Alabov', 'yalabov@mail.at', 650223589, 'Am Spitz 6/4', 'avatar.png', '123123', 'user');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`animal_id`);

--
-- Indizes für die Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`adoption_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `animals`
--
ALTER TABLE `animals`
  MODIFY `animal_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `adoption_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `animals` (`animal_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
