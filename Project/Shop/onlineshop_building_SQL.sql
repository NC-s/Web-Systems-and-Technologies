-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2019 at 04:41 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ID` int(11) NOT NULL,
  `QTY` int(11) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`ID`, `QTY`, `Item_ID`, `User`) VALUES
(7, 1, 2, '562'),
(12, 1, 3, '562'),
(57, 3, 3, 'Xavier'),
(61, 1, 4, 'Xavier'),
(97, 1, 21, 'standwithhk'),
(98, 1, 3, 'standwithhk'),
(108, 1, 1, 'Xavier'),
(109, 1, 9, 'Xavier'),
(111, 1, 3, 'EIE4432'),
(112, 1, 4, 'EIE4432');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `ID` int(11) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `User` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`ID`, `Item_ID`, `User`) VALUES
(4, 1, '562'),
(23, 3, 'Xavier'),
(26, 8, 'standwithhk'),
(32, 2, 'wongtsunhin'),
(34, 20, 'standwithhk');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `Image_Path` varchar(50) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Price` double NOT NULL,
  `Category` varchar(30) NOT NULL,
  `Shop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Name`, `Description`, `Image_Path`, `Stock`, `Price`, `Category`, `Shop`) VALUES
(1, 'Asahi Super dry 350ml', 'Japan No.1 beer', '1.jpg', 10, 9, 'Beverage', 1),
(2, 'Nissin Donbei Kitsune Udon', 'This kitsune udon comes with a tasty piece of fried tofu.', '2.jpg', 0, 9.9, 'Food', 1),
(3, 'BLAHAJ the Shark', 'Big and safe to have at your side if you want to discover the world underneath the sea. The blue shark can swim very far, dive really deep and hear your heart beating from far away.\r\n\r\nAll soft toys are good at hugging, comforting and listening and are fond of play and mischief. In addition, they are reliable and tested for safety.\r\n\r\nRecommended for children 18 months and older.', '3.png', 10, 60, 'Toys', 2),
(4, 'RG 1/144 MS-06S シャア専用ザク', '■ The second brand of the 30th anniversary commemoration new brand. Zaku dedicated to Chia with a real system appeared.\r\n■ Design designed on 1/1 assumption.\r\n■ Equipped with \"Advanced MS joint\" to change the assembly process of conventional internal structure.\r\n■ \"paint on metal\" which can not be easily reproduced in paint is reproduced on the seal \"realistic decal\" attached.\r\n■ 1/144 scale reproduction of unlike color classification reproduction.\r\n■ Designed an advanced MS joint to reproduce the astounding movement of ZAKU only for Char. Secure the largest movable area in the history of Gunpla.', '4.jpg', 9, 198, 'Toys', 3),
(5, 'RG 1/144 RX-78-2ガンダム', '■ REAL GRADE (RG) Developed from July 2010.\r\nIn pursuit of \"real\", high detail to convey precision, dynamic action & gimmick which does not sink to master grade, stress free assembly which adopted assembled inner frame, etc Various to satisfy all fans The gimmick condenses. A new brand that carries the latest technology and tells the new enjoyment of Gundam for all generations who know Gundam.\r\n■ RX-78-2 All \"setting\" of Gundam is aggregated in about 125mm in total height.\r\n■ Installed with an inner frame \"Advanced MS joint\" that can be dynamically moved by assembling with a small number of parts.\r\n■ Realistic texture, special material made pursuing the perfection of appearance \"Realistic Decal\" included.\r\n2', '5.jpg', 99, 198, 'Toys', 3),
(6, 'セイバー／ネロ・クラウディウス[ブライド]', '作品名: Fate/Grand Order\r\nサイズ: 全高約 245mm\r\n商品形態: PVC塗装済完成品\r\n原型: French Doll (Cerberus Project TM)\r\n彩色: 強龍 (Cerberus Project TM)\r\n付属品: ABS製専用台座、剣\r\n\r\nスマートフォン専用人気RPG「Fate/Grand Order」より、セイバー／ネロ・クラウディウス[ブライド]を再臨2段階目のイラストを元に立体化。\r\n再臨した拘束の花嫁衣裳に身を包み、愛らしい表情と気品を感じさせる佇まいが美しいフィギュアとなりました。透明素材で表現したベールやコスチュームの細やかなディテールなども必見です。\r\nネロ愛用の剣・原初の火（アエストゥス・エストゥス）を携えているポーズと、右手を腰に当てているポーズの2種のポーズでディスプレイ可能。', '6.jpg', 10, 1040, 'Others', 3),
(7, 'Nissin Donbei Kamatama Style Udon', 'Rich kamatama udon at home with ease.', '7.jpg', 12, 16, 'Food', 6),
(8, 'RG 1/144 ν ガンダム', 'Amuro lay boarding aircraft to RG appeared in \"chariot of Mobile Suit Gundam Counterattack\" lineup in RG!\r\n\r\n■ Various gimmicks to reproduce the setting mechanism and the poses in the play, and further, the original gimmicks based on real machine test results are condensed to 1/144 scale.\r\n■ It is compatible with the fun of making the image of 1/1 scale and the fun of decorating by precise parts composition.\r\n■ ν Gundam\'s distinctive coloring is reproduced in molded color. The white body uses three light gray molded colors to increase information density.\r\n■ The shoulder and abdomen have a built-in joint and can move flexibly. It enables twisting and shoulder extrusion, resulting in more dynamic posing.\r\n■ The shoulder armor incorporates a mechanism that expands in tandem with the internal joint. By expanding the range of motion of the shoulder, reduce the interference between parts that occur in posing etc. holding an arm.\r\n■ The waist joint moves finely for each block, and the movabl', '8.jpg', 7, 332, 'Toys', 3),
(9, 'RG 1/144 サザビー', '\"RG Sazabi\" with 1/144 scale biggest gimmick appeared!\r\nArm of arms such as cylinders and funnels are faithfully reproduced, and deployment mechanisms are set up in the promotion divisions such as verniers and backpacks as a result of real machine verification!\r\n■ Arm which symbolizes abundant hand parts, Sotheby and comes with various hand parts and high range of motion, you can reproduce the posing in the play such as two handed poses!\r\n\r\n[INCLUDED ACCESSORIES]\r\n■ Beam shot rifle × 1\r\nBeam · Tomahawk × 1\r\n■ Beam · saber × 2\r\n■ Shield × 1\r\nFunnel x 6\r\n■ Missile × 1\r\n\r\n[CONTENTS]\r\nMolded article × 17\r\n■ Realistic decal × 1', '9.jpg', 10, 356, 'Toys', 3),
(10, 'RG 1/144 ユニコーンガンダム2号機 バンシィ・ノルン', '■ Black lion \"RG Unicorn Gundam Unit 2 Banshi Norn\" finally loaded with a transformation gimmick at 1/144!\r\n■ Dark blue coloring is reproduced in three color molding colors, and characteristic head antennas are selectable and movable one type and two fixed types attached!\r\n■ Armed Armor XC has become a new model, partly cleared parts are adopted in the psycho frame exposed in the destroy mode, Armed Armor DE is also reproduced with new addition parts!\r\n■ Beam · Magnum can be fitted with beam Jutte with parts replacement, magazine can be attached to the rear armor!\r\n■ In addition to regular packages, the first time limited package [premium \"unicorn mode\" box] also appeared!\r\n\r\n[INCLUDED ACCESSORIES]\r\n■ Beam · Magnum × 1\r\n■ Revolving / launcher × 1\r\n■ Armed Armor DE × 1\r\n■ Armed Armor XC × 1\r\n■ Beam · Saber x 2\r\n\r\n[CONTENTS]\r\n■ Molded article × 20\r\n■ Realistic decal × 1', '10.jpg', 10, 316, 'Toys', 3),
(11, 'RG 1/144 ユニコーンガンダム', 'As GUNPLA EVOLUTION PROJECT 2nd, \"RG Unicorn Gundam\" which reproduced the form and transformation gimmick which pursued reality appeared finally!\r\n■ \"EVOLUTION POINT\" is \"TRANSFORMATION (transformation)\", realizing transformation beyond the limit within the constraint of 1/144 scale!\r\n■ New mechanism with three gimmicks \"Advance MS Framework\" has both high stability after assembly and mobility of each part!\r\n■ In addition to regular packages, the first time limited package [premium \"unicorn mode\" box] also appeared!\r\n\r\n[INCLUDED ACCESSORIES]\r\n■ Beam · Magnum × 1\r\n■ Beam · saber × 2\r\n■ Shield × 1\r\n■ Hyper · Bazooka × 1\r\n\r\n[CONTENTS]\r\n■ Sprue x 10\r\n■ Realistic decal × 1', '11.jpg', 10, 300, 'Toys', 3),
(12, 'RG 1/144 ガンダムアストレイ ゴールドフレーム天ミナ', '■ From \"Mobile Suit Gundam SEED\" Gaiden \"Gundam SEED Astray\", the guardian of \"Declaration of the Sky\" \"Gold Frame Tenma Mina\" descends to RG!\r\n\r\n■ The back “Magano Ikuchi” is equipped with a new gimmick with its own expansion / extension mechanism!\r\n\r\n■ Realistic reproduction of the difference in texture of the exterior part of the actual machine by using different molding colors and materials!', '12.jpg', 10, 237, 'Toys', 3),
(13, 'コードギアス 復活のルルーシュ C.C.', '2017～2018年公開の劇場版3部作で\r\n改めてその人気とクオリティーが評価された「コードギアス」が、\r\n2019年2月、新たなストーリーで劇場版としてまさに【復活】！\r\nその「コードギアス　復活のルルーシュ」より、\r\n不変の人気【C.C.】を劇場版の衣装でフィギュア化！！\r\n劇場告知1stのビジュアルをそのまま届けます。\r\n\r\n※商品と写真は異なる場合があります。予めご了承ください。\r\n\r\n©SUNRISE／PROJECT L-GEASS　Character Design\r\n(c)2006-2018 CLAMP・ST', '13.jpg', 50, 1100, 'Toys', 3),
(14, 'Mr.Design Knife', '-Mast items for cutting work appear at affordable prices.\r\n-A large blade is useful for cutting off gate marks and cutting patties.\r\n-Of course it is also useful for cutting tapes and stickers.\r\n-5 spare blades.\r\n\r\nItem Size/Weight : 19.3 x 5.4 x 1.8 cm / 35g', '14.jpg', 1000, 37, 'Stationary', 5),
(15, 'E.F.S.F. SOLDIER DESIGN WORK SHIRT / L', 'This is a wearable shirt, sweater, or other top.\r\n\r\nThis comfortable short-sleeved work shirt displays the Federation mark on the left chest, and is made from 100 percent cotton for maximum comfort and durability. Length (shoulder to hem): 72cm. Width (measured flat, under the arms, one side only): 59cm. \r\n\r\nPlease note that Japanese shirt sizes tend to run a half size to a full size smaller than their western counterparts. Please keep this in mind and check the measurements above before placing your order.\r\n\r\n[Garment Length]: 72cm\r\n[Garment Width]: 59cm', '15.jpg', 10, 640, 'Clothing', 3),
(16, 'Suntory The Premium Malts 350ml', 'The Premium Malt\'s features a delicate floral aroma and a rich, quality taste. The Premium Malt\'s is made from carefully selected pure ingredients using original brewing methods, in pursuit of the perfect premium beer. ', '16.jpg', 62, 10, 'Beverage', 1),
(17, 'Suntory Rich Malt 350ml', 'The Suntory Rich Malt is a happoshu , a sparkling low-malt beer, containing less than 67% malt. One of the most popular, drinkable canned beverages in Japan.', '17.jpg', 33, 13, 'Beverage', 1),
(18, 'SNUTTIG', 'Soft toy, polar bear, white\r\n\r\nAll soft toys are good at hugging, comforting and listening and are fond of play and mischief. In addition, they are reliable and tested for safety.\r\n\r\nRecommended for children 12 months and older.', '18.jpg', 70, 70, 'Toys', 2),
(19, 'Nissin Donbei Kitsune Udon', 'This kitsune udon comes with a tasty piece of fried tofu.', '19.jpg', 26, 9, 'Food', 6),
(20, 'LIVLIG', 'Behind these alert, bright blue eyes there is a cozy friend who loves adventure – and people. Always friendly and has thick warming fur that’s nice to cuddle with.\r\n\r\nAll soft toys are good at hugging, comforting and listening and are fond of play and mischief. In addition, they are reliable and tested for safety.\r\n\r\nRecommended for children 12 months and older.', '20.jpg', 47, 60, 'Toys', 2),
(21, 'Nissin Donbei Kakiage Tempura Udon', 'Nissin Food Donbei Kakiage Tempura Udon instant noodles. \r\n\r\nA simple and easy way to eat Udon noodles with real Japanese broth and kakiage tempura.', '21.jpg', 8, 16.8, 'Food', 6);

-- --------------------------------------------------------

--
-- Table structure for table `productinorder`
--

CREATE TABLE `productinorder` (
  `Order_No` int(11) NOT NULL,
  `QTY` int(11) NOT NULL,
  `Order_Date` date NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `Buyer` varchar(20) NOT NULL,
  `Finished` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productinorder`
--

INSERT INTO `productinorder` (`Order_No`, `QTY`, `Order_Date`, `Item_ID`, `Buyer`, `Finished`) VALUES
(1, 1, '2019-11-30', 1, 'Xavier', 0),
(2, 1, '2019-11-30', 3, 'Xavier', 0),
(3, 1, '2019-12-03', 3, '562', 1),
(4, 1, '2019-12-04', 3, 'Xavier', 0),
(5, 1, '2019-12-04', 4, 'Xavier', 1),
(6, 1, '2019-12-04', 1, 'Xavier', 0),
(7, 1, '2019-12-05', 18, 'Xavier', 0),
(8, 1, '2019-12-05', 21, 'Xavier', 0),
(9, 25, '2019-12-05', 8, 'standwithhk', 0),
(10, 3, '2019-12-05', 1, 'standwithhk', 0),
(11, 2, '2019-12-05', 2, 'standwithhk', 0),
(12, 562, '2019-12-05', 3, 'standwithhk', 0),
(13, 9, '2019-12-05', 4, 'standwithhk', 1),
(14, 1, '2019-12-05', 5, 'standwithhk', 0),
(15, 1, '2019-12-05', 12, 'standwithhk', 0),
(16, 78, '2019-12-05', 11, 'standwithhk', 0),
(17, 27, '2019-12-05', 10, 'standwithhk', 0),
(18, 2, '2019-12-05', 9, 'standwithhk', 0),
(19, 2147483647, '2019-12-05', 13, 'standwithhk', 0),
(20, 2342, '2019-12-05', 14, 'standwithhk', 0),
(21, 3243254, '2019-12-05', 15, 'standwithhk', 0),
(22, 2343, '2019-12-05', 16, 'standwithhk', 0),
(23, 2147483647, '2019-12-05', 17, 'standwithhk', 0),
(24, 1, '2019-12-05', 13, 'standwithhk', 0),
(25, 3, '2019-12-05', 20, 'wongtsunhin', 0),
(26, 3, '2019-12-05', 2, 'wongtsunhin', 0),
(27, 1, '2019-12-05', 9, 'wongtsunhin', 0),
(28, 1, '2019-12-06', 7, 'cupnoodle', 0);

-- --------------------------------------------------------

--
-- Table structure for table `remembermetoken`
--

CREATE TABLE `remembermetoken` (
  `LogID` int(11) NOT NULL,
  `Token` varchar(300) NOT NULL,
  `UserID` varchar(20) NOT NULL,
  `LoginTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `remembermetoken`
--

INSERT INTO `remembermetoken` (`LogID`, `Token`, `UserID`, `LoginTime`) VALUES
(0, '$2y$10$/.2BeYqJcZZd6WN6vHRKde6fgPObmNs1Vp6FwJ2JUiK/FPx82hD1e', 'wongtsunhin', '2019-12-05 22:51:18'),
(0, '$2y$10$//jEp3lo0OWn9DwnzvSCluNagcVD8ZbMzz7kbbxEf1w7enbf5/1E6', 'Xavier', '2019-12-06 20:15:33'),
(0, '$2y$10$5Dyt3CF2SLse10sMJpq/i.cazVhEJuHRduKzMyxa8oE6aguHx8y.C', 'EIE4432', '2019-12-06 23:26:13'),
(0, '$2y$10$aRoRxprjYtAQORA2bj0n8u0YxceO0Invc3tmO4ly7O3KsT2kDk2/K', 'Xavier', '2019-12-06 23:36:41'),
(0, '$2y$10$B/.b8u7Q772CjTaijpfMfeBwoWjXq.jfkKBd6j9cSCj2RYZMq8dwG', 'cupnoodle', '2019-12-06 00:45:03'),
(0, '$2y$10$CTxKC.O4l0VsV/GFqCzF8ugWQSyeO/x9Fgdp5ZBh0fNFeip4ulgEa', '562', '2019-12-06 00:46:12'),
(0, '$2y$10$gbdw0xwQlNHLRBgpWZaBEe.DjJSf/fjLGhkU/GZcGx75tWozDlsWi', 'Xavier', '2019-12-06 20:51:28'),
(0, '$2y$10$jFq..w2zqa2RgrAyOD2ukeLV6Ud4fnS8ymMta1LUVsbWi3w6ZMeIq', '562', '2019-12-05 22:48:44'),
(0, '$2y$10$Lr.4ns3U.dTYyYy7kXK79eufPmwU2ofaGN0vGlsOLeCmzEZm4y.HW', 'Xavier', '2019-12-06 23:15:25'),
(0, '$2y$10$mv7ndHrAZ22gP4yV.pUZouHKDXbPFoOSyTnnexTINDL/2c3bfjfFm', 'cupnoodle', '2019-12-06 00:45:24'),
(0, '$2y$10$QsjDkMuAQ1ncR/HVG5c/VeCvaeq0zxPPtKxR1zbIDGzUwbpQfHbpe', 'trying', '2019-12-06 14:56:43'),
(0, '$2y$10$u2aTf.6ZEKiGmuaP0kWr0uBJ3xDvE0ch1sT.1lindxrI87uqM72TO', 'EIE4432', '2019-12-06 23:27:42'),
(0, '$2y$10$wd425UGBawYAbKwQZw2hCOp6XM6kZ7rxvUIIwJba.iKWYd7WUWQv.', 'trying', '2019-12-06 21:45:19'),
(0, '$2y$10$XeUwLkpDbhtqMZ3.e3aaze9uSVJqlBck446L1QzIMjLvtwTtbUWVq', 'Xavier', '2019-12-06 19:54:03'),
(0, '$2y$10$xub.t6KVzvwQkCBLXF2VV.hqx60u7yobjey1EvwxcgiIfYkGHbMUy', 'Xavier', '2019-12-06 20:09:25'),
(0, '$2y$10$Y5pvGbvpRL98OdLhNL4FNe2h8.zv9IOCXZvpbomqzzVBOrS22x60e', 'Xavier', '2019-12-06 19:54:58'),
(2, '$2y$10$1B5o9faXVnoi4kqPGyrZdeRtm3EPDHjrVYJBuM2fSnvpPVg9rAWZ2', 'Xavier', '2019-12-05 14:38:26'),
(3, '$2y$10$4z7Vi1YSe4Gma9vj7M/qKuuA1qlQPzydALRwb62gPZZbn2Wm3LiEu', 'Xavier', '2019-12-05 14:48:12'),
(4, '$2y$10$i.CA37sDU0m9/Xw3DLbmM.7g7AdAZQQ1eVj7xeNuzrS1GyyLar1vu', 'Xavier', '2019-12-05 15:07:29'),
(11, '$2y$10$GiEgVtE76HrD4yDGHSsyvONH/TzB/VVueMclV/YgFQQ4jtWym5Hru', 'Xavier', '2019-12-05 15:40:42'),
(12, '$2y$10$nXev.EIJ19/kmJX/Hckyy.zTeHhImb0M48vt3H39n2KkZirULXzx2', '562', '2019-12-05 15:47:50'),
(15, '$2y$10$GPyEXnYeOcjyvQvSi4W5f.nfwh.1vdu7m1oYtCUZWUPSu5.LRqCC6', 'Xavier', '2019-12-05 16:06:45'),
(16, '$2y$10$2WXroy5PwjAAUEDgyFAcwuLJkB4E.hd2fq0gten4pfW9leKqJshq.', 'Xavier', '2019-12-05 16:15:24'),
(17, '$2y$10$QpU8GFzys8Rr22xdYzpC6uNuSzrOJO/kUz.nExjuIGb2/Jtykx8TW', 'Xavier', '2019-12-05 16:15:29'),
(24, '$2y$10$YmRvavr7hT5n48DTC4w9RuWE0CG13D3z7EiGh80TY8kkp3Vf9avjG', 'trying', '2019-12-05 18:41:24'),
(25, '$2y$10$WVGm7NfGydRWxTSAWo8xAeNoLLzhJc0Tt3kPThV.rU9rIAmfcEnpy', 'Xavier', '2019-12-05 18:41:49'),
(26, '$2y$10$BiD576ZuQSJhFvjukaFgNugH0ExI4QrvH0wA8g/Usuy20QdOupFBm', 'trying', '2019-12-05 18:42:29'),
(27, '$2y$10$cpePvRImvvVEkNnIsukHNeyJ1ZbhFvmeHl3OqdjvzLlZecxGYDQzS', '562', '2019-12-05 19:49:19'),
(28, '$2y$10$B7nnU8EenlHdo/lg2mZP5eszLQYnLe4XLSpxvg6kWTV7tIdTGNoUO', '562', '2019-12-05 19:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `Shop_ID` int(11) NOT NULL,
  `Title` varchar(30) NOT NULL,
  `Info` varchar(50) DEFAULT NULL,
  `Owner_ID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`Shop_ID`, `Title`, `Info`, `Owner_ID`) VALUES
(1, 'No Beer No Life', 'Selling Beverages', '562'),
(2, 'IKEA mascots', 'Selling IKEA mascots', 'Xavier'),
(3, 'Hobby Shop', 'Selling plastic models, PVC figures and Nendoroid', 'Xavier'),
(4, 'Colopl', 'Shironeko Project Goods', '562'),
(5, 'Book Store - Exercise', 'Selling Supplementary Exercise', 'trying'),
(6, 'Donbei', 'Nissin Donbei Noodles', '562'),
(7, 'Food Store', 'selling food', 'Xavier');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` varchar(20) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Password`, `Email`, `Address`) VALUES
('562', '$2y$10$LaN1IM1vh76IuDAy.YOi8OIAeRHLI665gZQXoFkCkrQcBwUS3iBVS', '562@562.com', 'Blue Brick University'),
('cupnoodle', '$2y$10$mDhNf0Bd1wJOiUw5TFMdXOn7QABu6HRylT3KAf/bjs1olhxVEg6aW', 'email@email.com', 'address'),
('EIE4432', '$2y$10$QVFkuoY4hBsw1k1PHcgSn.RM5ui9vMA4Ml1TzUQJpprFIe0MQGpzS', 'email@email.com', 'Hong Kong Polytechnic University'),
('firefox', '$2y$10$sI7S2alwr6ot1Fi6HuDOKeMPgigrVqoMLLmkHICQuHs9Sf.ZJX4mm', 'email@gmail.com', 'idk'),
('standwithhk', '$2y$10$0KEoUZFlG0Nmgo2AX2Wch.xWkGoaLoDhBbUAcOazrWVZ7G3YBVV6i', '30624700', 'test'),
('test', '$2y$10$gaACQbo0sWpFWtRmbu8p2..Ah3cNefgSt5FmbX11IeDsWMMHJ.T1C', '1231231313213144442@polyu.edu.hk', '1322421'),
('trying', '$2y$10$LaN1IM1vh76IuDAy.YOi8OIAeRHLI665gZQXoFkCkrQcBwUS3iBVS', 'try@email.com', 'trying'),
('wongtsunhin', '$2y$10$fQ2cgItSlGfxIXtsFXy6texNKEwOOW5CSdYI8PFF19kHneZqP6RHi', '123@gmail.com', 'dasdsada'),
('Xavier', '$2y$10$e6QbdgE7aa4HUgaFPvFDCe5Y9DeaMGpv9Xr1M2b7KJCaxUCNLQ1y6', 'xavier@gmail.com', 'Hong Kong');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Item_ID` (`Item_ID`),
  ADD KEY `User` (`User`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Item_ID` (`Item_ID`),
  ADD KEY `User` (`User`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Shop` (`Shop`);

--
-- Indexes for table `productinorder`
--
ALTER TABLE `productinorder`
  ADD PRIMARY KEY (`Order_No`),
  ADD KEY `Item_ID` (`Item_ID`),
  ADD KEY `Buyer` (`Buyer`);

--
-- Indexes for table `remembermetoken`
--
ALTER TABLE `remembermetoken`
  ADD UNIQUE KEY `RememberMeKey` (`LogID`,`Token`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`Shop_ID`),
  ADD KEY `Owner_ID` (`Owner_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `productinorder`
--
ALTER TABLE `productinorder`
  MODIFY `Order_No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `Shop_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`Item_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`User`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`Item_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`User`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Shop`) REFERENCES `shops` (`Shop_ID`);

--
-- Constraints for table `productinorder`
--
ALTER TABLE `productinorder`
  ADD CONSTRAINT `productinorder_ibfk_1` FOREIGN KEY (`Item_ID`) REFERENCES `product` (`Product_ID`),
  ADD CONSTRAINT `productinorder_ibfk_2` FOREIGN KEY (`Buyer`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `remembermetoken`
--
ALTER TABLE `remembermetoken`
  ADD CONSTRAINT `remembermetoken_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`User_ID`);

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`Owner_ID`) REFERENCES `users` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
