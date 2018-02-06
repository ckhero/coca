# Host: localhost  (Version 5.7.19)
# Date: 2018-02-06 23:35:14
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "co_activity"
#

CREATE TABLE `co_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动类型表',
  `short_name` char(32) DEFAULT NULL,
  `name` char(32) DEFAULT '',
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "co_activity"
#

REPLACE INTO `co_activity` VALUES (1,'Chapter','关卡',''),(2,'WorldBoss','世界boss',NULL),(3,'Day','日常答题',NULL);

#
# Structure for table "co_auth_rule"
#

CREATE TABLE `co_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "co_auth_rule"
#


#
# Structure for table "co_auth_item"
#

CREATE TABLE `co_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `co_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `co_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "co_auth_item"
#


#
# Structure for table "co_auth_item_child"
#

CREATE TABLE `co_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `co_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `co_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `co_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `co_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "co_auth_item_child"
#


#
# Structure for table "co_auth_assignment"
#

CREATE TABLE `co_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `co_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `co_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "co_auth_assignment"
#


#
# Structure for table "co_chapter"
#

CREATE TABLE `co_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `map_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属地图id',
  `name` char(32) NOT NULL DEFAULT '' COMMENT '关卡名字',
  `desc` text COMMENT '关卡描述',
  `bg_url` varchar(255) DEFAULT NULL,
  `sort` tinyint(3) DEFAULT NULL COMMENT '排序',
  `guide` varchar(255) DEFAULT NULL COMMENT '课件，多个视频图片逗号隔开',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "co_chapter"
#

REPLACE INTO `co_chapter` VALUES (1,6,'string1','string','uploads/20180202/46b0ba04-ca6c-12e4-b90d-803aaeef5e39.jpg',3,'string',NULL,NULL),(2,6,'1','string','uploads/20180202/46b0ba04-ca6c-12e4-b90d-803aaeef5e39.jpg',2,'string',NULL,NULL),(3,6,'string2','string','uploads/20180202/46b0ba04-ca6c-12e4-b90d-803aaeef5e39.jpg',11,'string',NULL,NULL);

#
# Structure for table "co_chapter_child"
#

CREATE TABLE `co_chapter_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属关卡',
  `name` char(32) DEFAULT NULL,
  `desc` text,
  `sort` tinyint(3) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

#
# Data for table "co_chapter_child"
#

REPLACE INTO `co_chapter_child` VALUES (12,1,'1-2',NULL,111,NULL,NULL),(13,2,NULL,NULL,2,NULL,NULL),(14,2,NULL,NULL,22,NULL,NULL),(15,0,NULL,NULL,0,'2018-02-06 08:52:40','2018-02-06 08:52:40'),(16,0,NULL,NULL,0,'2018-02-06 08:52:47','2018-02-06 08:52:47');

#
# Structure for table "co_chapter_child_question"
#

CREATE TABLE `co_chapter_child_question` (
  `chapter_child_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL DEFAULT '0',
  KEY `chapter_child_id` (`chapter_child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "co_chapter_child_question"
#

REPLACE INTO `co_chapter_child_question` VALUES (12,1),(12,2);

#
# Structure for table "co_game_log"
#

CREATE TABLE `co_game_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '详细的答题记录，每一题对错等等',
  `uid` int(11) DEFAULT NULL,
  `activity_id` tinyint(3) DEFAULT NULL,
  `activity_name` char(12) DEFAULT NULL,
  `chapter_child_id` int(11) DEFAULT '0',
  `detail` text,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

#
# Data for table "co_game_log"
#

REPLACE INTO `co_game_log` VALUES (1,NULL,1,NULL,0,NULL,NULL),(2,NULL,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 06:38:34'),(3,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 06:40:39'),(4,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 06:41:12'),(5,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 06:58:48'),(6,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 06:59:01'),(7,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 06:59:39'),(8,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 06:59:56'),(9,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:00:44'),(10,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:00:56'),(11,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:01:30'),(12,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:01:46'),(13,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:02:07'),(14,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:02:38'),(15,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:02:47'),(16,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:03:06'),(17,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:03:11'),(18,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:04:41'),(19,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:05:38'),(20,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:05:44'),(21,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:05:46'),(22,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"A\"}]','2018-02-06 07:05:59'),(23,2,1,NULL,0,'[{\"id\":0,\"option\":\"A\"}]','2018-02-06 08:53:26'),(24,2,1,NULL,0,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"C\"}]','2018-02-06 08:54:15'),(25,2,1,NULL,0,'[{\"id\":1,\"option\":\"A\"},{\"id\":2,\"option\":\"C\"}]','2018-02-06 08:54:32'),(26,NULL,1,NULL,12,'[{\"id\":0,\"option\":\"A\"}]','2018-02-06 13:30:04'),(27,3,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 13:32:25'),(28,3,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 13:42:37'),(29,3,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 13:42:57'),(30,3,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 13:43:06'),(31,3,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 13:43:33'),(32,3,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 13:43:57'),(33,3,1,NULL,0,'[{\"id\":1,\"option\":\"A\"},{\"id\":3,\"option\":\"B\"}]','2018-02-06 13:45:04'),(34,3,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 13:48:28'),(35,2,1,NULL,12,'[{\"id\":0,\"option\":\"A\"}]','2018-02-06 15:13:31'),(36,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:13:36'),(37,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:13:54'),(38,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:16:06'),(39,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:17:18'),(40,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:17:46'),(41,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:18:11'),(42,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:18:43'),(43,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:18:51'),(44,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:19:07'),(45,2,1,NULL,0,'[{\"id\":2,\"option\":\"C\"}]','2018-02-06 15:23:17'),(46,2,1,NULL,0,'[{\"id\":2,\"option\":\"C\"}]','2018-02-06 15:24:33'),(47,2,1,NULL,0,'[{\"id\":3,\"option\":\"C\"}]','2018-02-06 15:24:53'),(48,2,1,NULL,0,'[{\"id\":3,\"option\":\"C\"}]','2018-02-06 15:26:08'),(49,2,1,NULL,12,'[{\"id\":1,\"option\":\"A\"}]','2018-02-06 15:34:55');

#
# Structure for table "co_level"
#

CREATE TABLE `co_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '分数',
  `name` char(16) DEFAULT NULL COMMENT '等级名字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "co_level"
#


#
# Structure for table "co_map"
#

CREATE TABLE `co_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL DEFAULT '',
  `desc` text,
  `sort` tinyint(3) DEFAULT '0',
  `bg_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "co_map"
#

REPLACE INTO `co_map` VALUES (6,'2',NULL,0,NULL,NULL,NULL);

#
# Structure for table "co_menu"
#

CREATE TABLE `co_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `co_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `co_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "co_menu"
#


#
# Structure for table "co_migration"
#

CREATE TABLE `co_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "co_migration"
#


#
# Structure for table "co_prop"
#

CREATE TABLE `co_prop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(32) DEFAULT NULL,
  `desc` text,
  `sort` tinyint(3) DEFAULT '0',
  `img_url` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

#
# Data for table "co_prop"
#

REPLACE INTO `co_prop` VALUES (1,'string','string',0,'string',0,'2018-02-06 03:57:38','2018-02-06 03:57:38'),(2,'string','string',0,'string',1,NULL,NULL),(3,'string','string',0,'string',1,NULL,NULL),(4,'string','string',0,'string',1,NULL,NULL),(5,'string','string',0,'string',0,'2018-02-06 03:57:55','2018-02-06 03:57:55'),(6,'string','string',0,'string',5,NULL,NULL),(7,'string','string',0,'string',5,NULL,NULL),(8,'string','string',0,'string',5,NULL,NULL),(9,'string','string',0,'string',0,'2018-02-06 03:58:03','2018-02-06 03:58:03'),(10,'string','string',0,'string',9,NULL,NULL),(11,'string','string',0,'string',9,NULL,NULL),(12,'string','string',0,'string',9,NULL,NULL),(13,'string','string',0,'string',9,NULL,NULL),(14,'string','string',0,'string',0,'2018-02-06 06:33:24','2018-02-06 06:33:24'),(15,'string','string',0,'string',14,NULL,NULL),(16,'string','string',0,'string',14,NULL,NULL),(17,'string','string',0,'string',14,NULL,NULL),(18,'string','string',0,'string',14,NULL,NULL);

#
# Structure for table "co_pt_user"
#

CREATE TABLE `co_pt_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coca_id` int(11) NOT NULL DEFAULT '0' COMMENT '可口可乐的用户id',
  `nick_name` varchar(128) DEFAULT '',
  `head_img` varchar(255) DEFAULT '',
  `points` int(11) DEFAULT '0' COMMENT '积分，跟渴了挂钩',
  `exp` int(11) DEFAULT '0' COMMENT '经验值',
  `nog` int(11) DEFAULT '0' COMMENT '小游戏可以进行的次数',
  `access_token` char(32) DEFAULT NULL,
  `refresh_token` char(32) DEFAULT NULL,
  `access_expired_at` int(11) DEFAULT NULL COMMENT 'access_token过期时间',
  `refresh_expired_at` int(11) DEFAULT NULL COMMENT 'refresh_token过期时间',
  `status` tinyint(3) DEFAULT '1' COMMENT '用户状态',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access_token`,`access_expired_at`),
  KEY `id_refresh` (`refresh_token`,`refresh_expired_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "co_pt_user"
#

REPLACE INTO `co_pt_user` VALUES (2,111111,'test','http://img0.imgtn.bdimg.com/it/u=12867320,655225767',0,6400,1,'VgAU1Vn-_n6t3h4u_P7euV3eBxK0o07q','addNog',1517933598,1517994860,1,'2018-02-05 03:01:54','2018-02-06 15:13:18'),(3,11111,'test','http://img0.imgtn.bdimg.com/it/u=12867320,655225767',0,400,0,'AWJzqav_BuEc9WFWgsHEzyxWkgSDpaDH','oFMrj6pWDAaraTF8tQRjENPyoSlQuyjC',1517927442,1517994870,1,'2018-02-06 09:14:30','2018-02-06 13:43:33');

#
# Structure for table "co_question_options"
#

CREATE TABLE `co_question_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `q_id` int(11) DEFAULT '0' COMMENT '问题编号',
  `short_name` varchar(1) NOT NULL DEFAULT '' COMMENT '选项简称A-Z',
  `desc` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "co_question_options"
#

REPLACE INTO `co_question_options` VALUES (1,1,'C',NULL,NULL,NULL),(2,1,'A',NULL,NULL,NULL),(3,2,'A',NULL,NULL,NULL),(4,3,'B',NULL,NULL,NULL),(5,2,'C',NULL,NULL,NULL);

#
# Structure for table "co_questions"
#

CREATE TABLE `co_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` text NOT NULL COMMENT '问题描述',
  `right_option` char(1) NOT NULL DEFAULT '' COMMENT '正确答案选项',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "co_questions"
#

REPLACE INTO `co_questions` VALUES (1,'2312','A',NULL,NULL),(2,'121211','C',NULL,NULL),(3,'3','B',NULL,NULL);

#
# Structure for table "co_user"
#

CREATE TABLE `co_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `expired_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Data for table "co_user"
#

REPLACE INTO `co_user` VALUES (5,'ckhero','K0CddrjOrwvjGCM2M26sPMMnbMC4B-E-','$2y$13$PlGtKHK4yAaKiI6C3AIQTexHwtDxxnPPmu7EDRDYl1CXq/O77YZSG',NULL,'ckhero@163.com',10,1517798545,1517798545,NULL),(6,'ckhero2','gxjQEbrUYWqV9DXNh84OQI8mAdPBNiT0','$2y$13$rEDZbwzKU.ImhtnEgdMk1OFsIaAM2ENh83kJqPss9iB8O1b0V8MXS',NULL,'335688758@qq.com',10,1517798566,1517798566,NULL);

#
# Structure for table "co_user_chapter_record"
#

CREATE TABLE `co_user_chapter_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned DEFAULT '0' COMMENT '用户id',
  `activity_id` int(11) DEFAULT NULL COMMENT '属于哪种活动',
  `activity_name` char(32) DEFAULT NULL,
  `chapter_child_id` int(11) DEFAULT '0' COMMENT '关卡id',
  `total` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '总答题数',
  `right_num` tinyint(3) unsigned DEFAULT '0' COMMENT '答对的题目数',
  `point` tinyint(3) unsigned DEFAULT '0',
  `exp` int(11) unsigned DEFAULT '0',
  `props` text COMMENT '道具和碎片信息',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "co_user_chapter_record"
#

REPLACE INTO `co_user_chapter_record` VALUES (1,33,1,NULL,11,2,1,0,NULL,'','2018-02-06 13:43:33','2018-02-06 13:43:33'),(2,3,3,NULL,0,2,2,0,NULL,'','2018-02-06 13:45:04','2018-02-06 13:45:04'),(3,3,1,NULL,12,2,1,0,NULL,'','2018-02-06 13:48:28','2018-02-06 13:48:28'),(4,2,1,NULL,13,2,1,0,100,'[{\"id\":\"17\",\"name\":\"string\",\"desc\":\"string\",\"sort\":\"0\",\"img_url\":\"string\",\"pid\":\"14\",\"created_at\":null,\"updated_at\":null},{\"id\":\"18\",\"name\":\"string\",\"desc\":\"string\",\"sort\":\"0\",\"img_url\":\"string\",\"pid\":\"14\",\"created_at\":null,\"updated_at\":null},{\"id\":\"3\",\"name\":\"string\",\"desc\":\"string\",\"sort\":\"0\",\"img_url\":\"string\",\"pid\":\"1\",\"created_at\":null,\"updated_at\":null},{\"id\":\"12\",\"name\":\"string\",\"desc\":\"string\",\"sort\":\"0\",\"img_url\":\"string\",\"pid\":\"9\",\"created_at\":null,\"updated_at\":null},{\"id\":\"3\",\"name\":\"string\",\"desc\":\"string\",\"sort\":\"0\",\"img_url\":\"string\",\"pid\":\"1\",\"created_at\":null,\"updated_at\":null}]','2018-02-06 15:16:06','2018-02-06 15:16:06'),(5,2,1,NULL,13,2,1,0,100,'[\"12\",\"3\",\"8\",\"11\",\"17\"]','2018-02-06 15:17:46','2018-02-06 15:17:46'),(11,2,3,'每日任务',0,2,0,0,0,NULL,'2018-02-06 15:26:08','2018-02-06 15:26:08'),(12,2,1,'1-2',12,2,1,0,100,'[\"12\",\"16\",\"11\",\"3\",\"12\"]','2018-02-06 15:34:55','2018-02-06 15:34:55');

#
# Structure for table "co_user_prop"
#

CREATE TABLE `co_user_prop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0',
  `prop_id` int(11) DEFAULT '0',
  `type` tinyint(3) DEFAULT '0' COMMENT '0为碎片，1为道具',
  `status` tinyint(3) DEFAULT '1' COMMENT '0为已使用，1为未使用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8 COMMENT='用户的碎片道具列表';

#
# Data for table "co_user_prop"
#

REPLACE INTO `co_user_prop` VALUES (1,2,11,0,1,NULL,NULL),(2,2,3,0,1,NULL,NULL),(3,2,13,0,1,NULL,NULL),(4,2,10,0,1,NULL,NULL),(5,2,6,0,1,NULL,NULL),(6,2,8,1,1,NULL,NULL),(7,2,2,1,1,NULL,NULL),(8,2,12,1,1,NULL,NULL),(9,2,12,1,1,NULL,NULL),(10,2,13,1,1,NULL,NULL),(11,2,2,0,1,NULL,NULL),(12,2,10,0,1,NULL,NULL),(13,2,2,0,1,NULL,NULL),(14,2,4,0,1,NULL,NULL),(15,2,3,0,1,NULL,NULL),(16,2,6,0,1,NULL,NULL),(17,2,4,0,1,NULL,NULL),(18,2,2,0,1,NULL,NULL),(19,2,13,0,1,NULL,NULL),(20,2,11,0,1,NULL,NULL),(21,2,13,0,1,NULL,NULL),(22,2,8,0,1,NULL,NULL),(23,2,10,0,1,NULL,NULL),(24,2,4,0,1,NULL,NULL),(25,2,12,0,1,NULL,NULL),(26,2,10,0,1,NULL,NULL),(27,2,2,0,1,NULL,NULL),(28,2,7,0,1,NULL,NULL),(29,2,17,0,1,NULL,NULL),(30,2,12,0,1,NULL,NULL),(31,2,18,0,1,NULL,NULL),(32,2,6,0,1,NULL,NULL),(33,2,6,0,1,NULL,NULL),(34,2,12,0,1,NULL,NULL),(35,2,10,0,1,NULL,NULL),(36,2,17,0,1,NULL,NULL),(37,2,17,0,1,NULL,NULL),(38,2,12,0,1,NULL,NULL),(39,2,18,0,1,NULL,NULL),(40,2,7,0,1,NULL,NULL),(41,2,10,0,1,NULL,NULL),(42,2,2,0,1,NULL,NULL),(43,2,11,0,1,NULL,NULL),(44,2,16,0,1,NULL,NULL),(45,2,6,0,1,NULL,NULL),(46,2,3,0,1,NULL,NULL),(47,2,11,0,1,NULL,NULL),(48,2,8,0,1,NULL,NULL),(49,2,8,0,1,NULL,NULL),(50,2,4,0,1,NULL,NULL),(51,2,8,0,1,NULL,NULL),(52,2,13,0,1,NULL,NULL),(53,2,11,0,1,NULL,NULL),(54,2,12,0,1,NULL,NULL),(55,2,15,0,1,NULL,NULL),(56,2,13,0,1,NULL,NULL),(57,2,8,0,1,NULL,NULL),(58,2,18,0,1,NULL,NULL),(59,2,7,0,1,NULL,NULL),(60,2,7,0,1,NULL,NULL),(61,2,12,0,1,NULL,NULL),(62,2,18,0,1,NULL,NULL),(63,2,10,0,1,NULL,NULL),(64,2,16,0,1,NULL,NULL),(65,2,6,0,1,NULL,NULL),(66,2,18,0,1,NULL,NULL),(67,2,16,0,1,NULL,NULL),(68,2,4,0,1,NULL,NULL),(69,2,8,0,1,NULL,NULL),(70,2,6,0,1,NULL,NULL),(71,2,15,0,1,NULL,NULL),(72,2,13,0,1,NULL,NULL),(73,2,6,0,1,NULL,NULL),(74,2,11,0,1,NULL,NULL),(75,2,16,0,1,NULL,NULL),(76,2,7,0,1,NULL,NULL),(77,2,17,0,1,NULL,NULL),(78,2,2,0,1,NULL,NULL),(79,2,10,0,1,NULL,NULL),(80,2,17,0,1,NULL,NULL),(81,2,2,0,1,NULL,NULL),(82,2,7,0,1,NULL,NULL),(83,2,17,0,1,NULL,NULL),(84,2,10,0,1,NULL,NULL),(85,2,13,0,1,NULL,NULL),(86,2,11,0,1,NULL,NULL),(87,2,18,0,1,NULL,NULL),(88,2,18,0,1,NULL,NULL),(89,2,16,0,1,NULL,NULL),(90,2,11,0,1,NULL,NULL),(91,2,6,0,1,NULL,NULL),(92,2,4,0,1,NULL,NULL),(93,2,8,0,1,NULL,NULL),(94,2,18,0,1,NULL,NULL),(95,2,10,0,1,NULL,NULL),(96,2,15,0,1,NULL,NULL),(97,2,4,0,1,NULL,NULL),(98,2,3,0,1,NULL,NULL),(99,2,6,0,1,NULL,NULL),(100,2,11,0,1,NULL,NULL),(101,2,13,0,1,NULL,NULL),(102,2,18,0,1,NULL,NULL),(103,2,4,0,1,NULL,NULL),(104,2,4,0,1,NULL,NULL),(105,2,18,0,1,NULL,NULL),(106,2,17,0,1,NULL,NULL),(107,2,7,0,1,NULL,NULL),(108,2,17,0,1,NULL,NULL),(109,2,11,0,1,NULL,NULL),(110,2,15,0,1,NULL,NULL),(111,2,16,0,1,NULL,NULL),(112,2,15,0,1,NULL,NULL),(113,2,13,0,1,NULL,NULL),(114,2,12,0,1,NULL,NULL),(115,2,13,0,1,NULL,NULL),(116,2,18,0,1,NULL,NULL),(117,2,6,0,1,NULL,NULL),(118,2,10,0,1,NULL,NULL),(119,2,13,0,1,NULL,NULL),(120,2,3,0,1,NULL,NULL),(121,2,2,0,1,NULL,NULL),(122,2,7,0,1,NULL,NULL),(123,2,6,0,1,NULL,NULL),(124,2,11,0,1,NULL,NULL),(125,2,3,0,1,NULL,NULL),(126,2,17,0,1,NULL,NULL),(127,2,7,0,1,NULL,NULL),(128,2,15,0,1,NULL,NULL),(129,2,8,0,1,NULL,NULL),(130,2,12,0,1,NULL,NULL),(131,2,4,0,1,NULL,NULL),(132,2,7,0,1,NULL,NULL),(133,2,2,0,1,NULL,NULL),(134,2,17,0,1,NULL,NULL),(135,2,18,0,1,NULL,NULL),(136,2,15,0,1,NULL,NULL),(137,2,7,0,1,NULL,NULL),(138,2,17,0,1,NULL,NULL),(139,2,3,0,1,NULL,NULL),(140,2,8,0,1,NULL,NULL),(141,2,15,0,1,NULL,NULL),(142,2,3,0,1,NULL,NULL),(143,2,10,0,1,NULL,NULL),(144,2,8,0,1,NULL,NULL),(145,2,12,0,1,NULL,NULL),(146,2,17,0,1,NULL,NULL),(147,2,2,0,1,NULL,NULL),(148,2,3,0,1,NULL,NULL),(149,2,4,0,1,NULL,NULL),(150,2,12,0,1,NULL,NULL),(151,2,12,0,1,NULL,NULL),(152,2,16,0,1,NULL,NULL),(153,2,15,0,1,NULL,NULL),(154,2,6,0,1,NULL,NULL),(155,2,2,0,1,NULL,NULL),(156,2,6,0,1,NULL,NULL),(157,2,8,0,1,NULL,NULL),(158,2,3,0,1,NULL,NULL),(159,2,8,0,1,NULL,NULL),(160,2,17,0,1,NULL,NULL),(161,2,7,0,1,NULL,NULL),(162,2,8,0,1,NULL,NULL),(163,2,8,0,1,NULL,NULL),(164,2,8,0,1,NULL,NULL),(165,2,18,0,1,NULL,NULL),(166,2,2,0,1,NULL,NULL),(167,2,3,0,1,NULL,NULL),(168,2,16,0,1,NULL,NULL),(169,2,18,0,1,NULL,NULL),(170,2,7,0,1,NULL,NULL),(171,2,8,0,1,NULL,NULL),(172,2,18,0,1,NULL,NULL),(173,2,10,0,1,NULL,NULL),(174,2,18,0,1,NULL,NULL),(175,2,6,0,1,NULL,NULL),(176,2,12,0,1,NULL,NULL),(177,2,12,0,1,NULL,NULL),(178,2,11,0,1,NULL,NULL),(179,2,10,0,1,NULL,NULL),(180,2,16,0,1,NULL,NULL),(181,2,6,0,1,NULL,NULL),(182,2,18,0,1,NULL,NULL),(183,2,15,0,1,NULL,NULL),(184,2,18,0,1,NULL,NULL),(185,2,12,0,1,NULL,NULL),(186,2,17,0,1,NULL,NULL),(187,2,2,0,1,NULL,NULL),(188,2,6,0,1,NULL,NULL),(189,2,7,0,1,NULL,NULL),(190,2,17,0,1,NULL,NULL),(191,2,2,0,1,NULL,NULL),(192,2,17,0,1,NULL,NULL),(193,2,11,0,1,NULL,NULL),(194,2,13,0,1,NULL,NULL),(195,2,13,0,1,NULL,NULL),(196,2,16,0,1,NULL,NULL),(197,2,4,0,1,NULL,NULL),(198,2,3,0,1,NULL,NULL),(199,2,12,0,1,NULL,NULL),(200,2,18,0,1,NULL,NULL),(201,2,15,0,1,NULL,NULL),(202,2,7,0,1,NULL,NULL),(203,2,15,0,1,NULL,NULL),(204,2,15,0,1,NULL,NULL),(205,2,16,0,1,NULL,NULL),(206,2,4,0,1,NULL,NULL),(207,2,8,0,1,NULL,NULL),(208,2,13,0,1,NULL,NULL),(209,2,6,0,1,NULL,NULL),(210,2,12,0,1,NULL,NULL),(211,2,6,0,1,NULL,NULL),(212,2,17,0,1,NULL,NULL),(213,2,12,0,1,NULL,NULL),(214,2,17,0,1,NULL,NULL),(215,2,15,0,1,NULL,NULL),(216,2,12,0,1,NULL,NULL),(217,2,10,0,1,NULL,NULL),(218,2,8,0,1,NULL,NULL),(219,2,12,0,1,NULL,NULL),(220,2,3,0,1,NULL,NULL),(221,2,15,0,1,NULL,NULL),(222,2,16,0,1,NULL,NULL),(223,2,10,0,1,NULL,NULL),(224,2,3,0,1,NULL,NULL),(225,2,16,0,1,NULL,NULL),(226,2,12,0,1,NULL,NULL),(227,2,15,0,1,NULL,NULL),(228,2,11,0,1,NULL,NULL),(229,2,2,0,1,NULL,NULL),(230,2,7,0,1,NULL,NULL),(231,2,12,0,1,NULL,NULL),(232,2,12,0,1,NULL,NULL),(233,2,4,0,1,NULL,NULL),(234,2,17,0,1,NULL,NULL),(235,2,10,0,1,NULL,NULL),(236,3,17,0,1,NULL,NULL),(237,3,7,0,1,NULL,NULL),(238,3,11,0,1,NULL,NULL),(239,3,4,0,1,NULL,NULL),(240,3,16,0,1,NULL,NULL),(241,3,6,0,1,NULL,NULL),(242,3,12,0,1,NULL,NULL),(243,3,16,0,1,NULL,NULL),(244,3,10,0,1,NULL,NULL),(245,3,4,0,1,NULL,NULL),(246,3,10,0,1,NULL,NULL),(247,3,4,0,1,NULL,NULL),(248,3,11,0,1,NULL,NULL),(249,3,17,0,1,NULL,NULL),(250,3,3,0,1,NULL,NULL),(251,3,6,0,1,NULL,NULL),(252,3,7,0,1,NULL,NULL),(253,3,18,0,1,NULL,NULL),(254,3,13,0,1,NULL,NULL),(255,3,3,0,1,NULL,NULL),(256,3,3,0,1,NULL,NULL),(257,3,13,0,1,NULL,NULL),(258,3,7,0,1,NULL,NULL),(259,3,15,0,1,NULL,NULL),(260,3,4,0,1,NULL,NULL),(261,2,17,0,1,NULL,NULL),(262,2,3,0,1,NULL,NULL),(263,2,11,0,1,NULL,NULL),(264,2,18,0,1,NULL,NULL),(265,2,12,0,1,NULL,NULL),(266,2,7,0,1,NULL,NULL),(267,2,3,0,1,NULL,NULL),(268,2,17,0,1,NULL,NULL),(269,2,4,0,1,NULL,NULL),(270,2,18,0,1,NULL,NULL),(271,2,7,0,1,NULL,NULL),(272,2,15,0,1,NULL,NULL),(273,2,7,0,1,NULL,NULL),(274,2,16,0,1,NULL,NULL),(275,2,8,0,1,NULL,NULL),(276,2,17,0,1,NULL,NULL),(277,2,4,0,1,NULL,NULL),(278,2,8,0,1,NULL,NULL),(279,2,17,0,1,NULL,NULL),(280,2,18,0,1,NULL,NULL),(281,2,18,0,1,NULL,NULL),(282,2,11,0,1,NULL,NULL),(283,2,10,0,1,NULL,NULL),(284,2,17,0,1,NULL,NULL),(285,2,6,0,1,NULL,NULL),(286,2,17,0,1,NULL,NULL),(287,2,18,0,1,NULL,NULL),(288,2,3,0,1,NULL,NULL),(289,2,12,0,1,NULL,NULL),(290,2,3,0,1,NULL,NULL),(291,2,12,0,1,NULL,NULL),(292,2,3,0,1,NULL,NULL),(293,2,8,0,1,NULL,NULL),(294,2,11,0,1,NULL,NULL),(295,2,17,0,1,NULL,NULL),(296,2,4,0,1,NULL,NULL),(297,2,16,0,1,NULL,NULL),(298,2,10,0,1,NULL,NULL),(299,2,3,0,1,NULL,NULL),(300,2,16,0,1,NULL,NULL),(301,2,4,0,1,NULL,NULL),(302,2,4,0,1,NULL,NULL),(303,2,4,0,1,NULL,NULL),(304,2,7,0,1,NULL,NULL),(305,2,11,0,1,NULL,NULL),(306,2,16,0,1,NULL,NULL),(307,2,13,0,1,NULL,NULL),(308,2,17,0,1,NULL,NULL),(309,2,13,0,1,NULL,NULL),(310,2,7,0,1,NULL,NULL),(311,2,3,0,1,NULL,NULL),(312,2,7,0,1,NULL,NULL),(313,2,4,0,1,NULL,NULL),(314,2,4,0,1,NULL,NULL),(315,2,12,0,1,NULL,NULL),(316,2,2,0,1,NULL,NULL),(317,2,17,0,1,NULL,NULL),(318,2,11,0,1,NULL,NULL),(319,2,17,0,1,NULL,NULL),(320,2,2,0,1,NULL,NULL),(321,2,8,0,1,NULL,NULL),(322,2,11,0,1,NULL,NULL),(323,2,11,0,1,NULL,NULL),(324,2,13,0,1,NULL,NULL),(325,2,18,0,1,NULL,NULL),(326,2,4,0,1,NULL,NULL),(327,2,10,0,1,NULL,NULL),(328,2,12,0,1,NULL,NULL),(329,2,7,0,1,NULL,NULL),(330,2,17,0,1,NULL,NULL),(331,2,12,0,1,NULL,NULL),(332,2,6,0,1,NULL,NULL),(333,2,11,0,1,NULL,NULL),(334,2,15,0,1,NULL,NULL),(335,2,11,0,1,NULL,NULL),(336,2,12,0,1,NULL,NULL),(337,2,16,0,1,NULL,NULL),(338,2,11,0,1,NULL,NULL),(339,2,3,0,1,NULL,NULL),(340,2,12,0,1,NULL,NULL);
