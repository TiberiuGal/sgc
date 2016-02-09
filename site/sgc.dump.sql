/*
SQLyog Community v11.01 (64 bit)
MySQL - 5.5.47-0ubuntu0.12.04.1 : Database - sgc_web
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sgc_web` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sgc_web`;

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `body` text,
  `created_at` datetime DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `excerpt` text,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `publish_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `articles` */

insert  into `articles`(`id`,`title`,`slug`,`body`,`created_at`,`author`,`excerpt`,`published`,`publish_date`) values (1,'articol 1','/articol-initial','<p>&nbsp; lorem ipsum</p>\r\n<p><img src=\"../../img/media/a75d46599a9471d5892a09d34811f9e7.jpg\" alt=\"tedfaf as\" width=\"600\" height=\"400\" />&nbsp;</p>\r\n<p>fsdaetsfsd fsdaf</p>\r\n<p>&nbsp;</p>\r\n<p>s adfdsaf dsaf saf</p>\r\n<p>f sdaf</p>\r\n<p>s adfdsads fsad fsadf</p>','2016-01-17 13:31:49','scoala christiana',NULL,0,NULL),(2,'geta','/stire-2','<p>f sdaf asdf afdsaf asd</p>','2016-01-17 13:31:49','scoala christiana','test stire f sdf  sdf\r\nds fsadf sfdsf ',0,'2016-02-01'),(3,'sdaf sdaf','/stire-1','<p>dsaf asdfasfs adfsf</p>','2016-01-17 13:31:49','scoala christiana',' fsdaf sfdsf \r\nf sd\r\nf sfsdf \r\nsf sdfsdfsf dsfewf dfasdg',0,'2016-02-03'),(4,'Bine ati venit','/','<p>d fsdaf sdafsa<strong>f sdafsdaf sdaf</strong>dsf</p>\r\n<p>fds afdsaf sdaf</p>\r\n<p>ds fsaf</p>\r\n<h2>dsf dsafsdaf sadf</h2>\r\n<p>&nbsp;</p>',NULL,'scoala christiana','Bine ati venit la scoala gimnaziala christiana',0,'2016-02-01'),(6,'Cadre Didactice','/cadre','<p>dsf asdfasf sdaf dsfsaf sda</p>',NULL,'scoala christiana',NULL,0,NULL),(7,'Resurse 2','/resurse/submeniu2','<p>resurse 2</p>',NULL,'scoala christiana','pe scurt',0,'0000-00-00'),(8,'Oragnizare','/organizare','<p>&nbsp;sdaf fsadf</p>',NULL,'scoala christiana',NULL,0,NULL),(9,'Pagina cautata nu exista','/404','ne pare rau, \r\npagina cautata nu exista',NULL,'scoala christiana',NULL,0,NULL),(10,'Despre Noi','/despre','<p>sd afsadf sdfsadf</p>\r\n<p>fs adfsdf sdfsdf sdfsd fsdfs fsdfsadffds afsadf s</p>',NULL,'scoala christiana','dssdfa fsa fdsfsadfs  sdaf',0,NULL),(11,'Resurse','/resurse','<p>sda fasdf sadfasdf sadfsadfs</p>\r\n<p>df asdf</p>\r\n<p>sdfsadfsdfs</p>',NULL,'scoala christiana','sdff sadfsad fsda fsdaf sdafads',0,NULL),(12,'Resurse 1','/resurse/submeniu1','<p>despre noi</p>\r\n<p>{$lista_resurse}&nbsp;</p>\r\n<p>sdf sfsdfsf sdf</p>',NULL,'scoala christiana','resurse',0,'2016-01-05'),(13,'Cursanti 1','/cursanti/submeniu1','<p>sd afsadf sdfsadf</p>\r\n<p>fs adfsdf sdfsdf sdfsd fsdfs fsdfsadffds afsadf s</p>',NULL,NULL,NULL,0,NULL),(14,'Cursanti 2','/cursanti/submeniu2','<p>sd afsadf sdfsadf</p>\r\n<p>fs adfsdf sdfsdf sdfsd fsdfs fsdfsadffds afsadf s</p>',NULL,NULL,NULL,0,NULL);

/*Table structure for table `articles_categories` */

DROP TABLE IF EXISTS `articles_categories`;

CREATE TABLE `articles_categories` (
  `article_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `articles_categories` */

insert  into `articles_categories`(`article_id`,`category_id`) values (1,1),(2,2),(3,2),(4,1),(6,2),(7,1),(8,1),(9,1),(12,1);

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`title`) values (1,'pages'),(2,'news');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`id`,`title`) values (1,'meniu principal'),(2,'footer');

/*Table structure for table `menu_items` */

DROP TABLE IF EXISTS `menu_items`;

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `sort_index` int(11) DEFAULT '0',
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `menu_items` */

insert  into `menu_items`(`id`,`title`,`article_id`,`slug`,`parent`,`sort_index`,`menu_id`) values (1,'Despre Noi',10,'/despre',NULL,1,1),(2,'Organizare',8,'/organizare',NULL,2,1),(3,'Cursanti',NULL,'#',NULL,3,1),(4,'Submeniu 1',13,'/cursanti/submeniu1',3,1,1),(5,'Submeniu 2',14,'/cursanti/submeniu2',3,2,1),(6,'Cadre Didactice',6,'/cadre',NULL,5,1),(7,'Resurse',11,'/resurse',NULL,6,1),(8,'Resurse 1',12,'/resurse/submeniu1',7,1,1),(9,'Resurse 2',7,'/resurse/submeniu2',7,2,1),(10,'Contact',NULL,'/contact',NULL,7,1);

/*Table structure for table `resources` */

DROP TABLE IF EXISTS `resources`;

CREATE TABLE `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `published` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `resources` */

insert  into `resources`(`id`,`title`,`description`,`file_name`,`file_type`,`file_size`,`published`,`created_at`) values (1,'sdf fsdf safd',NULL,'d0afcd6feb90c3fe09d83c30b213705b.jpg','jpg',1173710,1,NULL),(2,'tesdff','sdfsaf','c86c5e1f570ea952575bf8ffaeca1ecd.jpg','jpg',1306529,1,NULL);

/*Table structure for table `site_configs` */

DROP TABLE IF EXISTS `site_configs`;

CREATE TABLE `site_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(255) DEFAULT NULL,
  `key_value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `site_configs` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
