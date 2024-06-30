-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2023 at 06:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(2, 'Radhi', '9195f873d1715b7575f88118db6dc42a91137874'),
(3, 'Anton', '2e8c0277e396fabf683e56c8b7fa7e6dad68c679'),
(4, 'Lemon', 'ab165cb90d19598f610a669dfe4798f4cd049a6a'),
(5, 'Kakashi', '667e624fb37408ba37177b3807fafa63c5a8332a'),
(6, 'Temari', '23a0538f53ccbf131a1f79874d3805ac4ed108fc');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 4, 'Alia Smith', 'Brim969@gmail.com', '0114257869', 'I need a refund defect in game'),
(2, 2, 'Marie Doe', 'Raze800@yahoo.com', '0114578246', 'The music album I boaght is missing a track.Please update the album');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 4, 'Alia Smith', '02223344', 'Brim969@gmail.com', 'credit card', '', 'Batman Arkham Knight game (50 x 2) - John Wick Chapter 4 movie (20 x 2) - ', 140, '2023-06-10', 'completed'),
(2, 4, 'Alia Smith', '114478985', 'Brim969@gmail.com', 'credit card', '', 'Batman Arkham Knight game (50 x 1) - John Wick Chapter 4 movie (20 x 1) - ', 70, '2023-06-11', 'pending'),
(3, 4, 'Alia Smith', '114589655', 'Brim969@gmail.com', 'paytm', '', 'Batman Arkham Knight game (50 x 1) - Love Actually movie (24 x 1) - ', 74, '2023-06-11', 'completed'),
(4, 2, 'Marie Doe', '114587895', 'Raze800@yahoo.com', 'paytm', '', 'Divide Album music (9 x 1) - Interstellar movie (30 x 1) - Love Actually movie (24 x 1) - ', 63, '2023-06-11', 'pending'),
(5, 2, 'Marie Doe', '114258785', 'Raze800@yahoo.com', 'paypal', '', '$50 giftcard (50 x 1) - Interstellar movie (30 x 1) - NieR:Automata game (49 x 1) - ', 129, '2023-06-11', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(1, 'Batman Arkham Knight game', 'Batman: Arkham Knight is a 2015 action-adventure game developed by Rocksteady Studios and published by Warner Bros. Interactive Entertainment.', 50, 'batman1.jpg', 'batman2.jpg', 'batman3.jpg'),
(2, 'John Wick Chapter 4 movie', 'With the price on his head ever increasing, legendary hit man John Wick takes his fight against the High Table global as he seeks out the most powerful players in the underworld, from New York to Paris to Japan to Berlin.', 20, 'john1.jpg', 'john2.jpg', 'john3.jfif'),
(3, 'Midnights Album music', 'Midnights is the tenth studio album by American singer-songwriter Taylor Swift, released on October 21, 2022, via Republic Records. It was announced at the 2022 MTV Video Music Awards, marking Swift&#39;s first new body of work since her 2020 indie folk albums, Folklore and Evermore.', 15, 'midnights1.png', 'midnights2.jpg', 'midnights3.png'),
(4, 'Assetto corsa game', 'Assetto Corsa is a sim racing video game developed by the Italian video game developer Kunos Simulazioni. It is designed with an emphasis on a realistic racing experience with support for extensive customization and moddability.', 40, 'Assetto1.png', 'Assetto2.jpg', 'Assetto3.jpg'),
(5, 'Interstellar movie', 'When Earth becomes uninhabitable in the future, a farmer and ex-NASA pilot, Joseph Cooper, is tasked to pilot a spacecraft, along with a team of researchers, to find a new planet for humans.', 30, 'interstellar1.jpg', 'interstellar2.jpg', 'interstellar3.jfif'),
(6, 'Divide Album music', '÷ is the third studio album by English singer-songwriter Ed Sheeran. It was released on 3 March 2017 through Asylum Records and Atlantic Records. &#34;Castle on the Hill&#34; and &#34;Shape of You&#34; were released as the album&#39;s lead singles on 6 January 2017.', 9, 'devide1.jpg', 'devide2.jpg', 'devide3.jpg'),
(7, 'NieR:Automata game', 'Nier: Automata is a 2017 action role-playing game developed by PlatinumGames and published by Square Enix. It is a sequel to Nier, itself a spin-off of and sequel to the Drakengard series.', 49, 'nier1.jfif', 'nier2.jpg', 'nier3.jpg'),
(8, 'Love Actually movie', 'Eight London couples try to deal with their relationships in different ways. Their tryst with love makes them discover how complicated relationships can be.', 24, 'love1.jpg', 'love2.jfif', 'love3.jpg'),
(9, 'Back in Black  Album music', 'Back in Black is the seventh studio album by Australian rock band AC/DC, released by Albert Productions and Atlantic Records on 25 July 1980. It was the band&#39;s first album to feature Brian Johnson as lead singer, following the death of Bon Scott, their previous vocalist.', 33, 'acdc1.png', 'acdc2.jpg', 'acdc3.jpg'),
(10, '$100 giftcard', 'Introducing our exclusive gift card, the perfect present for any occasion! Our gift card is a convenient and versatile choice that guarantees a smile on the face of your loved ones. Whether you&#39;re celebrating a birthday or any other special event, our gift card allows the recipient to choose their ideal gift from our wide selection of top-quality products.', 100, 'giftcard.jpg', 'giftcard.jpg', 'giftcard.jpg'),
(11, '$50 giftcard', 'Introducing our exclusive gift card, the perfect present for any occasion! Our gift card is a convenient and versatile choice that guarantees a smile on the face of your loved ones. Whether you&#39;re celebrating a birthday or any other special event, our gift card allows the recipient to choose their ideal gift from our wide selection of top-quality products.', 50, 'giftcard.jpg', 'giftcard.jpg', 'giftcard.jpg'),
(12, '$25 giftcard', 'Introducing our exclusive gift card, the perfect present for any occasion! Our gift card is a convenient and versatile choice that guarantees a smile on the face of your loved ones. Whether you&#39;re celebrating a birthday or any other special event, our gift card allows the recipient to choose their ideal gift from our wide selection of top-quality products.', 25, 'giftcard.jpg', 'giftcard.jpg', 'giftcard.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Abe Malone', 'Ajames57@gmail.com', 'd7ccd9aa0c4f697458127fdb628ff7429dcc1831'),
(2, 'Marie Doe', 'Raze800@yahoo.com', '6a5b7c063f4163dbbb799eb01649293aba6d8d53'),
(3, 'Jonh Black', 'Sage678@outlook.com', 'acef2c4925c52356ecee316e73efaf7ef504efe5'),
(4, 'Alia Smith', 'Brim969@gmail.com', 'a732634ee065b1872f4e21711704f8b73136f7d3'),
(5, 'Arashi Akino', 'Arashi700@gmail.com', '2943a91124d108bd1ed157bf01ff8c861d45893f');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
