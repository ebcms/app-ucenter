SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for prefix_ebcms_user_log
-- ----------------------------
DROP TABLE IF EXISTS `prefix_ebcms_user_log`;
CREATE TABLE `prefix_ebcms_user_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `type` varchar(24) NOT NULL DEFAULT '' COMMENT '类型',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `context` text,
  `http_raw` text,
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'ip',
  `record_date` date DEFAULT '1970-01-01',
  `record_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `record_date` (`record_date`),
  KEY `user_id` (`user_id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='会员日志表';

-- ----------------------------
-- Records of prefix_ebcms_user_log
-- ----------------------------

-- ----------------------------
-- Table structure for prefix_ebcms_user_user
-- ----------------------------
DROP TABLE IF EXISTS `prefix_ebcms_user_user`;
CREATE TABLE `prefix_ebcms_user_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '标题',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `introduction` varchar(255) NOT NULL DEFAULT '',
  `score` int(10) unsigned NOT NULL COMMENT '积分',
  `coin` int(10) unsigned NOT NULL COMMENT '金币',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `salt` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  UNIQUE KEY `nickname` (`nickname`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='会员表';

-- ----------------------------
-- Records of prefix_ebcms_user_user
-- ----------------------------
