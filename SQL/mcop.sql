/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50713
Source Host           : localhost:3306
Source Database       : mcop

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2017-11-30 18:02:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `mcop_access`
-- ----------------------------
DROP TABLE IF EXISTS `mcop_access`;
CREATE TABLE `mcop_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcop_access
-- ----------------------------
INSERT INTO `mcop_access` VALUES ('2', '3', '0', null);
INSERT INTO `mcop_access` VALUES ('2', '2', '0', null);
INSERT INTO `mcop_access` VALUES ('2', '1', '0', null);

-- ----------------------------
-- Table structure for `mcop_admin`
-- ----------------------------
DROP TABLE IF EXISTS `mcop_admin`;
CREATE TABLE `mcop_admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'admin_id',
  `name` varchar(16) NOT NULL,
  `password` char(32) NOT NULL DEFAULT '' COMMENT '真名',
  `email` varchar(64) NOT NULL COMMENT '用户邮箱',
  `truename` varchar(32) DEFAULT NULL,
  `is_active` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '0禁止 1允许',
  `remark` varchar(100) NOT NULL COMMENT '用户备注',
  `current_login_ip` char(15) NOT NULL DEFAULT '0' COMMENT '本次登录IP',
  `current_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '本次登录时间',
  `prev_login_ip` char(15) NOT NULL DEFAULT '0' COMMENT '上次登录IP',
  `prev_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `m_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '月登陆次数',
  `session` varchar(60) NOT NULL DEFAULT '0' COMMENT '用户的session_id',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COMMENT='admin 用户表';

-- ----------------------------
-- Records of mcop_admin
-- ----------------------------
INSERT INTO `mcop_admin` VALUES ('1', 'admin', '319d5c4152e4da43236d5d80efe57740', 'ishaiua@qq.com', 'admin', '1', 'null', '127.0.0.1', '1512034728', '127.0.0.1', '1512034716', '5', '0gu047sd2eq9up5ir14epirv4s');
INSERT INTO `mcop_admin` VALUES ('101', 'xiaohai', 'a1e0be3b496cdc855681917b2d271988', 'xiaohai@163.com', 'xiaohai', '1', '', '127.0.0.1', '1512035754', '127.0.0.1', '1512034702', '3', '0gu047sd2eq9up5ir14epirv4s');

-- ----------------------------
-- Table structure for `mcop_node`
-- ----------------------------
DROP TABLE IF EXISTS `mcop_node`;
CREATE TABLE `mcop_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcop_node
-- ----------------------------
INSERT INTO `mcop_node` VALUES ('1', 'Dashboard', 'Dashboard', '1', '', null, '0', '1', '1');
INSERT INTO `mcop_node` VALUES ('2', 'Index', '管理员设置', '1', '', null, '1', '2', '0');
INSERT INTO `mcop_node` VALUES ('3', 'index', '账户设置', '1', '', null, '2', '3', '0');
INSERT INTO `mcop_node` VALUES ('4', 'Setting', '网站设置', '1', '', null, '1', '2', '1');
INSERT INTO `mcop_node` VALUES ('6', 'setting', '基础设置', '1', '', null, '4', '3', '1');

-- ----------------------------
-- Table structure for `mcop_role`
-- ----------------------------
DROP TABLE IF EXISTS `mcop_role`;
CREATE TABLE `mcop_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcop_role
-- ----------------------------
INSERT INTO `mcop_role` VALUES ('2', '文章管理', null, '1', '');

-- ----------------------------
-- Table structure for `mcop_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `mcop_role_user`;
CREATE TABLE `mcop_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mcop_role_user
-- ----------------------------
INSERT INTO `mcop_role_user` VALUES ('2', '101');


DROP TABLE IF EXISTS `mcop_settings`;
CREATE TABLE `mcop_settings` (
  `id` int(10) unsigned NOT NULL  AUTO_INCREMENT ,
  `type` tinyint(4) unsigned DEFAULT 1 COMMENT '类型',
  `setting_name` char(32) NOT NULL  COMMENT 'key',
  `setting_value` char(32) DEFAULT NULL COMMENT 'value',
  `setting_extra` char(32) DEFAULT NULL COMMENT 'extra',
  PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `mcop_user`;
CREATE TABLE `mcop_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'user_id',
  `email` varchar(64) NOT NULL COMMENT '用户邮箱',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(32) DEFAULT NULL,
  `first_name` varchar(32) NOT NULL DEFAULT '' COMMENT '名' ,
  `last_name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓' ,
  `avatar` varchar(128) NOT NULL DEFAULT '' COMMENT '头像' ,
  `password_confirm_code` varchar(64) NOT NULL DEFAULT '' COMMENT '重置密码随机字符串',
  `email_confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 未验证 1 验证' ,
  `email_confirm_code`  varchar(64) NOT NULL DEFAULT '' COMMENT '验证邮箱随机字符串',
  `kyc_validate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 未验证 1 通过 2拒绝 ' ,
  `date_of_birth` varchar(12) NOT NULL DEFAULT '' COMMENT '生日',
  `street_address` varchar(128) NOT NULL DEFAULT '' COMMENT '街道、地址',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '城市',
  `state_region` varchar(32) NOT NULL DEFAULT '' COMMENT '州、省',
  `country` varchar(32) NOT NULL DEFAULT '' COMMENT '国家',
  `postal_code` varchar(16) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `ethereum_address` varchar(128) NOT NULL DEFAULT '' COMMENT '以太坊地址',
  `estimated_participation_amount` DECIMAL(12,2) NOT NULL DEFAULT '0.00' COMMENT '估计参与量',
  `idcard_number` varchar(32) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `idcard_front` varchar(128) NOT NULL DEFAULT '' COMMENT '身份证正面' ,
  `idcard_back` varchar(128) NOT NULL DEFAULT '' COMMENT '身份证反面' ,
  `idcard_face` varchar(128) NOT NULL DEFAULT '' COMMENT '手持身份证照',
  `nationality` varchar(16) NOT NULL DEFAULT '' COMMENT '国籍、国家',
  `invite_code` varchar(32) NOT NULL DEFAULT '' COMMENT '邀请码' ,
  `remark` varchar(100) NOT NULL COMMENT '用户备注',
  `reg_time` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `current_login_ip` char(15) NOT NULL DEFAULT '0' COMMENT '本次登录IP',
  `current_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '本次登录时间',
  `prev_login_ip` char(15) NOT NULL DEFAULT '0' COMMENT '上次登录IP',
  `prev_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `m_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '月登陆次数',
  `session` varchar(60) NOT NULL DEFAULT '0' COMMENT '用户的session_id',
  PRIMARY KEY (`user_id`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=16800 DEFAULT CHARSET=utf8 COMMENT='user 用户表';
