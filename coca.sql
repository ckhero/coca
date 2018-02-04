# Host: localhost  (Version 5.7.19)
# Date: 2018-02-04 22:57:25
# Generator: MySQL-Front 6.0  (Build 2.20)


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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

#
# Structure for table "co_chapter_child_question"
#

CREATE TABLE `co_chapter_child_question` (
  `chapter_child_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL DEFAULT '0',
  KEY `chapter_child_id` (`chapter_child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "co_level"
#

CREATE TABLE `co_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '分数',
  `name` char(16) DEFAULT NULL COMMENT '等级名字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

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
# Structure for table "co_migration"
#

CREATE TABLE `co_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
