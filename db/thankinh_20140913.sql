-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 13, 2014 at 01:25 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thankinh`
--

-- --------------------------------------------------------

--
-- Table structure for table `ntk_department`
--

CREATE TABLE IF NOT EXISTS `ntk_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ntk_department`
--

INSERT INTO `ntk_department` (`id`, `name`, `status`, `order`) VALUES
(1, 'BS Ngoại thần kinh', 1, 1),
(2, 'BS Chỉnh hình - Phẫu thuật cột sống', 1, 2),
(3, 'CN Khác', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ntk_file_type`
--

CREATE TABLE IF NOT EXISTS `ntk_file_type` (
  `file_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_type_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `file_type_icon` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `order` smallint(6) NOT NULL,
  PRIMARY KEY (`file_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ntk_file_type`
--

INSERT INTO `ntk_file_type` (`file_type_id`, `file_type_name`, `file_type_icon`, `status`, `order`) VALUES
(1, 'PDF', 'pdf.png', 1, 1),
(2, 'Word', 'word.png', 1, 1),
(3, 'Excel', 'excel.png', 1, 2),
(4, 'Powerpoint', 'powerpoint.png', 1, 3),
(5, 'HTML', 'html.png', 1, 4),
(7, 'Khac', 'file.png', 1, 5),
(6, 'Rar/Zip/7Zip', 'zip.png', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `ntk_hospital`
--

CREATE TABLE IF NOT EXISTS `ntk_hospital` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ntk_hospital`
--

INSERT INTO `ntk_hospital` (`id`, `name`, `province_id`, `status`, `order`) VALUES
(1, 'BV Chợ rẫy', 1, 1, 1),
(2, 'BV Đại Học Y Dược TP HCM', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ntk_menus`
--

CREATE TABLE IF NOT EXISTS `ntk_menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(250) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_order` smallint(6) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `language` varchar(2) DEFAULT 'vi',
  `group` varchar(50) DEFAULT 'ngoai-than-kinh',
  `link` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `ntk_menus`
--

INSERT INTO `ntk_menus` (`menu_id`, `menu_name`, `parent_id`, `menu_order`, `status`, `language`, `group`, `link`) VALUES
(1, 'TRANG CHỦ', -1, NULL, 1, 'vi', 'ngoai-than-kinh', 'trang-chu.html'),
(2, 'Giới thiệu hiệp hội', -1, NULL, 1, 'vi', 'ngoai-than-kinh', 'http://www.aaa.com'),
(3, 'Tin tức sự kiện', -1, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(4, 'Đào tạo', -1, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(5, 'Sức khỏe cộng đồng', -1, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(6, 'Liên hệ', -1, NULL, 1, 'vi', 'ngoai-than-kinh', 'lien-he.html'),
(7, 'Lịch sử hình thành hiệp hội', 2, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(8, 'Cơ cấu tổ chức', 2, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(9, 'Mạng lưới - thần kinh', 2, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(10, 'Trong nước', 3, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(11, 'Quốc tế', 3, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(12, 'Thông tin hội nghị', 3, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(13, 'Thông tin đào tạo', 4, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(14, 'Cập nhật kiến thức', 4, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(15, 'Journal Club', 4, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(16, 'Hỏi đáp', 5, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(17, 'Bài viết', 5, NULL, 1, 'vi', 'ngoai-than-kinh', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ntk_news`
--

CREATE TABLE IF NOT EXISTS `ntk_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `short` text,
  `status` smallint(6) DEFAULT '0',
  `source` varchar(250) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `news_order` int(11) DEFAULT '1000',
  `img` varchar(250) DEFAULT NULL,
  `show_index` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ntk_news`
--

INSERT INTO `ntk_news` (`id`, `cid`, `title`, `short`, `status`, `source`, `create_date`, `news_order`, `img`, `show_index`) VALUES
(1, 7, 'Gắp dị vật sát tủy cổ', 'Xin chào các bác sĩ.\r\nTôi có người quen không may bị trúng đạn hoa cải. Là đạn chì. Hiện các bác sĩ đã gắp được 23 viên còn 1 viên ở cổ, sợ gắp ra sẽ chạm vào tủy sống, thần kinh . Cho tôi hỏi hướng xử trí tiếp theo cho bệnh nhân này như thế nào? Liệu có gắp được viên đạn đó ra không? Nếu để đó thì có biến chứng gì không?\r\nXin cảm ơn !', 0, NULL, '2014-09-13 11:46:18', 1000, NULL, 1),
(2, 7, 'chấn thương sọ não', 'Câu hỏi: bác sĩ ơi cho con hói, sau khi bị tai nạn giao thông mà bệnh nhân vẫn tỉnh táo, vẫn trả lời được tất cả các câu hỏi bình thường ( tên, năm sinh, tuỏi,...) một cách chính xác, khi bị tai nạn thì mũ bảo hiểm vẫn', 0, NULL, '2014-07-27 16:23:07', 1000, NULL, 0),
(3, 7, 'Đau mỏi cổ và hai tay', 'Chào BS. Em năm nay 22 tuổi. Em bị đau nhức mỏi cổ, cơ vai và hai tay. Hay có hiện tượng đau nhức cột sống cổ ở say gáy. Nhức mỏi tê hai vai và nhiều lúc cảm giác tê mỏi mất cảm giác ở 2 tay từ gáy', 0, NULL, '2014-07-27 16:23:21', 1000, NULL, 0),
(4, 7, 'Vá sọ não sau CTSN', 'Xin hỏi Bác sĩ: Tôi có em bạn bị CTSN do TNGT, hiện đã xuất viện về nhà sau khi đã phẩu thuật mỗ sọ: Gia đình em bạn đang băn khuâng có nên vá sọ không? vì có người anh bên Mỹ nói vá sọ sẽ để lại nhiều', 0, NULL, '2014-07-28 09:35:28', 1000, NULL, 0),
(5, 7, 'Gãy đốt sống cụt số 3', 'Câu hỏi: Chồng em bị té va đập vào cột sống, chẩn đoán gãy đốt sống cụt số 3, ảnh hưởng dây thần kinh nên bí tiểu, không ngồi và đi lại được. Hiện đã nằm viện hơn 1 tuần nhưng chưa thấy thuyên giảm', 0, NULL, '2014-07-28 09:35:41', 1000, NULL, 0),
(6, 7, 'Đau nhức 2 cánh tay', 'Câu hỏi: Thưa bác, Cháu 25t, cháu bị đau nhức 2 cánh tay đã 5 năm,lúc đầu mới bị có cảm giác như 2 luồng điện chạy dọc 2 cánh tay,cháu chụp mri cách đây 1 năm bị phình nhẹ đĩa đệm c4,5,gây hẹp lỗ tiếp hợp', 0, NULL, '2014-07-28 09:35:52', 1000, NULL, 0),
(7, 7, 'Ê buot vung mông', 'Câu hỏi: Em chao bs, Cong viec cua m la saler, nen thuong xuyen ngoi xe gan may hoac xe đò de di cong tac. ngoai thoi gian lam viec em thuong ngoi ban de lam viec. ', 0, NULL, '2014-07-28 09:36:10', 1000, NULL, 0),
(8, 7, 'Bệnh đau nhức vai gáy và tê tay.', 'Chào bác sĩ. Mẹ em làm nông năm nay 50 tuổi, bị đau hai bên vai và tay trái bị tê. Cách đây nữa năm chỉ bị tê nhẹ và mẹ em đi chữa trị ở dưới quê cho đến nay vẫn không bớt(bớt 1 thời gian làm việc nặng', 0, NULL, '2014-07-28 09:36:18', 1000, NULL, 0),
(9, 7, 'Rỗng tủy sống cổ', 'Câu hỏi: Mẹ con bị co rút 2 bàn tay. cách đây khoảng 10 năm chỉ bị rút một ngón út bên phải sau đó đến cả tay bên trái, rồi sang tay trái. đã đến nhiều bệnh viện được chuẩn đoán nhiều bệnh và chữa theo đủ cách nhưng', 0, NULL, '2014-07-28 09:36:34', 1000, NULL, 0),
(10, 7, 'Hỏi về nên làm và không nên làm sau phẩu thuật vá sọ', 'Câu hỏi: Thưa bác sĩ, con đã phẩu thuật vá sọ được 5 tháng, sau gần 4 tháng hồi phục sau máu tụ dưới màng cứng, cho con hỏi con nên làm gì và không làm gì vào thời điểm bây giờ? phần sọ vá thì bao lâu mới lành', 0, NULL, '2014-07-28 09:43:45', 1000, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ntk_new_files`
--

CREATE TABLE IF NOT EXISTS `ntk_new_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `new_id` int(11) NOT NULL,
  `file_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `file_path` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `require_login` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ntk_new_files`
--

INSERT INTO `ntk_new_files` (`id`, `new_id`, `file_name`, `file_path`, `file_type_id`, `require_login`) VALUES
(1, 1, 'File số 1', 'file1.pdf', 1, 1),
(2, 1, 'File số 2', 'file2.docx', 2, 0),
(3, 1, 'File số 3', 'file3.xlxs', 3, 1),
(4, 1, 'File số 4', 'file4.pptx', 4, 0),
(5, 1, 'File số 5', 'file5.rar', 5, 0),
(6, 1, 'File số 6', 'file6.zip', 6, 0),
(7, 1, 'File số 7', 'file7.rar', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ntk_province`
--

CREATE TABLE IF NOT EXISTS `ntk_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ntk_province`
--

INSERT INTO `ntk_province` (`id`, `name`, `order`) VALUES
(1, 'TP Hồ Chí Minh', 1),
(2, 'Hà Nội', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ntk_users`
--

CREATE TABLE IF NOT EXISTS `ntk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ntk_users`
--

INSERT INTO `ntk_users` (`id`, `email`, `password`, `full_name`, `province_id`, `department_id`, `hospital_id`) VALUES
(1, 'congtran90@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Trần Tấn Công 122', 1, 1, 1),
(2, 'email@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Email', 1, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
