-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2018 at 06:28 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookedcar`
--

CREATE TABLE IF NOT EXISTS `bookedcar` (
  `bookedcar_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone` int(11) NOT NULL,
  `book_start_date` datetime NOT NULL,
  `book_end_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookedcar`
--

INSERT INTO `bookedcar` (`bookedcar_id`, `car_id`, `name`, `email`, `phone`, `book_start_date`, `book_end_date`) VALUES
(1, 10, 'Tarikul', 'tarikulislam.cse@gmail.com', 91864402, '2018-07-03 00:00:00', '2018-07-05 00:00:00'),
(2, 11, 'rofiq', 'tarikulislam.cse@gmail.com', 91864402, '2018-07-04 00:00:00', '2018-07-06 00:00:00'),
(3, 8, 'harun', 'tarikulislam.cse@gmail.com', 251478, '2018-07-02 00:00:00', '2018-07-02 00:00:00'),
(4, 3, 'tarikul', 'tarikulislam.cse@gmail.com', 91864402, '2018-07-17 00:00:00', '2018-07-18 00:00:00'),
(5, 11, 'MD TARIKUL ISLAM', 'tarikulislam.cse@gmail.com', 544945955, '2018-07-08 00:00:00', '2018-07-09 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `carfeatures`
--

CREATE TABLE IF NOT EXISTS `carfeatures` (
  `carfeatures_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `aircondition` varchar(255) CHARACTER SET utf8 NOT NULL,
  `is_automatic_transmission` tinyint(4) NOT NULL,
  `is_manual_transmission` tinyint(4) NOT NULL,
  `kmpl` decimal(10,2) NOT NULL,
  `is_fuel_petrol` tinyint(4) NOT NULL,
  `is_fuel_diesel` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carfeatures`
--

INSERT INTO `carfeatures` (`carfeatures_id`, `car_id`, `capacity`, `aircondition`, `is_automatic_transmission`, `is_manual_transmission`, `kmpl`, `is_fuel_petrol`, `is_fuel_diesel`) VALUES
(1, 1, 5, 'Dual Zone', 1, 0, '21.20', 0, 1),
(2, 2, 4, 'Three Zone', 1, 0, '19.20', 1, 1),
(3, 3, 5, 'Dual Zone', 0, 1, '24.40', 1, 1),
(4, 4, 5, 'Dual Zone', 1, 0, '14.60', 1, 0),
(5, 5, 4, 'Dual Zone', 1, 0, '14.50', 1, 0),
(6, 6, 5, 'Dual Zone', 1, 1, '27.40', 1, 1),
(7, 7, 5, 'Dual Zone', 1, 0, '11.00', 1, 0),
(8, 8, 4, 'Dual Zone', 1, 0, '15.00', 1, 0),
(9, 9, 5, 'Dual Zone', 1, 0, '16.00', 1, 0),
(10, 10, 5, 'Dual Zone', 0, 1, '23.70', 0, 1),
(11, 11, 6, 'Four Zone', 1, 1, '36.50', 1, 1),
(12, 15, 4, 'Three Zone', 1, 0, '74.00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `car_id` int(11) NOT NULL,
  `cartype_id` int(11) NOT NULL,
  `carname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `identityNo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `costPerday` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `cartype_id`, `carname`, `identityNo`, `photo`, `description`, `costPerday`) VALUES
(1, 1, 'MINI 5 door', 'AE 46577', 'mini-5-door.jpg', 'The 5-door MINI is loaded to the brim in terms of features. The new display and operating concept will include the instrument cluster on the steering column with colour display, central instrument with new display elements and coloured lighting configuration among other things. It also gets a wide array of innovative driver assistance systems in addition to the unique MINI Connected in-car infotainment program. Long story short, this new hatch will offer an extensive range of standard features and high-end options to enhance comfort, safety, premium characteristics and individual style.', 8),
(2, 1, 'MINI Countryman', 'AE 11102', 'mini-countryman.jpg', 'MINI has launched the new Countryman in India with prices starting at Rs. 34.90 lakh for the Cooper S, going up to Rs. 41.4 lakh for the range topping Cooper S JCW (prices ex-showroom, India). The new-gen Countryman gets two petrol and one diese engine. The all-new Countryman underpins the new BMW X1 and will be locally assembled at BMW''s Chennai plant.', 11),
(3, 1, 'Ford Freestyle', 'AE 21001', 'ford-freestyle.png', 'Freestyle, the new crossover from Ford has been launched in India with prices starting from Rs. 5.09 lakh for the petrol base and going up to Rs. 7.89 lakh for the top-end diesel trim (prices are ex-showroom, Delhi). Ford is calling it a CUV or a compact utility vehicle, which is, more or less, a jazzier and beefed up version of the new Figo hatch.', 7),
(4, 7, 'MINI Cooper Convertible', 'AA 10111', 'mercedes-amg-slc-43.jpg', 'The all- new MINI Convertible also comes with the best-in-class safety technology. The standard safety equipment comprises of Front and Passenger Airbags, Brake Assist, 3-Point Seat Belts, Dynamic Stability Control, Crash Sensor, Anti-lock Braking System, Cornering Brake Control and Run-flat Indicator.Talking about the powertrain under the hood, the new MINI Cooper Convertible is powered by a 2-litre four-cylinder Twin-Power Turbo engine that is tuned to produce 189bhp of power and a peak torque of 280Nm.', 15),
(5, 7, 'Maserati GranCabrio', 'AA 22014', 'maserati-grancabrio.jpg', 'The Maserati GranCabrio gets a 4.7-litre naturally aspirated V8 engine that tuned to develop 450 bhp of power and 510 Nm of peak torque. The motor comes paired to a 6-speed automatic transmission sending power to the rear wheels. All the power helps the GranCabrio to propel from 0-100 kmph in just 5.2 seconds, while hitting a top speed of 285 kmph.', 10),
(6, 2, 'Honda Amaze', 'AE 11111', 'honda-amaze.png', 'Honda has launched the 2018 Amaze in India with prices starting at Rs. 5.59 lakh for the base petrol version whereas the diesel top-end is going to cost Rs 8.99 lakh. Initially introduced to Indian customers in 2013, the subcompact sedan quickly climbed the popularity chart emerging a strong threat to arch rival Maruti Suzuki Dzire. The new 2018 Honda Amaze comes with significant updates. While the engine line-up remains unchanged, the subcompact sedan has received a new diesel CVT this time around.', 8),
(7, 2, 'Mercedes-AMG E 63 S', 'AE 11122', 'mercedes-amg-e-63-s.png', 'Mercedes-AMG has launched the E 63 S 4Matic+ in India priced at Rs 1.5 crore (ex-showroom, India). The all-new AMG E 63 S 4Matic+ is the most powerful E-Class ever and trust us, it can do 0-100kmph in a claimed time of 3.4 seconds. This makes the AMG E 63 S 4Matic+ faster than the AMG GT R, which was recently launched in India. After the Maybach S650, the new S-Class facelift and the GLS Grand Edition, the AMG E 63 S 4Matic+ is Mercedes-AMG''s fourth launch of the year 2018. ', 10),
(8, 4, 'Mercedes-AMG GLA 45', 'AE 131211', 'mercedes-amg-gla-45.jpg', 'The Mercedes AMG GLA 45 look pretty much identical to the previous model except for the new styling and paint scheme. Along with some minor cosmetic tweaks, now the cars come in a new stylish glossy black paint job with yellow highlights for the front and rear bumper, tyre walls, and in the case of AMG GLA 45 the rear spoiler as well. Additionally, there is a matte black racing stripe that runs along the hood, roof and boot, and AMG graphics on both sides above the side skirts, which enhance the sporty character of the cars. Furthermore, you also get Mercedes-AMG''s customisation package.', 7),
(9, 4, 'Lamborghini Urus', 'AE 13123', 'lamborghini-urus.png', 'Lamborghini Urus performance SUV has been launched in India with a price tag of Rs 3 crore (ex-showroom India). The Urus is the second performance SUV from the Italian car maker and had been in the making for a long time. ', 7),
(10, 5, 'Hyundai i20 Active', 'AE 96321', 'hyundai-i20-active.jpg', 'Hyundai i20 Active is the beefed up version of Elite i20 hatchback. Joining the likes of Etios Cross and Volkswagen Cross Polo in the hatchback based crossover segment, i20 Active is by far the most attractive and sporty model in this space. The crossover shares engine set up with i20 hatchback and gets a manual transmission missing out on the automatic unit.', 8),
(11, 5, 'Volvo S60 Cross Country', 'AE 520147', 'volvo-s60-cross-country.jpg', 'Volvo S60 Cross Country is a sedan crossover that has raised heads for its new body style. Unlike the usual cross concepts that we have around like the hatchback crossover or SUV crossover, this premium offering from the Swedish auto maker comes in as a fresh breath of air, however it remains to be seen if it will get acceptance in India or not. Powering S60 CC is a 2.4 litre, D4 diesel engine good for 189bhp.', 534),
(15, 6, 'tartartar', 'AE 4657755 aa', 'aston-martin-db11.jpg', 'sdfsd sdfsd', 212343),
(18, 7, 'fhr r', 'eg', 'ferrari-california.png', 'fghf ', 7);

-- --------------------------------------------------------

--
-- Table structure for table `cartypes`
--

CREATE TABLE IF NOT EXISTS `cartypes` (
  `cartype_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cartypes`
--

INSERT INTO `cartypes` (`cartype_id`, `name`) VALUES
(1, 'Hatchback'),
(2, 'Sedan'),
(3, 'MPV'),
(4, 'SUV'),
(5, 'Crossover'),
(6, 'Coupe'),
(7, 'Convertible');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `lname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'abomat30@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookedcar`
--
ALTER TABLE `bookedcar`
  ADD PRIMARY KEY (`bookedcar_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `carfeatures`
--
ALTER TABLE `carfeatures`
  ADD PRIMARY KEY (`carfeatures_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `cartype_id` (`cartype_id`);

--
-- Indexes for table `cartypes`
--
ALTER TABLE `cartypes`
  ADD PRIMARY KEY (`cartype_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookedcar`
--
ALTER TABLE `bookedcar`
  MODIFY `bookedcar_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `carfeatures`
--
ALTER TABLE `carfeatures`
  MODIFY `carfeatures_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `cartypes`
--
ALTER TABLE `cartypes`
  MODIFY `cartype_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookedcar`
--
ALTER TABLE `bookedcar`
  ADD CONSTRAINT `bookedcar_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`cartype_id`) REFERENCES `cartypes` (`cartype_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
