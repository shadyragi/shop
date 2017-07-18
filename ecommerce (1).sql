-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2017 at 11:25 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `pwd`) VALUES
(1, 'admin@yahoo.com', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Stand-in structure for view `bestseller`
--
CREATE TABLE `bestseller` (
`id` int(11)
,`title` varchar(255)
,`image` varchar(255)
,`description` text
,`price` int(11)
,`stock` int(11)
,`dte` datetime
,`sold` int(11)
,`categ` varchar(255)
,`offers` enum('yes','no')
,`new_price` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `blocked`
--

CREATE TABLE `blocked` (
  `id` int(11) NOT NULL,
  `blocked_ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blocked`
--

INSERT INTO `blocked` (`id`, `blocked_ip`) VALUES
(1, '$ip'),
(2, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user_id`, `product_id`, `price`, `qty`, `id`, `category`) VALUES
(2, 36, 20, 1, 31, 'cameras'),
(2, 42, 20, 5, 37, 'cameras'),
(1, 65, 20, 5, 38, 'makeup');

--
-- Triggers `cart`
--
DELIMITER $$
CREATE TRIGGER `carttrigger` BEFORE INSERT ON `cart` FOR EACH ROW BEGIN
UPDATE product SET stock = stock - new.qty, sold = sold + new.qty WHERE id = new.product_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deletetrigger` BEFORE DELETE ON `cart` FOR EACH ROW BEGIN
	UPDATE product
    SET    stock = stock + old.qty, sold = sold - old.qty
    WHERE id = old.id;
    
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `historytrigger1` AFTER INSERT ON `cart` FOR EACH ROW BEGIN
INSERT INTO history(user_id, product_id, type) VALUES(new.user_id, new.product_id, "add");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `historytriggerdelete` AFTER DELETE ON `cart` FOR EACH ROW BEGIN
INSERT INTO history(user_id, product_id, type) VALUES(old.user_id, old.product_id, "delete");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `historytriggerupdate` AFTER UPDATE ON `cart` FOR EACH ROW BEGIN
INSERT INTO history(user_id, product_id, type) VALUES(new.user_id, new.product_id, "update");
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updatecart` BEFORE UPDATE ON `cart` FOR EACH ROW BEGIN
DECLARE x INT;
IF old.qty < new.qty THEN
SET x = new.qty - old.qty;
UPDATE product SET stock = stock - x, sold = sold + x WHERE id = old.product_id;
ELSE
SET x = old.qty - new.qty;
UPDATE product SET stock = stock + x, sold = sold - x WHERE id = old.product_id;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(1, 'sport'),
(2, 'cameras'),
(3, 'jackets'),
(5, 'technology'),
(6, 'new category');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `subject` text NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `name`, `email`, `subject`, `comment`, `date`) VALUES
(1, 'asd', 'gtskahmed@gmail.com', 'asd', 'asd', '2015-09-14 07:47:55'),
(2, 'asd', 'gtskahmed@gmail.com', 'asd', 'asd', '2015-09-14 07:48:28'),
(3, 'asd', 'gtskahmed@gmail.com', 'asd', 'asd', '2015-09-14 07:49:10');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dte` datetime DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `product_id`, `user_id`, `dte`, `type`) VALUES
(8, 42, 2, '2017-05-24 07:52:47', 'add'),
(9, 12, 2, '2017-05-24 08:24:09', 'delete'),
(10, 42, 2, '2017-05-24 08:24:12', 'update'),
(13, 12, 1, '2017-05-28 05:23:25', 'delete'),
(14, 21, 1, '2017-05-30 05:24:18', 'add'),
(32, 22, 1, '2017-06-20 17:03:31', 'delete'),
(33, 65, 1, '2017-07-10 11:26:08', 'add');

-- --------------------------------------------------------

--
-- Stand-in structure for view `latest_product`
--
CREATE TABLE `latest_product` (
`id` int(11)
,`title` varchar(255)
,`image` varchar(255)
,`description` text
,`price` int(11)
,`stock` int(11)
,`dte` datetime
,`sold` int(11)
,`categ` varchar(255)
,`offers` enum('yes','no')
,`new_price` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `dte` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `product_id`, `type`, `dte`) VALUES
(24, 1, 12, 'stock', '2017-05-08 07:15:16');

-- --------------------------------------------------------

--
-- Stand-in structure for view `offers`
--
CREATE TABLE `offers` (
`id` int(11)
,`title` varchar(255)
,`image` varchar(255)
,`description` text
,`price` int(11)
,`stock` int(11)
,`dte` datetime
,`sold` int(11)
,`categ` varchar(255)
,`offers` enum('yes','no')
,`new_price` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `category` text NOT NULL,
  `status` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `image`, `category`, `status`, `date`, `author`) VALUES
(1, 'The First Post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'images/img1.jpg', '2', 'published', '2015-09-19 22:38:28', 'gtskahmed@gmail.com'),
(2, 'The Second Post', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat', 'images/img2.jpg', '3', 'draft', '2015-09-19 22:37:47', 'gtskahmed@gmail.com'),
(7, 'The Second Post', '<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus asd saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</p>', '', '3', 'draft', '2015-09-19 22:37:50', 'gtskahmed@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `price` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `dte` datetime DEFAULT CURRENT_TIMESTAMP,
  `sold` int(11) DEFAULT '0',
  `categ` varchar(255) DEFAULT NULL,
  `offers` enum('yes','no') DEFAULT 'no',
  `new_price` int(11) DEFAULT '0',
  `brand` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `title`, `image`, `description`, `price`, `stock`, `dte`, `sold`, `categ`, `offers`, `new_price`, `brand`) VALUES
(11, 'product 8', 'http://www.placehold.it/100/200', 'Lorem ipsum dolor sit amet, gravida nulla consectetuer, praesent mi et vestibulum a ultricies donec, a pellentesque faucibus. Aliquam sem lorem donec venenatis sociis, diam cras a morbi pede nec arcu, placerat a lobortis, egestas elit nec porttitor nec litora posuere, eget cursus aptent molestie amet. Morbi at. Nisl at pellentesque, sodales elementum. Donec magna leo maecenas pellentesque rutrum sed, morbi massa quis nam, et risus, a amet auctor molestie varius nibh mauris. Arcu diam dis adipiscing pede eget, nullam tristique nunc risus turpis, duis in amet fusce, at rhoncus in vestibulum fermentum ut. Asperiores sodales bibendum ante, phasellus mauris pulvinar nunc mi sit libero, adipiscing et, elementum mauris ultrices tellus nisl tortor vestibulum, aliquam montes elit fusce. Auctor quisque eget laoreet sed mi sit, consequat nibh nulla, laoreet pellentesque est aut odio nunc mattis, nisl interdum habitasse. Inceptos faucibus tristique.\r\nLeo massa non tellus cras enim, id libero mi risus, magna gravida molestie volutpat est vivamus. Volutpat volutpat purus neque mi tellus, hac vitae fusce est imperdiet ac pellentesque, velit nulla nullam eget. Wisi justo. At ac dolor placerat at, magna arcu sed turpis pulvinar velit, porttitor maecenas dolor mattis mauris nec, feugiat placerat aenean et non. Malesuada quod dictum imperdiet curabitur, rutrum feugiat adipiscing nulla tincidunt purus, euismod maecenas et velit vivamus. Eget nullam ante etiam, dolor dui magnis proin libero. Et nonummy nunc ornare nam elit eu, pulvinar sapien leo, augue urna est. Maecenas venenatis tellus, ipsum amet morbi curabitur, urna qui magna, lacus mauris nec nulla, eu magna vivamus. Libero feugiat, elit ut dictum justo, taciti hymenaeos pulvinar facilisis et etiam ac, et nulla vulputate tristique duis eget. Fringilla varius nulla convallis morbi, aliquam adipiscing cras parturient nunc, praesent massa ipsum cursus ut turpis. Urna congue iaculis molestie.\r\nSodales eget, risus ornare fringilla. Mi velit. Cras eget, praesent sapien euismod adipiscing, vivamus mattis mus diam, commodo wisi at, placerat dictum dolor ipsum ut. Augue eleifend in vulputate. Ridiculus luctus augue metus ipsum orci vitae, ut placerat libero mauris nibh, vitae integer velit, vestibulum lorem et quis nec est. Turpis interdum aenean accumsan justo sed. Lacus risus, adipiscing blandit velit congue nullam, gravida arcu dui, dui arcu dolor condimentum dolor eius dolor. Maecenas proin, amet sit praesent eros, pellentesque nunc proin consequat non sed donec, consectetuer nunc nibh purus massa nostra morbi, iaculis ante rhoncus penatibus.\r\nTristique harum est ut, duis id eu dolor, lacinia purus dolor arcu varius porta, eu leo magna maecenas, eget tortor sapien fusce amet fames. Sit ligula quis posuere odio magnis, pulvinar sed arcu ut. Vel libero, dui ligula placerat donec vulputate, sit libero, laoreet dictum, id ut varius nulla rutrum suscipit a. Cras sed id risus quis, suspendisse a, et penatibus sunt convallis. Donec enim sociis mus consequatur mi tortor, dolor ligula in eu lobortis consectetuer, turpis fusce, magnam enim, ante in mollis blandit malesuada dignissim vestibulum. Arcu amet leo vestibulum etiam leo nulla, et eu, ex massa. Pellentesque est adipiscing enim a gravida est, quis suspendisse dolorem euismod lectus aliquam, pulvinar magna donec ad nulla proin, ut vestibulum consequat ultricies, mauris viverra. Libero dictum pellentesque, neque imperdiet suspendisse, mollis sociis laoreet tempor mauris vehicula. Accumsan volutpat aliquet augue, corporis autem in pede, erat lorem pulvinar amet nunc tristique et, nibh aliquam accumsan nulla.', 60, 8, '2016-10-01 04:07:39', 17, 'cameras', 'yes', 5, 'camera brand'),
(12, 'product 9', 'http://www.placehold.it/100/200', 'Lorem ipsum dolor sit amet, gravida nulla consectetuer, praesent mi et vestibulum a ultricies donec, a pellentesque faucibus. Aliquam sem lorem donec venenatis sociis, diam cras a morbi pede nec arcu, placerat a lobortis, egestas elit nec porttitor nec litora posuere, eget cursus aptent molestie amet. Morbi at. Nisl at pellentesque, sodales elementum. Donec magna leo maecenas pellentesque rutrum sed, morbi massa quis nam, et risus, a amet auctor molestie varius nibh mauris. Arcu diam dis adipiscing pede eget, nullam tristique nunc risus turpis, duis in amet fusce, at rhoncus in vestibulum fermentum ut. Asperiores sodales bibendum ante, phasellus mauris pulvinar nunc mi sit libero, adipiscing et, elementum mauris ultrices tellus nisl tortor vestibulum, aliquam montes elit fusce. Auctor quisque eget laoreet sed mi sit, consequat nibh nulla, laoreet pellentesque est aut odio nunc mattis, nisl interdum habitasse. Inceptos faucibus tristique.\r\nLeo massa non tellus cras enim, id libero mi risus, magna gravida molestie volutpat est vivamus. Volutpat volutpat purus neque mi tellus, hac vitae fusce est imperdiet ac pellentesque, velit nulla nullam eget. Wisi justo. At ac dolor placerat at, magna arcu sed turpis pulvinar velit, porttitor maecenas dolor mattis mauris nec, feugiat placerat aenean et non. Malesuada quod dictum imperdiet curabitur, rutrum feugiat adipiscing nulla tincidunt purus, euismod maecenas et velit vivamus. Eget nullam ante etiam, dolor dui magnis proin libero. Et nonummy nunc ornare nam elit eu, pulvinar sapien leo, augue urna est. Maecenas venenatis tellus, ipsum amet morbi curabitur, urna qui magna, lacus mauris nec nulla, eu magna vivamus. Libero feugiat, elit ut dictum justo, taciti hymenaeos pulvinar facilisis et etiam ac, et nulla vulputate tristique duis eget. Fringilla varius nulla convallis morbi, aliquam adipiscing cras parturient nunc, praesent massa ipsum cursus ut turpis. Urna congue iaculis molestie.\r\nSodales eget, risus ornare fringilla. Mi velit. Cras eget, praesent sapien euismod adipiscing, vivamus mattis mus diam, commodo wisi at, placerat dictum dolor ipsum ut. Augue eleifend in vulputate. Ridiculus luctus augue metus ipsum orci vitae, ut placerat libero mauris nibh, vitae integer velit, vestibulum lorem et quis nec est. Turpis interdum aenean accumsan justo sed. Lacus risus, adipiscing blandit velit congue nullam, gravida arcu dui, dui arcu dolor condimentum dolor eius dolor. Maecenas proin, amet sit praesent eros, pellentesque nunc proin consequat non sed donec, consectetuer nunc nibh purus massa nostra morbi, iaculis ante rhoncus penatibus.\r\nTristique harum est ut, duis id eu dolor, lacinia purus dolor arcu varius porta, eu leo magna maecenas, eget tortor sapien fusce amet fames. Sit ligula quis posuere odio magnis, pulvinar sed arcu ut. Vel libero, dui ligula placerat donec vulputate, sit libero, laoreet dictum, id ut varius nulla rutrum suscipit a. Cras sed id risus quis, suspendisse a, et penatibus sunt convallis. Donec enim sociis mus consequatur mi tortor, dolor ligula in eu lobortis consectetuer, turpis fusce, magnam enim, ante in mollis blandit malesuada dignissim vestibulum. Arcu amet leo vestibulum etiam leo nulla, et eu, ex massa. Pellentesque est adipiscing enim a gravida est, quis suspendisse dolorem euismod lectus aliquam, pulvinar magna donec ad nulla proin, ut vestibulum consequat ultricies, mauris viverra. Libero dictum pellentesque, neque imperdiet suspendisse, mollis sociis laoreet tempor mauris vehicula. Accumsan volutpat aliquet augue, corporis autem in pede, erat lorem pulvinar amet nunc tristique et, nibh aliquam accumsan nulla.', 60, 8, '2016-10-01 04:07:54', 50, 'cameras', 'no', 0, 'camera brand'),
(14, 'product 11', 'http://www.placehold.it/100/200', 'Lorem ipsum dolor sit amet, gravida nulla consectetuer, praesent mi et vestibulum a ultricies donec, a pellentesque faucibus. Aliquam sem lorem donec venenatis sociis, diam cras a morbi pede nec arcu, placerat a lobortis, egestas elit nec porttitor nec litora posuere, eget cursus aptent molestie amet. Morbi at. Nisl at pellentesque, sodales elementum. Donec magna leo maecenas pellentesque rutrum sed, morbi massa quis nam, et risus, a amet auctor molestie varius nibh mauris. Arcu diam dis adipiscing pede eget, nullam tristique nunc risus turpis, duis in amet fusce, at rhoncus in vestibulum fermentum ut. Asperiores sodales bibendum ante, phasellus mauris pulvinar nunc mi sit libero, adipiscing et, elementum mauris ultrices tellus nisl tortor vestibulum, aliquam montes elit fusce. Auctor quisque eget laoreet sed mi sit, consequat nibh nulla, laoreet pellentesque est aut odio nunc mattis, nisl interdum habitasse. Inceptos faucibus tristique.\r\nLeo massa non tellus cras enim, id libero mi risus, magna gravida molestie volutpat est vivamus. Volutpat volutpat purus neque mi tellus, hac vitae fusce est imperdiet ac pellentesque, velit nulla nullam eget. Wisi justo. At ac dolor placerat at, magna arcu sed turpis pulvinar velit, porttitor maecenas dolor mattis mauris nec, feugiat placerat aenean et non. Malesuada quod dictum imperdiet curabitur, rutrum feugiat adipiscing nulla tincidunt purus, euismod maecenas et velit vivamus. Eget nullam ante etiam, dolor dui magnis proin libero. Et nonummy nunc ornare nam elit eu, pulvinar sapien leo, augue urna est. Maecenas venenatis tellus, ipsum amet morbi curabitur, urna qui magna, lacus mauris nec nulla, eu magna vivamus. Libero feugiat, elit ut dictum justo, taciti hymenaeos pulvinar facilisis et etiam ac, et nulla vulputate tristique duis eget. Fringilla varius nulla convallis morbi, aliquam adipiscing cras parturient nunc, praesent massa ipsum cursus ut turpis. Urna congue iaculis molestie.\r\nSodales eget, risus ornare fringilla. Mi velit. Cras eget, praesent sapien euismod adipiscing, vivamus mattis mus diam, commodo wisi at, placerat dictum dolor ipsum ut. Augue eleifend in vulputate. Ridiculus luctus augue metus ipsum orci vitae, ut placerat libero mauris nibh, vitae integer velit, vestibulum lorem et quis nec est. Turpis interdum aenean accumsan justo sed. Lacus risus, adipiscing blandit velit congue nullam, gravida arcu dui, dui arcu dolor condimentum dolor eius dolor. Maecenas proin, amet sit praesent eros, pellentesque nunc proin consequat non sed donec, consectetuer nunc nibh purus massa nostra morbi, iaculis ante rhoncus penatibus.\r\nTristique harum est ut, duis id eu dolor, lacinia purus dolor arcu varius porta, eu leo magna maecenas, eget tortor sapien fusce amet fames. Sit ligula quis posuere odio magnis, pulvinar sed arcu ut. Vel libero, dui ligula placerat donec vulputate, sit libero, laoreet dictum, id ut varius nulla rutrum suscipit a. Cras sed id risus quis, suspendisse a, et penatibus sunt convallis. Donec enim sociis mus consequatur mi tortor, dolor ligula in eu lobortis consectetuer, turpis fusce, magnam enim, ante in mollis blandit malesuada dignissim vestibulum. Arcu amet leo vestibulum etiam leo nulla, et eu, ex massa. Pellentesque est adipiscing enim a gravida est, quis suspendisse dolorem euismod lectus aliquam, pulvinar magna donec ad nulla proin, ut vestibulum consequat ultricies, mauris viverra. Libero dictum pellentesque, neque imperdiet suspendisse, mollis sociis laoreet tempor mauris vehicula. Accumsan volutpat aliquet augue, corporis autem in pede, erat lorem pulvinar amet nunc tristique et, nibh aliquam accumsan nulla.', 60, 10, '2016-10-01 04:08:26', 13, 'makeup', 'no', 0, NULL),
(15, 'product 12', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 19, '0000-00-00 00:00:00', 17, 'sport', 'yes', 0, 'sport brand'),
(17, 'product 14', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 22, '0000-00-00 00:00:00', 20, 'sport', 'yes', 0, 'sport brand'),
(21, 'product 18', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 31, '0000-00-00 00:00:00', 23, 'sport', '', 0, 'sport brand'),
(22, 'product 19', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 36, '0000-00-00 00:00:00', 21, 'sport', '', 0, 'sport brand'),
(23, 'product 19', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 38, '0000-00-00 00:00:00', 19, 'playstation', 'yes', 0, NULL),
(24, 'product 20', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 40, '0000-00-00 00:00:00', 20, 'playstation', 'yes', 0, NULL),
(26, 'product 22', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 44, '0000-00-00 00:00:00', 22, 'playstation', 'yes', 0, NULL),
(27, 'product 23', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 47, '0000-00-00 00:00:00', 22, 'playstation', 'yes', 0, NULL),
(28, 'product 24', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 52, '0000-00-00 00:00:00', 20, 'playstation', '', 0, NULL),
(29, 'product 25', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 52, '0000-00-00 00:00:00', 23, 'playstation', '', 0, NULL),
(30, 'product 26', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 54, '0000-00-00 00:00:00', 24, 'playstation', '', 0, NULL),
(31, 'product 27', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 54, '0000-00-00 00:00:00', 27, 'playstation', '', 0, NULL),
(32, 'product 28', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 57, '0000-00-00 00:00:00', 27, 'playstation', '', 0, NULL),
(33, 'product 29', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 59, '0000-00-00 00:00:00', 28, 'playstation', '', 0, NULL),
(35, 'product 31', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 67, '0000-00-00 00:00:00', 26, 'cameras', 'yes', 0, 'camera brand'),
(36, 'product 32', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 69, '0000-00-00 00:00:00', 27, 'cameras', 'yes', 0, 'camera brand'),
(37, 'product 33', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 66, '0000-00-00 00:00:00', 33, 'cameras', 'yes', 0, 'camera brand'),
(38, 'product 34', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 75, '0000-00-00 00:00:00', 27, 'cameras', 'yes', 0, 'camera brand'),
(39, 'product 35', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 71, '0000-00-00 00:00:00', 34, 'cameras', '', 0, 'camera brand'),
(40, 'product 36', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 74, '0000-00-00 00:00:00', 34, 'cameras', '', 0, 'camera brand'),
(41, 'product 37', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 87, '0000-00-00 00:00:00', 24, 'cameras', '', 0, 'camera brand'),
(42, 'product 38', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 72, '0000-00-00 00:00:00', 42, 'cameras', '', 0, 'camera brand'),
(43, 'product 39', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 79, '0000-00-00 00:00:00', 38, 'cameras', '', 0, 'camera brand'),
(44, 'product 40', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 82, '0000-00-00 00:00:00', 38, 'technology', 'yes', 0, 'technology brand'),
(46, 'product 42', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 85, '0000-00-00 00:00:00', 41, 'technology', 'yes', 0, 'technology brand'),
(47, 'product 43', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 96, '0000-00-00 00:00:00', 33, 'technology', 'yes', 0, 'technology brand'),
(48, 'product 44', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 89, '0000-00-00 00:00:00', 43, 'technology', 'yes', 0, 'technology brand'),
(49, 'product 45', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 91, '0000-00-00 00:00:00', 44, 'technology', '', 0, 'technology brand'),
(50, '', '', '', 0, 1, '0000-00-00 00:00:00', -1, '', '', 0, ''),
(51, 'product 47', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 95, '0000-00-00 00:00:00', 46, 'technology', '', 0, 'technology brand'),
(52, 'product 48', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 97, '0000-00-00 00:00:00', 47, 'technology', '', 0, 'technology brand'),
(53, 'product 49', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 99, '0000-00-00 00:00:00', 48, 'technology', '', 0, 'technology brand'),
(54, 'product 50', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 100, '0000-00-00 00:00:00', 50, 'jacket', 'yes', 0, 'jackets brand'),
(55, 'product 51', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 102, '0000-00-00 00:00:00', 51, 'jacket', 'yes', 0, 'jackets brand'),
(56, 'product 52', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 104, '0000-00-00 00:00:00', 52, 'jacket', 'yes', 0, 'jackets brand'),
(57, 'product 53', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 106, '0000-00-00 00:00:00', 53, 'jacket', 'yes', 0, 'jackets brand'),
(58, 'product 54', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 108, '0000-00-00 00:00:00', 54, 'jacket', 'yes', 0, 'jackets brand'),
(59, 'product 55', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 110, '0000-00-00 00:00:00', 55, 'jacket', '', 0, 'jackets brand'),
(60, 'product 56', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 112, '0000-00-00 00:00:00', 56, 'jacket', '', 0, 'jackets brand'),
(61, 'product 57', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 114, '0000-00-00 00:00:00', 57, 'jacket', '', 0, 'jackets brand'),
(62, 'product 58', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 116, '0000-00-00 00:00:00', 58, 'jacket', '', 0, 'jackets brand'),
(63, 'product 59', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 118, '0000-00-00 00:00:00', 59, 'jacket', '', 0, 'jackets brand'),
(64, 'product 60', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 120, '0000-00-00 00:00:00', 60, 'makeup', 'yes', 0, NULL),
(65, 'product 61', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 117, '0000-00-00 00:00:00', 66, 'makeup', 'yes', 0, NULL),
(66, 'product 62', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 124, '0000-00-00 00:00:00', 62, 'makeup', 'yes', 0, NULL),
(68, 'product 64', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 128, '0000-00-00 00:00:00', 64, 'makeup', 'yes', 0, NULL),
(69, 'product 65', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 130, '0000-00-00 00:00:00', 65, 'makeup', '', 0, NULL),
(70, 'product 66', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 131, '0000-00-00 00:00:00', 67, 'makeup', '', 0, NULL),
(73, 'product 69', 'http://www.placehold.it/100/600', 'Lorem ipsum dolor sit amet, sodales dolor in metus et, commodo consectetuer elit odio. Est velit consectetuer faucibus morbi. Neque lacus eget nec in non, pede facilisis neque, turpis urna et malesuada pede per, neque sollicitudin imperdiet interdum malesuada libero, eget ipsum diam sodales blandit interdum. Vitae erat facilisis quis, amet dictum arcu mauris. Blandit ut sit, enim ut mauris dui varius, non sit suscipit mollis arcu id. Nunc sed mollis wisi condimentum vestibulum justo. Porta odio risus et. Felis scelerisque in maecenas tortor, suspendisse nulla sollicitudin', 20, 138, '0000-00-00 00:00:00', 69, 'makeup', '', 0, NULL),
(74, 'shady product', '', 'blablabla', 555, 66, '0000-00-00 00:00:00', 0, 'cateogy', '', 0, ''),
(75, 'csrf', '', 'csrf test', 50, 9898, '0000-00-00 00:00:00', 0, 'csrf', '', 0, '');

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `notifications` AFTER UPDATE ON `product` FOR EACH ROW BEGIN
DECLARE myid INT;
DECLARE finished INT DEFAULT 0;
DECLARE CUR CURSOR FOR SELECT user_id FROM wishlist where product_id = new.id;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
IF (old.offers = 'no' AND new.offers = 'yes') OR (old.stock = 0 AND new.stock > 0) THEN
open cur;


myloop: LOOP
FETCH cur INTO myid;
IF finished = 1 THEN
LEAVE myloop;
END IF;
IF (old.offers = 'no' AND new.offers = 'yes') THEN
INSERT INTO notification(user_id, product_id, type) VALUES(myid, new.id, 'offer');

ELSEIF (old.stock = 0 AND new.stock > 0) THEN
INSERT INTO notification(user_id, product_id, type) VALUES(myid, new.id, 'stock');
END IF;


END LOOP;
close cur;
END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `productdelete` AFTER DELETE ON `product` FOR EACH ROW BEGIN
DELETE FROM wishlist WHERE product_id = old.id;

DELETE FROM history WHERE product_id = old.id;
DELETE FROM notification WHERE product_id = old.id;

DELETE FROM productview WHERE product_id = old.id;



END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `productview`
--

CREATE TABLE `productview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productview`
--

INSERT INTO `productview` (`id`, `user_id`, `product_id`, `category`) VALUES
(844, 2, 38, 'cameras'),
(845, 2, 38, 'cameras'),
(846, 2, 43, 'cameras'),
(847, 2, 39, 'cameras'),
(848, 2, 34, 'cameras'),
(849, 2, 34, 'cameras'),
(850, 2, 41, 'cameras'),
(851, 2, 39, 'cameras'),
(852, 2, 41, 'cameras'),
(853, 2, 41, 'cameras'),
(1461, 0, 73, 'makeup'),
(1464, 0, 73, 'makeup'),
(1465, 0, 73, 'makeup'),
(1471, 0, 73, 'makeup'),
(1534, NULL, 5, NULL),
(1535, NULL, 70, 'makeup'),
(1541, NULL, 73, 'makeup'),
(1542, NULL, 70, 'makeup'),
(1543, NULL, 70, 'makeup'),
(1544, NULL, 73, 'makeup'),
(1545, NULL, 73, 'makeup'),
(1546, NULL, 73, 'makeup'),
(1556, NULL, 70, 'makeup'),
(1557, NULL, 65, 'makeup'),
(1558, NULL, 70, 'makeup'),
(1559, NULL, 70, 'makeup'),
(1560, NULL, 15, 'sport'),
(1561, NULL, 65, 'makeup'),
(1562, NULL, 73, 'makeup'),
(1563, NULL, 73, 'makeup'),
(1564, NULL, 70, 'makeup'),
(1565, NULL, 73, 'makeup'),
(1566, NULL, 65, 'makeup'),
(1567, NULL, 65, 'makeup'),
(1568, NULL, 65, 'makeup'),
(1569, NULL, 70, 'makeup'),
(1570, NULL, 70, 'makeup'),
(1571, NULL, 65, 'makeup'),
(1572, NULL, 70, 'makeup'),
(1573, NULL, 65, 'makeup'),
(1574, NULL, 65, 'makeup'),
(1575, NULL, 73, 'makeup'),
(1576, NULL, 70, 'makeup'),
(1577, NULL, 70, 'makeup'),
(1578, NULL, 70, 'makeup'),
(1579, NULL, 70, 'makeup'),
(1580, NULL, 70, 'makeup'),
(1581, NULL, 70, 'makeup'),
(1582, NULL, 70, 'makeup'),
(1583, NULL, 70, 'makeup'),
(1588, NULL, 70, 'makeup'),
(1590, NULL, 70, 'makeup'),
(1591, 1, 69, 'makeup'),
(1592, 1, 70, 'makeup'),
(1593, 1, 70, 'makeup'),
(1594, 1, 65, 'makeup'),
(1595, 1, 70, 'makeup'),
(1596, 1, 65, 'makeup'),
(1597, 1, 70, 'makeup'),
(1598, 1, 70, 'makeup'),
(1599, 1, 70, 'makeup'),
(1600, 1, 65, 'makeup');

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE `search` (
  `id` int(11) NOT NULL,
  `search_key` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testevent`
--
-- in use(#1932 - Table 'ecommerce.testevent' doesn't exist in engine)
-- Error reading data: (#1932 - Table 'ecommerce.testevent' doesn't exist in engine)

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `used` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id`, `user_id`, `token`, `used`) VALUES
(1, 100, 'mytoken', 0),
(6, 1, '1|5963c6c7b64942.67237728', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pwd`, `username`) VALUES
(1, 'shady@yahoo.com', '123456', 'shady'),
(6, 'sheko_madrid@yahoo.com', '123456789behacked', 'sheko_ragi'),
(10, 'llotot@yaho.com', 'adasd54123456', 'shady@yahoo.com'),
(11, 'toto2@yahoo.com', 'ad6a5sd123456', 'shady@yahoo.com'),
(13, 'lslslsl@yahoo.com', 'ad56as6d123456', 'shady@yahoo.com'),
(15, 'aldalsd@asldas.com', 'ad5123456', 'shady@yahoo.com'),
(16, 'asfasf@yaola.sdocm', 'sd45asd45as4d54', 'shady@yahoo.com'),
(17, 'aldfslkfalkf@yaho.com', 'asd65as5123456', 'shady@yahoo.com'),
(18, 'skjdaksjf@yahoo.com', '123456asd56s6d5', 'shady@yahoo.com');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `usersdelete` AFTER DELETE ON `users` FOR EACH ROW BEGIN
DELETE FROM cart where user_id = old.id;
DELETE FROM wishlist where user_id = old.id;
DELETE FROM notification where user_id = old.id;
DELETE FROM history where user_id = old.id;
DELETE FROM search where user_id = old.id;
DELETE FROM productview where user_id = old.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `viewstable`
--

CREATE TABLE `viewstable` (
  `id` int(11) NOT NULL,
  `recordid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `viewstable`
--
DELIMITER $$
CREATE TRIGGER `viewtabletrigger` BEFORE INSERT ON `viewstable` FOR EACH ROW BEGIN
DELETE from productview WHERE id = new.recordid;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT '1',
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`user_id`, `product_id`, `product_name`, `price`, `qty`, `id`, `category`) VALUES
(2, 10, 'product 7', 60, 1, 12, 'technology'),
(2, 36, 'product 32', 20, 1, 13, 'cameras'),
(2, 42, 'product 38', 20, 1, 15, 'cameras'),
(1, 22, 'product 19', 20, 1, 16, 'sport'),
(1, 70, 'product 66', 20, 1, 17, 'makeup');

-- --------------------------------------------------------

--
-- Structure for view `bestseller`
--
DROP TABLE IF EXISTS `bestseller`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bestseller`  AS  select `product`.`id` AS `id`,`product`.`title` AS `title`,`product`.`image` AS `image`,`product`.`description` AS `description`,`product`.`price` AS `price`,`product`.`stock` AS `stock`,`product`.`dte` AS `dte`,`product`.`sold` AS `sold`,`product`.`categ` AS `categ`,`product`.`offers` AS `offers`,`product`.`new_price` AS `new_price` from `product` order by `product`.`sold` desc limit 4 ;

-- --------------------------------------------------------

--
-- Structure for view `latest_product`
--
DROP TABLE IF EXISTS `latest_product`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `latest_product`  AS  select `product`.`id` AS `id`,`product`.`title` AS `title`,`product`.`image` AS `image`,`product`.`description` AS `description`,`product`.`price` AS `price`,`product`.`stock` AS `stock`,`product`.`dte` AS `dte`,`product`.`sold` AS `sold`,`product`.`categ` AS `categ`,`product`.`offers` AS `offers`,`product`.`new_price` AS `new_price` from `product` order by `product`.`dte` desc ;

-- --------------------------------------------------------

--
-- Structure for view `offers`
--
DROP TABLE IF EXISTS `offers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `offers`  AS  select `product`.`id` AS `id`,`product`.`title` AS `title`,`product`.`image` AS `image`,`product`.`description` AS `description`,`product`.`price` AS `price`,`product`.`stock` AS `stock`,`product`.`dte` AS `dte`,`product`.`sold` AS `sold`,`product`.`categ` AS `categ`,`product`.`offers` AS `offers`,`product`.`new_price` AS `new_price` from `product` where (`product`.`offers` = 'yes') ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blocked`
--
ALTER TABLE `blocked`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productview`
--
ALTER TABLE `productview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search`
--
ALTER TABLE `search`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viewstable`
--
ALTER TABLE `viewstable`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blocked`
--
ALTER TABLE `blocked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `productview`
--
ALTER TABLE `productview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1601;
--
-- AUTO_INCREMENT for table `search`
--
ALTER TABLE `search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `viewstable`
--
ALTER TABLE `viewstable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `blockevent3` ON SCHEDULE AT '2017-07-17 07:06:59' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM blocked WHERE id = '3'$$

CREATE DEFINER=`root`@`localhost` EVENT `id109` ON SCHEDULE AT '2017-07-14 02:34:45' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE product SET offers = 'no' AND new_price = '0' WHERE id = '109'$$

CREATE DEFINER=`root`@`localhost` EVENT `blockevent6` ON SCHEDULE AT '2017-07-15 05:23:19' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM blocked WHERE id = '6'$$

CREATE DEFINER=`root`@`localhost` EVENT `blockevent4` ON SCHEDULE AT '2017-07-17 07:07:12' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM blocked WHERE id = '4'$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
