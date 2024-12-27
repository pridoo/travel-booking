-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 02:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_tour`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `packageID` int(11) NOT NULL,
  `bookingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `departureDate` datetime NOT NULL,
  `returnDate` datetime NOT NULL,
  `Status` enum('Approved','Declined','Pending') NOT NULL DEFAULT 'Pending',
  `guideID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `name`, `email`, `subject`, `message`, `created_at`, `parent_id`) VALUES
(4, 7, 'Phillip Quiban', 'phillipquiban@gmail.com', 'The blog is great!', 'I just want to say that it this blog helped me a lot.', '2024-04-23 12:33:47', 0),
(5, 7, 'Phillip Quiban', 'phillipquiban@gmail.com', 'The great is blog!', 'Yes, it\'s real. The blog is definitely good.', '2024-04-23 19:40:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `name`, `email`, `phone`, `address`) VALUES
(1, 'Phillip Quiban', 'quiban.phillip@clsu2.edu.ph', '09156470368', 'Balungao, Pangasinan'),
(2, 'Phillip Quiban', 'quiban.phillip@clsu2.edu.ph', '09156470368', 'Balungao, Pangasinan'),
(3, 'Phillip Quiban', 'quiban.phillip@clsu2.edu.ph', '09156470368', 'Balungao, Pangasinan');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `inquiry_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `bookingID` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `paymentMethod` enum('Gcash','Credit Card','Debit Card') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `bookingID`, `amount`, `paymentDate`, `paymentMethod`) VALUES
(5, 5, 10999.00, '2024-04-24 10:07:35', 'Gcash');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Draft') NOT NULL DEFAULT 'Draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `category`, `author`, `date`, `content`, `image`, `status`) VALUES
(6, 'Surviving The World’s Most Dangerous Hike – Mt Huashan', 'Adventure', 'Alesha and Jarryd', '2024-04-02', '<p>I still remember the first time I saw photos of someone traversing a narrow plank of wood bolted to the side of a cliff, 2000 feet in the air. I sat up straight in my chair, eyes open, and mouthed the words, &ldquo;I have to do this&rdquo;.</p>\r\n<p>I was in Canada at the time, and a bit of research made me discover that the pictures I had seen were not just of any old via ferrata &ndash; These were images of Mount Huashan, and the world&rsquo;s most dangerous hike.</p>\r\n<p>The 2154m tall Mount Huashan is considered to be one of 5 sacred mountains in China, and locals know it as the &ldquo;most precipitous mountain under heaven&rdquo;.</p>\r\n<p>Adorned with influential Taoist temples, this mountain has been part of folklore for thousands of years. Five peaks make up the jagged mountain, with each one holding teahouses and shrines.</p>', 'blog1.jpg', 'Active'),
(7, 'The Best Camping Sleeping Pad of 2024 | Top 12 Sleeping pads', 'Gear', 'Alesha and Jarryd', '2024-03-13', '<p>Easily one of the most overlooked hiking essentials, a high-quality sleeping pad can make the difference in getting rest in between days out on the trail.</p>\r\n<p>And with so many options out there, finding the best camping sleeping pad that is sturdy enough to provide comfort yet small and lightweight enough to pack on your trek can be a challenge.</p>\r\n<p>But if you&rsquo;ve scooped up the best tent and sleeping bag, adding a sleeping pad to your gear is a no-brainer.</p>\r\n<p>As you venture into the wilderness, comfort is found in short supply. This is often one of the cerebral benefits of getting outdoors. But a good night&rsquo;s sleep goes a long way, so why not invest in a sleeping pad that will help you achieve your backcountry goals?</p>\r\n<p>The foam sleeping pad was once the standard, but now, inflatable sleeping pads with intricate designs are providing a relatively luxurious camping experience on the trail.</p>\r\n<p>Below we break down the best of them (with a couple of foam pads thrown in) to help you rest easy whether you&rsquo;re a thru-hiker, overnighter or car camper.</p>', 'blog2.jpg', 'Active'),
(8, 'How To Plan A Trip: A Month-By-Month Guide', 'Tips', 'Nomadic Matt', '2024-04-02', '<p>A lot of people talk vaguely about travel: they never say where they are going, just that they are going. They might talk about it for years before actually departing (if they go at all). But it&rsquo;s much easier to reach and plan for the goal of &ldquo;I am going to Paris for two weeks this summer&rdquo; than &ldquo;I&rsquo;m going somewhere.&rdquo;</p>\r\n<p>If you already have a dream destination in mind, great! If not, here are some posts to help you get started:</p>\r\n<p>But, this far out, the real thing you want to do is start saving money and figuring out your costs. Accommodation and flights are the obvious ones, but how much do restaurants, attractions, and other activities cost? Knowing these costs will allow you accurately estimate how much money you&rsquo;ll need. Here is how to research costs:</p>\r\n<p>While you&rsquo;re working to save money,&nbsp;get a travel credit card so you can earn miles and points for free flights and hotel stays. It&rsquo;s what has kept my costs down and me on the road for so many years.</p>\r\n<p>These days, most cards have welcome offers of 60,000-80,000 points (some can be as high as 100,000) when you meet their minimum spending requirement (generally $2,000-5,000 USD within a 3&ndash;6-month time frame). That&rsquo;s enough miles for a free round-trip economy flight to Europe from the East Coast of North America.</p>\r\n<p>In addition, get a fee-free ATM card. I use Charles Schwab, but there are lots of other banks that don&rsquo;t charge ATM fees (don&rsquo;t forget to check your local banks and credit unions too).&nbsp;Here&rsquo;s how you can avoid bank fees while traveling.</p>', 'blog3.jpg', 'Active'),
(9, 'The Best ESIM On The Market: How To Get Unlimited Data For Your Trip', 'Tips', 'Andres Caulimower', '2024-04-04', '<p>When I started backpacking around the world, there were no smartphones. If you needed to call home, you had to find a pay phone and if you needed to use a computer to look something up or send an email, you had to find an internet caf&eacute;.</p>\r\n<p>But times have changed.</p>\r\n<p>These days, travelers rely on their phones to&nbsp;find cheap flights, book accommodation, look up things to see and do, translate menus, get directions, and much more.</p>\r\n<p>And while I think a lot of travelers maybe spend too much time on their phone, phones are a vital part of the&nbsp;savvy traveler&rsquo;s arsenal.</p>\r\n<p>That means travelers need reliable mobile data so they can find the information they need and keep in touch with friends and family back home.</p>\r\n<p>For travelers around the world, the best way to ensure you have access to the internet and are able to&nbsp;stay connected is with an eSIM.</p>\r\n<p data-slot-rendered-content=\"true\">While it&rsquo;s definitely possible to buy a SIM card on arrival to your destination, eSIMs are super easy to use and allow you to get prepared in advance so that you have mobile data the moment you land. They&rsquo;re also cheaper and come with better support.</p>\r\n<h3><span id=\"what-is-an-esim\">What is an eSIM?</span></h3>\r\n<p data-slot-rendered-content=\"true\">A SIM card is a small memory card that you insert into your smartphone in order to make calls and use the mobile data. It has unique identifiers that ensure that when people call you, the call comes to your device. You generally get one from your phone provider when you sign your contract.</p>\r\n<p>An eSIM is a digital version of this. Instead of a physical memory card, you&rsquo;ll install software on your smartphone that replicates the same functions as the physical card.</p>\r\n<p>Most smartphones only have a single port for a SIM card so the benefit of eSIMs is that you can have multiple eSIMs on a single device.</p>\r\n<p>For example, if you&rsquo;re from Australia and are visiting the United States, you&rsquo;ll need to physically remove your Australian SIM card on arrival and install a US SIM card if you want to avoid paying excessive roaming fees. But once you swap SIM cards, you won&rsquo;t be able to receive calls or texts to your Australian phone number unless you physically remove the US SIM card and put the Australian SIM card back into your phone.</p>\r\n<p data-slot-rendered-content=\"true\">This is a tedious process if you need to access multiple numbers during your trip. Hence the convenience of eSIMs. They make it super easy to visit multiple countries each year without having to juggle SIM cards. And since they let you get set up before you arrive, they provide more peace of mind.</p>', 'blog4.jpeg', 'Active'),
(10, 'Philippines Travel Guide: Essential Things to Know', 'Travel Guide', 'Desiree Chin', '2024-03-03', '<p><em><strong>The Philippines &ndash; home to beautiful beaches</strong></em>, chilled island vibes, an interesting history and some of the most wonderfully kind people. It&rsquo;s one of the very best places I&rsquo;ve been to. In fact, I love the Philippines so much that I can&rsquo;t wait for a return visit. However, having been to the Philippines twice now, I thought I&rsquo;d share all of the useful information and vital tips I&rsquo;ve gathered on my trips in this Philippines travel guide.</p>\r\n<p>In this post, I&rsquo;ve tried to detail everything you could need to know before visiting the Philippines, with the advice ranging from handling poor weather, unexpected hassles to tips to save money and to help you stay safe. I wish I had known some of these useful tips before my travels through the Philippines&ndash; as many of these tips and tricks are completely specific to the country!</p>\r\n<p>Take a read below and let me know if you have any questions or thoughts. I hope you find these useful whilst planning your Philippines itinerary!</p>\r\n<p>As you fix up your travel plans around the islands of the Philippines, don&rsquo;t assume there&rsquo;ll be an ATM where you&rsquo;re staying.</p>\r\n<p>Either research ahead of time or ask your hostel/hotel. Places like&nbsp;Manila,&nbsp;Cebu&nbsp;and&nbsp;Boracay&nbsp;have plentiful ATMs but many of the smaller Philippines islands do not have ATMs.</p>\r\n<p>El Nido&nbsp;in 2014 didn&rsquo;t have an ATM, but by January 2017 there was one ATM. However, it often ran out of cash. To be on the safe side, always try and keep a reasonable amount of the local currency (Philippine Pesos &ndash; PHP) on you. You really don&rsquo;t want to be stuck anywhere without cash &ndash; many hostels etc will not take card payments either.</p>\r\n<p>On the same note, not all ATMs in the Philippines take international cards so always think ahead about your money needs. You may need to stock up on Philippine Pesos a little way ahead.</p>\r\n<p>To be honest, this may well be the most useful of my Philippines travel tips as you can&rsquo;t get that far without some money!</p>', 'blog5.jpg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tourguide`
--

CREATE TABLE `tourguide` (
  `guideID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `image` varchar(255) NOT NULL,
  `specialization` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tourguide`
--

INSERT INTO `tourguide` (`guideID`, `name`, `email`, `phone`, `image`, `specialization`) VALUES
(1, 'Roel Dela Magiba', 'roeldelamagiba@travel.com', '09123456789', 'tour1.jpg', 'Roel Dela Magiba\'s passion for exploration and commitment to delivering unforgettable experiences make his Adventure Tours a must for anyone seeking adrenaline-fueled escapades amidst the stunning vistas of Roel\'s Ridge.'),
(2, 'Ferdinand Mabillan', 'ferdinandmabillan@travel.com', '09234567890', 'tour2.jpg', 'Ferdinand Mabillan\'s unwavering dedication to ecotourism goes beyond providing transformative experiences; his endeavors actively contribute to the preservation of natural habitats and the promotion of sustainable practices, ensuring that future generatio'),
(5, 'Maria Magdalena', 'mariamagdalena@travel.com', '09345678901', 'tour3.jpg', 'Maria Magdalena, celebrated for her fervent advocacy of cultural immersion through tourism, crafts enriching journeys that delve deep into the tapestry of heritage and tradition. With her guidance, travelers embark on transformative experiences designed t'),
(6, 'Harry Okhay', 'harryokhay@travel.com', '094567890123', 'tour4.jpg', 'Harry Okhay\'s innovative approach to guided tours seamlessly blends the thrill of adventure with the pleasures of culinary discovery, offering travelers an unforgettable journey that stimulates not only their taste buds but also their sense of wonder and ');

-- --------------------------------------------------------

--
-- Table structure for table `tourpackage`
--

CREATE TABLE `tourpackage` (
  `packageID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `image` varchar(25) NOT NULL,
  `airport` varchar(50) NOT NULL,
  `extras` varchar(50) NOT NULL DEFAULT 'All Inclusive',
  `price` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tourpackage`
--

INSERT INTO `tourpackage` (`packageID`, `name`, `duration`, `image`, `airport`, `extras`, `price`) VALUES
(13, 'Boracay Beach, Aklan', 4, 'boracay.jpg', 'NAIA Terminal II', 'All Inclusive', 10999.00),
(14, 'Tokyo, Japan', 5, 'tokyo.jpg', 'NAIA Terminal III', 'All Inclusive', 35999.00),
(15, 'El Nido, Palawan', 4, 'palawan.jpg', 'NAIA Terminal I', 'All Inclusive', 15999.00),
(17, 'Eiffel Tower, France', 6, 'paris.jpg', 'NAIA Terminal I', 'All Inclusive', 45999.00),
(18, 'Sydney, Australia', 7, 'sydney.jpg', 'NAIA Terminal II', 'All Inclusive', 36999.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `packageID` (`packageID`),
  ADD KEY `fk_guideID` (`guideID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`inquiry_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `bookingID` (`bookingID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tourguide`
--
ALTER TABLE `tourguide`
  ADD PRIMARY KEY (`guideID`);

--
-- Indexes for table `tourpackage`
--
ALTER TABLE `tourpackage`
  ADD PRIMARY KEY (`packageID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tourguide`
--
ALTER TABLE `tourguide`
  MODIFY `guideID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tourpackage`
--
ALTER TABLE `tourpackage`
  MODIFY `packageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`packageID`) REFERENCES `tourpackage` (`packageID`),
  ADD CONSTRAINT `fk_guideID` FOREIGN KEY (`guideID`) REFERENCES `tourguide` (`guideID`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
