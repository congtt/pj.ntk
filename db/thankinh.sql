-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 10, 2014 at 12:18 PM
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `ntk_news`
--

INSERT INTO `ntk_news` (`id`, `cid`, `title`, `short`, `status`, `source`, `create_date`, `news_order`, `img`) VALUES
(1, 7, 'Gắp dị vật sát tủy cổ', 'Xin chào các bác sĩ.\r\nTôi có người quen không may bị trúng đạn hoa cải. Là đạn chì. Hiện các bác sĩ đã gắp được 23 viên còn 1 viên ở cổ, sợ gắp ra sẽ chạm vào tủy sống, thần kinh . Cho tôi hỏi hướng xử trí tiếp theo cho bệnh nhân này như thế nào? Liệu có gắp được viên đạn đó ra không? Nếu để đó thì có biến chứng gì không?\r\nXin cảm ơn !', 0, NULL, '2014-07-27 16:22:53', 1000, NULL),
(2, 7, 'chấn thương sọ não', 'Câu hỏi: bác sĩ ơi cho con hói, sau khi bị tai nạn giao thông mà bệnh nhân vẫn tỉnh táo, vẫn trả lời được tất cả các câu hỏi bình thường ( tên, năm sinh, tuỏi,...) một cách chính xác, khi bị tai nạn thì mũ bảo hiểm vẫn', 0, NULL, '2014-07-27 16:23:07', 1000, NULL),
(3, 7, 'Đau mỏi cổ và hai tay', 'Chào BS. Em năm nay 22 tuổi. Em bị đau nhức mỏi cổ, cơ vai và hai tay. Hay có hiện tượng đau nhức cột sống cổ ở say gáy. Nhức mỏi tê hai vai và nhiều lúc cảm giác tê mỏi mất cảm giác ở 2 tay từ gáy', 0, NULL, '2014-07-27 16:23:21', 1000, NULL),
(4, 7, 'Vá sọ não sau CTSN', 'Xin hỏi Bác sĩ: Tôi có em bạn bị CTSN do TNGT, hiện đã xuất viện về nhà sau khi đã phẩu thuật mỗ sọ: Gia đình em bạn đang băn khuâng có nên vá sọ không? vì có người anh bên Mỹ nói vá sọ sẽ để lại nhiều', 0, NULL, '2014-07-28 09:35:28', 1000, NULL),
(5, 7, 'Gãy đốt sống cụt số 3', 'Câu hỏi: Chồng em bị té va đập vào cột sống, chẩn đoán gãy đốt sống cụt số 3, ảnh hưởng dây thần kinh nên bí tiểu, không ngồi và đi lại được. Hiện đã nằm viện hơn 1 tuần nhưng chưa thấy thuyên giảm', 0, NULL, '2014-07-28 09:35:41', 1000, NULL),
(6, 7, 'Đau nhức 2 cánh tay', 'Câu hỏi: Thưa bác, Cháu 25t, cháu bị đau nhức 2 cánh tay đã 5 năm,lúc đầu mới bị có cảm giác như 2 luồng điện chạy dọc 2 cánh tay,cháu chụp mri cách đây 1 năm bị phình nhẹ đĩa đệm c4,5,gây hẹp lỗ tiếp hợp', 0, NULL, '2014-07-28 09:35:52', 1000, NULL),
(7, 7, 'Ê buot vung mông', 'Câu hỏi: Em chao bs, Cong viec cua m la saler, nen thuong xuyen ngoi xe gan may hoac xe đò de di cong tac. ngoai thoi gian lam viec em thuong ngoi ban de lam viec. ', 0, NULL, '2014-07-28 09:36:10', 1000, NULL),
(8, 7, 'Bệnh đau nhức vai gáy và tê tay.', 'Chào bác sĩ. Mẹ em làm nông năm nay 50 tuổi, bị đau hai bên vai và tay trái bị tê. Cách đây nữa năm chỉ bị tê nhẹ và mẹ em đi chữa trị ở dưới quê cho đến nay vẫn không bớt(bớt 1 thời gian làm việc nặng', 0, NULL, '2014-07-28 09:36:18', 1000, NULL),
(9, 7, 'Rỗng tủy sống cổ', 'Câu hỏi: Mẹ con bị co rút 2 bàn tay. cách đây khoảng 10 năm chỉ bị rút một ngón út bên phải sau đó đến cả tay bên trái, rồi sang tay trái. đã đến nhiều bệnh viện được chuẩn đoán nhiều bệnh và chữa theo đủ cách nhưng', 0, NULL, '2014-07-28 09:36:34', 1000, NULL),
(10, 7, 'Hỏi về nên làm và không nên làm sau phẩu thuật vá sọ', 'Câu hỏi: Thưa bác sĩ, con đã phẩu thuật vá sọ được 5 tháng, sau gần 4 tháng hồi phục sau máu tụ dưới màng cứng, cho con hỏi con nên làm gì và không làm gì vào thời điểm bây giờ? phần sọ vá thì bao lâu mới lành', 0, NULL, '2014-07-28 09:43:45', 1000, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
