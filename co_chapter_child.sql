# Host: localhost  (Version 5.7.19-log)
# Date: 2018-02-09 10:03:54
# Generator: MySQL-Front 5.3  (Build 5.39)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "co_chapter_child"
#

CREATE TABLE `co_chapter_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属关卡',
  `name` char(32) DEFAULT NULL,
  `desc` text,
  `sort` tinyint(3) NOT NULL DEFAULT '0',
  `guide` text,
  `guide_bg_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

#
# Data for table "co_chapter_child"
#

REPLACE INTO `co_chapter_child` VALUES (12,1,'1-2',NULL,111,NULL,NULL,NULL,NULL),(13,2,NULL,NULL,2,NULL,NULL,NULL,NULL),(14,2,NULL,NULL,22,NULL,NULL,NULL,NULL),(15,0,NULL,NULL,0,NULL,NULL,'2018-02-06 08:52:40','2018-02-06 08:52:40'),(16,0,NULL,NULL,0,NULL,NULL,'2018-02-06 08:52:47','2018-02-06 08:52:47'),(17,0,'string','string',1,'string','uploads/20180202/46b0ba04-ca6c-12e4-b90d-803aaeef5e39.jpg','2018-02-09 10:02:45','2018-02-09 10:02:45');
