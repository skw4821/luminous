-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-12-22 20:59
-- 서버 버전: 8.0.40
-- PHP 버전: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `dewaura`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `cart`
--

CREATE TABLE `cart` (
  `cart_id` char(14) NOT NULL,
  `content_code` varchar(10) NOT NULL,
  `content_options` varchar(30) NOT NULL DEFAULT '옵션을 선택해주세요.',
  `content_amount` int NOT NULL DEFAULT '1',
  `user_id` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `contents`
--

CREATE TABLE `contents` (
  `content_code` char(14) NOT NULL,
  `content_img` varchar(500) NOT NULL,
  `deliv_today` char(1) NOT NULL,
  `content_name` varchar(50) NOT NULL,
  `discount_rate` decimal(3,0) NOT NULL DEFAULT '0',
  `content_cost` int NOT NULL,
  `content_price` int NOT NULL,
  `capacity_1` int DEFAULT NULL,
  `capacity_2` int DEFAULT NULL,
  `capacity_3` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 테이블의 덤프 데이터 `contents`
--

INSERT INTO `contents` (`content_code`, `content_img`, `deliv_today`, `content_name`, `discount_rate`, `content_cost`, `content_price`, `capacity_1`, `capacity_2`, `capacity_3`) VALUES
('11', 'img/contents/perfume1.jpg', 'Y', 'Chanel No. 5', 30, 60000, 35000, 30, 60, 100),
('12', 'img/contents/perfume2.jpg', 'N', 'Dior Sauvage', 30, 60000, 35000, 30, 60, 100),
('13', 'img/contents/perfume3.jpg', 'Y', 'J\'adore', 20, 50000, 35000, 30, 60, 100),
('14', 'img/contents/perfume4.jpg', 'Y', 'Libre', 10, 60000, 35000, 30, 60, 100),
('15', 'img/contents/perfume5.jpg', 'N', 'Aura', 30, 60000, 25000, 30, 60, 100),
('16', 'img/contents/perfume6.jpg', 'N', 'Her', 20, 30000, 35000, 30, 60, 100),
('17', 'img/contents/perfume7.jpg', 'Y', 'Eros', 20, 50000, 35000, 30, 60, 100),
('18', 'img/contents/perfume8.jpg', 'Y', 'Luna', 50, 90000, 50000, 30, 60, 100),
('19', 'img/contents/perfume9.jpg', 'N', 'Idôle', 30, 60000, 30000, 30, 60, 100),
('20', 'img/contents/perfume10.jpg', 'Y', 'Alien', 30, 60000, 45000, 30, 60, 100);

-- --------------------------------------------------------

--
-- 테이블 구조 `defuser`
--

CREATE TABLE `defuser` (
  `content_code` int NOT NULL,
  `content_img` varchar(255) DEFAULT NULL,
  `deliv_today` int DEFAULT NULL,
  `content_name` varchar(255) DEFAULT NULL,
  `discount_rate` int DEFAULT NULL,
  `content_cost` int DEFAULT NULL,
  `content_price` int DEFAULT NULL,
  `capacity_1` int DEFAULT NULL,
  `capacity_2` int DEFAULT NULL,
  `capacity_3` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 테이블의 덤프 데이터 `defuser`
--

INSERT INTO `defuser` (`content_code`, `content_img`, `deliv_today`, `content_name`, `discount_rate`, `content_cost`, `content_price`, `capacity_1`, `capacity_2`, `capacity_3`) VALUES
(1, '/dewAura/img/contents/defuser1.jpg', 1, '아로마 블리스', 10, 27000, 30000, 50, 100, 200),
(2, '/dewAura/img/contents/defuser2.jpg', 0, '세레니티 브리즈', 5, 42750, 45000, 50, NULL, 200),
(3, '/dewAura/img/contents/defuser3.jpg', 1, '라벤더 에센스', 0, 50000, 50000, 50, 100, 200),
(4, '/dewAura/img/contents/defuser4.jpg', 0, '트랜퀼 이스케이프', 20, 48000, 60000, NULL, NULL, 200),
(5, '/dewAura/img/contents/defuser5.jpg', 1, '시트러스 드림', 15, 21250, 25000, 50, 100, 200),
(6, '/dewAura/img/contents/defuser6.jpg', 0, '오션 위스퍼', 0, 55000, 55000, 50, 100, 200),
(7, '/dewAura/img/contents/defuser7.jpg', 1, '로즈우드 인퓨전', 10, 31500, 35000, 50, 100, 200),
(8, '/dewAura/img/contents/defuser8.jpg', 0, '진로 디퓨저', 5, 38000, 40000, 50, 100, 200),
(9, '/dewAura/img/contents/defuser9.jpg', 1, '프레시 메도우', 30, 49000, 70000, NULL, 100, 200),
(10, '/dewAura/img/contents/defuser10.jpg', 0, '스위트 자스민', 25, 60000, 80000, 50, 100, 200),
(11, '/dewAura/img/contents/defuser11.jpg', 1, '유칼립투스 캄', 10, 27000, 30000, 50, 100, 200),
(12, '/dewAura/img/contents/defuser12.jpg', 0, '썸머 글로우', 5, 42750, 45000, 50, NULL, 200),
(13, '/dewAura/img/contents/defuser13.jpg', 1, '미드나잇 라벤더', 0, 50000, 50000, 50, 100, 200),
(14, '/dewAura/img/contents/defuser14.jpg', 0, '와일드플라워 에센스', 20, 48000, 60000, NULL, NULL, 200),
(15, '/dewAura/img/contents/defuser15.jpg', 1, '시트러스 부케', 15, 21250, 25000, 50, 100, 200),
(16, '/dewAura/img/contents/defuser16.jpg', 0, '오션 브리즈', 0, 55000, 55000, 50, 100, 200),
(17, '/dewAura/img/contents/defuser17.jpg', 1, '가르데니아 딜라이트', 10, 31500, 35000, 50, 100, 200),
(18, '/dewAura/img/contents/defuser18.jpg', 0, '퓨어 바닐라', 5, 38000, 40000, 50, 100, 200),
(19, '/dewAura/img/contents/defuser19.jpg', 1, '시트러스 선라이즈', 30, 49000, 70000, NULL, 100, 200),
(20, '/dewAura/img/contents/defuser20.jpg', 0, '앰버 우즈', 25, 60000, 80000, 50, 100, 200);

-- --------------------------------------------------------

--
-- 테이블 구조 `female_perfume`
--

CREATE TABLE `female_perfume` (
  `content_code` char(14) NOT NULL,
  `content_img` varchar(500) NOT NULL,
  `deliv_today` char(1) NOT NULL,
  `content_name` varchar(50) NOT NULL,
  `discount_rate` decimal(3,0) NOT NULL DEFAULT '0',
  `content_cost` int NOT NULL,
  `content_price` int NOT NULL,
  `capacity_1` int DEFAULT NULL,
  `capacity_2` int DEFAULT NULL,
  `capacity_3` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 테이블의 덤프 데이터 `female_perfume`
--

INSERT INTO `female_perfume` (`content_code`, `content_img`, `deliv_today`, `content_name`, `discount_rate`, `content_cost`, `content_price`, `capacity_1`, `capacity_2`, `capacity_3`) VALUES
('30', '/dewAura/img/contents/female1.jpg', '1', '디올 미스 디올 오 드 퍼퓸', 25, 60000, 45000, 30, 60, 100),
('31', '/dewAura/img/contents/female2.jpg', '0', '샤넬 No.5 오 드 퍼퓸', 10, 50000, 45000, NULL, 60, 100),
('32', '/dewAura/img/contents/female3.jpg', '1', '불가리 오피움 오 드 퍼퓸', 15, 60000, 51000, 30, NULL, 100),
('33', '/dewAura/img/contents/female4.jpg', '0', '구찌 블룸 오 드 퍼퓸', 20, 50000, 40000, 30, 60, NULL),
('34', '/dewAura/img/contents/female5.jpg', '1', '에스티로더 퍼펙트 리프레셔 오 드 퍼퓸', 30, 45000, 31500, NULL, 60, 100),
('35', '/dewAura/img/contents/female6.jpg', '1', '버버리 브리튼 우먼 오 드 퍼퓸', 20, 50000, 40000, 30, NULL, 100),
('36', '/dewAura/img/contents/female7.jpg', '1', '랑방 에끌라 드 아르페쥬', 30, 55000, 38500, 30, 60, NULL),
('37', '/dewAura/img/contents/female8.jpg', '0', '조말론 런던 블랙베리 앤 베이', 25, 50000, 37500, NULL, 60, 100),
('38', '/dewAura/img/contents/female9.jpg', '1', '클리니크 해피 오 드 퍼퓸', 40, 60000, 36000, 30, NULL, 100),
('39', '/dewAura/img/contents/female10.jpg', '0', '불가리 알레그라 오 드 퍼퓸', 15, 45000, 38250, 30, 60, NULL),
('40', '/dewAura/img/contents/female11.jpg', '1', '샤넬 가르뎅 오 드 퍼퓸', 30, 50000, 35000, NULL, 60, 100),
('41', '/dewAura/img/contents/female12.jpg', '0', '프라다 캔디 오 드 퍼퓸', 25, 55000, 41250, 30, NULL, 100),
('42', '/dewAura/img/contents/female13.jpg', '1', '디올 쟈도르 오 드 퍼퓸', 10, 40000, 36000, 30, 60, NULL),
('43', '/dewAura/img/contents/female14.jpg', '0', '에르메스 트윌리 드 엑르메스', 20, 50000, 40000, NULL, 60, 100),
('44', '/dewAura/img/contents/female15.jpg', '1', '샤넬 코코 마드모아젤', 25, 60000, 45000, 30, 60, NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `male_perfume`
--

CREATE TABLE `male_perfume` (
  `content_code` char(14) NOT NULL,
  `content_img` varchar(500) NOT NULL,
  `deliv_today` char(1) NOT NULL,
  `content_name` varchar(50) NOT NULL,
  `discount_rate` decimal(3,0) NOT NULL DEFAULT '0',
  `content_cost` int NOT NULL,
  `content_price` int NOT NULL,
  `capacity_1` int DEFAULT NULL,
  `capacity_2` int DEFAULT NULL,
  `capacity_3` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 테이블의 덤프 데이터 `male_perfume`
--

INSERT INTO `male_perfume` (`content_code`, `content_img`, `deliv_today`, `content_name`, `discount_rate`, `content_cost`, `content_price`, `capacity_1`, `capacity_2`, `capacity_3`) VALUES
('50', '/dewAura/img/contents/male1.jpg', '1', '디올 Sauvage 오 드 토일렛', 20, 60000, 48000, 30, 60, 100),
('51', '/dewAura/img/contents/male2.jpg', '0', '샤넬 블루 드 샤넬 오 드 퍼퓸', 15, 50000, 42500, NULL, 60, 100),
('52', '/dewAura/img/contents/male3.jpg', '1', '불가리 아쿠아 디 파르마 오 드 퍼퓸', 10, 60000, 54000, 30, NULL, 100),
('53', '/dewAura/img/contents/male4.jpg', '0', '구찌 길티 오 드 퍼퓸', 25, 50000, 37500, 30, 60, NULL),
('54', '/dewAura/img/contents/male5.jpg', '1', '아르마니 코드 오 드 퍼퓸', 30, 45000, 31500, NULL, 60, 100),
('55', '/dewAura/img/contents/male6.jpg', '1', '랑방 마이 랑방 오 드 퍼퓸', 20, 50000, 40000, 30, NULL, 100),
('56', '/dewAura/img/contents/male7.jpg', '1', '티파니 & 코. 티파니 퍼퓸', 30, 55000, 38500, 30, 60, NULL),
('57', '/dewAura/img/contents/male8.jpg', '0', '아쿠아 디 파르마 콜로니아', 25, 50000, 37500, NULL, 60, 100),
('58', '/dewAura/img/contents/male9.jpg', '1', '에르메스 떼르 드 에르메스 오 드 퍼퓸', 40, 60000, 36000, 30, NULL, 100),
('59', '/dewAura/img/contents/male10.jpg', '0', '벨루가 퍼퓸 프레쉬 오 드 퍼퓸', 15, 45000, 38250, 30, 60, NULL),
('60', '/dewAura/img/contents/male11.jpg', '1', '조 말론 런던 우드 세이지 앤 시 솔트', 30, 50000, 35000, NULL, 60, 100),
('61', '/dewAura/img/contents/male12.jpg', '0', '불가리 블루 오 드 퍼퓸', 25, 55000, 41250, 30, NULL, 100),
('62', '/dewAura/img/contents/male13.jpg', '1', '헤리티지 오 드 퍼퓸', 10, 40000, 36000, 30, 60, NULL),
('63', '/dewAura/img/contents/male14.jpg', '0', '랑방 오 드 퍼퓸', 20, 50000, 40000, NULL, 60, 100),
('64', '/dewAura/img/contents/male15.jpg', '1', '샤넬 알뤼르 옴므', 25, 60000, 45000, 30, 60, NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `members`
--

CREATE TABLE `members` (
  `id` char(15) NOT NULL,
  `pass` varchar(450) NOT NULL,
  `name` char(10) NOT NULL,
  `phone` char(20) NOT NULL,
  `birth` char(20) DEFAULT NULL,
  `email` char(80) DEFAULT NULL,
  `refferer` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 테이블의 덤프 데이터 `members`
--

INSERT INTO `members` (`id`, `pass`, `name`, `phone`, `birth`, `email`, `refferer`) VALUES
('korea', '$2y$10$y5HuSrp2LH9FcaUDLMxOgeHYgnuR/Qzhz2AFk8JXdZgAW936IQui.', 'korea', '01011112222', '', '@', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `pay`
--

CREATE TABLE `pay` (
  `order_id` char(14) NOT NULL,
  `orderer_name` char(10) NOT NULL,
  `orderer_email` char(80) NOT NULL,
  `orderer_phone` char(20) NOT NULL,
  `Recipient_name` char(10) NOT NULL,
  `zip_code` char(5) NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `Recipient_phone` char(20) NOT NULL,
  `message` varchar(20) DEFAULT NULL,
  `member_id` char(15) NOT NULL,
  `order_contents` varchar(500) NOT NULL,
  `review` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 테이블의 덤프 데이터 `pay`
--

INSERT INTO `pay` (`order_id`, `orderer_name`, `orderer_email`, `orderer_phone`, `Recipient_name`, `zip_code`, `address1`, `address2`, `Recipient_phone`, `message`, `member_id`, `order_contents`, `review`) VALUES
('20241222201103', '송광우', '1234125@naver.com', '010-1234-5678', '이주형', '', '', '아파트', '010-1244-1255', '잘 와주세요', 'korea', '[{\"content_code\":\"50\",\"content_amount\":\"1\",\"content_options\":\"none\"},{\"content_code\":\"35\",\"content_amount\":\"3\",\"content_options\":\"60ml\"}]', 'Y');

-- --------------------------------------------------------

--
-- 테이블 구조 `review`
--

CREATE TABLE `review` (
  `review_id` char(15) NOT NULL,
  `writer_id` char(15) NOT NULL,
  `content_code` char(14) NOT NULL,
  `review_contents` varchar(500) NOT NULL,
  `photo` varchar(500) DEFAULT NULL,
  `star` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- 테이블의 덤프 데이터 `review`
--

INSERT INTO `review` (`review_id`, `writer_id`, `content_code`, `review_contents`, `photo`, `star`) VALUES
('20241222_2c2908', 'korea', '11', '저한테는 안맞지만 향은 좋아요..', NULL, 3),
('20241222_5a5ebb', 'korea', '50', '저한테는 안 맞지만 향은 좋아요...', NULL, 3),
('20241222_8e45fb', 'korea', '50', '향이 너무 좋아요! 재구매 의사 있습니당', NULL, 5),
('20241222_93509e', 'korea', '50', '향이 넘 맘에 들어요 ㅎㅅㅎ', NULL, NULL),
('20241222_cf499e', 'korea', '11', '향이 너무 좋아요! 재구매 의사 있습니다', NULL, 5);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- 테이블의 인덱스 `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`content_code`);

--
-- 테이블의 인덱스 `defuser`
--
ALTER TABLE `defuser`
  ADD PRIMARY KEY (`content_code`);

--
-- 테이블의 인덱스 `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`order_id`);

--
-- 테이블의 인덱스 `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
