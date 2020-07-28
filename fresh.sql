-- MySQL dump 10.13  Distrib 5.7.26, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fresh
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `image_key` varchar(50) NOT NULL DEFAULT '' COMMENT '上传时的配置key',
  `reg_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '注册IP',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态  0 禁用，1正常',
  `group_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '权限组',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='管理员用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admini','d93a5def7511da3d0f2d171d9c344e91','123@163.com','王五一','15237156573','微信图片_20200210092237.png','aliyun','127.0.0.1',1595859750,'123.149.208.76',1595859750,1,1,1540975213,0),(2,'kyangs','d93a5def7511da3d0f2d171d9c344e91','kyangs@163.com','咏春1','16602112169','fresh/2020-07/backgorund.jpg','','127.0.0.1',1594650854,'39.149.12.184',1594652203,1,1,1540975213,1594652203);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adv`
--

DROP TABLE IF EXISTS `adv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adv` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(16) NOT NULL DEFAULT '' COMMENT '创建者名',
  `image_id` int(11) NOT NULL DEFAULT '0',
  `link` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `position` varchar(50) NOT NULL DEFAULT '' COMMENT '广告位置',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态  0 禁用，1正常',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_time` timestamp NULL DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `create_time` (`create_time`) USING BTREE,
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`),
  KEY `position` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='广告表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adv`
--

LOCK TABLES `adv` WRITE;
/*!40000 ALTER TABLE `adv` DISABLE KEYS */;
INSERT INTO `adv` VALUES (8,'admini',4,'/pages/class/class?category_id=6','home','2020-07-12 03:22:34',1,'2020-07-11 06:56:32',NULL,'2020-07-01 16:00:00','2020-07-23 16:00:00',1),(9,'admini',1,'/pages/search/search','home','2020-07-12 02:44:37',1,'2020-07-11 06:57:20',NULL,'2020-06-30 16:00:00','2020-07-30 16:00:00',100),(10,'admini',33,'','home','2020-07-11 06:57:42',1,'2020-07-11 06:57:42',NULL,'2020-07-01 16:00:00','2020-07-30 16:00:00',100),(11,'admini',6,'/pages/shopping/shopping','home_notice','2020-07-12 02:45:05',1,'2020-07-11 07:02:51',NULL,'2020-06-30 16:00:00','2020-07-16 16:00:00',100);
/*!40000 ALTER TABLE `adv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app`
--

DROP TABLE IF EXISTS `app`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `appid` char(18) NOT NULL DEFAULT '' COMMENT '应用id',
  `app_salt` char(32) NOT NULL DEFAULT '' COMMENT '应用签名盐值',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
  `description` varchar(255) NOT NULL COMMENT '备注',
  `reg_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '注册IP',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态  0 禁用，1正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `appid` (`appid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='app应用表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app`
--

LOCK TABLES `app` WRITE;
/*!40000 ALTER TABLE `app` DISABLE KEYS */;
INSERT INTO `app` VALUES (1,'ty9fd2848a039ab554','ec32286d0718118861afdbf6e401ee81','管理员端','','127.0.0.1',1521305444,'123.149.208.76',1514962598,1,0);
/*!40000 ALTER TABLE `app` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT 'seo描述',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态  0 禁用，1正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sorts` int(3) NOT NULL DEFAULT '100' COMMENT '排序',
  `cate_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '分类id',
  `column_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '所属栏目',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `image_key` varchar(50) NOT NULL DEFAULT '' COMMENT '上传时的配置key',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,'AAA','content content content content',1595860393,1,1594741134,100,1,1,'fresh/2020-07/00-07-44.png','minio');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_categery`
--

DROP TABLE IF EXISTS `article_categery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_categery` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态  0 禁用，1正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sorts` int(3) NOT NULL DEFAULT '100' COMMENT '排序',
  `column_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '所属栏目',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_categery`
--

LOCK TABLES `article_categery` WRITE;
/*!40000 ALTER TABLE `article_categery` DISABLE KEYS */;
INSERT INTO `article_categery` VALUES (1,'AAA','',1594741088,1,1594741088,100,1);
/*!40000 ALTER TABLE `article_categery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_column`
--

DROP TABLE IF EXISTS `article_column`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_column` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `seo_title` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo关键词',
  `seo_dec` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态  0 禁用，1正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sorts` int(3) NOT NULL DEFAULT '100' COMMENT '排序',
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '父id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章栏目表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_column`
--

LOCK TABLES `article_column` WRITE;
/*!40000 ALTER TABLE `article_column` DISABLE KEYS */;
INSERT INTO `article_column` VALUES (1,'A','','',1594740711,1,1594740711,100,0);
/*!40000 ALTER TABLE `article_column` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_group`
--

DROP TABLE IF EXISTS `auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` char(100) DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '为1正常，为0禁用',
  `rules` text COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `update_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户组表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group`
--

LOCK TABLES `auth_group` WRITE;
/*!40000 ALTER TABLE `auth_group` DISABLE KEYS */;
INSERT INTO `auth_group` VALUES (1,'超级管理员',1,'58,59,55,57,56,53,54,51,52,49,50,45,48,47,46,43,44,39,40,1,38,7,2',1595672181,1544881719),(2,'普通管理员',1,'70622770253402113,70622988382375937,68328234063892481,68328450783580160,67745401595367425,67745734388224001,7246645603471361,7247512280895489,7247267136409601,7247034964905985',1594558953,1542787522);
/*!40000 ALTER TABLE `auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `type` tinyint(1) DEFAULT '1' COMMENT '为1正常，为0禁用',
  `status` tinyint(1) DEFAULT '1' COMMENT '1 正常，0=禁用',
  `condition` char(100) DEFAULT '' COMMENT '规则表达式，为空表示存在就验证',
  `pid` bigint(20) DEFAULT '0' COMMENT '上级菜单',
  `sorts` mediumint(8) DEFAULT '0' COMMENT '升序',
  `icon` varchar(50) DEFAULT '',
  `update_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `path` varchar(255) DEFAULT '' COMMENT '路经',
  `component` varchar(255) DEFAULT '' COMMENT '组件',
  `hidden` tinyint(1) DEFAULT '0' COMMENT '左侧菜单 0==显示,1隐藏',
  `no_cache` tinyint(1) DEFAULT '0' COMMENT '1=不缓存，0=缓存',
  `always_show` tinyint(1) DEFAULT '0' COMMENT '1= 总显示,0=否 依据子菜单个数',
  `redirect` varchar(255) DEFAULT '',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='规则表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` VALUES (1,'manage','权限管理',1,1,'',0,0,'component',1593867807,'/manage','layout',0,0,1,'',0),(2,'manage/admin','管理员列表',1,1,'',1,0,'user',1541666364,'admin','manage/admin',0,0,0,'',0),(7,'manage/rules','权限列表',1,1,'',1,0,'lock',1542353476,'rules','manage/rules',0,0,0,'',0),(38,'manage/roles','角色列表',1,1,'',1,0,'list',1542602805,'roles','manage/roles',0,0,0,'',0),(39,'log','日志管理',1,1,'',0,0,'component',1579436605,'/log','layout',0,0,1,'',0),(40,'log/log','登陆日志',1,1,'',39,0,'list',1593868512,'log','log/log',0,0,0,'',0),(43,'icon','图标管理',1,1,'',0,0,'component',1579436588,'/icon','layout',0,0,0,'',0),(44,'icon/index','图标列表',1,1,'',43,0,'list',0,'index','icons/index',0,0,0,'',0),(45,'article','文章管理',1,1,'',0,0,'component',1579440670,'/article','layout',0,0,1,'',1579440670),(46,'article/categery','分类列表',1,1,'',45,0,'list',1579440763,'categery','article/categery',0,0,0,'',1579440763),(47,'article/column','栏目列表',1,1,'',45,0,'list',1579440819,'column','article/column',0,0,0,'',1579440819),(48,'article/blog','文章列表',1,1,'',45,0,'list',1579440877,'blog','article/blog',0,0,0,'',1579440877),(49,'adv','广告管理',1,1,'',0,0,'component',1593864868,'/adv','layout',0,1,1,'',1593864698),(50,'adv/list','广告列表',1,1,'',49,0,'list',1593871402,'list','adv/list',0,1,0,'noredirect',1593864777),(51,'category','分类管理',1,1,'',0,0,'component',1594003681,'category','layout',0,1,1,'',1594003656),(52,'category/list','分类列表',1,1,'',51,0,'list',1594003762,'list','layout',0,1,0,'noredirect',1594003708),(53,'system_notice','公告管理',1,1,'',0,0,'component',1594554195,'system_notice','layout',0,1,1,'',1594550716),(54,'system_notice/list','公告列表',1,1,'',53,0,'list',1594554201,'list','layout',0,1,0,'noredirect',1594550768),(55,'goods','商品管理',1,1,'',0,0,'component',1595055683,'goods','layout',0,1,1,'noredirect',1595055368),(56,'goods/list','商品列表',1,1,'',55,0,'list',1595055714,'list','layout',0,1,0,'noredirect',1595055714),(57,'goods/create','添加商品',1,1,'',55,0,'form',1595056037,'create','layout',0,1,0,'noredirect',1595056005),(58,'system','系统设置',1,1,'',0,0,'component',1595672334,'system','layout',0,1,1,'',1595672132),(59,'system/upload','上传设置',1,1,'',58,0,'documentation',1595672342,'upload','layout',0,1,0,'noredirect',1595672171);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品分类id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类id',
  `image_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类图片id',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序方式(数字越小越靠前)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `show_home` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否首页显示 ',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用 ',
  `creator` varchar(100) NOT NULL DEFAULT '' COMMENT '创建人者 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (2,'安心蔬菜',0,14,1,0,'2020-07-11 06:47:22','2020-07-11 06:50:32',1,1,'admini'),(3,'肉禽蛋',0,15,2,0,'2020-07-11 07:26:27','2020-07-11 07:26:27',1,1,'admini'),(4,'生鲜海鲜',0,13,3,0,'2020-07-11 07:26:51','2020-07-11 07:26:53',1,1,'admini'),(5,'时令水果',0,12,4,0,'2020-07-11 07:27:12','2020-07-11 07:27:12',1,1,'admini'),(6,'粮油调味',0,10,5,0,'2020-07-11 07:38:45','2020-07-11 07:38:45',1,1,'admini'),(7,'乳品早点',0,16,6,0,'2020-07-11 07:39:07','2020-07-11 07:39:07',1,1,'admini'),(8,'酒水饮料',0,7,7,0,'2020-07-11 07:39:22','2020-07-11 07:39:22',1,1,'admini'),(9,'速冻食品',0,9,8,0,'2020-07-11 07:40:30','2020-07-11 07:49:05',1,1,'admini'),(11,'家具个护',0,16,9,0,'2020-07-11 07:58:47','2020-07-11 07:59:08',1,1,'admini'),(12,'生鲜饮食',0,11,10,0,'2020-07-11 07:59:05','2020-07-11 07:59:05',1,1,'admini'),(13,'西红柿',2,14,100,0,'2020-07-11 10:44:10','2020-07-11 10:44:51',0,1,'admini'),(14,'茄子',2,10,100,0,'2020-07-11 10:44:35','2020-07-11 10:45:03',0,1,'admini'),(15,'辣椒',2,12,100,0,'2020-07-11 10:45:22','2020-07-11 10:45:22',0,1,'admini'),(16,'红豆',2,10,100,0,'2020-07-11 10:45:37','2020-07-11 10:45:37',0,1,'admini');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) NOT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1=小程序，2=短信',
  `data` text COMMENT '数据',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='队列失败任务记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件id',
  `storage` varchar(20) NOT NULL DEFAULT '' COMMENT '存储方式',
  `group_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件分组id',
  `file_url` varchar(255) NOT NULL DEFAULT '' COMMENT '存储域名',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `file_size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小(字节)',
  `file_type` varchar(20) NOT NULL DEFAULT '' COMMENT '文件类型',
  `extension` varchar(20) NOT NULL DEFAULT '' COMMENT '文件扩展名',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '软删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `config_key` varchar(50) NOT NULL DEFAULT '' COMMENT '用什么配置上传的',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `file_name` (`file_name`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
INSERT INTO `file` VALUES (1,'',4,'fresh/2020-07/23-58-54.png','23-58-54.png',32480,'image/webp','tmp',0,0,'minio','2020-07-09 14:46:12','2020-07-27 11:41:28'),(2,'',4,'fresh/2020-07/23-58-57.png','23-58-57.png',28916,'image/webp','tmp',0,0,'minio','2020-07-09 14:46:21','2020-07-27 11:41:28'),(3,'',4,'fresh/2020-07/23-59-01.png','23-59-01.png',37044,'image/webp','tmp',0,0,'minio','2020-07-09 14:46:25','2020-07-27 11:41:28'),(4,'',4,'fresh/2020-07/23-59-04.png','23-59-04.png',49810,'image/webp','tmp',0,0,'minio','2020-07-09 14:46:29','2020-07-27 11:41:28'),(5,'',4,'fresh/2020-07/23-59-07.gif','23-59-07.gif',496065,'image/gif','tmp',0,0,'minio','2020-07-09 14:46:33','2020-07-27 11:41:28'),(6,'',4,'fresh/2020-07/ad1.gif','ad1.gif',843855,'image/gif','tmp',0,0,'minio','2020-07-09 14:46:55','2020-07-27 11:41:28'),(7,'',5,'fresh/2020-07/00-00-08.png','00-00-08.png',6186,'image/webp','tmp',0,0,'minio','2020-07-09 14:47:44','2020-07-27 11:41:28'),(8,'',5,'fresh/2020-07/00-00-22.png','00-00-22.png',5910,'image/webp','tmp',0,0,'minio','2020-07-09 14:47:47','2020-07-27 11:41:28'),(9,'',5,'fresh/2020-07/00-00-25.png','00-00-25.png',7438,'image/webp','tmp',0,0,'minio','2020-07-09 14:47:49','2020-07-27 11:41:28'),(10,'',5,'fresh/2020-07/00-00-31.png','00-00-31.png',6510,'image/webp','tmp',0,0,'minio','2020-07-09 14:48:05','2020-07-27 11:41:28'),(11,'',5,'fresh/2020-07/00-00-34.png','00-00-34.png',5726,'image/webp','tmp',0,0,'minio','2020-07-09 14:48:09','2020-07-27 11:41:28'),(12,'',5,'fresh/2020-07/00-00-37.png','00-00-37.png',7210,'image/webp','tmp',0,0,'minio','2020-07-09 14:48:12','2020-07-27 11:41:28'),(13,'',5,'fresh/2020-07/00-00-40.png','00-00-40.png',8730,'image/webp','tmp',0,0,'minio','2020-07-09 14:48:16','2020-07-27 11:41:28'),(14,'',5,'fresh/2020-07/00-00-49.png','00-00-49.png',7470,'image/webp','tmp',0,0,'minio','2020-07-09 14:48:19','2020-07-27 11:41:28'),(15,'',5,'fresh/2020-07/00-00-43.png','00-00-43.png',8748,'image/webp','tmp',0,0,'minio','2020-07-09 14:48:26','2020-07-27 11:41:28'),(16,'',5,'fresh/2020-07/00-00-28.png','00-00-28.png',6926,'image/webp','tmp',0,0,'minio','2020-07-09 14:48:49','2020-07-27 11:41:28'),(17,'',3,'fresh/2020-07/00-07-44.png','00-07-44.png',17316,'image/webp','tmp',0,0,'minio','2020-07-09 14:55:15','2020-07-27 11:41:28'),(18,'',3,'fresh/2020-07/00-07-48.png','00-07-48.png',49068,'image/webp','tmp',1,0,'minio','2020-07-09 14:55:15','2020-07-27 11:41:28'),(19,'',3,'fresh/2020-07/00-07-57.jpg','00-07-57.jpg',65606,'image/jpeg','tmp',1,0,'minio','2020-07-09 14:55:27','2020-07-27 11:41:28'),(20,'',3,'fresh/2020-07/00-07-53.png','00-07-53.png',84844,'image/webp','tmp',0,0,'minio','2020-07-09 14:55:27','2020-07-27 11:41:28'),(21,'',3,'fresh/2020-07/00-07-58.jpg','00-07-58.jpg',73798,'image/jpeg','tmp',0,0,'minio','2020-07-09 14:55:28','2020-07-27 11:41:28'),(22,'',3,'fresh/2020-07/00-07-59.jpg','00-07-59.jpg',73594,'image/jpeg','tmp',0,0,'minio','2020-07-09 14:55:28','2020-07-27 11:41:28'),(23,'',3,'fresh/2020-07/00-07-60.jpg','00-07-60.jpg',81765,'image/jpeg','tmp',0,0,'minio','2020-07-09 14:55:28','2020-07-27 11:41:28'),(24,'',3,'fresh/2020-07/00-07-56.png','00-07-56.png',174810,'image/webp','tmp',0,0,'minio','2020-07-09 14:55:28','2020-07-27 11:41:28'),(25,'',3,'fresh/2020-07/00-07-53.png','00-07-53.png',84844,'image/webp','tmp',0,0,'minio','2020-07-10 16:22:30','2020-07-27 11:41:28'),(26,'',3,'fresh/2020-07/微信图片_20200210092256.jpg','微信图片_20200210092256.jpg',85506,'image/jpeg','tmp',1,0,'minio','2020-07-10 16:41:57','2020-07-27 11:41:28'),(27,'',3,'fresh/2020-07/微信图片_20200210092250.png','微信图片_20200210092250.png',166575,'image/png','tmp',1,0,'minio','2020-07-10 16:41:57','2020-07-27 11:41:28'),(28,'',3,'fresh/2020-07/微信图片_20200210092237.png','微信图片_20200210092237.png',175108,'image/png','tmp',1,0,'minio','2020-07-10 16:41:58','2020-07-27 11:41:28'),(29,'',5,'fresh/2020-07/微信图片_20200315103547.jpg','微信图片_20200315103547.jpg',60347,'image/jpeg','tmp',1,0,'minio','2020-07-10 16:44:57','2020-07-27 11:41:28'),(30,'',5,'fresh/2020-07/wx.jpg','wx.jpg',46851,'image/jpeg','tmp',1,0,'minio','2020-07-10 16:44:57','2020-07-27 11:41:28'),(31,'',5,'fresh/2020-07/wx.png','wx.png',146108,'image/png','tmp',1,0,'minio','2020-07-10 16:44:58','2020-07-27 11:41:28'),(32,'',5,'fresh/2020-07/20190731214117.png','20190731214117.png',160673,'image/png','tmp',1,0,'minio','2020-07-10 16:45:16','2020-07-27 11:41:28'),(33,'',4,'fresh/2020-07/backgorund.jpg','backgorund.jpg',601375,'image/jpeg','tmp',0,0,'minio','2020-07-11 06:57:34','2020-07-27 11:41:28'),(34,'',3,'fresh/2020-07/timg.jpg','timg.jpg',65509,'image/jpeg','tmp',0,0,'minio','2020-07-19 03:45:52','2020-07-27 11:41:28'),(35,'',3,'fresh/2020-07/x1j.jpg','x1j.jpg',20754,'image/jpeg','tmp',0,0,'minio','2020-07-19 03:45:52','2020-07-27 11:41:28'),(36,'',3,'fresh/2020-07/xj.jpg','xj.jpg',23340,'image/jpeg','tmp',0,0,'minio','2020-07-19 03:45:52','2020-07-27 11:41:28'),(37,'',4,'fresh/2020-07/微信图片_20200210092237.png','微信图片_20200210092237.png',175108,'image/png','tmp',0,0,'minio','2020-07-26 03:39:24','2020-07-27 11:41:28'),(38,'',3,'fresh/2020-07/emoji.jpg','emoji.jpg',231590,'image/jpeg','tmp',0,0,'minio','2020-07-27 06:17:20','2020-07-27 11:41:28'),(39,'',3,'fresh/2020-07/0dba32ec834c8327ae56433051d44b5f6c74cafe.png','0dba32ec834c8327ae56433051d44b5f6c74cafe.png',1257057,'image/png','tmp',0,0,'minio','2020-07-27 06:18:22','2020-07-27 11:41:28'),(40,'',3,'fresh/2020-07/backgorund.jpg','backgorund.jpg',601375,'image/jpeg','tmp',1,0,'minio','2020-07-27 06:19:46','2020-07-27 11:41:28'),(41,'',3,'fresh/2020-07/DE-Excel.png','DE-Excel.png',180959,'image/png','tmp',1,0,'minio','2020-07-27 08:45:51','2020-07-27 11:41:28'),(42,'',3,'','DE-Geo.png',208629,'image/png','tmp',1,0,'minio','2020-07-27 10:58:15','2020-07-27 11:41:28'),(43,'',3,'0dba32ec834c8327ae56433051d44b5f6c74cafe.png','0dba32ec834c8327ae56433051d44b5f6c74cafe.png',1257057,'image/png','tmp',1,0,'minio','2020-07-27 11:05:27','2020-07-27 11:41:28'),(44,'',3,'DE-Geo.png','DE-Geo.png',208629,'image/png','tmp',1,0,'minio','2020-07-27 11:33:41','2020-07-27 11:41:28'),(45,'',3,'fresh/2020-07/DE-Geo.png','DE-Geo.png',208629,'image/png','tmp',0,0,'minio','2020-07-27 11:40:48','2020-07-27 11:40:48'),(46,'',3,'EX-Menu.png','EX-Menu.png',489952,'image/png','tmp',0,0,'aliyun','2020-07-27 11:54:43','2020-07-27 11:54:43');
/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_group`
--

DROP TABLE IF EXISTS `file_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `group_type` varchar(10) NOT NULL DEFAULT '' COMMENT '文件类型',
  `group_name` varchar(30) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类排序(数字越小越靠前)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_name` (`group_name`),
  KEY `type_index` (`group_type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_group`
--

LOCK TABLES `file_group` WRITE;
/*!40000 ALTER TABLE `file_group` DISABLE KEYS */;
INSERT INTO `file_group` VALUES (3,'','商品',1,0,'2020-07-06 07:59:55','2020-07-19 04:05:28'),(4,'','广告图',99,0,'2020-07-09 14:44:33','2020-07-11 07:27:53'),(5,'','分类图',1,0,'2020-07-09 14:47:32','2020-07-11 07:27:25');
/*!40000 ALTER TABLE `file_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) DEFAULT '0' COMMENT '店铺ID',
  `goods_name` char(200) DEFAULT '' COMMENT '名称',
  `short_desc` char(200) DEFAULT '' COMMENT '简短描述',
  `is_enabled` tinyint(1) DEFAULT '1' COMMENT '为1正常，为0下回架',
  `detail` text COMMENT '商品详情',
  `sort` int(11) DEFAULT '100' COMMENT '商品排序',
  `stock` int(11) DEFAULT '0' COMMENT '商品库存',
  `sale` bigint(20) DEFAULT '0' COMMENT '商品销量',
  `warning_num` int(11) DEFAULT '1' COMMENT '商品预警量',
  `weight` int(11) DEFAULT '0' COMMENT '商品预重量单位g',
  `origin_price` decimal(10,2) DEFAULT '0.00' COMMENT '商品原价',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '商品当前价',
  `main_image` bigint(20) DEFAULT '0' COMMENT '商品主图ID',
  `cate_id` bigint(20) DEFAULT '0' COMMENT '商品分类',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `update_time` (`update_time`),
  KEY `create_time` (`create_time`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (1,0,'桔子100元/5斤','',0,'桔子100元/5斤',100,100,0,1,0,0.00,100.00,20,5,'2020-07-19 04:31:55','2020-07-18 11:56:47'),(3,0,'云南大香蕉100/6斤','',1,'好吃不多，你要吃的，好吧1',100,100,0,1,0,199.00,100.00,36,5,'2020-07-19 06:25:39','2020-07-19 04:10:29'),(4,0,'云南大香蕉100/6斤','',1,'好吃不多，你要吃的，好吧11',100,100,0,1,0,199.00,100.00,36,13,'2020-07-19 05:20:12','2020-07-19 04:11:09');
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_attr`
--

DROP TABLE IF EXISTS `goods_attr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_attr` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) DEFAULT '0' COMMENT '商品ID',
  `attr_name` varchar(20) DEFAULT NULL COMMENT '属性名',
  `attr_value` varchar(100) DEFAULT NULL COMMENT '属性值',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='商品属性表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_attr`
--

LOCK TABLES `goods_attr` WRITE;
/*!40000 ALTER TABLE `goods_attr` DISABLE KEYS */;
INSERT INTO `goods_attr` VALUES (4,3,'产地','云南'),(5,3,'重量','100g'),(6,3,'保存期','100天');
/*!40000 ALTER TABLE `goods_attr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_detail_intro_image`
--

DROP TABLE IF EXISTS `goods_detail_intro_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_detail_intro_image` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) DEFAULT '0' COMMENT '商品ID',
  `image_id` bigint(20) DEFAULT NULL COMMENT 'FILe表主键',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='商品详情介绍图片表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_detail_intro_image`
--

LOCK TABLES `goods_detail_intro_image` WRITE;
/*!40000 ALTER TABLE `goods_detail_intro_image` DISABLE KEYS */;
INSERT INTO `goods_detail_intro_image` VALUES (1,1,25),(2,1,20),(27,4,36),(28,4,35),(29,4,34),(30,4,36),(31,4,35),(32,4,34),(33,4,36),(34,4,35),(35,4,34),(36,4,36),(37,4,35),(38,4,34),(39,4,36),(40,4,35),(41,4,34),(42,4,36),(43,4,35),(44,4,34),(45,4,36),(46,4,35),(47,4,34),(48,4,36),(49,4,35),(50,4,34),(51,3,36),(52,3,35),(53,3,34),(54,3,36),(55,3,35),(56,3,34),(57,3,36),(58,3,35),(59,3,34),(60,3,36),(61,3,35),(62,3,34);
/*!40000 ALTER TABLE `goods_detail_intro_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_image`
--

DROP TABLE IF EXISTS `goods_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_image` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) DEFAULT '0' COMMENT '商品ID',
  `image_id` bigint(20) DEFAULT NULL COMMENT 'FILe表主键',
  `type` varchar(10) DEFAULT NULL COMMENT '类型：carousel ：轮播，detail:详情图片',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_image`
--

LOCK TABLES `goods_image` WRITE;
/*!40000 ALTER TABLE `goods_image` DISABLE KEYS */;
INSERT INTO `goods_image` VALUES (1,1,25,'carousel'),(2,1,20,'carousel'),(3,1,25,'detail'),(4,1,20,'detail'),(5,2,17,'carousel'),(6,2,17,'detail'),(16,4,36,NULL),(17,4,35,NULL),(18,4,34,NULL),(19,3,36,NULL),(20,3,35,NULL),(21,3,34,NULL);
/*!40000 ALTER TABLE `goods_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_sales`
--

DROP TABLE IF EXISTS `goods_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_sales` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` bigint(20) DEFAULT '0' COMMENT '店铺ID',
  `goods_id` bigint(200) DEFAULT '0' COMMENT '商品ID',
  `num` int(11) DEFAULT '0' COMMENT '卖出数量',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `store_id` (`store_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商品销量表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_sales`
--

LOCK TABLES `goods_sales` WRITE;
/*!40000 ALTER TABLE `goods_sales` DISABLE KEYS */;
INSERT INTO `goods_sales` VALUES (1,0,3,1,'2020-07-19 06:37:24'),(2,0,3,4,'2020-07-19 06:37:24'),(3,0,4,2,'2020-07-19 06:37:30');
/*!40000 ALTER TABLE `goods_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_tag`
--

DROP TABLE IF EXISTS `goods_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) DEFAULT '0' COMMENT '商品ID',
  `name` varchar(20) DEFAULT NULL COMMENT 'name',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='商品标签表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_tag`
--

LOCK TABLES `goods_tag` WRITE;
/*!40000 ALTER TABLE `goods_tag` DISABLE KEYS */;
INSERT INTO `goods_tag` VALUES (1,1,'当天发货'),(2,2,'大葱'),(6,4,'云南特产'),(7,3,'云南特产');
/*!40000 ALTER TABLE `goods_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_hash`
--

DROP TABLE IF EXISTS `image_hash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_hash` (
  `id` bigint(20) unsigned NOT NULL,
  `image` varchar(255) DEFAULT '' COMMENT '图片',
  `hash` varchar(50) DEFAULT '' COMMENT '图片hash',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_hash`
--

LOCK TABLES `image_hash` WRITE;
/*!40000 ALTER TABLE `image_hash` DISABLE KEYS */;
INSERT INTO `image_hash` VALUES (5819117802229761,'https://hardphp.oss-cn-beijing.aliyuncs.com\\images/20200115\\1ed50a8ff67bedbe1d4794705868a234.jpg','d3ab533b8b10e4f3daeee85dde4179df68cfcc4d',1579100321,1579100321),(19177852159266817,'https://hardphp.oss-cn-beijing.aliyuncs.com\\images/20200221\\c2a62a8dbba7ae828c5837291e170a4c.jpg','b3857f39fb233da316eae01bbbedc67561519cdb',1582285292,1582285292);
/*!40000 ALTER TABLE `image_hash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_log`
--

DROP TABLE IF EXISTS `login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_log` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'ID',
  `uid` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `login_ip` varchar(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `roles` varchar(50) NOT NULL DEFAULT '' COMMENT '角色',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员登录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_log`
--

LOCK TABLES `login_log` WRITE;
/*!40000 ALTER TABLE `login_log` DISABLE KEYS */;
INSERT INTO `login_log` VALUES (502,1,'admin','115.60.16.49',1569570610,'超级管理员',0,0),(503,1,'admin','115.60.16.49',1569570926,'超级管理员',0,0),(504,1,'admin','115.60.16.49',1569571106,'超级管理员',0,0),(505,1,'admin','115.60.16.49',1569571198,'超级管理员',0,0),(506,1,'admin','115.60.16.49',1569572567,'超级管理员',0,0),(507,1,'admin','115.60.16.49',1569572862,'超级管理员',0,0),(508,1,'admin','115.60.16.49',1569577336,'超级管理员',0,0),(509,1,'admin','115.60.16.49',1569577374,'超级管理员',0,0),(510,1,'admin','115.60.16.49',1569579992,'超级管理员',0,0),(511,1,'admin','115.60.16.49',1569580000,'超级管理员',0,0),(512,1,'admin','115.60.16.49',1569580041,'超级管理员',0,0),(513,1,'admin','115.60.16.49',1569580343,'超级管理员',0,0),(514,1,'admin','115.60.16.49',1569580809,'超级管理员',0,0),(515,1,'admin','115.60.16.49',1569580949,'超级管理员',0,0),(516,1,'admin','115.60.16.49',1569581081,'超级管理员',0,0),(517,1,'admin','115.60.16.49',1569581087,'超级管理员',0,0),(518,1,'admin','115.60.16.49',1569581136,'超级管理员',0,0),(519,1,'admin','115.60.16.49',1569581209,'超级管理员',0,0),(520,1,'admin','115.60.16.49',1569581628,'超级管理员',0,0),(521,1,'admin','115.60.16.49',1569581657,'超级管理员',0,0),(522,1,'admin','115.60.16.49',1569581699,'超级管理员',0,0),(523,1,'admin','115.60.16.49',1569581722,'超级管理员',0,0),(524,1,'admin','115.60.16.49',1569583325,'超级管理员',0,0),(525,1,'admin','115.60.19.188',1569634122,'超级管理员',0,0),(526,1,'admin','115.60.19.188',1569639797,'超级管理员',0,0),(527,1,'admin','115.60.19.188',1569639873,'超级管理员',0,0),(528,1,'admin','115.60.19.188',1569640203,'超级管理员',0,0),(529,1,'admin','115.60.19.188',1569640213,'超级管理员',0,0),(530,1,'admin','115.60.19.188',1569642217,'超级管理员',0,0),(531,1,'admin','39.149.247.160',1574342514,'超级管理员',0,0),(532,1,'admin','39.149.247.160',1574468895,'超级管理员',0,0),(533,1,'admin','223.88.30.142',1574846370,'超级管理员',0,0),(534,1,'admin','223.88.30.142',1574848961,'超级管理员',0,0),(535,1,'admin','223.88.30.142',1574849547,'超级管理员',0,0),(536,1,'admin','223.88.30.142',1574849754,'超级管理员',0,0),(537,1,'admin','223.88.30.142',1574850555,'超级管理员',0,0),(538,1,'admin','223.88.30.142',1574850985,'超级管理员',0,0);
/*!40000 ALTER TABLE `login_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `creator` varchar(20) NOT NULL DEFAULT '' COMMENT '创建者名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '公告标题',
  `tag` varchar(10) NOT NULL DEFAULT '' COMMENT '标签',
  `content` text COMMENT '公告内容',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态  0 禁用，1正常',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_time` timestamp NULL DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `create_time` (`create_time`) USING BTREE,
  KEY `start_time` (`start_time`),
  KEY `end_time` (`end_time`),
  KEY `update_time` (`update_time`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='公告表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` VALUES (12,'admini','配送到家功能上线,满29即可包邮','公告','配送到家功能上线,满29即可包邮','2020-07-12 12:23:55',1,'2020-07-12 12:05:11',NULL,'2020-06-30 16:00:00','2020-07-30 16:00:00',1),(13,'admini','新用户首单打5折！！！','优惠','新用户首单打5折！！！','2020-07-12 12:23:30',1,'2020-07-12 12:12:49',NULL,'2020-07-02 16:00:00','2020-07-24 16:00:00',2);
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice_send_log`
--

DROP TABLE IF EXISTS `notice_send_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notice_send_log` (
  `id` bigint(20) NOT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '1=小程序，2=公众号，3=短信',
  `data` text COMMENT '数据',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `result` text COMMENT '结果',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='通知消息发送记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice_send_log`
--

LOCK TABLES `notice_send_log` WRITE;
/*!40000 ALTER TABLE `notice_send_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `notice_send_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms`
--

DROP TABLE IF EXISTS `sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms` (
  `id` bigint(20) unsigned NOT NULL,
  `phone` char(11) NOT NULL COMMENT '手机号',
  `code` varchar(10) NOT NULL COMMENT '验证码',
  `ip` varchar(50) NOT NULL COMMENT 'ip地址',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=注册，2=登录，3=找回密码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 未使用，1已使用',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='手机验证码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms`
--

LOCK TABLES `sms` WRITE;
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_setting`
--

DROP TABLE IF EXISTS `system_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_setting` (
  `unique_key` varchar(30) NOT NULL COMMENT '设置项标示',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '设置项描述',
  `value` mediumtext NOT NULL COMMENT '设置内容（json格式）',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_key` (`unique_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_setting`
--

LOCK TABLES `system_setting` WRITE;
/*!40000 ALTER TABLE `system_setting` DISABLE KEYS */;
INSERT INTO `system_setting` VALUES ('upload','上传设置','{\"aliyun\":{\"accessKeyId\":\"LTAI4GFioN3HVHhvugbhLzxm\",\"accessKeySecret\":\"gBTo0ElWFad9suSwbfjoJr5Ln5IL8c\",\"endpoint\":\"oss-cn-beijing.aliyuncs.com\",\"bucket\":\"fresh-kyang\",\"http\":\"http:\\/\\/fresh-kyang.oss-cn-beijing.aliyuncs.com\"},\"qiniuyun\":{\"accessKeyId\":\"5JsGXDMCZx9rJCXkB6VZr2_RVVdzWC4q2-ETgsuz\",\"accessKeySecret\":\"UeD1CFDNMBf7z7N28LOl5STa6IS8_6sUoGiofnVf\",\"endpoint\":\"s3-cn-east-1.qiniucs.com\",\"bucket\":\"fresh-kyangs\",\"http\":\"http:\\/\\/qe4knhsk2.bkt.clouddn.com\"},\"txyun\":{\"accessKeyId\":\"\",\"accessKeySecret\":\"\",\"endpoint\":\"\",\"region\":\"\",\"token\":\"\"},\"minio\":{\"userName\":\"kyangs\",\"password\":\"a3lhbmdzX21pbmlv\",\"endpoint\":\"http:\\/\\/yl8134.cn:9999\",\"bucket\":\"fresh\",\"http\":\"http:\\/\\/yl8134.cn:9999\"},\"default\":\"minio\",\"signature\":\"ed6d741584f1a2022f5af64e50032a4c\"}','2020-07-28 01:37:56','2020-07-25 13:09:45');
/*!40000 ALTER TABLE `system_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `open_id` varchar(255) NOT NULL DEFAULT '' COMMENT '微信openid(唯一标示)',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `real_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户真实姓名',
  `password` varchar(100) NOT NULL DEFAULT '' COMMENT '密码',
  `phone` varchar(30) NOT NULL DEFAULT '' COMMENT '手机号',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `image_key` varchar(20) NOT NULL DEFAULT '' COMMENT '头像保存在哪个设置key里',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `country` varchar(50) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(50) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(50) NOT NULL DEFAULT '' COMMENT '城市',
  `address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `birth` varchar(50) NOT NULL DEFAULT '' COMMENT '生日',
  `reg_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '注册IP',
  `login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT 'IP',
  `login_time` int(10) NOT NULL DEFAULT '0' COMMENT '登录时间',
  `sign` varchar(200) NOT NULL DEFAULT '' COMMENT '个性签名',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `openid` (`open_id`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在省份id',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在城市id',
  `region_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在区id',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_address`
--

LOCK TABLES `user_address` WRITE;
/*!40000 ALTER TABLE `user_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_address` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-28 10:00:43
