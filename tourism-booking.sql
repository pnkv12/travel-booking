-- Adminer 4.8.1 MySQL 5.5.5-10.4.20-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `tourism-booking` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `tourism-booking`;

DROP TABLE IF EXISTS `booking-ticket`;
CREATE TABLE `booking-ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT 'date of the booking made by customer',
  `updated_at` datetime DEFAULT NULL,
  `state` int(1) NOT NULL COMMENT '0: New, 1: In Progress, 2: Completed',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `category` (`id`, `cate_name`) VALUES
(1,	'An Giang'),
(2,	'Bà Rịa – Vũng Tàu'),
(3,	'Bắc Giang'),
(4,	'Bắc Kạn'),
(5,	'Bạc Liêu'),
(6,	'Bắc Ninh'),
(7,	'Bến Tre'),
(8,	'Bình Định'),
(9,	'Bình Dương'),
(10,	'Bình Phước'),
(11,	'Bình Thuận'),
(12,	'Cà Mau'),
(13,	'Cần Thơ'),
(14,	'Cao Bằng'),
(15,	'Đà Nẵng'),
(16,	'Đắk Lắk'),
(17,	'Đắk Nông'),
(18,	'Điện Biên'),
(19,	'Đồng Nai'),
(20,	'Đồng Tháp'),
(21,	'Gia Lai'),
(22,	'Hà Giang'),
(23,	'Hà Nam'),
(24,	'Hà Nội'),
(25,	'Hà Tĩnh'),
(26,	'Hải Dương'),
(27,	'Hải Phòng'),
(28,	'Hậu Giang'),
(29,	'Hòa Bình'),
(30,	'Hưng Yên'),
(31,	'Khánh Hòa'),
(32,	'Kiên Giang'),
(33,	'Kon Tum'),
(34,	'Lai Châu'),
(35,	'Lâm Đồng'),
(36,	'Lạng Sơn'),
(37,	'Lào Cai'),
(38,	'Long An'),
(39,	'Nam Định'),
(40,	'Nghệ An'),
(41,	'Ninh Bình'),
(42,	'Ninh Thuận'),
(43,	'Phú Thọ'),
(44,	'Phú Yên'),
(45,	'Quảng Bình'),
(46,	'Quảng Nam'),
(47,	'Quảng Ngãi'),
(48,	'Quảng Ninh'),
(49,	'Quảng Trị'),
(50,	'Sóc Trăng'),
(51,	'Sơn La'),
(52,	'Tây Ninh'),
(53,	'Thái Bình'),
(54,	'Thái Nguyên'),
(55,	'Thanh Hóa'),
(56,	'Thừa Thiên Huế'),
(57,	'Tiền Giang'),
(58,	'TP Hồ Chí Minh'),
(59,	'Trà Vinh'),
(60,	'Tuyên Quang'),
(61,	'Vĩnh Long'),
(62,	'Vĩnh Phúc'),
(63,	'Yên Bái');

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `is_shown` int(2) NOT NULL COMMENT '0: Published; 1: Hidden',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `news` (`id`, `title`, `category_id`, `content`, `photo`, `author`, `created_at`, `updated_at`, `is_shown`) VALUES
(1,	'Buổi tối ở Đà Lạt nên đi đâu?',	35,	'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere',	NULL,	'1',	'2021-09-23 16:33:37',	'2021-09-23 16:33:00',	0),
(2,	'Lorem Ipsum',	10,	'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.',	NULL,	'1',	'2021-09-23 15:24:00',	NULL,	0),
(4,	'Test Private',	2,	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,',	NULL,	'1',	'2021-09-23 16:21:40',	'2021-09-23 16:21:00',	0);

DROP TABLE IF EXISTS `tours`;
CREATE TABLE `tours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tour_id` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `departure` date NOT NULL,
  `return` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `vehicle` varchar(255) NOT NULL COMMENT 'Plane, Bus, Ship',
  `details` longtext NOT NULL,
  `is_active` int(2) NOT NULL COMMENT '0: Available, 1: Sold Out',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tours` (`id`, `tour_id`, `name`, `departure`, `return`, `price`, `vehicle`, `details`, `is_active`, `created_at`, `updated_at`) VALUES
(1,	'T001',	'Combo du lịch Đà lạt 2 ngày 1 đêm',	'2021-09-23',	'2021-09-25',	56.78,	'2',	'Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles. Ma quande lingues coalesce, li grammatica del resultant lingue es plu simplic e regulari quam ti del coalescent lingues. Li nov lingua franca va esser plu simplic e regulari quam li existent Europan lingues. It va esser tam simplic quam Occidental in fact, it va esser Occidental. A un Angleso it va semblar un simplificat Angles, quam un skeptic Cambridge amico dit me que Occidental es.Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solmen va esser necessi far uniform grammatica, pronunciation e plu sommun paroles.',	0,	'2021-09-23 20:01:00',	'2021-09-23 20:52:00'),
(2,	'T002',	'test',	'2021-09-27',	'2021-09-30',	123.50,	'0',	'One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. \"What\'s happened to me?\" he thought. It wasn\'t a dream. His room, a proper human room although a little too small, lay peacefully between its four familiar walls. A collection of textile samples lay spread out on the table - Samsa was a travelling salesman - and above it there hung a picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame. It showed a lady fitted out with a fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look out the window at the dull weather. Drops',	1,	'2021-09-27 13:41:00',	'2021-09-27 13:41:00'),
(3,	'T003',	'Current Project',	'2021-09-07',	'2021-09-19',	23.50,	'1',	'This post will give you example of laravel where between eloquent. This post will give you simple example of laravel eloquent wherebetween. i would like to share with you laravel eloquent wherebetween dates. you can see laravel wherebetween dates example. Here, Creating a basic example of laravel wherebetween date format.<br />\r\n<br />\r\nwhereBetween() will help you to getting data with between two dates or two values from database in laravel 6, laravel 7 and laravel 8 application.<br />\r\n<br />\r\nIn this example i will give you very simple example of how to use whereBetween in laravel application. you can easily use it with laravel 6 and laravel 7 application.<br />\r\n<br />\r\nSo, let\'s see bellow examples that will help you how to use whereBetween() eloquent query in laravel.',	1,	'2021-09-27 13:57:00',	'2021-09-27 14:01:00'),
(4,	'T004',	'Combo Sài Gòn mới',	'2021-09-29',	'2021-10-01',	100.56,	'0',	'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.',	0,	'2021-09-27 13:58:00',	NULL),
(5,	'T005',	'ĐI hà nội thoi',	'2021-10-06',	'2021-10-11',	120.23,	'0',	'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.',	0,	'2021-09-27 13:58:00',	NULL),
(6,	'T006',	'Combo khuyến mãi 3 ngày ở Vũng Tàu',	'2021-10-08',	'2021-10-10',	20.78,	'2',	'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way. When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then',	0,	'2021-09-27 14:43:00',	NULL);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_confirmation` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `password`, `password_confirmation`, `phone`, `created_at`, `updated_at`) VALUES
(1,	'Vy Pham Ngoc Khanh',	'pnkv@test.com',	'pnkv12',	'$2y$10$roKpwYND6L1ICQ4zajPdku5d.UqdMwWawEWoANdDVz5BnGZgkp49C',	'$2y$10$YhApmCzHTlmLoEpW0zem3..UdFQISF0QO1gJcHILpoDjZfO2Kzz6O',	'0936284871',	NULL,	'2021-09-27 17:27:00'),
(2,	'Huy Tran',	'huyt@test.com',	'huytran',	'$2y$10$wlamtdupCbE7DulhHI.zheuz13Z4I7mi9A3MB0vZj9SCXFR74lD4q',	NULL,	'0123456789',	NULL,	NULL),
(3,	'Laina Park',	'laina@test.com',	'lainap',	'$2y$10$KI3J9mWcU0jMurNrjCXmBumHcoNMvUGgp3T.ryvcuRjrZJOYkK9Iy	',	NULL,	'0123456789',	NULL,	NULL),
(4,	'My Phan Huynh',	'myph@test.com',	'myph13',	'$2y$10$KI3J9mWcU0jMurNrjCXmBumHcoNMvUGgp3T.ryvcuRjrZJOYkK9Iy	',	NULL,	'0123456789',	NULL,	NULL),
(5,	'Andy Lee',	'andylee@test.com',	'andylee',	'$2y$10$KI3J9mWcU0jMurNrjCXmBumHcoNMvUGgp3T.ryvcuRjrZJOYkK9Iy	',	NULL,	'0123456789',	NULL,	NULL),
(6,	'Hao Nguyen',	'haonmh@test.com',	'haonmh',	'$2y$10$kfgRgzuP6ElS9RwzUBvqxudNrXKtK/U2pnxNM.cKAcA3BjDf4eFZG',	NULL,	'0123456789',	NULL,	NULL),
(7,	'Huỳnh Hoa',	'hoahn@test.com',	'hoahn1',	'$2y$10$C3Hk.nkwvJbqmijMMjs7lO213F1PQH3TwLKZq8h8neEwyQ/g6YRc6',	NULL,	'0909087745',	NULL,	NULL);

-- 2021-09-27 11:15:52
