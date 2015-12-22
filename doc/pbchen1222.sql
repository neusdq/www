/*
SQLyog v10.2 
MySQL - 5.5.5-10.0.17-MariaDB : Database - gift_management
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `gift_management`;

/*Table structure for table `sales_order_book` */

DROP TABLE IF EXISTS `sales_order_book`;

CREATE TABLE `sales_order_book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `book_id` bigint(20) NOT NULL COMMENT '礼册ID',
  `book_name` varchar(40) NOT NULL COMMENT '礼册名',
  `price` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `discount` decimal(15,2) DEFAULT NULL COMMENT '折扣',
  `scode` bigint(20) NOT NULL COMMENT '开始号码',
  `ecode` bigint(20) NOT NULL COMMENT '结束号码',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `sales_order_book` */

insert  into `sales_order_book`(`id`,`order_id`,`book_id`,`book_name`,`price`,`discount`,`scode`,`ecode`,`num`) values (1,6,1,'热热','20.00','1.00',10000,20000,10001);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
