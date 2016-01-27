/*
SQLyog Community v11.01 (64 bit)
MySQL - 5.5.46-0ubuntu0.12.04.2 : Database - sgc_web
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
  `publish_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `articles` */

insert  into `articles`(`id`,`title`,`slug`,`body`,`created_at`,`author`,`excerpt`,`published`,`publish_date`) values (1,'articol 1','/articol-initial','<p>&nbsp; lorem ipsum</p>\r\n<p><img src=\"../../img/media/a75d46599a9471d5892a09d34811f9e7.jpg\" alt=\"tedfaf as\" width=\"600\" height=\"400\" />&nbsp;</p>\r\n<p>fsdaetsfsd fsdaf</p>\r\n<p>&nbsp;</p>\r\n<p>s adfdsaf dsaf saf</p>\r\n<p>f sdaf</p>\r\n<p>s adfdsads fsad fsadf</p>','2016-01-17 13:31:49','io',NULL,0,NULL),(2,'geta','cine-i-geta','<p>f sdaf asdf afdsaf asd</p>',NULL,'io',NULL,0,NULL),(3,'sdaf sdaf','dsafsadf','<p>dsaf asdfasfs adfsf</p>',NULL,'sdafdasf',NULL,0,NULL),(4,'getafe','dfse','<p>d fsdaf sdafsa<strong>f sdafsdaf sdaf</strong>dsf</p>\r\n<p>fds afdsaf sdaf</p>\r\n<p>ds fsaf</p>\r\n<h2>dsf dsafsdaf sadf</h2>\r\n<p>&nbsp;</p>',NULL,'afea',NULL,0,NULL),(6,'articol 5','articol-6','<p>dsf asdfasf sdaf dsfsaf sda</p>',NULL,'tibi sd',NULL,0,NULL),(7,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),(8,'fdsaf','sdf asdf ','<p>&nbsp;sdaf fsadf</p>',NULL,' asdf sadf',NULL,0,NULL),(9,'Pagina cautata nu exista','/404','ne pare rau, \r\npagina cautata nu exista',NULL,NULL,NULL,0,NULL);

/*Table structure for table `articles_categories` */

DROP TABLE IF EXISTS `articles_categories`;

CREATE TABLE `articles_categories` (
  `article_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `articles_categories` */

insert  into `articles_categories`(`article_id`,`category_id`) values (1,1),(2,2),(3,2),(6,2),(8,1),(9,1);

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
  `link` varchar(255) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `sort_index` int(11) DEFAULT '0',
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `menu_items` */

insert  into `menu_items`(`id`,`title`,`link`,`parent`,`sort_index`,`menu_id`) values (1,'Despre Noi','/despre',NULL,1,1),(2,'Organizare','/organizare',NULL,2,1),(3,'Cursanti','#',NULL,3,1),(4,'Submeniu 1','/cursanti/pagina1',3,1,1),(5,'Submeniu 2','/cursanti/pagin2',3,2,1),(6,'Cadre Didactice','/cadre',NULL,5,1),(7,'Resurse','/resurse',NULL,6,1),(8,'Resurse 12','/resurse/submeniu1',7,1,1),(9,'Resurse 2','/resurse/pagina2',7,2,1),(10,'Contact','/contact',NULL,7,1);

/*Table structure for table `site_configs` */

DROP TABLE IF EXISTS `site_configs`;

CREATE TABLE `site_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(255) DEFAULT NULL,
  `key_value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `site_configs` */

insert  into `site_configs`(`id`,`key_name`,`key_value`) values (1,'main_menu','[\r\n{\"id\": \"1\", \"parent\": \"#\", \"text\":\"Despre Noi\"}, \r\n{\"id\": \"2\", \"parent\": \"#\", \"text\":\"contact\"},\r\n{\"id\": \"3\", \"parent\": \"#\", \"text\": \"resurse\"}, \r\n{\"id\": \"4\", \"parent\": \"3\", \"text\": \"resurse 1\" }]');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
