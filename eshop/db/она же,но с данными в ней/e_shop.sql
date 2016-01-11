SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `pubyear` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

INSERT INTO `catalog` (`id`, `title`, `author`, `pubyear`, `price`) VALUES
(4, 'O''Rielly', 'O''brian', 2015, 322323.56),
(5, 'Чебурашка', 'Дима', 2015, 300.45),
(6, 'Незнайка на пизде', 'O''brian', 2014, 16.56),
(7, '12 оттенков', 'O''brian', 2015, 4000.65),
(8, 'Симпсоны', 'DIMMA', 2015, 254.46),
(9, 'как заработать пиздюлей', 'O''Rielly and O''brian', 2010, 845.16),
(10, 'Парк Горького все альбомы', 'Gorky Par''ks', 1995, 500.5);

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `pubyear` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `orderid` varchar(50) NOT NULL DEFAULT '',
  `datetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

INSERT INTO `orders` (`id`, `title`, `author`, `pubyear`, `price`, `quantity`, `orderid`, `datetime`) VALUES
(19, 'Симпсоны', 'DIMMA', 2015, 254.46, 1, '5561a6afe18e24.23658868', 1432463653),
(20, 'как заработать пиздюлей', 'O''Rielly and O''brian', 2010, 845.16, 1, '5561a6afe18e24.23658868', 1432463653),
(21, 'Чебурашка', 'Дима', 2015, 300.45, 1, '5561a9260f07b8.52565993', 1432463678),
(22, 'Чебурашка', 'Дима', 2015, 300.45, 1, '5561a93ef15ae4.05724614', 1432574964),
(23, 'Незнайка на пизде', 'O''brian', 2014, 16.56, 1, '5561a93ef15ae4.05724614', 1432574964),
(24, '12 оттенков', 'O''brian', 2015, 4000.65, 1, '55635bf623cc28.92311180', 1432673717),
(25, 'Парк Горького все альбомы', 'Gorky Par''ks', 1995, 500.5, 1, '55635bf623cc28.92311180', 1432673717);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
