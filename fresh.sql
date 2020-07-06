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
  `id` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `username` char(16) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `reg_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '注册IP',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态  0 禁用，1正常',
  `group_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '权限组',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admini','d93a5def7511da3d0f2d171d9c344e91','123@163.com','123','15237156573','https://hardphp.oss-cn-beijing.aliyuncs.com\\images/20200115\\1ed50a8ff67bedbe1d4794705868a234.jpg','127.0.0.1',1594001387,'39.149.12.184',1594001387,1,1,1540975213,0),(2,'admina','00b091d5bbbcbea4a371242e61d644a3','123@163.com','王五一','15237156573','https://hardphp.oss-cn-beijing.aliyuncs.com/vedios/20191220/044a612bd5f0874e669e0755f51ca93e.jpg','127.0.0.1',1540975213,'123.149.208.76',1579146396,1,1,1540975213,0);
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
  `image` varchar(255) NOT NULL DEFAULT '',
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='广告表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adv`
--

LOCK TABLES `adv` WRITE;
/*!40000 ALTER TABLE `adv` DISABLE KEYS */;
INSERT INTO `adv` VALUES (1,'admini','fresh/2020-07/23-58-54.png','','home','2020-07-06 02:30:31',1,'2020-07-05 11:40:32',NULL,'2020-06-30 16:00:00','2020-07-07 16:00:00',1),(2,'admini','fresh/2020-07/23-58-57.png','','home','2020-07-06 02:30:28',1,'2020-07-05 11:40:42',NULL,'2020-06-30 16:00:00','2020-07-14 16:00:00',5),(3,'admini','fresh/2020-07/23-59-01.png','','home','2020-07-05 12:00:40',1,'2020-07-05 11:40:52',NULL,'2020-06-30 16:00:00','2020-07-10 16:00:00',4),(4,'admini','fresh/2020-07/ad1.gif','','home_notice','2020-07-05 11:41:09',1,'2020-07-05 11:41:09',NULL,'2020-06-30 16:00:00','2020-07-22 16:00:00',100),(5,'admini','fresh/2020-07/23-59-07.gif','','home','2020-07-05 11:41:26',1,'2020-07-05 11:41:26',NULL,'2020-07-01 16:00:00','2020-07-23 16:00:00',100),(6,'admini','fresh/2020-07/23-59-04.png','','home','2020-07-05 12:00:34',1,'2020-07-05 11:41:39',NULL,'2020-07-01 16:00:00','2020-07-30 16:00:00',3),(7,'admini','fresh/2020-07/backgorund.jpg','','home','2020-07-05 12:00:29',1,'2020-07-05 11:50:19',NULL,'2020-06-30 16:00:00','2020-07-15 16:00:00',2);
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
  `id` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT 'seo描述',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态  0 禁用，1正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sorts` int(3) NOT NULL DEFAULT '100' COMMENT '排序',
  `cate_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '分类id',
  `column_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '所属栏目',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,'ty9fd2848a039ab554','管理员端',1582518981,1,1514962598,100,18716532003704833,7264324116680705,'https://hardphp.oss-cn-beijing.aliyuncs.com\\images/20200221\\c2a62a8dbba7ae828c5837291e170a4c.jpg');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_categery`
--

DROP TABLE IF EXISTS `article_categery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_categery` (
  `id` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态  0 禁用，1正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sorts` int(3) NOT NULL DEFAULT '100' COMMENT '排序',
  `column_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '所属栏目',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_categery`
--

LOCK TABLES `article_categery` WRITE;
/*!40000 ALTER TABLE `article_categery` DISABLE KEYS */;
INSERT INTO `article_categery` VALUES (18716532003704833,'未全额委屈','',1582175304,1,1582175304,100,7264576798330881);
/*!40000 ALTER TABLE `article_categery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_column`
--

DROP TABLE IF EXISTS `article_column`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_column` (
  `id` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `seo_title` varchar(150) NOT NULL DEFAULT '' COMMENT 'seo关键词',
  `seo_dec` varchar(255) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态  0 禁用，1正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sorts` int(3) NOT NULL DEFAULT '100' COMMENT '排序',
  `pid` bigint(20) NOT NULL DEFAULT '0' COMMENT '父id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章栏目表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_column`
--

LOCK TABLES `article_column` WRITE;
/*!40000 ALTER TABLE `article_column` DISABLE KEYS */;
INSERT INTO `article_column` VALUES (1,'编程语言','ec32286d0718118861afdbf6e401ee81','管理员端',1579444850,1,1514962598,100,0),(7264107703177217,'数据库','1','1',1579445065,1,1579444834,100,0),(7264249676173313,'开发框架','','',1579444868,1,1579444868,100,0),(7264324116680705,'开发工具','','',1579444885,1,1579444885,100,0),(7264576798330881,'应用实例','','',1579444946,1,1579444946,100,0),(7264664253763585,'php','','',1579445040,1,1579444966,100,1),(7264796114292737,'golang','','',1579444998,1,1579444998,100,1),(7264844751441921,'python','','',1579445009,1,1579445009,100,1);
/*!40000 ALTER TABLE `article_column` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_group`
--

DROP TABLE IF EXISTS `auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_group` (
  `id` bigint(20) unsigned NOT NULL,
  `title` char(100) DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) DEFAULT '1' COMMENT '为1正常，为0禁用',
  `rules` text COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `update_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_group`
--

LOCK TABLES `auth_group` WRITE;
/*!40000 ALTER TABLE `auth_group` DISABLE KEYS */;
INSERT INTO `auth_group` VALUES (1,'超级管理员',1,'68328234063892481,68328450783580160,67745401595367425,67745734388224001,7246645603471361,7247512280895489,7247267136409601,7247034964905985,43,44,39,40,1,38,7,2',1594003780,1544881719),(2,'普通管理员',1,'1,2',1542787522,1542787522);
/*!40000 ALTER TABLE `auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `id` bigint(20) unsigned NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='规则表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` VALUES (1,'manage','权限管理',1,1,'',0,0,'component',1593867807,'/manage','layout',0,0,1,'',0),(2,'manage/admin','管理员列表',1,1,'',1,0,'user',1541666364,'admin','manage/admin',0,0,0,'',0),(7,'manage/rules','权限列表',1,1,'',1,0,'lock',1542353476,'rules','manage/rules',0,0,0,'',0),(38,'manage/roles','角色列表',1,1,'',1,0,'list',1542602805,'roles','manage/roles',0,0,0,'',0),(39,'log','日志管理',1,1,'',0,0,'component',1579436605,'/log','layout',0,0,1,'',0),(40,'log/log','登陆日志',1,1,'',39,0,'list',1593868512,'log','log/log',0,0,0,'',0),(43,'icon','图标管理',1,1,'',0,0,'component',1579436588,'/icon','layout',0,0,0,'',0),(44,'icon/index','图标列表',1,1,'',43,0,'list',0,'index','icons/index',0,0,0,'',0),(7246645603471361,'article','文章管理',1,1,'',0,0,'component',1579440670,'/article','layout',0,0,1,'',1579440670),(7247034964905985,'article/categery','分类列表',1,1,'',7246645603471361,0,'list',1579440763,'categery','article/categery',0,0,0,'',1579440763),(7247267136409601,'article/column','栏目列表',1,1,'',7246645603471361,0,'list',1579440819,'column','article/column',0,0,0,'',1579440819),(7247512280895489,'article/blog','文章列表',1,1,'',7246645603471361,0,'list',1579440877,'blog','article/blog',0,0,0,'',1579440877),(67745401595367425,'adv','广告管理',1,1,'',0,0,'component',1593864868,'/adv','layout',0,1,1,'',1593864698),(67745734388224001,'adv/list','广告列表',1,1,'',67745401595367425,0,'list',1593871402,'list','adv/list',0,1,0,'noredirect',1593864777),(68328234063892481,'category','分类管理',1,1,'',0,0,'component',1594003681,'category','layout',0,1,1,'',1594003656),(68328450783580160,'category/list','分类列表',1,1,'',68328234063892481,0,'list',1594003762,'list','layout',0,1,0,'noredirect',1594003708);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
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
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `file_name` (`file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file`
--

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_group`
--

LOCK TABLES `file_group` WRITE;
/*!40000 ALTER TABLE `file_group` DISABLE KEYS */;
INSERT INTO `file_group` VALUES (3,'','商品',1,0,'2020-07-06 07:59:55','2020-07-06 07:59:55');
/*!40000 ALTER TABLE `file_group` ENABLE KEYS */;
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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL COMMENT 'ID',
  `openid` varchar(150) NOT NULL DEFAULT '' COMMENT '微信身份标识',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '32位小写MD5密码',
  `phone` varchar(30) NOT NULL DEFAULT '' COMMENT '手机号',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用',
  `nickname` varchar(20) NOT NULL COMMENT '用户昵称',
  `img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像URL',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别标志：0，其他；1，男；2，女',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `birth` varchar(50) NOT NULL DEFAULT '' COMMENT '生日',
  `descript` varchar(200) NOT NULL DEFAULT '',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户总金额',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '注册IP',
  `login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT 'IP',
  `login_time` int(10) NOT NULL DEFAULT '0' COMMENT '登录时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `delete_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主系统用户表。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'','','15237156573','12312333',1,'xiegaolei','/uploads/images/20180512/6c7cf3ee6e3e83c031e260c5fa0844fb.jpg',0,20210.00,'1989-10-10','我要给你一个拥抱 给你一双温热手掌',525225.00,1515057952,'123.149.214.69','',0,0,0),(10,'','','','',1,'','',0,0.00,'','',0.00,0,'','',0,0,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-06 16:11:21
