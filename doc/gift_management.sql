-- MySQL dump 10.13  Distrib 5.6.27, for osx10.10 (x86_64)
--
-- Host: localhost    Database: gift_management
-- ------------------------------------------------------
-- Server version	5.6.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `book_goods_mapping`
--

DROP TABLE IF EXISTS `book_goods_mapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_goods_mapping` (
  `gift_book_id` int(10) unsigned NOT NULL COMMENT '礼册id',
  `gift_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `gift_num` int(11) DEFAULT NULL COMMENT '商品数量',
  `ctime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`gift_book_id`,`gift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_goods_mapping`
--

LOCK TABLES `book_goods_mapping` WRITE;
/*!40000 ALTER TABLE `book_goods_mapping` DISABLE KEYS */;
INSERT INTO `book_goods_mapping` VALUES (3,1,1,'2015-12-08 20:16:14');
/*!40000 ALTER TABLE `book_goods_mapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `card_order`
--

DROP TABLE IF EXISTS `card_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `card_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_id` int(11) DEFAULT NULL COMMENT '销售员id，从user表获取',
  `custom_id` int(11) DEFAULT NULL COMMENT '客户id，从客户表取',
  `delever_id` int(11) DEFAULT NULL COMMENT '快递公司id',
  `expire_date` date DEFAULT NULL COMMENT '失效日期',
  `wechat_id` int(11) DEFAULT NULL COMMENT '微信模版id',
  `remark` text COMMENT '备注',
  `delivrer_num` varchar(45) DEFAULT NULL COMMENT '快递单号',
  `order_name` varchar(45) DEFAULT NULL COMMENT '册1*2，册2*3',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:待审核 2: 待发货 3: 已完成 4作废',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `card_order`
--

LOCK TABLES `card_order` WRITE;
/*!40000 ALTER TABLE `card_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `card_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `change_order`
--

DROP TABLE IF EXISTS `change_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `change_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_id` int(11) NOT NULL DEFAULT '0',
  `card_num` varchar(45) NOT NULL DEFAULT '',
  `gift_id` int(11) DEFAULT NULL COMMENT '选择兑换的商品id',
  `customer_name` varchar(45) DEFAULT NULL COMMENT '用户名称，收件人',
  `phone` varchar(45) DEFAULT NULL COMMENT '电话',
  `address` varchar(255) DEFAULT NULL COMMENT '收件地址',
  `postcode` varchar(45) DEFAULT NULL COMMENT '邮编',
  `deliver_id` int(11) DEFAULT NULL COMMENT '快递公司id',
  `deliver_date` datetime DEFAULT NULL COMMENT '发货日期',
  `remark` text COMMENT '备注',
  `status` int(11) DEFAULT NULL COMMENT '订单状态',
  `deliver_num` varchar(45) DEFAULT NULL COMMENT '快递单号',
  `order_source` int(11) NOT NULL COMMENT '订单来源，1: 电话，2: 官网，3:微信',
  `ctime` datetime DEFAULT NULL,
  `utime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`card_id`,`card_num`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `change_order`
--

LOCK TABLES `change_order` WRITE;
/*!40000 ALTER TABLE `change_order` DISABLE KEYS */;
INSERT INTO `change_order` VALUES (1,0,'1',1,'1','18500612974','North Fourth Ring Road','100080',1,'2015-12-16 00:00:00','1',1,'1',1,'2015-12-11 18:49:56','2015-12-11 18:49:56'),(2,0,'1',1,'1','18500612974','North Fourth Ring Road','100080',1,'2015-12-01 00:00:00','1',1,'1',1,'2015-12-11 18:51:29','2015-12-11 18:51:29'),(10000,0,'1',1,'1','18500612974','North Fourth Ring Road','100080',1,'2015-12-10 00:00:00','111',1,'1',1,'2015-12-11 19:02:01','2015-12-11 19:02:01');
/*!40000 ALTER TABLE `change_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '客户名称',
  `type` int(11) DEFAULT NULL COMMENT '1:代理商 2:企业大客户',
  `contact_person` varchar(45) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(45) DEFAULT NULL COMMENT '手机号',
  `address` varchar(45) DEFAULT NULL COMMENT '地址',
  `status` int(11) NOT NULL DEFAULT '2' COMMENT '1: 启用 2:停用',
  `ctime` datetime DEFAULT NULL COMMENT '创建时间',
  `utime` datetime DEFAULT NULL COMMENT '更新时间',
  `email` varchar(45) DEFAULT NULL COMMENT '邮箱',
  `postcode` varchar(45) DEFAULT NULL COMMENT '邮编',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'test',1,'333','13500612978','3',1,'2015-12-08 20:02:30','2015-12-08 20:02:30','fdfdfkd@163.com','110004','3'),(2,'kehumingcheng',1,'lianxiren','13445670000','huilongguan',1,'2015-12-08 20:03:15','2015-12-08 20:03:15','xxxxx@163.com','110004','fdkf'),(3,'333',1,'3333','18500612974','North Fourth Ring Road',1,'2015-12-08 20:21:56','2015-12-08 20:21:56','333kfd@163.com','100080','fdfdf'),(4,'44',1,'444','13456789876','44',1,'2015-12-09 20:44:55','2015-12-09 20:44:55','ffdfdkdfj@163.com','110004','444'),(5,'33',1,'333','13436544321','fdfdf',1,'2015-12-09 20:50:59','2015-12-09 20:50:59','nfdkfdkfd@163.com','110004','fdfdf'),(6,'fdfdfd',1,'fdfdfdf','18500612974','North Fourth Ring Road',1,'2015-12-09 20:52:03','2015-12-09 20:52:03','nefu@163.com','100080','fdfd'),(7,'cdsdsd',1,'11fdf','18500612974','North Fourth Ring Road',1,'2015-12-09 20:53:09','2015-12-09 20:53:09','ndfdkfjkdj@163.com','100080','');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deliver`
--

DROP TABLE IF EXISTS `deliver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deliver` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '快递自增ID',
  `name` varchar(20) NOT NULL COMMENT '快递名称',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(1:使用中,2:停用)',
  `remark` varchar(120) DEFAULT NULL COMMENT '备注',
  `ctime` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliver`
--

LOCK TABLES `deliver` WRITE;
/*!40000 ALTER TABLE `deliver` DISABLE KEYS */;
INSERT INTO `deliver` VALUES (1,'中通',1,NULL,NULL),(2,'申通',1,NULL,NULL),(3,'顺丰',1,NULL,NULL),(4,'京东',1,NULL,NULL);
/*!40000 ALTER TABLE `deliver` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dim`
--

DROP TABLE IF EXISTS `dim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dim` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `dim_id` int(10) unsigned NOT NULL COMMENT '维度类型ID',
  `dim_type` varchar(45) NOT NULL COMMENT '维度类型，gift_type: 商品类型，deliver:快递列表 3: wechat_style',
  `dim_value` varchar(45) NOT NULL COMMENT '维度值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dim`
--

LOCK TABLES `dim` WRITE;
/*!40000 ALTER TABLE `dim` DISABLE KEYS */;
/*!40000 ALTER TABLE `dim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entity_order`
--

DROP TABLE IF EXISTS `entity_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_order` (
  `id` int(11) NOT NULL,
  `sales` varchar(45) DEFAULT NULL,
  `deal_date` date DEFAULT NULL,
  `customer_name` varchar(45) DEFAULT NULL,
  `last_customer` varchar(45) DEFAULT NULL,
  `contact_person` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `entity_ordercol` varchar(45) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  `utime` datetime DEFAULT NULL,
  `order_name` varchar(255) DEFAULT NULL,
  `price` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `pay_remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entity_order`
--

LOCK TABLES `entity_order` WRITE;
/*!40000 ALTER TABLE `entity_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `entity_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gift`
--

DROP TABLE IF EXISTS `gift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `name` varchar(40) NOT NULL COMMENT '商品名称',
  `groupid` varchar(320) NOT NULL COMMENT '仅针对组合商品，33*2,34*4. 单品次字段为''''',
  `type` int(11) DEFAULT NULL COMMENT 'dim表id',
  `classify_id` int(11) DEFAULT NULL COMMENT '商品分类id',
  `brand_id` int(11) DEFAULT NULL COMMENT '商品品牌id',
  `supply_id` int(11) DEFAULT NULL COMMENT '商品供应商id',
  `sale_price` decimal(15,2) DEFAULT NULL COMMENT '销售价格',
  `buy_price` decimal(15,2) DEFAULT NULL COMMENT '采购价格',
  `store_num` int(11) DEFAULT NULL COMMENT '库存',
  `munit` varchar(45) DEFAULT NULL COMMENT '商品计量单位',
  `deliver_id` int(11) DEFAULT NULL COMMENT '快递id',
  `desciption` text COMMENT '商品描述',
  `pic_ids` varchar(255) DEFAULT NULL COMMENT '宣传图片id，用逗号的拼接列表',
  `remark` text COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态 1: 上架， 2 下架',
  `ctime` datetime DEFAULT NULL COMMENT '创建时间',
  `utime` datetime DEFAULT NULL COMMENT '更新时间',
  `sold_num` int(11) NOT NULL DEFAULT '0' COMMENT '售出数量，初始为0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gift`
--

LOCK TABLES `gift` WRITE;
/*!40000 ALTER TABLE `gift` DISABLE KEYS */;
INSERT INTO `gift` VALUES (1,'test','',1,3,2,1,12.00,2.00,10,'个',1,'搜索','poster.jpg,','test',1,'2015-11-28 20:50:36','2015-12-04 23:57:18',0),(2,'test','1,',2,2,3,1,12.00,2.00,12,'个',1,'test','vimeo (1).png,','test',1,'2015-11-28 20:52:13','2015-12-01 10:01:56',0),(3,'qwe','1*2,',2,NULL,2,NULL,10.00,6.00,0,'个',1,'test11','test2.jpg,','',1,'2015-11-30 23:53:14','2015-11-30 23:53:14',0),(4,'qwe','1*2',2,NULL,5,NULL,12.00,6.00,0,'个',1,'sss','test2.jpg,','',1,'2015-11-30 23:55:45','2015-11-30 23:55:45',0),(5,'13333','',1,1,2,1,1.00,1.00,1,'1',1,'1','2,','1',1,'2015-12-08 20:16:45','2015-12-08 20:16:45',0);
/*!40000 ALTER TABLE `gift` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gift_book`
--

DROP TABLE IF EXISTS `gift_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '礼册名称',
  `theme_id` int(11) DEFAULT NULL COMMENT '礼册主题id',
  `set_id` int(11) DEFAULT NULL COMMENT '礼册系列id',
  `wechat_id` int(11) DEFAULT NULL COMMENT '微信模版id',
  `type_id` int(11) DEFAULT NULL COMMENT '礼册类型id 1: 普通 2: 年卡 3: 半年卡 4:季卡',
  `sale_price` float DEFAULT NULL COMMENT '销售价格',
  `group_ids` varchar(255) DEFAULT NULL COMMENT '33*3,34*2',
  `describe` text COMMENT '礼册描述',
  `pic_id` int(11) DEFAULT NULL COMMENT '上传后，需要保存到 media表',
  `remark` text COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: 启用 2: 停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gift_book`
--

LOCK TABLES `gift_book` WRITE;
/*!40000 ALTER TABLE `gift_book` DISABLE KEYS */;
INSERT INTO `gift_book` VALUES (1,'热热',1,2,1,1,400,'1*23,3*32,','ess',1,'dsf',1),(2,'sscc',3,1,2,3,300,'1*1,',NULL,2,'cccdd',1),(3,'tes',1,1,NULL,1,12,'1*2',NULL,NULL,'ccc',1),(4,'testc',1,1,NULL,1,12,'2*2',NULL,NULL,'ccssddd',1),(5,'热热s',1,2,NULL,1,400,'1*2',NULL,NULL,'dsf',1),(6,'tswd',1,1,NULL,1,10,'1*2','cccc',0,'sdc',1),(7,'33',1,1,NULL,1,3,'1',NULL,NULL,'3',1);
/*!40000 ALTER TABLE `gift_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gift_brand`
--

DROP TABLE IF EXISTS `gift_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '品牌名称',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:使用 2:停用',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gift_brand`
--

LOCK TABLES `gift_brand` WRITE;
/*!40000 ALTER TABLE `gift_brand` DISABLE KEYS */;
INSERT INTO `gift_brand` VALUES (1,'小鸟依人',2,'testa'),(2,'阿三时尚',1,'tests'),(3,'圣诞狂欢',1,'test'),(4,'测试',2,'test'),(5,'fkdjkf',1,'fdfd');
/*!40000 ALTER TABLE `gift_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gift_card`
--

DROP TABLE IF EXISTS `gift_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_code` int(11) DEFAULT NULL COMMENT '礼品卡号码',
  `password` int(11) DEFAULT NULL COMMENT '密码',
  `ctime` varchar(45) DEFAULT NULL COMMENT '生成时间',
  `status` int(11) NOT NULL DEFAULT '3' COMMENT '状态 1: 未激活 2: 已激活 3:已使用 4: 已过期 5: 已退卡 6: 冻结',
  `book_id` int(11) NOT NULL COMMENT '礼册id',
  `discount` decimal(15,2) DEFAULT NULL COMMENT '折扣 0-10',
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gift_card`
--

LOCK TABLES `gift_card` WRITE;
/*!40000 ALTER TABLE `gift_card` DISABLE KEYS */;
INSERT INTO `gift_card` VALUES (1,1,1,NULL,3,3,NULL,NULL);
/*!40000 ALTER TABLE `gift_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gift_classify`
--

DROP TABLE IF EXISTS `gift_classify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '分类名称',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:使用 2:停用',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gift_classify`
--

LOCK TABLES `gift_classify` WRITE;
/*!40000 ALTER TABLE `gift_classify` DISABLE KEYS */;
INSERT INTO `gift_classify` VALUES (1,'生日',1,'test'),(2,'结婚',1,'wer'),(3,'朋友送礼',1,NULL),(4,'fdf',1,'fdfd');
/*!40000 ALTER TABLE `gift_classify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gift_supply`
--

DROP TABLE IF EXISTS `gift_supply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gift_supply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '品牌名称',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:使用 2:停用',
  `remark` text COMMENT '备注',
  `contact_person` varchar(45) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(45) DEFAULT NULL COMMENT '手机号',
  `qq` varchar(45) DEFAULT NULL COMMENT 'qq号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gift_supply`
--

LOCK TABLES `gift_supply` WRITE;
/*!40000 ALTER TABLE `gift_supply` DISABLE KEYS */;
INSERT INTO `gift_supply` VALUES (1,'电信',1,'sss','pbchen','1234567876','123245643'),(2,'网通',2,'hgfds',NULL,NULL,NULL),(3,'国美',1,NULL,NULL,NULL,NULL),(4,'苏宁',2,NULL,NULL,NULL,NULL),(5,'test',1,'qwwz','pbchen','123456543','123654');
/*!40000 ALTER TABLE `gift_supply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map_order_card`
--

DROP TABLE IF EXISTS `map_order_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map_order_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `card_id` int(11) NOT NULL COMMENT '礼品卡id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map_order_card`
--

LOCK TABLES `map_order_card` WRITE;
/*!40000 ALTER TABLE `map_order_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `map_order_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL COMMENT '存储路径,包括商品图片，多媒体管理里面的图片／视频／音频',
  `name` varchar(45) DEFAULT NULL COMMENT '名称',
  `status` int(11) NOT NULL DEFAULT '2' COMMENT '1:停用 2启用',
  `ctime` datetime DEFAULT NULL COMMENT '创建时间',
  `utime` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (14,'img/20151211/6c6ae4/','252.jpg',1,'2015-12-11 11:15:11','2015-12-11 11:15:11'),(15,'img/20151211/3e57b3/','252.jpg',1,'2015-12-11 11:23:42','2015-12-11 11:23:42'),(16,'img/20151211/0e6242/','252.jpg',1,'2015-12-11 11:24:15','2015-12-11 11:24:15'),(17,'img/20151211/18a8bd/','252.jpg',1,'2015-12-11 11:43:29','2015-12-11 11:43:29'),(18,'img/20151211/abd20b/','252.jpg',1,'2015-12-11 11:54:16','2015-12-11 11:54:16'),(19,'img/20151211/4f7cbe/','252.jpg',1,'2015-12-11 11:58:35','2015-12-11 11:58:35'),(20,'img/20151211/77d183/','252.jpg',1,'2015-12-11 11:59:04','2015-12-11 11:59:04'),(21,'img/20151211/772632/','252.jpg',1,'2015-12-11 12:00:10','2015-12-11 12:00:10'),(22,'img/20151211/dc02f0/','252.jpg',1,'2015-12-11 12:12:41','2015-12-11 12:12:41');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mediainfo`
--

DROP TABLE IF EXISTS `mediainfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mediainfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `media_id` int(11) NOT NULL COMMENT '存储路径,包括商品图片，多媒体管理里面的图片／视频／音频',
  `name` varchar(45) DEFAULT NULL COMMENT '名称',
  `status` int(11) NOT NULL DEFAULT '2' COMMENT '1:停用 2启用',
  `ctime` datetime DEFAULT NULL COMMENT '创建时间',
  `utime` datetime DEFAULT NULL COMMENT '更新时间',
  `type` int(11) DEFAULT NULL,
  `author` varchar(45) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mediainfo`
--

LOCK TABLES `mediainfo` WRITE;
/*!40000 ALTER TABLE `mediainfo` DISABLE KEYS */;
INSERT INTO `mediainfo` VALUES (14,19,'3',1,'2015-12-11 11:58:38','2015-12-11 11:58:38',1,'e',NULL,'2015-12-08'),(15,20,'r',1,'2015-12-11 11:59:06','2015-12-11 11:59:06',1,'fd',NULL,'2015-12-08'),(16,21,'33',1,'2015-12-11 12:00:11','2015-12-11 12:00:11',1,'33','333','2015-12-15'),(17,22,'ffd',1,'2015-12-11 12:12:44','2015-12-11 12:12:44',1,'fdfd','fdfd','2015-12-15');
/*!40000 ALTER TABLE `mediainfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `name` varchar(45) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'普通用户'),(2,'管理员'),(3,'超级管理员');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `set`
--

DROP TABLE IF EXISTS `set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `set` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '系列ID',
  `name` varchar(45) NOT NULL COMMENT '系列名',
  `remark` text COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: 启用 2: 停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `set`
--

LOCK TABLES `set` WRITE;
/*!40000 ALTER TABLE `set` DISABLE KEYS */;
INSERT INTO `set` VALUES (1,'春晚','测试',1),(2,'秋意浓','cc',1),(3,'123','测测',1);
/*!40000 ALTER TABLE `set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '主题名',
  `remark` text COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: 启用 2: 停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme`
--

LOCK TABLES `theme` WRITE;
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;
INSERT INTO `theme` VALUES (1,'天花乱坠','双方都',1),(2,'小林别克1','菜市场11111',2),(3,'通天塔','1233饿肚肚',1);
/*!40000 ALTER TABLE `theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `user_name` varchar(45) NOT NULL COMMENT '账号4-15数字字母任意组合',
  `nick_name` varchar(42) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL COMMENT '密码',
  `email` varchar(45) DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(45) DEFAULT NULL COMMENT '手机号',
  `role` int(11) DEFAULT NULL COMMENT '角色身份id',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'pbchen','小城别顾','e10adc3949ba59abbe56e057f20f883e','294306275@qq.com','15201421881',1,'2015-11-24 13:14:05');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_book_card`
--

DROP TABLE IF EXISTS `view_book_card`;
/*!50001 DROP VIEW IF EXISTS `view_book_card`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_book_card` AS SELECT 
 1 AS `num_code`,
 1 AS `expire_date`,
 1 AS `book_id`,
 1 AS `book_name`,
 1 AS `sale_price`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_book_gift`
--

DROP TABLE IF EXISTS `view_book_gift`;
/*!50001 DROP VIEW IF EXISTS `view_book_gift`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_book_gift` AS SELECT 
 1 AS `gift_id`,
 1 AS `book_id`,
 1 AS `gift_name`,
 1 AS `sale_price`,
 1 AS `store_num`,
 1 AS `sold_num`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_order_gift_card`
--

DROP TABLE IF EXISTS `view_order_gift_card`;
/*!50001 DROP VIEW IF EXISTS `view_order_gift_card`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_order_gift_card` AS SELECT 
 1 AS `id`,
 1 AS `card_num`,
 1 AS `gift_id`,
 1 AS `gift_name`,
 1 AS `customer_name`,
 1 AS `phone`,
 1 AS `address`,
 1 AS `deliver_id`,
 1 AS `status`,
 1 AS `deliver_num`,
 1 AS `order_source`,
 1 AS `book_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `website`
--

DROP TABLE IF EXISTS `website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL COMMENT '网站名称',
  `type` int(11) DEFAULT NULL COMMENT '1:兑换网站 2:礼册商城',
  `domain` varchar(45) DEFAULT NULL COMMENT '绑定域名',
  `hotline` varchar(45) DEFAULT NULL COMMENT '客服热线',
  `qq` varchar(45) DEFAULT NULL COMMENT 'qq号码',
  `expire_date` date DEFAULT NULL COMMENT '有效期',
  `pic_id` int(11) DEFAULT NULL COMMENT 'log id，来自呀media表',
  `description` text COMMENT '描述',
  `remark` varchar(45) DEFAULT NULL COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: 启用 2:停用',
  `ctime` datetime DEFAULT NULL COMMENT '创建时间',
  `utime` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website`
--

LOCK TABLES `website` WRITE;
/*!40000 ALTER TABLE `website` DISABLE KEYS */;
INSERT INTO `website` VALUES (1,'111',1,'3','3','3','2015-12-09',0,'3','3',1,'2015-12-09 20:06:12','2015-12-09 20:06:12'),(2,'2',1,'2','2','2','2015-12-09',0,'2','2',1,'2015-12-09 20:09:44','2015-12-09 20:09:44'),(3,'2',1,'3','3','3','2015-12-09',0,'3','3',1,'2015-12-09 20:11:19','2015-12-09 20:11:19'),(4,'44',1,'444','444','444','2015-12-11',0,'333','333',1,'2015-12-09 20:24:50','2015-12-09 20:24:50'),(5,'44',1,'444','444','444','2015-12-11',0,'333','333',1,'2015-12-09 20:28:21','2015-12-09 20:28:21'),(6,'3',1,'3','44','444','2015-12-17',0,'4','4',1,'2015-12-09 20:41:43','2015-12-09 20:41:43'),(7,'3',1,'3','44','444','2015-12-17',0,'4','4',1,'2015-12-09 20:43:26','2015-12-09 20:43:26'),(8,'3',1,'3','44','444','2015-12-17',0,'4','4',1,'2015-12-09 20:43:28','2015-12-09 20:43:28'),(9,'6',1,'6','6','6','2015-12-09',0,'6','6',1,'2015-12-09 20:43:40','2015-12-09 20:43:40'),(10,'3',1,'44','','55','2015-12-09',0,'555','555',1,'2015-12-09 20:44:07','2015-12-09 20:44:07'),(11,'3',1,'44','','55','2015-12-09',0,'555','555',1,'2015-12-09 20:44:08','2015-12-09 20:44:08'),(12,'3',1,'3','3','3','2015-12-01',0,'3','3',1,'2015-12-09 20:46:29','2015-12-09 20:46:29'),(13,'3',1,'3','3','3','2015-12-01',0,'3','3',1,'2015-12-09 20:46:30','2015-12-09 20:46:30'),(14,'3',1,'3','3','3','2015-12-01',0,'3','3',1,'2015-12-09 20:46:43','2015-12-09 20:46:43'),(15,'3',1,'3','3','3','2015-12-01',0,'3','3',1,'2015-12-09 20:47:28','2015-12-09 20:47:28'),(16,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:42','2015-12-09 20:47:42'),(17,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:43','2015-12-09 20:47:43'),(18,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:44','2015-12-09 20:47:44'),(19,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:44','2015-12-09 20:47:44'),(20,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:44','2015-12-09 20:47:44'),(21,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:45','2015-12-09 20:47:45'),(22,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:45','2015-12-09 20:47:45'),(23,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:45','2015-12-09 20:47:45'),(24,'3',1,'3','3','3','2015-12-08',0,'3','3',1,'2015-12-09 20:47:46','2015-12-09 20:47:46'),(25,'333',1,'33','33','333','2015-12-08',0,'33','333',1,'2015-12-09 20:57:28','2015-12-09 20:57:28'),(26,'4',1,'4','4','4','2015-12-22',0,'4','',1,'2015-12-09 20:58:05','2015-12-09 20:58:05'),(27,'44',1,'444','4444','4444','2015-12-16',0,'444','',1,'2015-12-09 20:58:41','2015-12-09 20:58:41'),(28,'444',1,'444','4444','4444','2015-12-08',0,'444','444',1,'2015-12-09 20:59:18','2015-12-09 20:59:18'),(29,'gf',1,'gfgf','gfggfgf','gfgf','1970-01-01',0,'gfg','',1,'2015-12-09 20:59:47','2015-12-09 20:59:47'),(30,'gf',1,'gfgf','gfggfgf','gfgf','1970-01-01',0,'gfg','',1,'2015-12-09 21:02:29','2015-12-09 21:02:29'),(31,'name',2,'domain','010303003','476401','2015-12-22',0,'3333','3333',1,'2015-12-09 21:53:51','2015-12-09 21:53:51');
/*!40000 ALTER TABLE `website` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat`
--

DROP TABLE IF EXISTS `wechat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT '模版名称',
  `style` int(11) DEFAULT NULL COMMENT '样式，从dim 取wechat_style',
  `pic_id` int(11) DEFAULT NULL COMMENT '图片id',
  `audio_id` varchar(45) DEFAULT NULL COMMENT '音频id',
  `vedio_id` varchar(45) DEFAULT NULL COMMENT '视频id',
  `copywriter` text COMMENT '文案',
  `url` varchar(255) DEFAULT NULL COMMENT '网址',
  `expire_time` date DEFAULT NULL COMMENT '有效期',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1: 启用 2:停用',
  `sender` varchar(45) DEFAULT NULL,
  `reciver` varchar(45) DEFAULT NULL,
  `remark` text COMMENT '备注',
  `ctime` datetime DEFAULT NULL,
  `utime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat`
--

LOCK TABLES `wechat` WRITE;
/*!40000 ALTER TABLE `wechat` DISABLE KEYS */;
INSERT INTO `wechat` VALUES (1,'3',1,3,'3','3','z',NULL,NULL,1,'s','r','b','2015-12-10 21:51:41','2015-12-10 21:51:41'),(2,'2',1,2,'2','2','z',NULL,NULL,1,'s','r','b','2015-12-10 22:05:22','2015-12-10 22:05:22');
/*!40000 ALTER TABLE `wechat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `view_book_card`
--

/*!50001 DROP VIEW IF EXISTS `view_book_card`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_book_card` AS select `a`.`num_code` AS `num_code`,`a`.`expire_date` AS `expire_date`,`b`.`id` AS `book_id`,`b`.`name` AS `book_name`,`b`.`sale_price` AS `sale_price` from (`gift_card` `a` join `gift_book` `b` on((`a`.`book_id` = `b`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_book_gift`
--

/*!50001 DROP VIEW IF EXISTS `view_book_gift`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_book_gift` AS select `a`.`id` AS `gift_id`,`b`.`gift_book_id` AS `book_id`,`a`.`name` AS `gift_name`,`a`.`sale_price` AS `sale_price`,`a`.`store_num` AS `store_num`,`a`.`sold_num` AS `sold_num` from (`gift` `a` join `book_goods_mapping` `b` on((`a`.`id` = `b`.`gift_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_order_gift_card`
--

/*!50001 DROP VIEW IF EXISTS `view_order_gift_card`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_order_gift_card` AS select `a`.`id` AS `id`,`a`.`card_num` AS `card_num`,`a`.`gift_id` AS `gift_id`,`b`.`name` AS `gift_name`,`a`.`customer_name` AS `customer_name`,`a`.`phone` AS `phone`,`a`.`address` AS `address`,`a`.`deliver_id` AS `deliver_id`,`a`.`status` AS `status`,`a`.`deliver_num` AS `deliver_num`,`a`.`order_source` AS `order_source`,`c`.`book_id` AS `book_id` from ((`change_order` `a` join `gift` `b`) join `gift_card` `c` on(((`a`.`gift_id` = `b`.`id`) and (`a`.`card_num` = `c`.`num_code`)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-12 13:23:25