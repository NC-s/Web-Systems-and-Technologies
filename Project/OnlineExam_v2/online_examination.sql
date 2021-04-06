-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-12-16 19:34:20
-- 伺服器版本： 10.4.17-MariaDB
-- PHP 版本： 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `online_examination`
--

-- --------------------------------------------------------

--
-- 資料表結構 `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_login_id` varchar(150) NOT NULL,
  `admin_password` varchar(150) NOT NULL,
  `admin_verfication_code` varchar(100) NOT NULL,
  `admin_email_address` varchar(150) NOT NULL,
  `admin_type` enum('master','sub_master') NOT NULL,
  `admin_created_on` datetime NOT NULL,
  `email_verified` enum('no','yes') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_login_id`, `admin_password`, `admin_verfication_code`, `admin_email_address`, `admin_type`, `admin_created_on`, `email_verified`) VALUES
(1, 'testing', '$2y$10$gteBLTgs/Y7dBsmmnCnLqeBh1vN7vuBFCWsGo/mvPRdr3Hc00wMl2', 'e4c62523e38987be2e934389ac6e225a', 'testing@gamil.com', 'master', '2020-12-16 22:22:20', 'no'),
(2, 'Teacher1', '$2y$10$JgQrq0QaBql34bze0GGboeSwkOPaEAW2ZTxgudBf7rBqUzX.yFYG.', 'c1f43bd5c8c7745cf58b1fe19b4a096c', 'Teacher1@gmail.com', 'master', '2020-12-17 02:17:02', 'no'),
(3, 'Teacher2', '$2y$10$rYwuo4HaTrB4nio5gz/USOn0oOvoukecBMelVIp6y34W0MMrlWJIW', '9afe9d98ec637f14c272c402f3e78222', 'Teacher2@gmail.com', 'master', '2020-12-17 02:25:51', 'no');

-- --------------------------------------------------------

--
-- 資料表結構 `online_exam_table`
--

CREATE TABLE `online_exam_table` (
  `online_exam_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `online_exam_title` varchar(250) NOT NULL,
  `online_exam_datetime` datetime NOT NULL,
  `online_exam_duration` varchar(30) NOT NULL,
  `total_question` int(5) NOT NULL,
  `marks_per_right_answer` varchar(30) NOT NULL,
  `marks_per_wrong_answer` varchar(30) NOT NULL,
  `online_exam_created_on` datetime NOT NULL,
  `online_exam_status` enum('Pending','Created','Started','Completed') NOT NULL,
  `online_exam_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `online_exam_table`
--

INSERT INTO `online_exam_table` (`online_exam_id`, `admin_id`, `online_exam_title`, `online_exam_datetime`, `online_exam_duration`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`, `online_exam_created_on`, `online_exam_status`, `online_exam_code`) VALUES
(1, 1, 'testing', '2020-12-17 00:25:08', '1', 4, '1', '0', '2020-12-16 23:15:33', 'Completed', '75ddb6c7e633740cb7c60836bc7dbf86');

-- --------------------------------------------------------

--
-- 資料表結構 `option_table`
--

CREATE TABLE `option_table` (
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_number` int(2) NOT NULL,
  `option_title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `option_table`
--

INSERT INTO `option_table` (`option_id`, `question_id`, `option_number`, `option_title`) VALUES
(1, 1, 1, 'testing'),
(2, 1, 2, 'tseting'),
(3, 1, 3, 'ttesing'),
(4, 1, 4, 'teitsng'),
(5, 2, 1, 'True'),
(6, 2, 2, 'False'),
(7, 2, 3, 'Null'),
(8, 2, 4, 'Null'),
(9, 3, 1, 'testing'),
(10, 3, 2, 'Null'),
(11, 3, 3, 'Null'),
(12, 3, 4, 'Null'),
(13, 4, 1, 'testing'),
(14, 4, 2, 'Null'),
(15, 4, 3, 'Null'),
(16, 4, 4, 'Null');

-- --------------------------------------------------------

--
-- 資料表結構 `question_table`
--

CREATE TABLE `question_table` (
  `question_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `question_title` mediumtext NOT NULL,
  `answer_option` enum('1','2','3','4') NOT NULL,
  `question_type` enum('Multiple Choice','True/False','Short Answer','Fill in the blank') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `question_table`
--

INSERT INTO `question_table` (`question_id`, `online_exam_id`, `question_title`, `answer_option`, `question_type`) VALUES
(1, 1, 'MC: testing', '1', 'Multiple Choice'),
(2, 1, 'T/F: False', '2', 'True/False'),
(3, 1, 'Fill in the blank: testing', '1', 'Fill in the blank'),
(4, 1, 'Short Answer: testing', '1', 'Short Answer');

-- --------------------------------------------------------

--
-- 資料表結構 `user_exam_enroll_table`
--

CREATE TABLE `user_exam_enroll_table` (
  `user_exam_enroll_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `attendance_status` enum('Absent','Present') NOT NULL,
  `submit_exam_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `user_exam_enroll_table`
--

INSERT INTO `user_exam_enroll_table` (`user_exam_enroll_id`, `user_id`, `exam_id`, `attendance_status`, `submit_exam_datetime`) VALUES
(1, 2, 1, 'Present', '2020-12-16 23:25:59'),
(3, 6, 1, 'Present', '2020-12-17 00:26:00');

-- --------------------------------------------------------

--
-- 資料表結構 `user_exam_question_answer`
--

CREATE TABLE `user_exam_question_answer` (
  `user_exam_question_answer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_answer_option` enum('0','1','2','3','4') NOT NULL,
  `marks` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `user_exam_question_answer`
--

INSERT INTO `user_exam_question_answer` (`user_exam_question_answer_id`, `user_id`, `exam_id`, `question_id`, `user_answer_option`, `marks`) VALUES
(1, 2, 1, 1, '1', '+1'),
(2, 2, 1, 2, '2', '+1'),
(3, 2, 1, 3, '1', '+1'),
(4, 2, 1, 4, '1', '+1'),
(5, 6, 1, 1, '2', '-0'),
(6, 6, 1, 2, '3', '-0'),
(7, 6, 1, 3, '2', '-0'),
(8, 6, 1, 4, '1', '+1');

-- --------------------------------------------------------

--
-- 資料表結構 `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_role` enum('Student','Teacher') NOT NULL,
  `user_login_id` varchar(150) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_verfication_code` varchar(100) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_email_address` varchar(250) NOT NULL,
  `user_image` varchar(150) NOT NULL DEFAULT '5fd8d743f3710.png',
  `user_gender` enum('Male','Female') DEFAULT NULL,
  `user_birthday` date DEFAULT NULL,
  `user_course_no` varchar(30) NOT NULL,
  `user_address` mediumtext NOT NULL,
  `user_mobile_no` varchar(30) NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_email_verified` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_role`, `user_login_id`, `user_password`, `user_verfication_code`, `user_name`, `user_email_address`, `user_image`, `user_gender`, `user_birthday`, `user_course_no`, `user_address`, `user_mobile_no`, `user_created_on`, `user_email_verified`) VALUES
(1, 'Teacher', 'testing', '$2y$10$wj3lN26IoGp2R18qu8mkVeMHd.2sfxLQOnEV72bhsmogl.hOxnECS', 'e4c62523e38987be2e934389ac6e225a', 'testing', 'testing@gamil.com', '5fd8d64d305be.jpg', NULL, NULL, 'EIE4432', '', '', '2020-12-16 22:22:20', 'no'),
(2, 'Student', 'testing', '$2y$10$l4iCvz4t0d6gXObzye07iONSl9/WMPQi4OZQSbkYK4PaHtdpSlJW2', 'c7358d1697ccd99d7533915b25d39747', 'testing', 'testing1212@gmail.com', '5fd89fb9b0b87.jpg', 'Male', '1999-01-01', '', '', '', '2020-12-16 22:51:18', 'no'),
(6, 'Student', 'student1', '$2y$10$PSH/EDOtXGhpMLQh6G/ZaemhGeg8vMxtM5Q3XP2.USksC8VHl09F.', '06e99d5ad880a17a8945fce3366fc6b2', 'Summer', 'student@gmail.com', '5fda29426751b.jpg', 'Male', '2001-02-22', '', '', '', '2020-12-16 23:35:30', 'no'),
(8, 'Teacher', 'test', '$2y$10$V5Ru4jnZHkQTwRFABfJgc.g8F4dRwIhoTMzlI/BlmpR63wKDCey9e', 'c8cb0b427a8159196055c10f4d60286b', 'test', 'test@gmail.com', '5fd8d743f3710.png', NULL, NULL, 'EIE4432', '', '', '2020-12-17 00:35:52', 'no'),
(9, 'Student', 'TestStu1', '$2y$10$ZdSHbVPPr3y3nWGif/Uihe7qRoiB/Dm7OA4vWfGU6hf7W6ALy13kC', '80c8bceb25f0219755e9d212ffb583b1', 'TestStuOne', 'TestStu1@gmail.com', '5fda4d7dabad3.jpg', 'Male', '1995-01-01', '', '', '', '2020-12-17 02:10:05', 'no'),
(10, 'Student', 'TestStu2', '$2y$10$w/0XR5Wicz4mDf7w01aUveGq0y/Qwwl6alvptxXybHQBaBqNOxzdy', 'eb6f7c23a8ced6523aed634f7aa76a9e', 'TestStuTwo', 'TestStu2@gmail.com', '5fda4daf26404.jpg', 'Male', '1992-01-01', '', '', '', '2020-12-17 02:10:55', 'no'),
(11, 'Student', 'TestStu3', '$2y$10$rFL3SKsCOkoocEizvk3LtePhGIvyXzjg/fTkJGB2xqu.CLmDs/teG', 'e77240bbf6581817b4504162e4da9ad3', 'TestStuThree', 'TestStu3@gmail.com', '5fda4de53d186.jpg', 'Female', '1990-01-12', '', '', '', '2020-12-17 02:11:49', 'no'),
(12, 'Teacher', 'Teacher1', '$2y$10$CE3CyHa8suh3lbMINtb6oOF7PrgeS4XOn4R26wwZF6vp75.pm2uJm', 'c1f43bd5c8c7745cf58b1fe19b4a096c', 'TeacherOne', 'Teacher1@gmail.com', '5fda4f1e04210.png', NULL, NULL, 'EIE4432', '', '', '2020-12-17 02:17:02', 'no'),
(13, 'Teacher', 'Teacher2', '$2y$10$daW/59.pruweW.1AqpPmBehdVoIf4q8ysiWabhEw2hJB96k6F/m42', '9afe9d98ec637f14c272c402f3e78222', 'TeacherTwo', 'Teacher2@gmail.com', '5fda512f2f029.png', NULL, NULL, 'EIE4432', '', '', '2020-12-17 02:25:51', 'no'),
(14, 'Student', 'TestStu4', '$2y$10$UaojuNSKEavKm1S7egRa9OLL5VonoF1ugdkiVnc2SsNPIJP8zl.72', 'c61d199db139220f161a43c54f7ddd7a', 'TestStuFour', 'TestStu4@gmail.com', '5fda52e008215.jpg', 'Female', '1983-01-11', '', '', '', '2020-12-17 02:33:04', 'no');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- 資料表索引 `online_exam_table`
--
ALTER TABLE `online_exam_table`
  ADD PRIMARY KEY (`online_exam_id`);

--
-- 資料表索引 `option_table`
--
ALTER TABLE `option_table`
  ADD PRIMARY KEY (`option_id`);

--
-- 資料表索引 `question_table`
--
ALTER TABLE `question_table`
  ADD PRIMARY KEY (`question_id`);

--
-- 資料表索引 `user_exam_enroll_table`
--
ALTER TABLE `user_exam_enroll_table`
  ADD PRIMARY KEY (`user_exam_enroll_id`);

--
-- 資料表索引 `user_exam_question_answer`
--
ALTER TABLE `user_exam_question_answer`
  ADD PRIMARY KEY (`user_exam_question_answer_id`);

--
-- 資料表索引 `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `online_exam_table`
--
ALTER TABLE `online_exam_table`
  MODIFY `online_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `option_table`
--
ALTER TABLE `option_table`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `question_table`
--
ALTER TABLE `question_table`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_exam_enroll_table`
--
ALTER TABLE `user_exam_enroll_table`
  MODIFY `user_exam_enroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_exam_question_answer`
--
ALTER TABLE `user_exam_question_answer`
  MODIFY `user_exam_question_answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
