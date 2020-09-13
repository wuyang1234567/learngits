/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 80017
Source Host           : localhost:3306
Source Database       : vip

Target Server Type    : MYSQL
Target Server Version : 80017
File Encoding         : 65001

Date: 2020-09-10 12:41:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dry_admin
-- ----------------------------
DROP TABLE IF EXISTS `dry_admin`;
CREATE TABLE `dry_admin` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `aname` varchar(20) NOT NULL DEFAULT '',
  `apwd` varchar(32) NOT NULL DEFAULT '',
  `atel` varchar(11) NOT NULL DEFAULT '0' COMMENT '11位手机号',
  `aemail` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `arole` varchar(10) NOT NULL DEFAULT '' COMMENT '角色',
  `atime` datetime DEFAULT NULL COMMENT '创建时间',
  `astatus` int(1) NOT NULL DEFAULT '0' COMMENT '0-禁用  1-开启',
  `beizhu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='平台管理员';

-- ----------------------------
-- Records of dry_admin
-- ----------------------------
INSERT INTO `dry_admin` VALUES ('1', 'admin', 'd93a5def7511da3d0f2d171d9c344e91', '12345678901', '1@qq.com', '1', '2018-04-19 06:52:28', '1', '不要轻易改动');
INSERT INTO `dry_admin` VALUES ('2', '张三', 'd93a5def7511da3d0f2d171d9c344e91', '11111111111', '1@qq.com', '1', '2018-04-20 01:29:50', '1', null);
INSERT INTO `dry_admin` VALUES ('3', '李四', 'd93a5def7511da3d0f2d171d9c344e91', '11111111111', '1@qq.com', '2', '2018-04-20 01:29:51', '0', null);
INSERT INTO `dry_admin` VALUES ('4', '王五', 'd93a5def7511da3d0f2d171d9c344e91', '22222222222', '2@qq.com', '2', '2018-04-20 01:32:49', '0', null);
INSERT INTO `dry_admin` VALUES ('5', '廖六', 'd93a5def7511da3d0f2d171d9c344e91', '3333333333', '3@qq.com', '2', '2018-04-20 01:34:58', '0', null);
INSERT INTO `dry_admin` VALUES ('6', '111', '4d0df1b16618f6322192bcead957079b', '12121212121', '1@qq.111', '1', '2018-04-20 01:42:55', '0', null);

-- ----------------------------
-- Table structure for dry_admincate
-- ----------------------------
DROP TABLE IF EXISTS `dry_admincate`;
CREATE TABLE `dry_admincate` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `parentid` varchar(255) NOT NULL DEFAULT '0' COMMENT '所属父类，0为一级分类',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='后台栏目分类';

-- ----------------------------
-- Records of dry_admincate
-- ----------------------------
INSERT INTO `dry_admincate` VALUES ('1', ' 会员管理', null, '&#xe60d', '0');
INSERT INTO `dry_admincate` VALUES ('2', '会员列表', 'admin/member/index', null, '1');
INSERT INTO `dry_admincate` VALUES ('3', '销售人员管理', '', '&#xe62c', '0');
INSERT INTO `dry_admincate` VALUES ('4', '销售人员列表', 'admin/agents/index', '', '3');
INSERT INTO `dry_admincate` VALUES ('5', '分类管理', '', '&#xe681', '0');
INSERT INTO `dry_admincate` VALUES ('6', '后台分类管理', 'admin/admincate/index', '', '5');
INSERT INTO `dry_admincate` VALUES ('7', 'VIP卡管理', '', '', '0');
INSERT INTO `dry_admincate` VALUES ('8', 'VIP卡管理', 'admin/room/rent', '', '7');
INSERT INTO `dry_admincate` VALUES ('14', '房东管理', null, '&#xe60a', '0');

-- ----------------------------
-- Table structure for dry_adminhandle
-- ----------------------------
DROP TABLE IF EXISTS `dry_adminhandle`;
CREATE TABLE `dry_adminhandle` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `handlecateid` int(11) NOT NULL DEFAULT '0',
  `handle` int(11) NOT NULL DEFAULT '0' COMMENT '0-查看 1-停用 2-启用 3-删除 4-添加 5-编辑 6-修改密码',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='后台菜单操作表';

-- ----------------------------
-- Records of dry_adminhandle
-- ----------------------------
INSERT INTO `dry_adminhandle` VALUES ('1', '1', '0');
INSERT INTO `dry_adminhandle` VALUES ('2', '2', '0');
INSERT INTO `dry_adminhandle` VALUES ('3', '2', '1');
INSERT INTO `dry_adminhandle` VALUES ('4', '2', '2');
INSERT INTO `dry_adminhandle` VALUES ('5', '2', '3');
INSERT INTO `dry_adminhandle` VALUES ('6', '2', '4');
INSERT INTO `dry_adminhandle` VALUES ('7', '2', '5');
INSERT INTO `dry_adminhandle` VALUES ('8', '2', '6');
INSERT INTO `dry_adminhandle` VALUES ('9', '3', '0');
INSERT INTO `dry_adminhandle` VALUES ('10', '4', '0');
INSERT INTO `dry_adminhandle` VALUES ('11', '4', '1');
INSERT INTO `dry_adminhandle` VALUES ('12', '4', '2');
INSERT INTO `dry_adminhandle` VALUES ('13', '4', '3');
INSERT INTO `dry_adminhandle` VALUES ('14', '4', '4');
INSERT INTO `dry_adminhandle` VALUES ('15', '4', '5');
INSERT INTO `dry_adminhandle` VALUES ('16', '4', '6');
INSERT INTO `dry_adminhandle` VALUES ('17', '5', '0');
INSERT INTO `dry_adminhandle` VALUES ('18', '6', '0');
INSERT INTO `dry_adminhandle` VALUES ('19', '6', '3');
INSERT INTO `dry_adminhandle` VALUES ('20', '6', '4');
INSERT INTO `dry_adminhandle` VALUES ('21', '6', '5');
INSERT INTO `dry_adminhandle` VALUES ('22', '7', '0');
INSERT INTO `dry_adminhandle` VALUES ('23', '8', '0');
INSERT INTO `dry_adminhandle` VALUES ('24', '8', '3');
INSERT INTO `dry_adminhandle` VALUES ('25', '8', '4');
INSERT INTO `dry_adminhandle` VALUES ('26', '8', '5');

-- ----------------------------
-- Table structure for dry_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `dry_admin_role`;
CREATE TABLE `dry_admin_role` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL DEFAULT '' COMMENT '角色名',
  `describe` varchar(50) DEFAULT '' COMMENT '角色描述',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员权限';

-- ----------------------------
-- Records of dry_admin_role
-- ----------------------------
INSERT INTO `dry_admin_role` VALUES ('1', '超级管理员', '拥有至高无上的权利');
INSERT INTO `dry_admin_role` VALUES ('2', '总编', '具有添加、审核、发布、删除内容的权限');
INSERT INTO `dry_admin_role` VALUES ('3', '财务', ' 财务管理qq\n                 ');

-- ----------------------------
-- Table structure for dry_advice
-- ----------------------------
DROP TABLE IF EXISTS `dry_advice`;
CREATE TABLE `dry_advice` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `tel` varchar(11) DEFAULT NULL COMMENT '用户咨询建议联系方式',
  `city` varchar(10) DEFAULT NULL COMMENT '用户咨询建议所在城市',
  `describe` varchar(200) DEFAULT NULL COMMENT '用户咨询建议详细描述',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='咨询建议表';

-- ----------------------------
-- Records of dry_advice
-- ----------------------------
INSERT INTO `dry_advice` VALUES ('1', '111111', null, null);

-- ----------------------------
-- Table structure for dry_agent
-- ----------------------------
DROP TABLE IF EXISTS `dry_agent`;
CREATE TABLE `dry_agent` (
  `gid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gname` varchar(15) NOT NULL DEFAULT '' COMMENT '销售人员登陆管理端的账号',
  `gpwd` varchar(32) NOT NULL DEFAULT '',
  `gtel` varchar(11) NOT NULL DEFAULT '',
  `gemail` varchar(30) NOT NULL DEFAULT '',
  `gstatus` int(1) unsigned NOT NULL DEFAULT '1',
  `gaccent` varchar(255) NOT NULL DEFAULT '' COMMENT '销售人员姓名',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='经纪人';

-- ----------------------------
-- Records of dry_agent
-- ----------------------------
INSERT INTO `dry_agent` VALUES ('1', '111', 'd93a5def7511da3d0f2d171d9c344e91', '1234567890', '1@qq.ccc', '1', '张三');
INSERT INTO `dry_agent` VALUES ('2', '222', 'd93a5def7511da3d0f2d171d9c344e91', '1234567890', '1@qq.ccc', '1', '李四');
INSERT INTO `dry_agent` VALUES ('3', '333', 'd93a5def7511da3d0f2d171d9c344e91', '111', '1@qq.com', '1', '王五');
INSERT INTO `dry_agent` VALUES ('4', '444', 'd93a5def7511da3d0f2d171d9c344e91', '11', '1@qq.com', '1', '小红');
INSERT INTO `dry_agent` VALUES ('5', '555', 'd93a5def7511da3d0f2d171d9c344e91', '11', '1@qq.com', '1', '小张');
INSERT INTO `dry_agent` VALUES ('6', 'ljp', 'd93a5def7511da3d0f2d171d9c344e91', '13439763834', 'ljp@126.com', '1', '小品');
INSERT INTO `dry_agent` VALUES ('7', 'lili', 'c78b6663d47cfbdb4d65ea51c104044e', '17733476547', 'df@qq.com', '1', '丽丽');

-- ----------------------------
-- Table structure for dry_bargain
-- ----------------------------
DROP TABLE IF EXISTS `dry_bargain`;
CREATE TABLE `dry_bargain` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(11) NOT NULL DEFAULT '0',
  `uname` varchar(11) NOT NULL DEFAULT '0',
  `agent` varchar(11) NOT NULL DEFAULT '0',
  `conimg` varchar(255) NOT NULL DEFAULT '',
  `jid` int(11) DEFAULT NULL COMMENT '与join关联',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='合同信息表';

-- ----------------------------
-- Records of dry_bargain
-- ----------------------------
INSERT INTO `dry_bargain` VALUES ('1', '房东', '用户', '111', '1.jpg', null);

-- ----------------------------
-- Table structure for dry_hobby
-- ----------------------------
DROP TABLE IF EXISTS `dry_hobby`;
CREATE TABLE `dry_hobby` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='收藏表';

-- ----------------------------
-- Records of dry_hobby
-- ----------------------------

-- ----------------------------
-- Table structure for dry_housers
-- ----------------------------
DROP TABLE IF EXISTS `dry_housers`;
CREATE TABLE `dry_housers` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sname` varchar(15) NOT NULL DEFAULT '' COMMENT '商家真实姓名',
  `stel` varchar(15) NOT NULL DEFAULT '' COMMENT '商家联系方式',
  `sarea` varchar(20) NOT NULL DEFAULT '' COMMENT '地区（北京市-朝阳区）',
  `svillage` varchar(30) NOT NULL DEFAULT '' COMMENT '小区名',
  `sothers` varchar(200) DEFAULT NULL COMMENT '商家其他信息',
  `ssign` int(1) NOT NULL DEFAULT '1' COMMENT '1-线上委托  2-实勘房源  3-即刻签约  4-坐享收益',
  `sid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT '0',
  `sdetailAddress` varchar(50) DEFAULT NULL COMMENT '商家详细地址',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='商家信息表';

-- ----------------------------
-- Records of dry_housers
-- ----------------------------
INSERT INTO `dry_housers` VALUES ('1', '行三', '11111111111', '1111', '11111', null, '4', '1', '0', null);
INSERT INTO `dry_housers` VALUES ('2', '李四', '22222222222', '', '2222222', null, '4', '2', '0', null);
INSERT INTO `dry_housers` VALUES ('5', '丽水', '15803267793', '北京', '静心小区', '', '4', null, '0', '五单元三号楼静心别苑');
INSERT INTO `dry_housers` VALUES ('6', 'mss', '15803267794', '北京', '静心苑', '', '2', '1', '0', '五单元四号楼17层07');

-- ----------------------------
-- Table structure for dry_house_allocation
-- ----------------------------
DROP TABLE IF EXISTS `dry_house_allocation`;
CREATE TABLE `dry_house_allocation` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL DEFAULT '0',
  `bed` int(1) NOT NULL DEFAULT '0' COMMENT '床 0-没有 1-有',
  `cabinet` int(1) NOT NULL DEFAULT '0' COMMENT '衣柜 0-没有 1-有',
  `computerTable` int(1) NOT NULL DEFAULT '0' COMMENT '电脑桌 0-没有 1-有',
  `chair` int(1) NOT NULL DEFAULT '0' COMMENT '椅子 0-没有 1-有',
  `television` int(1) NOT NULL DEFAULT '0' COMMENT '电视 0-没有 1-有',
  `refirgerator` int(1) NOT NULL DEFAULT '0' COMMENT '冰箱 0-没有 1-有',
  `washer` int(1) NOT NULL DEFAULT '0' COMMENT '洗衣机 0-没有 1-有',
  `airConditioner` int(1) NOT NULL DEFAULT '0' COMMENT '空调 0-没有 1-有',
  `gas` int(1) NOT NULL DEFAULT '0' COMMENT '燃气 0-没有 1-有',
  `hatwater` int(1) NOT NULL DEFAULT '0' COMMENT '热水器 0-没有 1-有',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='房屋配置';

-- ----------------------------
-- Records of dry_house_allocation
-- ----------------------------
INSERT INTO `dry_house_allocation` VALUES ('1', '1', '1', '1', '0', '1', '1', '1', '0', '1', '1', '1');
INSERT INTO `dry_house_allocation` VALUES ('2', '2', '1', '1', '1', '0', '1', '0', '1', '0', '0', '1');

-- ----------------------------
-- Table structure for dry_image
-- ----------------------------
DROP TABLE IF EXISTS `dry_image`;
CREATE TABLE `dry_image` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) DEFAULT NULL,
  `imagetype` int(1) NOT NULL DEFAULT '0' COMMENT '图片类型（0-房屋用图 1-首页大图）',
  `imageurl` varchar(255) DEFAULT NULL,
  `fid` int(10) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='图片';

-- ----------------------------
-- Records of dry_image
-- ----------------------------
INSERT INTO `dry_image` VALUES ('1', '1', '0', 'dbimg/1.jpg', '2');
INSERT INTO `dry_image` VALUES ('2', '1', '0', 'dbimg/2.jpg', '3');
INSERT INTO `dry_image` VALUES ('3', '2', '0', 'dbimg/3.jpg', '4');
INSERT INTO `dry_image` VALUES ('4', '1', '0', 'dbimg/4.jpg', '5');
INSERT INTO `dry_image` VALUES ('5', '3', '0', 'dbimg/5.jpg', '6');
INSERT INTO `dry_image` VALUES ('6', '3', '0', 'dbimg/6.jpg', '8');
INSERT INTO `dry_image` VALUES ('7', '5', '0', 'dbimg/7.jpg', '9');
INSERT INTO `dry_image` VALUES ('8', null, '0', 'dbimg/8.jpg', '10');
INSERT INTO `dry_image` VALUES ('9', null, '1', 'dbimg/9.jpg', '10');
INSERT INTO `dry_image` VALUES ('10', null, '0', 'dbimg/1.jpg', '11');
INSERT INTO `dry_image` VALUES ('11', null, '1', 'dbimg/2.jpg', '11');
INSERT INTO `dry_image` VALUES ('12', null, '0', 'dbimg/10.jpg', '12');
INSERT INTO `dry_image` VALUES ('13', null, '1', 'dbimg/11.jpg', '12');
INSERT INTO `dry_image` VALUES ('14', null, '0', 'dbimg/12.jpg', '13');
INSERT INTO `dry_image` VALUES ('15', null, '0', 'dbimg/13.jpg', '14');
INSERT INTO `dry_image` VALUES ('16', null, '1', 'dbimg/14.jpg', '14');
INSERT INTO `dry_image` VALUES ('17', null, '0', 'dbimg/15.jpg', '15');
INSERT INTO `dry_image` VALUES ('18', null, '1', 'dbimg/16.jpg', '15');
INSERT INTO `dry_image` VALUES ('19', null, '1', 'dbimg/17.jpg', '15');
INSERT INTO `dry_image` VALUES ('20', null, '0', 'dbimg/1.jpg', '16');
INSERT INTO `dry_image` VALUES ('21', null, '1', 'dbimg/12.jpg', '16');
INSERT INTO `dry_image` VALUES ('22', null, '0', 'dbimg/20180522\\6583464af3dd9241a5f58b5259d3bac5.png', '21');
INSERT INTO `dry_image` VALUES ('23', null, '0', 'dbimg/20180523\\c9d0bb89456c9d5467ae633ef8c369df.jpg', '22');

-- ----------------------------
-- Table structure for dry_join
-- ----------------------------
DROP TABLE IF EXISTS `dry_join`;
CREATE TABLE `dry_join` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) DEFAULT '0',
  `gid` int(11) DEFAULT '0' COMMENT '销售员id',
  `rtitle` varchar(25) DEFAULT NULL,
  `rareas` float(5,2) unsigned DEFAULT NULL COMMENT '面积',
  `rdirection` varchar(5) DEFAULT '' COMMENT '合租房屋朝向（南）',
  `rprice` int(5) DEFAULT NULL COMMENT '房屋租金',
  `rstatus` int(1) DEFAULT '0' COMMENT '房屋租赁状态（0-未出租 1-已出租）',
  `rtype` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '房屋类型（室厅）0-主卧 1-次卧',
  `rname` varchar(10) DEFAULT NULL,
  `uendTime` varchar(25) DEFAULT NULL,
  `uenterTime` varchar(25) DEFAULT NULL,
  `content` text COMMENT 'VIP卡介绍',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='合租详细信息表';

-- ----------------------------
-- Records of dry_join
-- ----------------------------
INSERT INTO `dry_join` VALUES ('2', '1', '1', '测试的VIP卡1', '15.80', '南', '1500', '0', '0', 'A卧室', '2018-6.28', '2018-9.30', '111【编前语】“天地英雄气，千秋尚凛然。”无数英雄先烈是我们民族的脊梁，是我们不断开拓前进的勇气和力量所在。新华社《学习进行时》梳理了习近平总书记关于崇尚英雄、缅怀先烈的十句经典论述，与您分享，一同铭记。\n\n1.祖国是人民最坚实的依靠，英雄是民族最闪亮的坐标。\n\n——2016年11月30日，在中国文联十大、中国作协九大开幕式上的讲话\n\n2.对中华民族的英雄，要心怀崇敬，浓墨重彩记录英雄、塑造英雄，让英雄在文艺作品中得到传扬，引导人民树立正确的历史观、民族观、国家观、文化观，绝不做亵渎祖先、亵渎经典、亵渎英雄的事情。\n\n——2016年11月30日，在中国文联十大、中国作协九大开幕式上的讲话');
INSERT INTO `dry_join` VALUES ('3', '1', '2', '测试的VIP卡2', '13.85', '西', '1380', '0', '0', 'C卧室', null, null, '22211月30日，在中国文联十大、中国作协九大开幕式上的讲话\n\n2.对中华民族的英雄，要心怀崇敬，浓墨重彩记录英雄、塑造英雄，让英雄在文艺作品中得到传扬，引导人民树立正确的历史观、民族观、国家观、文化观，绝不做亵渎祖先、亵渎经典、亵渎英雄的事情。\n\n——2016年11月30日，在中国文联十大、中国作协九大开幕式上的讲话\n\n3.理想之光不灭，信念之光不灭。我们一定要铭记烈士们');
INSERT INTO `dry_join` VALUES ('4', '2', '3', '测试的VIP卡3', '16.50', '', '1680', '0', '0', '', null, null, '333祝中国共产党成立95周年大会上的讲话\n\n4.一个有希望的民族不能没有英雄，一个有前途的国家不能没有先锋。\n\n——2015年9月2日，在颁发“中国人民抗日战争胜利70周年”纪念章仪式上的讲话\n\n5.包括抗战英雄在内的一切民族英雄，都是中华');
INSERT INTO `dry_join` VALUES ('5', '1', '4', '测试的VIP卡4', '13.20', '东', '1200', '0', '0', 'B卧室', null, null, '444民抗日战争胜利70周年”纪念章仪式上的讲话\n\n6.我们要铭记一切为中华民族和中国人民作出贡献的英雄们，崇尚英雄，捍卫英雄，学习英雄，关爱英雄，戮力同心为实现“两个一百年”奋斗目标、实现中华民族伟大复兴的中国梦而努力奋斗！\n\n——2015年9月2日，在颁发“中国人民抗日战争胜利70周年”纪念章仪式上的讲话\n\n7.有些人刻意抹黑我们的英雄人物，歪曲我们的光辉历史，要引起我们高度警觉。\n\n——2014年10月31日，在全军政治工作会议上的讲话');
INSERT INTO `dry_join` VALUES ('6', '3', '5', '测试的VIP卡5', '13.60', '南', '4500', '0', '0', 'A卧室', null, null, '555牺牲行为永远值得尊重和纪念。\n\n——2014年10月31日，在全军政治工作会议上的讲话\n\n9.我们要在全社会树立崇尚英雄、缅怀先烈的良好风尚。对为国牺牲、为民牺牲的英雄烈士，我们要永远怀念他们，给予他们极大的荣誉和敬仰，不然谁愿意为国家和人民牺牲呢？\n\n——2014年10月31日，在全军政治工作会议上的讲');
INSERT INTO `dry_join` VALUES ('8', '4', '1', '测试的VIP卡6', '15.80', '东', '4500', '0', '0', null, null, null, '666民，海内外所有中华儿女，更加紧密地团结起来，肩负起历史重任，以中华民族伟大复兴不断前行的新成就，告慰为中国人民抗日战争和世界反法西斯战争胜利献出生命的所有先烈，告慰近代以来为中华民族独立、中国人民解放献出生命的所有英灵，这是我们对中国人民抗日战争和世界反法西斯战争胜利最好的纪念！\n\n——2014年9月3日，在纪念中国人民抗日战争暨世界反法西斯战争胜');
INSERT INTO `dry_join` VALUES ('9', '5', '1', '测试的VIP卡7', '999.99', '南', '1111', '0', '0', 'A卧室', null, null, '777民，海内外所有中华儿女，更加紧密地团结起来，肩负起历史重任，以中华民族伟大复兴不断前行的新成就，告慰为中国人民抗日战争和世界反法西斯战争胜利献出生命的所有先烈，告慰近代以来为中华民族独立、中国人民解放献出生命的所有英灵，这是我们对中国人民抗日战争和世界反法西斯战争胜利最好的纪念！\n\n——2014年9月3日，在纪念中国人民抗日战争暨世界反法西斯战争胜');
INSERT INTO `dry_join` VALUES ('10', '0', '6', '测试的VIP卡8', null, '', '1111', '1', '0', null, null, null, '<p>xffdsfsf</p>原标题：定调“生态文明建设”！习近平提出这些“真招”“实招”\n\n　　学习笔记按：全国生态环境保护大会18日至19日在北京召开，习近平出席会议并发表了重要讲话。此次大会规格高，信息量大，为新时代我国建设“生态文明”“美丽中国”布局定调。一个重大判断是什么？六个原则有哪些？哪些环保“大事”要做？学习笔记为您一一梳理总书记提出的这些“真招”“实招”。\n\n　　定调生态文明建设');
INSERT INTO `dry_join` VALUES ('12', '0', '6', '测试的VIP卡9', null, '', '1234', '0', '0', null, null, null, '<p>dxfsdfsdfds</p>文明建设是关系中华民族永续发展的根本大计。生态环境是关系党的使命宗旨的重大政治问题，也是关系民生的重大社会问题。\n\n　　 一个重大判断：生态文明建设正处于“三期叠加”\n\n　　生态文明建设正处于压力叠加、负重前行的关键期，已进入提供更多优质生态产品以满足人民日益增长的优美生态环境需要的攻');
INSERT INTO `dry_join` VALUES ('13', '0', '6', '测试的VIP卡10', null, '', '1234', '0', '0', null, null, null, '<p>xcvddsfdsf</p>目标基本实现\n\n　　习近平提出，要通过加快构建生态文明体系，确保到2035年，生态环境质量实现根本好转，美丽中国目标基本实现。到本世纪中叶，物质文明、政治文明、精神文明、社会文明、生态文明全面提升，绿色发展方式和生活方式全面形成，人与自然和谐共生，生态环境领域国家治理体系和治理能力现代化全面实现，建成美丽中国。\n\n　　五个生态文明体系：实现生态文明建设的“真招');
INSERT INTO `dry_join` VALUES ('14', '0', '6', '测试的VIP卡11', null, '', '13443', '0', '0', null, null, null, '<p>dsdfdsf</p>文化体系；\n\n　　以产业生态化和生态产业化为主体的生态经济体系；\n\n　　以改善生态环境质量为核心的目标责任体系；\n\n　　以治理体系和治理能力现代化为保障的生态');
INSERT INTO `dry_join` VALUES ('15', '0', '6', '测试的VIP卡12', null, '', '5675', '0', '1', null, null, null, '<p>发刚恢复光滑</p>控为重点的生态安全体系。\n\n　　六个原则+五点要求：推进生态文明建设的“实招”\n\n　　六个原则：\n\n　　一是坚持人与自然和谐共生；');
INSERT INTO `dry_join` VALUES ('16', '0', '6', '测试的VIP卡13', null, '', '457', '0', '0', null, null, null, '<p>色嗯嗯我</p>金山银山；\n\n　　三是良好生态环境是最普惠的民生福祉；\n\n　　四是山水林田湖草是生命共同体；\n\n　　五是用最严格制度最严密法治保护生态环境；\n\n　　六是共谋全球生态文明建设。\n\n　　五点要求：\n\n　　要加快构建生态文明体系；\n\n　　要全面推动绿色发展；\n\n　　要把解决突出生态环境问题作为民生优先领域；\n\n　　要有效防范生态环境风险；');
INSERT INTO `dry_join` VALUES ('21', '0', '6', 'aaa222', null, '', '123', '0', '0', null, null, null, '<p>dsfsdfsdds</p>');
INSERT INTO `dry_join` VALUES ('22', '0', '6', '5-23', null, '', '1111', '0', '0', null, null, null, '<p>sdfsdfsdf</p>');

-- ----------------------------
-- Table structure for dry_rolecate
-- ----------------------------
DROP TABLE IF EXISTS `dry_rolecate`;
CREATE TABLE `dry_rolecate` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `roleid` int(11) NOT NULL DEFAULT '0',
  `cateid` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='角色授权';

-- ----------------------------
-- Records of dry_rolecate
-- ----------------------------
INSERT INTO `dry_rolecate` VALUES ('1', '1', '2', '1');
INSERT INTO `dry_rolecate` VALUES ('2', '1', '4', '1');
INSERT INTO `dry_rolecate` VALUES ('3', '1', '6', '1');
INSERT INTO `dry_rolecate` VALUES ('4', '1', '8', '1');
INSERT INTO `dry_rolecate` VALUES ('5', '1', '10', '1');
INSERT INTO `dry_rolecate` VALUES ('6', '1', '11', '1');
INSERT INTO `dry_rolecate` VALUES ('7', '1', '13', '1');
INSERT INTO `dry_rolecate` VALUES ('8', '1', '15', '1');
INSERT INTO `dry_rolecate` VALUES ('9', '1', '16', '1');

-- ----------------------------
-- Table structure for dry_room
-- ----------------------------
DROP TABLE IF EXISTS `dry_room`;
CREATE TABLE `dry_room` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `roomType` varchar(20) DEFAULT NULL COMMENT '房屋户型（1室一厅）',
  `rdecorate` int(1) DEFAULT '1' COMMENT '0-毛坯 1-简装 2-精装',
  `rfloor` varchar(10) DEFAULT NULL COMMENT '房屋楼层',
  `rrentType` int(1) DEFAULT '0' COMMENT '0-合租 1-整租',
  `raddress` varchar(15) DEFAULT NULL COMMENT '房屋地址',
  `renterTime` date DEFAULT NULL COMMENT '用户入住时间',
  `sid` int(11) NOT NULL DEFAULT '0' COMMENT '房东的id',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '经纪人的id',
  `rcity` varchar(15) DEFAULT '北京市',
  `rbathroom` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-无 1-有',
  `rbalcony` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-无 1-有',
  `rnum` int(2) unsigned DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='整租房屋信息';

-- ----------------------------
-- Records of dry_room
-- ----------------------------
INSERT INTO `dry_room` VALUES ('1', '三室一厅', '1', '1/10', '0', '朝阳区红庙1区', '2018-01-05', '1', '1', '北京市', '0', '1', '3');
INSERT INTO `dry_room` VALUES ('2', '一室一厅', '2', '2/23', '1', '大望路1345号', '2018-02-04', '2', '2', '北京市', '0', '0', '0');
INSERT INTO `dry_room` VALUES ('3', '两室一厅', '1', '12/34', '1', '大兴区68号', '2018-07-07', '1', '1', '北京市', '0', '0', '2');
INSERT INTO `dry_room` VALUES ('4', '两室一厅', '1', '1/23', '0', '顺义区27号', '2018-09-09', '2', '2', '北京市', '0', '0', '0');
INSERT INTO `dry_room` VALUES ('5', '三室一厅', '1', '1/11', '0', '安安安安安安', '1111-01-01', '1', '6', '北京市', '0', '0', '0');

-- ----------------------------
-- Table structure for dry_user
-- ----------------------------
DROP TABLE IF EXISTS `dry_user`;
CREATE TABLE `dry_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id（主键）',
  `uname` varchar(20) DEFAULT NULL COMMENT '用户名',
  `upwd` varchar(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `usex` int(1) DEFAULT '0' COMMENT '1-男 2 -女',
  `utel` varchar(11) NOT NULL DEFAULT '0' COMMENT '用户联系方式',
  `uemail` varchar(20) DEFAULT NULL COMMENT '用户邮箱',
  `uwork` int(2) DEFAULT NULL COMMENT '0-无',
  `ubirth` date DEFAULT NULL COMMENT '用户出生时间',
  `uhead` varchar(60) DEFAULT NULL COMMENT '用户头像',
  `ustatus` int(1) NOT NULL DEFAULT '1' COMMENT '0 -禁止 1-开启',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='用户信息表';

-- ----------------------------
-- Records of dry_user
-- ----------------------------
INSERT INTO `dry_user` VALUES ('1', 'wqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('2', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('3', 'ew', 'd93a5def7511da3d0f2d171d9c344e91', '2', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('4', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('5', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('6', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('7', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '0', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('8', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('9', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('10', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('11', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('12', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('13', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('14', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('15', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('16', 'qqqq', 'd93a5def7511da3d0f2d171d9c344e91', '1', '1234567890', '1@qq.ccc', '1', '1992-01-04', null, '1');
INSERT INTO `dry_user` VALUES ('17', null, 'd93a5def7511da3d0f2d171d9c344e91', '0', '1111111111', null, null, null, null, '1');
INSERT INTO `dry_user` VALUES ('18', null, 'd93a5def7511da3d0f2d171d9c344e91', '0', '1111111112', null, null, null, null, '1');
INSERT INTO `dry_user` VALUES ('19', null, 'd93a5def7511da3d0f2d171d9c344e91', '0', '11111111113', null, null, null, null, '1');
INSERT INTO `dry_user` VALUES ('20', null, '1234567', '0', '1111111115', null, null, null, null, '1');
INSERT INTO `dry_user` VALUES ('28', null, 'cdee62e244c46526d047b581fd784fd7', '0', '15803267793', null, null, null, null, '1');
INSERT INTO `dry_user` VALUES ('29', null, 'bca9e87f1dc4919f77e72838d4a674bd', '0', '18612898298', null, null, null, null, '1');
INSERT INTO `dry_user` VALUES ('30', null, 'c78b6663d47cfbdb4d65ea51c104044e', '0', '18501171986', null, null, null, null, '1');
