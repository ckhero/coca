# Host: localhost  (Version 5.7.19)
# Date: 2018-02-10 23:13:43
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "co_boss"
#

CREATE TABLE `co_boss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hp` int(11) NOT NULL DEFAULT '0' COMMENT '总血量',
  `reduced` int(11) NOT NULL DEFAULT '0' COMMENT '已经掉的血量',
  `start` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '开始时间',
  `end` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_start_end` (`start`,`end`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='世界boss';
