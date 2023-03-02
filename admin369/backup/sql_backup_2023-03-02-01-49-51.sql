DROP TABLE IF EXISTS `categorias`; 

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorias` VALUES(`1`,`Literatura`);




DROP TABLE IF EXISTS `files`; 

CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `file_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `files` VALUES(`1`,`O Livro Perdido de Enki.pdf`,``);






DROP TABLE IF EXISTS `stand`; 

CREATE TABLE `stand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `file_id` int(10) NOT NULL,
  `img` varchar(100) NOT NULL,
  `category` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`category`)),
  `view` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `stand` VALUES(`1`,`O Pequeno Principe`,`1`,`pequeno_principe.png`,`{\"Literatura\":\"1\"}`,`1`);












DROP TABLE IF EXISTS `view`; 

CREATE TABLE `view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stand` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;





DROP TABLE IF EXISTS `who-access`; 

CREATE TABLE `who-access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(100) NOT NULL,
  `book` int(100) NOT NULL,
  `register` varchar(100) NOT NULL,
  `json-resp` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`json-resp`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `who-access` VALUES(`1`,`127.0.0.1`,`1`,`01/03/2023 21:47:10 PM`,`{\"ip\":\"127.0.0.1\",\"country_code\":\"\",\"country_name\":\"\",\"region_code\":\"\",\"region_name\":\"\",\"city\":\"\",\"zip_code\":\"\",\"time_zone\":\"\",\"latitude\":0,\"longitude\":0,\"metro_code\":0}`);










