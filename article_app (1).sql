-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2022 at 09:33 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `article_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `uid` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bday` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`uid`, `first_name`, `last_name`, `email_address`, `password`, `bday`, `gender`, `street`, `city`, `state`, `zip_code`, `profile_pic`) VALUES
(1, 'Teddy', 'Enaje', 'teddymarccastillo.enaje@bicol-u.edu.ph', '7815696ecbf1c96e6894b779456d330e', '2022-04-04', 'male', 'prieto', 'gubat', 'sorsogon', '4710', 'user_1650268212.jpg'),
(3, 'John', 'Doe', 'john.doe@gmail.com', '6579e96f76baa00787a28653876c6127', '2002-07-30', 'male', 'street', 'city', 'sorsogon', '4700', 'user_1949077564.png'),
(4, 'Ross', 'Cordova', 'ross.cordova@gg.com', 'edeee8f93fded5d72328f773125fb118', '1996-12-31', 'female', 'majoha', 'sorsogon', 'sorsogon', '4700', 'user_1649077576.png'),
(10, 'qwe', 'rty', 'qwerty@gg.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', '0000-00-00', 'none', '', '', '', '', 'user_1651037771.png'),
(21, 'Johnny', 'Depp', 'testemail@gg.com', '098f6bcd4621d373cade4e832627b4f6', '2021-02-13', 'female', 'street5', 'sorsogon', 'sorsogon', '4700', 'user_1652420232.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `contents` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `photo_headline` varchar(255) NOT NULL,
  `author_uid` int(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `contents`, `category_id`, `photo_headline`, `author_uid`, `date_created`) VALUES
(15, 'Developing a web based using PHP', '\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultricies, dui eu pulvinar pellentesque, nunc risus sodales augue, sed vestibulum diam est vel enim. Fusce commodo mattis neque at fermentum. Nulla id neque a lacus dignissim bibendum. Aliquam erat volutpat. Nulla facilisi. Nulla vel nulla a sapien commodo imperdiet. Aliquam tincidunt auctor felis, eu feugiat quam blandit vel. In eleifend auctor nulla, ut pulvinar odio egestas in. Curabitur dui urna, laoreet at arcu laoreet, ullamcorper lobortis nunc. Sed at ornare justo, et vehicula risus. Donec nec leo sed mauris consequat vestibulum a vitae nisl.\r\n\r\nDuis et aliquet quam. Phasellus sollicitudin suscipit enim, ac dictum nisl rhoncus sed. Nam fermentum tellus ac metus aliquet, at varius justo dignissim. Maecenas maximus, leo at euismod sollicitudin, dolor quam porta justo, ut efficitur dui sem ut nunc. Nulla dignissim consectetur maximus. Morbi pharetra ipsum mauris, eu convallis enim efficitur non. Donec sodales fermentum tortor fringilla laoreet. Ut quis ligula ut ex suscipit vehicula.\r\n\r\nMorbi nisi justo, aliquet eu malesuada sed, consectetur ac nisl. Maecenas consequat consequat commodo. Nunc pharetra maximus pellentesque. Ut vulputate porttitor erat eu vestibulum. Duis lacinia, tortor vitae mollis porta, elit libero facilisis sapien, non dictum mauris sem quis metus. Morbi ultrices arcu id est mattis, molestie tincidunt leo dictum. Aenean a lorem lacinia, pharetra est id, eleifend ligula. Cras finibus nibh a malesuada fermentum.\r\n\r\nQuisque ultricies purus in turpis sollicitudin, sit amet imperdiet ligula molestie. Sed ac metus nec lacus placerat elementum. Integer sit amet ultricies tellus. Morbi volutpat venenatis justo sed feugiat. Aliquam tincidunt, ante ac facilisis consequat, tortor dui iaculis mi, eu lacinia neque sem quis leo. Mauris vel vestibulum velit, ac interdum nisi. Nulla dignissim, nulla ac pellentesque eleifend, dui dui ornare lacus, a luctus est purus sit amet neque. Ut felis lectus, sodales et sem ut, ultrices commodo orci. Cras molestie lorem et eros ornare, vel tempor nunc pulvinar. Vivamus dolor justo, tincidunt eu arcu eget, pharetra luctus nibh. Fusce scelerisque semper rutrum. Curabitur maximus quam orci, at lacinia neque euismod eget. Fusce mollis lectus a mauris volutpat sollicitudin. Sed finibus ullamcorper purus eu finibus. Integer ac nisi eu ipsum elementum finibus. Proin efficitur iaculis urna, nec venenatis elit volutpat ac.', 7, 'art_1650268299.png', 3, '2022-04-18 00:00:00'),
(18, 'My First Article', 'Duis et aliquet quam. Phasellus sollicitudin suscipit enim, ac dictum nisl rhoncus sed. Nam fermentum tellus ac metus aliquet, at varius justo dignissim. Maecenas maximus, leo at euismod sollicitudin, dolor quam porta justo, ut efficitur dui sem ut nunc. Nulla dignissim consectetur maximus. Morbi pharetra ipsum mauris, eu convallis enim efficitur non. Donec sodales fermentum tortor fringilla laoreet. Ut quis ligula ut ex suscipit vehicula.\r\n\r\nMorbi nisi justo, aliquet eu malesuada sed, consectetur ac nisl. Maecenas consequat consequat commodo. Nunc pharetra maximus pellentesque. Ut vulputate porttitor erat eu vestibulum. Duis lacinia, tortor vitae mollis porta, elit libero facilisis sapien, non dictum mauris sem quis metus. Morbi ultrices arcu id est mattis, molestie tincidunt leo dictum. Aenean a lorem lacinia, pharetra est id, eleifend ligula. Cras finibus nibh a malesuada fermentum.\r\n\r\nQuisque ultricies purus in turpis sollicitudin, sit amet imperdiet ligula molestie. Sed ac metus nec lacus placerat elementum. Integer sit amet ultricies tellus. Morbi volutpat venenatis justo sed feugiat. Aliquam tincidunt, ante ac facilisis consequat, tortor dui iaculis mi, eu lacinia neque sem quis leo. Mauris vel vestibulum velit, ac interdum nisi. Nulla dignissim, nulla ac pellentesque eleifend, dui dui ornare lacus, a luctus est purus sit amet neque. Ut felis lectus, sodales et sem ut, ultrices commodo orci. Cras molestie lorem et eros ornare, vel tempor nunc pulvinar. Vivamus dolor justo, tincidunt eu arcu eget, pharetra luctus nibh. Fusce scelerisque semper rutrum. Curabitur maximus quam orci, at lacinia neque euismod eget. Fusce mollis lectus a mauris volutpat sollicitudin. Sed finibus ullamcorper purus eu finibus. Integer ac nisi eu ipsum elementum finibus. Proin efficitur iaculis urna, nec venenatis elit volutpat ac.', 8, 'art_1650269863.jpg', 4, '2022-04-18 00:00:00'),
(24, 'dasdasd', 'dasd', 7, 'art_1651040277.png', 10, '2022-04-27 14:17:57'),
(26, 'test\'s test', 'asd asd asedqw asd q3wedasd ', 8, 'art_1652420120.png', 3, '2022-05-13 13:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `articles_category`
--

CREATE TABLE `articles_category` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles_category`
--

INSERT INTO `articles_category` (`id`, `category`) VALUES
(7, 'Technology'),
(8, 'Programming');

-- --------------------------------------------------------

--
-- Table structure for table `articles_comments`
--

CREATE TABLE `articles_comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `commentor_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_edited` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles_comments`
--

INSERT INTO `articles_comments` (`id`, `article_id`, `commentor_id`, `comment`, `date_created`, `is_edited`) VALUES
(17, 15, 3, 'nice article!', '2022-05-13 05:47:47', 0),
(18, 15, 3, 'This comment is Edited', '2022-05-13 05:56:15', 1),
(22, 15, 21, 'hola', '2022-05-13 07:36:03', 0),
(23, 26, 21, 'Goods ah', '2022-05-13 07:37:38', 0),
(25, 18, 3, 'Very informative article! Thank you..', '2022-05-18 11:24:56', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_uid` (`author_uid`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `articles_category`
--
ALTER TABLE `articles_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles_comments`
--
ALTER TABLE `articles_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commentor_id` (`commentor_id`),
  ADD KEY `article_id` (`article_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `articles_category`
--
ALTER TABLE `articles_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `articles_comments`
--
ALTER TABLE `articles_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_uid`) REFERENCES `accounts` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `articles_comments`
--
ALTER TABLE `articles_comments`
  ADD CONSTRAINT `articles_comments_ibfk_1` FOREIGN KEY (`commentor_id`) REFERENCES `accounts` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_comments_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
