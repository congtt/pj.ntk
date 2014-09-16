-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2014 at 10:31 PM
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
  `menu_name_vi` varchar(250) DEFAULT NULL,
  `menu_name_en` varchar(500) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `menu_order` smallint(6) DEFAULT NULL,
  `status` smallint(6) DEFAULT '1',
  `language` varchar(2) DEFAULT 'vi',
  `group` varchar(50) DEFAULT 'ngoai-than-kinh',
  `link` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `ntk_menus`
--

INSERT INTO `ntk_menus` (`menu_id`, `menu_name_vi`, `menu_name_en`, `parent_id`, `menu_order`, `status`, `language`, `group`, `link`) VALUES
(1, 'TRANG CHỦ', 'HOME', -1, 1, 1, 'vi', 'ngoai-than-kinh', 'trang-chu.html'),
(2, 'Giới thiệu hiệp hội', 'Introduce', -1, 2, 1, 'vi', 'ngoai-than-kinh', 'http://www.aaa.com'),
(3, 'Tin tức/Hội nghị', 'News/Events', -1, 3, 1, 'vi', 'ngoai-than-kinh', NULL),
(4, 'Đào tạo', 'Training', -1, 5, 1, 'vi', 'ngoai-than-kinh', NULL),
(5, 'Tạp chí', 'Magazine', -1, 4, 1, 'vi', 'ngoai-than-kinh', NULL),
(6, 'Liên hệ', 'Contact', -1, NULL, 1, 'vi', 'ngoai-than-kinh', 'lien-he.html'),
(7, 'Về Hội PTTK Việt Nam', 'Về Hội PTTK Việt Nam', 2, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(8, 'Văn bản pháp quy của Hội', 'Văn bản pháp quy của Hội', 2, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(9, 'Bộ máy tổ chức hội', 'Orchart', 2, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(10, 'Thông báo hội', 'Notification', 3, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(11, 'Lịch hội nghị trong nước', 'Event ', 3, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(12, 'Lịch hội nghị quốc tế', 'Event foreign', 3, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(13, 'Lớp đào tạo liên tục (CME)', 'Lớp đào tạo liên tục (CME)', 4, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(14, 'Workshops', 'Workshops', 4, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(15, 'Hội nghị trong nước', 'Hội nghị trong nước', 4, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(16, 'Guidelines', 'Guidelines', 5, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(17, 'Bài dịch CME', 'CME Translate', 5, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(18, 'Trong nước', 'Trong nước', 5, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(19, 'Quốc tế: JNS và Neurosurgery', 'Quốc tế: JNS và Neurosurgery', 5, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(20, 'Hội nghị Quốc tế', 'Hội nghị Quốc tế', 4, NULL, 1, 'vi', 'ngoai-than-kinh', NULL),
(21, 'Thành viên', 'Members', -1, 6, 1, 'vi', 'ngoai-than-kinh', NULL),
(22, 'Quyền lợi và nghĩa vụ thành viên', 'Quyền lợi và nghĩa vụ thành viên', 21, NULL, 1, 'vi', 'ngoai-than-kinh', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ntk_news`
--

CREATE TABLE IF NOT EXISTS `ntk_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `title_vi` varchar(250) DEFAULT NULL,
  `title_en` varchar(200) NOT NULL,
  `short_vi` text,
  `short_en` text NOT NULL,
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

INSERT INTO `ntk_news` (`id`, `cid`, `title_vi`, `title_en`, `short_vi`, `short_en`, `status`, `source`, `create_date`, `news_order`, `img`, `show_index`) VALUES
(1, 7, 'Gắp dị vật sát tủy cổ', 'Medulla police pick up strange objects', 'Xin chào các bác sĩ.\r\nTôi có người quen không may bị trúng đạn hoa cải. Là đạn chì. Hiện các bác sĩ đã gắp được 23 viên còn 1 viên ở cổ, sợ gắp ra sẽ chạm vào tủy sống, thần kinh . Cho tôi hỏi hướng xử trí tiếp theo cho bệnh nhân này như thế nào? Liệu có gắp được viên đạn đó ra không? Nếu để đó thì có biến chứng gì không?\r\nXin cảm ơn !', 'Hello doctor.  Unfortunately I have acquaintance wealth gunshot flowers. As lead shot. Does the doctor have to pick up the 23 members who are first in the neck, gripping fear will touch the spinal cord, nerves. So I asked the next direction for the management of patients like? Is there a bullet trap is not it? If so then there are any complications?  Thank you!', 1, NULL, '2014-09-15 21:22:42', 1000, NULL, 1),
(2, 7, 'chấn thương sọ não', 'traumatic brain injury', 'Câu hỏi: bác sĩ ơi cho con hói, sau khi bị tai nạn giao thông mà bệnh nhân vẫn tỉnh táo, vẫn trả lời được tất cả các câu hỏi bình thường ( tên, năm sinh, tuỏi,...) một cách chính xác, khi bị tai nạn thì mũ bảo hiểm vẫn', 'Question: My doctor bald child after traffic accident in which the patient is still awake, still answering all the usual questions (name, year of birth, age, ...) a major determine when the accident helmet still', 1, NULL, '2014-09-15 21:22:58', 1000, NULL, 0),
(3, 7, 'Đau mỏi cổ và hai tay', '', 'Chào BS. Em năm nay 22 tuổi. Em bị đau nhức mỏi cổ, cơ vai và hai tay. Hay có hiện tượng đau nhức cột sống cổ ở say gáy. Nhức mỏi tê hai vai và nhiều lúc cảm giác tê mỏi mất cảm giác ở 2 tay từ gáy', 'Hey BS. I''m 22 years old this year. I suffer from neck aches, shoulder muscles and arms. Or the phenomenon of cervical spine pain in neck deep. Achy shoulders and sometimes numbness numbness numbness fatigue in 2 hands from neck', 1, NULL, '2014-09-15 21:15:08', 1000, NULL, 0),
(4, 7, 'Vá sọ não sau CTSN', '', 'Xin hỏi Bác sĩ: Tôi có em bạn bị CTSN do TNGT, hiện đã xuất viện về nhà sau khi đã phẩu thuật mỗ sọ: Gia đình em bạn đang băn khuâng có nên vá sọ không? vì có người anh bên Mỹ nói vá sọ sẽ để lại nhiều', '', 1, NULL, '2014-09-15 21:07:39', 1000, NULL, 0),
(5, 7, 'Gãy đốt sống cụt số 3', '', 'Câu hỏi: Chồng em bị té va đập vào cột sống, chẩn đoán gãy đốt sống cụt số 3, ảnh hưởng dây thần kinh nên bí tiểu, không ngồi và đi lại được. Hiện đã nằm viện hơn 1 tuần nhưng chưa thấy thuyên giảm', '', 1, NULL, '2014-09-15 21:07:39', 1000, NULL, 0),
(6, 7, 'Đau nhức 2 cánh tay', '', 'Câu hỏi: Thưa bác, Cháu 25t, cháu bị đau nhức 2 cánh tay đã 5 năm,lúc đầu mới bị có cảm giác như 2 luồng điện chạy dọc 2 cánh tay,cháu chụp mri cách đây 1 năm bị phình nhẹ đĩa đệm c4,5,gây hẹp lỗ tiếp hợp', '', 1, NULL, '2014-09-15 21:07:39', 1000, NULL, 0),
(7, 7, 'Ê buot vung mông', '', 'Câu hỏi: Em chao bs, Cong viec cua m la saler, nen thuong xuyen ngoi xe gan may hoac xe đò de di cong tac. ngoai thoi gian lam viec em thuong ngoi ban de lam viec. ', '', 1, NULL, '2014-09-15 21:07:39', 1000, NULL, 0),
(8, 7, 'Bệnh đau nhức vai gáy và tê tay.', '', 'Chào bác sĩ. Mẹ em làm nông năm nay 50 tuổi, bị đau hai bên vai và tay trái bị tê. Cách đây nữa năm chỉ bị tê nhẹ và mẹ em đi chữa trị ở dưới quê cho đến nay vẫn không bớt(bớt 1 thời gian làm việc nặng', '', 1, NULL, '2014-09-15 21:07:39', 1000, NULL, 0),
(9, 7, 'Rỗng tủy sống cổ', '', 'Câu hỏi: Mẹ con bị co rút 2 bàn tay. cách đây khoảng 10 năm chỉ bị rút một ngón út bên phải sau đó đến cả tay bên trái, rồi sang tay trái. đã đến nhiều bệnh viện được chuẩn đoán nhiều bệnh và chữa theo đủ cách nhưng', '', 1, NULL, '2014-09-15 21:07:39', 1000, NULL, 0),
(10, 7, 'Hỏi về nên làm và không nên làm sau phẩu thuật vá sọ', '', 'Câu hỏi: Thưa bác sĩ, con đã phẩu thuật vá sọ được 5 tháng, sau gần 4 tháng hồi phục sau máu tụ dưới màng cứng, cho con hỏi con nên làm gì và không làm gì vào thời điểm bây giờ? phần sọ vá thì bao lâu mới lành', '', 1, NULL, '2014-09-15 21:07:39', 1000, NULL, 0);

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
