/*
Navicat MySQL Data Transfer

Source Server         : rds
Source Server Version : 50718
Source Host           : rm-2ze1a086yu11qbb8txo.mysql.rds.aliyuncs.com:3306
Source Database       : py

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2018-11-17 17:23:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_access
-- ----------------------------
DROP TABLE IF EXISTS `admin_access`;
CREATE TABLE `admin_access` (
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_access
-- ----------------------------
INSERT INTO `admin_access` VALUES ('1', '15');

-- ----------------------------
-- Table structure for admin_group
-- ----------------------------
DROP TABLE IF EXISTS `admin_group`;
CREATE TABLE `admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `rules` varchar(4000) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_group
-- ----------------------------
INSERT INTO `admin_group` VALUES ('15', '系统管理员', '76,77,78,79,80,81,10,28,30,31,32,33,34,35,36,38,39,40,41,42,43,44,46,47,48,49,50,51,52,54,55,56,59,61,62,63,53,45,37,29,57,104,105,107,108,111,112,116,117,118,119,120,121,122,123,124,125,126,127,129,130,10,115,100,104,109,110,143,144,145,146,147,148,106,149,150,151,152,154,153,138,137,139,140,141,142,155,156,157,158,159,160,161,162,163,166,165,164,104,131,132,133,134,135,136,167,168,169,170,171,172,173,174,175,176,177,178,179,180,104,181,104,182,10,11,13,10,10,75,184,185,186,187,188,189,73,190,191,192,193,194,195,10,196,197,104,198,199,200,10,20,21,22,23,24,25,26,27,76,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,101,102,103,104,105,113,114,117,123,114,123,10,114,123,125,128,114,123,125', '0', '拥有所有权限', '1');

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '上级菜单ID',
  `title` varchar(32) DEFAULT '' COMMENT '菜单名称',
  `url` varchar(127) DEFAULT '' COMMENT '链接地址',
  `icon` varchar(64) DEFAULT '' COMMENT '图标',
  `menu_type` tinyint(4) DEFAULT NULL COMMENT '菜单类型',
  `sort` tinyint(4) unsigned DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `rule_id` int(11) DEFAULT NULL COMMENT '权限id',
  `module` varchar(50) DEFAULT NULL,
  `menu` varchar(50) DEFAULT NULL COMMENT '三级菜单吗',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('52', '0', '系统', '', 'el-icon-setting', '1', '1', '1', '59', 'Administrative', '');
INSERT INTO `admin_menu` VALUES ('53', '52', '系统配置', '', 'system', '1', '1', '1', '61', 'Administrative', '');
INSERT INTO `admin_menu` VALUES ('54', '53', '菜单管理', '/cms/home/menu/list', 'el-icon-setting', '1', '2', '1', '21', 'Administrative', 'menu');
INSERT INTO `admin_menu` VALUES ('55', '53', '系统参数', '/cms/home/config/add', 'el-icon-setting', '1', '3', '1', '29', 'Administrative', 'systemConfig');
INSERT INTO `admin_menu` VALUES ('56', '53', '权限规则', '/cms/home/rule/list', 'el-icon-setting', '1', '1', '1', '13', 'Administrative', 'rule');
INSERT INTO `admin_menu` VALUES ('57', '52', '组织架构', '', 'component', '1', '2', '1', '63', 'Administrative', '');
INSERT INTO `admin_menu` VALUES ('60', '57', '角色管理', '/cms/home/groups/list', 'el-icon-setting', '1', '0', '1', '47', 'Administrative', 'groups');
INSERT INTO `admin_menu` VALUES ('61', '52', '账户管理', '', 'admin', '1', '3', '1', '62', 'Administrative', '');
INSERT INTO `admin_menu` VALUES ('62', '61', '账户列表', '/cms/home/users/list', 'el-icon-book', '1', '0', '1', '55', 'Administrative', 'users');
INSERT INTO `admin_menu` VALUES ('64', '63', '系统配置', '', '', '1', '0', '1', '61', 'Administrative', '');
INSERT INTO `admin_menu` VALUES ('68', '53', '数据备份', '/cms/home/Db/list', 'el-icon-setting', '2', '5', '0', '73', 'Administrative', 'Db');
INSERT INTO `admin_menu` VALUES ('71', '53', '登陆日志', '/cms/home/signlog/list', '', '2', '4', '1', '75', 'Administrative', 'signlog');
INSERT INTO `admin_menu` VALUES ('72', '52', '后台首页', '/cms/home/dashboard/list', 'dashboard', '3', '0', '1', '422', 'Administrative', '');

-- ----------------------------
-- Table structure for admin_rule
-- ----------------------------
DROP TABLE IF EXISTS `admin_rule`;
CREATE TABLE `admin_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT '' COMMENT '名称',
  `name` varchar(100) DEFAULT '' COMMENT '定义',
  `level` tinyint(5) DEFAULT NULL COMMENT '级别。1模块,2控制器,3操作',
  `pid` int(11) DEFAULT '0' COMMENT '父id，默认0',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态，1启用，0禁用',
  `isLog` tinyint(4) DEFAULT '0' COMMENT '0 不进行日志处理 1 记录日志',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=565 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of admin_rule
-- ----------------------------
INSERT INTO `admin_rule` VALUES ('10', '系统基础功能', 'admin', '1', '0', '1', '0');
INSERT INTO `admin_rule` VALUES ('11', '权限规则', 'rules', '2', '10', '1', '1');
INSERT INTO `admin_rule` VALUES ('13', '规则列表', 'index', '3', '11', '1', '1');
INSERT INTO `admin_rule` VALUES ('14', '权限详情', 'read', '3', '11', '1', '0');
INSERT INTO `admin_rule` VALUES ('15', '编辑权限', 'update', '3', '11', '1', '0');
INSERT INTO `admin_rule` VALUES ('16', '删除权限', 'delete', '3', '11', '1', '0');
INSERT INTO `admin_rule` VALUES ('17', '添加权限', 'save', '3', '11', '1', '0');
INSERT INTO `admin_rule` VALUES ('18', '批量删除权限', 'deletes', '3', '11', '1', '0');
INSERT INTO `admin_rule` VALUES ('19', '批量启用/禁用权限', 'enables', '3', '11', '1', '0');
INSERT INTO `admin_rule` VALUES ('20', '菜单管理', 'menus', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('21', '菜单列表', 'index', '3', '20', '1', '0');
INSERT INTO `admin_rule` VALUES ('22', '添加菜单', 'save', '3', '20', '1', '0');
INSERT INTO `admin_rule` VALUES ('23', '菜单详情', 'read', '3', '20', '1', '0');
INSERT INTO `admin_rule` VALUES ('24', '编辑菜单', 'update', '3', '20', '1', '0');
INSERT INTO `admin_rule` VALUES ('25', '删除菜单', 'delete', '3', '20', '1', '0');
INSERT INTO `admin_rule` VALUES ('26', '批量删除菜单', 'deletes', '3', '20', '1', '0');
INSERT INTO `admin_rule` VALUES ('27', '批量启用/禁用菜单', 'enables', '3', '20', '1', '0');
INSERT INTO `admin_rule` VALUES ('28', '系统管理', 'systemConfigs', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('29', '修改系统配置', 'save', '3', '28', '1', '0');
INSERT INTO `admin_rule` VALUES ('30', '岗位管理', 'posts', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('31', '岗位列表', 'index', '3', '30', '1', '0');
INSERT INTO `admin_rule` VALUES ('32', '岗位详情', 'read', '3', '30', '1', '0');
INSERT INTO `admin_rule` VALUES ('33', '编辑岗位', 'update', '3', '30', '1', '0');
INSERT INTO `admin_rule` VALUES ('34', '删除岗位', 'delete', '3', '30', '1', '0');
INSERT INTO `admin_rule` VALUES ('35', '添加岗位', 'save', '3', '30', '1', '0');
INSERT INTO `admin_rule` VALUES ('36', '批量删除岗位', 'deletes', '3', '30', '1', '0');
INSERT INTO `admin_rule` VALUES ('37', '批量启用/禁用岗位', 'enables', '3', '30', '1', '0');
INSERT INTO `admin_rule` VALUES ('38', '部门管理', 'structures', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('39', '部门列表', 'index', '3', '38', '1', '0');
INSERT INTO `admin_rule` VALUES ('40', '部门详情', 'read', '3', '38', '1', '0');
INSERT INTO `admin_rule` VALUES ('41', '编辑部门', 'update', '3', '38', '1', '0');
INSERT INTO `admin_rule` VALUES ('42', '删除部门', 'delete', '3', '38', '1', '0');
INSERT INTO `admin_rule` VALUES ('43', '添加部门', 'save', '3', '38', '1', '0');
INSERT INTO `admin_rule` VALUES ('44', '批量删除部门', 'deletes', '3', '38', '1', '0');
INSERT INTO `admin_rule` VALUES ('45', '批量启用/禁用部门', 'enables', '3', '38', '1', '0');
INSERT INTO `admin_rule` VALUES ('46', '用户组管理', 'groups', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('47', '用户组列表', 'index', '3', '46', '1', '0');
INSERT INTO `admin_rule` VALUES ('48', '用户组详情', 'read', '3', '46', '1', '0');
INSERT INTO `admin_rule` VALUES ('49', '编辑用户组', 'update', '3', '46', '1', '0');
INSERT INTO `admin_rule` VALUES ('50', '删除用户组', 'delete', '3', '46', '1', '0');
INSERT INTO `admin_rule` VALUES ('51', '添加用户组', 'save', '3', '46', '1', '0');
INSERT INTO `admin_rule` VALUES ('52', '批量删除用户组', 'deletes', '3', '46', '1', '0');
INSERT INTO `admin_rule` VALUES ('53', '批量启用/禁用用户组', 'enables', '3', '46', '1', '0');
INSERT INTO `admin_rule` VALUES ('54', '成员管理', 'users', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('55', '成员列表', 'index', '3', '54', '1', '0');
INSERT INTO `admin_rule` VALUES ('56', '成员详情', 'read', '3', '54', '1', '0');
INSERT INTO `admin_rule` VALUES ('57', '删除成员', 'delete', '3', '54', '1', '0');
INSERT INTO `admin_rule` VALUES ('59', '管理菜单', 'Adminstrative', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('61', '系统管理二级菜单', 'systemConfig', '1', '59', '1', '0');
INSERT INTO `admin_rule` VALUES ('62', '账户管理二级菜单', 'personnel', '3', '59', '1', '0');
INSERT INTO `admin_rule` VALUES ('63', '组织架构二级菜单', 'structures', '3', '59', '1', '0');
INSERT INTO `admin_rule` VALUES ('73', '数据库备份', 'DbBackup', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('75', '登陆日志', 'signlogs', '2', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('100', '后台主页', 'dashboard', '1', '10', '1', '0');
INSERT INTO `admin_rule` VALUES ('420', '菜单权限', '菜单权限', '1', '0', '0', '0');
INSERT INTO `admin_rule` VALUES ('421', '系统', '系统', '2', '420', '1', '0');
INSERT INTO `admin_rule` VALUES ('422', '后台首页', '后台首页', '3', '421', '1', '0');
INSERT INTO `admin_rule` VALUES ('423', '权限规则', '权限规则', '3', '421', '1', '0');
INSERT INTO `admin_rule` VALUES ('424', '系统参数', '系统参数', '3', '421', '1', '0');
INSERT INTO `admin_rule` VALUES ('425', '系统参数', '系统参数', '3', '421', '1', '0');
INSERT INTO `admin_rule` VALUES ('426', '登陆日志', '登陆日志', '3', '421', '1', '0');
INSERT INTO `admin_rule` VALUES ('427', '角色管理', '角色管理', '3', '421', '1', '0');
INSERT INTO `admin_rule` VALUES ('428', '账户列表', '账户列表', '3', '421', '1', '0');

-- ----------------------------
-- Table structure for admin_signlog
-- ----------------------------
DROP TABLE IF EXISTS `admin_signlog`;
CREATE TABLE `admin_signlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) NOT NULL COMMENT '登陆ip',
  `uid` int(11) NOT NULL COMMENT '后台用户id',
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登录日期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='登陆日志';

-- ----------------------------
-- Records of admin_signlog
-- ----------------------------

-- ----------------------------
-- Table structure for admin_syslog
-- ----------------------------
DROP TABLE IF EXISTS `admin_syslog`;
CREATE TABLE `admin_syslog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `URI` varchar(100) NOT NULL COMMENT '请求的资源地址',
  `data` varchar(6000) NOT NULL COMMENT '请求的数据, 以json格式存储',
  `result` varchar(6000) NOT NULL COMMENT '返回的数据json格式',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of admin_syslog
-- ----------------------------

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(100) DEFAULT NULL COMMENT '管理后台账号',
  `password` varchar(100) DEFAULT NULL COMMENT '管理后台密码',
  `remark` varchar(100) DEFAULT NULL COMMENT '用户备注',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态,1启用0禁用',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `UnitName` varchar(100) DEFAULT NULL COMMENT '单位名称',
  `RealName` varchar(100) DEFAULT NULL COMMENT '真实姓名',
  `GroupID` int(11) DEFAULT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('1', 'admin', 'd93a5def7511da3d0f2d171d9c344e91', '', '1', null, null, null, '15');

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(50) DEFAULT '',
  `value` varchar(100) DEFAULT '' COMMENT '配置值',
  `group` tinyint(4) unsigned DEFAULT '0' COMMENT '配置分组',
  `need_auth` tinyint(4) DEFAULT '1' COMMENT '1需要登录后才能获取，0不需要登录即可获取',
  PRIMARY KEY (`id`),
  UNIQUE KEY `参数名` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='【配置】系统配置表';

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('1', 'SYSTEM_NAME', '会展管理', '0', '1');
INSERT INTO `system_config` VALUES ('2', 'SYSTEM_LOGO', 'uploads/20171129/0f7f382250ffdf612bd2e0eb6b78ad48.jpg', '0', '1');
INSERT INTO `system_config` VALUES ('3', 'LOGIN_SESSION_VALID', '30001', '0', '1');
INSERT INTO `system_config` VALUES ('4', 'IDENTIFYING_CODE', '0', '0', '1');
