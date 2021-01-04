USE project_manager;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `project_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id_id1` (`project_id`),
  CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `employees` WRITE; 
LOCK TABLES `projects` WRITE; 

ALTER TABLE `project_manager`.`projects` 
AUTO_INCREMENT = 5 ;

ALTER TABLE `project_manager`.`projects` 
AUTO_INCREMENT = 5 ;

LOCK TABLES `projects` WRITE;
INSERT INTO `projects` VALUES (1,'Finances'),(2,'Engineering'),(3,'Architecture');

LOCK TABLES `employees` WRITE;
INSERT INTO `employees` VALUES (1,'Andrius',2),(2,'Viktoras',1),(3,'Julia',2);

UNLOCK TABLES;
