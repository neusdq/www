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
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `entity_order`
--

DROP TABLE IF EXISTS `entity_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales` varchar(45) DEFAULT NULL,
  `deal_date` date DEFAULT NULL,
  `enduser` varchar(45) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  `utime` datetime DEFAULT NULL,
  `order_name` varchar(255) DEFAULT NULL,
  `price` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `pay_remark` varchar(255) DEFAULT NULL,
  `oper_person` varchar(45) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entity_order_book_map`
--

DROP TABLE IF EXISTS `entity_order_book_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entity_order_book_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eorder_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `book_count` int(11) DEFAULT NULL,
  `sum_price` int(11) DEFAULT NULL,
  `book_remark` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  `utime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exchange_order_detail`
--

DROP TABLE IF EXISTS `exchange_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exchange_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `to_gift` int(11) DEFAULT NULL,
  `diliver_money` int(11) DEFAULT NULL,
  `remark` int(11) DEFAULT NULL,
  `oper_person` varchar(45) DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  `utime` datetime DEFAULT NULL,
  `from_gift` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id_UNIQUE` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `return_order_detail`
--

DROP TABLE IF EXISTS `return_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `return_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(45) DEFAULT NULL,
  `return_amount` float DEFAULT NULL,
  `bank` int(11) DEFAULT NULL,
  `open_bank_address` varchar(255) DEFAULT NULL,
  `bank_card_num` varchar(45) DEFAULT NULL,
  `bank_card_name` varchar(45) DEFAULT NULL,
  `ctime` datetime DEFAULT NULL,
  `utime` datetime DEFAULT NULL,
  `oper_person` varchar(45) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id_UNIQUE` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `sales_order_book`
--

DROP TABLE IF EXISTS `sales_order_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Temporary view structure for view `view_eorder_customer_user`
--

DROP TABLE IF EXISTS `view_eorder_customer_user`;
/*!50001 DROP VIEW IF EXISTS `view_eorder_customer_user`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_eorder_customer_user` AS SELECT 
 1 AS `id`,
 1 AS `sales`,
 1 AS `deal_date`,
 1 AS `enduser`,
 1 AS `expire_date`,
 1 AS `remark`,
 1 AS `order_name`,
 1 AS `price`,
 1 AS `status`,
 1 AS `oper_person`,
 1 AS `customer_id`,
 1 AS `pay_remark`,
 1 AS `customer_name`,
 1 AS `contact_person`,
 1 AS `phone`,
 1 AS `address`,
 1 AS `sales_name`*/;
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Final view structure for view `view_eorder_customer_user`
--

/*!50001 DROP VIEW IF EXISTS `view_eorder_customer_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_eorder_customer_user` AS select `a`.`id` AS `id`,`a`.`sales` AS `sales`,`a`.`deal_date` AS `deal_date`,`a`.`enduser` AS `enduser`,`a`.`expire_date` AS `expire_date`,`a`.`remark` AS `remark`,`a`.`order_name` AS `order_name`,`a`.`price` AS `price`,`a`.`status` AS `status`,`a`.`oper_person` AS `oper_person`,`a`.`customer_id` AS `customer_id`,`a`.`pay_remark` AS `pay_remark`,`b`.`name` AS `customer_name`,`b`.`contact_person` AS `contact_person`,`b`.`phone` AS `phone`,`b`.`address` AS `address`,`c`.`nick_name` AS `sales_name` from ((`entity_order` `a` join `customer` `b`) join `user` `c` on(((`a`.`customer_id` = `b`.`id`) and (`a`.`sales` = `c`.`id`)))) */;
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

-- Dump completed on 2015-12-23 21:17:16
