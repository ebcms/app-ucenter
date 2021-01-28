/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-08-20 20:50:13
*/

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
  `record_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ua` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
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
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE,
  UNIQUE KEY `nickname` (`nickname`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='会员表';

-- ----------------------------
-- Records of prefix_ebcms_user_user
-- ----------------------------
