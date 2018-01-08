/*
Navicat MySQL Data Transfer

Source Server         : server
Source Server Version : 50610
Source Host           : 192.168.30.191:3306
Source Database       : statistics_20160226

Target Server Type    : MYSQL
Target Server Version : 50610
File Encoding         : 65001

Date: 2016-03-14 15:28:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `job_info`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `job_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `sort` smallint(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `lang` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1全部，2中文，3英文',
  `admin_id` varchar(100) NOT NULL,
  `mtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1未发布，2已发布',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
