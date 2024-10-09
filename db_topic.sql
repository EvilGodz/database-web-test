-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2024 at 04:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_topic`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(2000) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `user_id`, `topic_id`) VALUES
(147, 'เป็นปัญหาระดับชาติเลยค่ะ (ฮาๆ แอบเวอร์นิดหนึ่ง) ถ้าตามทับศัพท์จริงก็ตามที่จขกท.บอกถูกแล้วค่ะ อิงตามพระราชบัณฑิตยสถาน', 18, 55),
(148, 'ตรวจสอบสิทธิ์ แจกเงินหมื่น ผ่านเว็บไซต์ govwelfare.cgd.go.th คลิกลิงค์กันเลย~~~', 19, 56),
(175, 'แก้ยังไงครับ', 10, 64),
(176, 'คอมเมนต์ ครับ Comment หากเข้าหลักทับศัพท์แล้ว ก็จะได้ ต์ เพราะตัวสะกดภาษาอังกฤษที่เป็นตัว T ตามหลักแล้วต้องใช้ ต เป็นตัวการันต์เท่านั้น จะเป็น ท ได้ก็ต่อเมื่อตัวสะกดภาษาอังกฤษเป็น th ครับผม และเขาไม่นิยมใส่รูปวรรณยุกต์ ใส่ได้ก็แต่เพียงไม้ไต่คู้เท่านั้น ดังนั้น ไม้โทจึงไม่จำเป็น หลักการทับศัพท์จะตกไปทันที หากคำคำนั้นมีบันทึกอยู่ในพจนานุกรมอยู่แล้ว แต่คำใดก็ตาม ที่ไม่มีในพจนานุกรมของราชบัณฑิตฯ ก็ต้องมาเข้ากระบวนการทับศัพท์ก่อนทุกคำครับ ดังนั้น คำว่า comment ไม่มีในพจนานุกรมแน่นอน ไม่มีไม้โท ต้องใช้ ต เต่าการันต์ จึงต้องเขียนว่า คอมเมนต์', 10, 55),
(177, '1', 20, 69),
(178, 'แก้ยังไงครับ', 12, 69),
(179, 'ดอกอะไรหรอคะ', 20, 71),
(180, 'ดอกทองรึเปล่า', 21, 71),
(182, 'ดอกทานตะวันครับผม', 10, 71);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `report_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `user_id`, `topic_id`, `comment_id`, `report_date`) VALUES
(16, 10, 64, NULL, '2024-10-04 12:04:04');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `topic_name` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` varchar(2000) NOT NULL,
  `topic_date` datetime NOT NULL DEFAULT current_timestamp(),
  `topic_images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_name`, `user_id`, `body`, `topic_date`, `topic_images`) VALUES
(55, 'Comment มันเขียนแบบไหนกันแน่คะ', 18, '\"คอมเม้น\"\"คอมเม้นต์\"\"คอมเมนท์\"\"คอมเมนต์\" มันเขียนแบบไหนกันแน่คะ', '2024-10-04 08:50:10', 'uploads_topic/'),
(56, 'เงินดิจิทัลเฟส 2 จะแจกเงินเมื่อไหร่', 19, 'เงินดิจิทัลเฟส 2 จะแจกเงิน 10,000 บาท วันไหน คนลงทะเบียนไปแล้วจะได้เงินทุกคนหรือไม่ คลังตอบแล้ว ', '2024-10-04 08:55:49', 'uploads_topic/when.png'),
(57, 'X ปรับนโยบายใหม่ให้ทุกโพสต์ที่เป็นสาธารณะสามารถมองเห็นได้ทั้งหมด รวมถึงบัญชีที่ถูกบล็อก', 19, 'เอ็กซ์ได้ทำให้ทุกโพสต์ของผู้ใช้งานทุกคนที่เป็นสาธารณะจะได้รับการมองเห็นทั้งหมด ไม่เว้นแม้แต่ผู้ใช้งานที่ถูกปิดกั้น หรือบล็อก (Blocked) ก็ตาม จากการประกาศของอีลอน มัสก์ เจ้าของเอ็กซ์', '2024-10-04 08:58:16', 'uploads_topic/dFQROr7oWzulq5Fa6rBl3VweN3W5qSqzQPzQqW88wJHbLjL320w85kzmnGgNN8QijgJ.png'),
(58, 'สรุปเงื่อนไขโครงการเงินดิจิตอล 10,000 บาท ล่าสุด', 20, '🚩1. ร้านค้าที่เข้าร่วมโครงการ\r\nต้องเป็นร้านค้าที่อยู่ในระบบภาษีเท่านั้น และไม่สามารถถอนเงินสดได้ทันทีหลังลูกค้าใช้จ่าย ซึ่งการถอนเงิน จะถอนเงินสดได้เมื่อมีการใช้จ่ายตั้งแต่รอบที่ 2\r\n - สรุปคือเป็นร้านค้าแถวบ้านๆเล็กๆไม่ได้ว่านั้น 😴\r\n\r\n🚩2. สามารถใช้จ่ายสินค้าได้ทุกประเภท ยกเว้น\r\n1.สินค้าอบายมุข\r\n2.น้ำมัน\r\n3.สินค้าด้านบริการ\r\n4.สินค้าออนไลน์\r\nนอกจากนี้ ยังรวมถึงสินค้าอื่น ๆ ที่รัฐบาลกำหนดหลังจากนี้\r\n - อันนี้พอเข้าใจได้ 🫥\r\n\r\n🚩3.วิธีการใช้จ่ายเงิน\r\n-ใช้จ่ายผ่านแอปพลิเคชัน Super App แอปทางรัฐ (รัฐบาลมีแอปเป็นร้อยกว่าแอปแล้วครับ แอปที่ใช้แล้วเสถียรไม่ค่อยมี เดี๋ยวข้อมูลหลุดปชช.อีก😂)\r\n-ใช้จ่ายภายในอำเภอ (878 อำเภอ)\r\n-ใช้จ่ายภายใน 6 เดือน ไม่จำกัดจำนวนใช้จ่ายต่อวัน\r\n-ประชาชนซื้อสินค้าได้เฉพาะร้านค้าขนาดเล็กเท่านั้น ตามที่กระทรวงพาณิชย์กำหนด (7-11 ก็ได้ใช่เปล่าครับ😊)\r\n-ร้านค้าซื้อสินค้าจากร้านค้าได้ทุกขนาด และไม่จำกัดพื้นที่ (ไม่จัดกัดพื้นที่จริงหรอครับพอดีอยู่ไกลบ้าน😅)\r\n\r\n** คนที่ไม่ได้ก็ต้องรับภาระหนีเหมือนกันนะครับ', '2024-10-04 09:00:49', 'uploads_topic/'),
(64, '', 10, '', '2024-10-04 11:02:29', 'uploads_topic/Screenshot_2024-09-05_185417.png'),
(69, 'ตะลึง ! ผลสอบของนักศึกษา ECP3R', 10, 'อ่านเพิ่มเติม...', '2024-10-04 12:28:08', 'uploads_topic/images.jpg'),
(71, 'Flower', 12, 'เช้านี้กินข้าวยังคะ', '2024-10-04 13:11:40', 'uploads_topic/IMG_6527.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `topic_likes`
--

CREATE TABLE `topic_likes` (
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topic_likes`
--

INSERT INTO `topic_likes` (`topic_id`, `user_id`) VALUES
(0, 11),
(24, 11),
(22, 10),
(22, 11),
(27, 11),
(41, 10),
(42, 10),
(45, 10),
(45, 12),
(43, 12),
(44, 12),
(52, 11),
(39, 12),
(36, 12),
(32, 12),
(30, 12),
(28, 12),
(27, 12),
(38, 12),
(37, 12),
(54, 12),
(22, 12),
(53, 12),
(52, 12),
(55, 18),
(57, 20),
(56, 20),
(55, 20),
(56, 10),
(57, 18),
(59, 18),
(56, 21),
(57, 21),
(57, 12),
(70, 12),
(71, 20),
(71, 21),
(71, 10),
(57, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `joined` date NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `joined`, `is_admin`, `email`) VALUES
(7, 'admin', '900150983cd24fb0d6963f7d28e17f72', '0000-00-00', 1, 'asdadsadsdassaddsadsa@a'),
(10, 'non', '202cb962ac59075b964b07152d234b70', '2024-09-28', 1, 'an@n'),
(11, 'EvilGodz', '202cb962ac59075b964b07152d234b70', '2024-09-28', 1, 'an@nymous'),
(12, 'Admin', '202cb962ac59075b964b07152d234b70', '2024-09-29', 1, 'admin@gmail.com'),
(18, 'User01', '202cb962ac59075b964b07152d234b70', '2024-10-04', 0, 'user01@gmail'),
(19, 'User02', '202cb962ac59075b964b07152d234b70', '2024-10-04', 0, 'User02@gmail'),
(20, 'User03', '202cb962ac59075b964b07152d234b70', '2024-10-04', 0, 'user03@gmail.com'),
(21, 'User04', '202cb962ac59075b964b07152d234b70', '2024-10-04', 0, 'user04@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_images`
--

CREATE TABLE `user_images` (
  `image` text NOT NULL DEFAULT 'uploads/default.png',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_images`
--

INSERT INTO `user_images` (`image`, `user_id`) VALUES
('uploads/66fd86183905d.gif', 10),
('uploads/66ff80abcb5ee.jpg', 12),
('uploads/66fd897683664.gif', 11),
('uploads/cirno-brick.gif', 7),
('uploads/default.png', 18),
('uploads/default.png', 19),
('uploads/default.png', 20),
('uploads/default.png', 21);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `firstname` text DEFAULT 'ไม่ปรากฏ',
  `lastname` text DEFAULT 'ไม่ปรากฏ',
  `bio` text DEFAULT '\'แสดงความเป็นตัวของคุณเองได้ที่นี่!\''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `firstname`, `lastname`, `bio`) VALUES
(11, 'ไม่ปรากฏ', 'ไม่ปรากฏ', 'test'),
(10, 'นนทวัฒน์', 'คงนอก', '&#39;แสดงความเป็นตัวของคุณเองได้ที่นี่!&#39;'),
(12, 'ตัวร้าย', 'ตัวตึง', ''),
(18, 'ไม่ปรากฏ', 'ไม่ปรากฏ', '\'แสดงความเป็นตัวของคุณเองได้ที่นี่!\''),
(19, 'ไม่ปรากฏ', 'ไม่ปรากฏ', '\'แสดงความเป็นตัวของคุณเองได้ที่นี่!\''),
(20, 'ไม่ปรากฏ', 'ไม่ปรากฏ', '\'แสดงความเป็นตัวของคุณเองได้ที่นี่!\''),
(21, 'ไม่ปรากฏ', 'ไม่ปรากฏ', '\'แสดงความเป็นตัวของคุณเองได้ที่นี่!\'');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
