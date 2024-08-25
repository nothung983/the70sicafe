-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 02, 2024 lúc 12:12 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

create database the_70s_icafe;
use the_70s_icafe;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `the_70s_icafe`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(100) NOT NULL,
  `ad_name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id_admin`, `ad_name`, `password`) VALUES
(1, 'ADMIN_HUNG', 'b0a236abbaa2bb4218d22e9ea07b22ff'),
(3, 'adminnew', '9b25a78de118ea12ab1f12e0a6c67163');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `id_product` int(100) NOT NULL,
  `quantity` int(10) NOT NULL CHECK (`quantity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `id_product`, `quantity`) VALUES
(1, 3, 2, 1),
(8, 4, 1, 3),
(9, 4, 2, 4),
(24, 2, 2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `catergory`
--

CREATE TABLE `catergory` (
  `id_catergory` int(10) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `catergory`
--

INSERT INTO `catergory` (`id_catergory`, `category_name`) VALUES
(1, 'Tea'),
(2, 'Coffee'),
(3, 'Milk Tea'),
(4, 'Freeze');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id_message` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `message_details` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id_message`, `id_user`, `message_details`) VALUES
(2, 1, 'service is amazing');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id_order` int(100) NOT NULL,
  `id_user` int(100) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `payment_method`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(14, 2, 'Cash on delivery', 'Lotus Tea (30000 x 2) - ', 60000, '2024-04-29 17:00:00', 'pending'),
(15, 2, 'Credit card', 'Lotus Tea (30000 x 3) - ', 90000, '2024-04-29 17:00:00', 'completed'),
(16, 2, 'Cash on delivery', 'Black Coffee (29000 x 2) - Lotus Tea (30000 x 1) - ', 88000, '2024-04-30 08:53:48', 'completed'),
(17, 2, 'Cash on delivery', 'Black Coffee (29000 x 1) - Lotus Tea (30000 x 2) - Matcha Milk Tea (35000 x 2) - ', 159000, '2024-04-30 14:19:16', 'completed'),
(18, 2, 'Cash on delivery', 'Lotus Tea (30000 x 2) - ', 60000, '2024-05-01 14:18:45', 'pending');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id_product` int(100) NOT NULL,
  `id_catergory` int(10) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` int(10) NOT NULL,
  `product_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id_product`, `id_catergory`, `product_name`, `product_price`, `product_image`) VALUES
(1, 2, 'Black Coffee', 29000, 'coffee-den.png'),
(2, 1, 'LOTUS TEA', 30000, 'fruit-tea-2.png'),
(3, 4, 'MATCHA CREAM FREEZE', 35000, 'freeze.png'),
(7, 1, 'GRAPE TEA', 40000, 'TRA-NHO.png'),
(8, 1, 'TROPICAL FRUIT TEA', 35000, 'ALISAN-TRÁI-CÂY.png'),
(9, 3, 'AIYU MILK TEA', 42000, 'Chanh-Aiyu-trân-châu-trắng-2.png'),
(10, 3, 'FOAM MILK TEA', 37000, 'Okinawa-Milk-Foam-Smoothie.png'),
(11, 3, 'TRADITIONAL MILK TEA', 32000, 'Tra-sua-tran-chau-HK.png'),
(12, 1, 'PEACH TEA', 43000, 'TRA_THANH_DAO-09.jpg'),
(13, 2, 'PHIN COFFEE WITH CHOCO', 36000, 'PHINDI_CHOCO.jpg'),
(14, 2, 'WHITE COFFEE', 31000, 'BAC_XIU.jpg'),
(15, 4, 'STARWBERRY FREEZE', 47000, 'Freeze_Berry.jpg'),
(16, 1, 'LOTUS BEAN TEA', 27000, 'TSV.jpg'),
(17, 1, 'LYCHEE TEA', 32000, 'TRA_TACH_VAI.jpg'),
(18, 4, 'PASSION FRUIT FREEZE', 46000, 'Freeze_chanh_day.jpg'),
(19, 4, 'CHOCOLATE FREEZE', 46000, 'FREEZE_CHOCO.jpg'),
(20, 4, 'ORIO FREEZE', 37000, 'choco freeze.png'),
(21, 4, 'BURBERRY FREEZE', 50000, 'freeze-kem-may-dau-tam.webp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id_user` int(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_phone_number` varchar(10) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_address` varchar(500) NOT NULL,
  `user_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id_user`, `username`, `user_email`, `user_phone_number`, `user_password`, `user_address`, `user_image`) VALUES
(1, 'Hung123', 'hung@gmail.com', '0912345678', '5e36941b3d856737e81516acd45edc50', '12 Alley 7 Mau Than St.,Xuan Khanh, Ninh Kieu, Can Tho', ''),
(2, 'Dang Hoang Hung', 'hung12@gmail.com', '0901237676', 'e6fc2f75a041940873a68e27c68d2ef7', '12 Hem 7, Mau Than, Xuan Khanh, Ninh Kieu, Can Tho', 'Dang Hoang Hung.jpg'),
(3, 'Doan Anh Minh', 'minh@gmail.com', '0907293935', '5e36941b3d856737e81516acd45edc50', '', ''),
(4, 'Dang Hoang Test', 'test@gmail.com', '098765432', 'accc9105df5383111407fd5b41255e23', '12 Hem 7, Mau Than, Xuan Khanh, Ninh Kieu, Can Tho', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `fk_id_product` (`id_product`),
  ADD KEY `fk_id_user` (`id_user`);

--
-- Chỉ mục cho bảng `catergory`
--
ALTER TABLE `catergory`
  ADD PRIMARY KEY (`id_catergory`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `fk_mess_user` (`id_user`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `fk_ord_user` (`id_user`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `fk_id_catergory` (`id_catergory`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `catergory`
--
ALTER TABLE `catergory`
  MODIFY `id_catergory` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_id_product` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`),
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_mess_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_ord_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_id_catergory` FOREIGN KEY (`id_catergory`) REFERENCES `catergory` (`id_catergory`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
