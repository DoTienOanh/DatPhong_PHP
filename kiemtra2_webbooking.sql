-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 14, 2024 lúc 04:40 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `kiemtra2_webbooking`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_confirmation`
--

CREATE TABLE `booking_confirmation` (
  `confirmation_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `qr_code` varchar(100) DEFAULT NULL,
  `confirmation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_confirmation`
--

INSERT INTO `booking_confirmation` (`confirmation_id`, `booking_id`, `qr_code`, `confirmation_date`) VALUES
(1, 1, 'QR_ORD_1001', '2024-10-01'),
(2, 4, 'QR_ORD_1004', '2024-10-05'),
(3, 5, 'QR_ORD_1005', '2024-10-06'),
(4, 7, 'QR_ORD_1007', '2024-10-08'),
(5, 10, 'QR_ORD_1010', '2024-10-11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `booking_status` enum('Pending','Confirmed','Cancelled') DEFAULT NULL,
  `order_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `booking_status`, `order_id`) VALUES
(1, 1, 1, '2024-11-11', '2024-11-20', 'Confirmed', 'ORD_1001'),
(2, 2, 2, '2024-10-03', '2024-10-06', 'Cancelled', 'ORD_1002'),
(3, 3, 3, '2024-10-04', '2024-10-08', 'Cancelled', 'ORD_1003'),
(4, 4, 4, '2024-10-05', '2024-10-10', 'Cancelled', 'ORD_1004'),
(5, 5, 5, '2024-10-06', '2024-10-09', 'Cancelled', 'ORD_1005'),
(6, 6, 6, '2024-10-07', '2024-10-11', 'Pending', 'ORD_1006'),
(7, 7, 7, '2024-10-08', '2024-10-12', 'Confirmed', 'ORD_1007'),
(8, 8, 8, '2024-10-09', '2024-10-14', 'Cancelled', 'ORD_1008'),
(9, 9, 9, '2024-10-10', '2024-10-15', 'Confirmed', 'ORD_1009'),
(10, 10, 10, '2024-10-11', '2024-10-16', 'Confirmed', 'ORD_1010');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_details`
--

CREATE TABLE `customer_details` (
  `user_id` int(11) NOT NULL,
  `ho_ten` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `so_dien_thoai` varchar(15) DEFAULT NULL,
  `dia_chi` varchar(100) DEFAULT NULL,
  `gioi_tinh` enum('Nam','Nu') DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_details`
--

INSERT INTO `customer_details` (`user_id`, `ho_ten`, `email`, `so_dien_thoai`, `dia_chi`, `gioi_tinh`, `ngay_sinh`) VALUES
(1, 'Nguyen Van A', 'vana@example.com', '0901234567', '123 Le Loi, HCM', 'Nam', '1985-05-10'),
(2, 'Le Thi B', 'leb@example.com', '0912345678', '456 Tran Hung Dao, HCM', 'Nu', '1990-07-15'),
(3, 'Tran Van C', 'tvc@example.com', '0923456789', '789 Nguyen Trai, HCM', 'Nam', '1978-09-20'),
(4, 'Pham Thi D', 'ptd@example.com', '0934567890', '321 Le Thanh Ton, HCM', 'Nu', '1982-11-05'),
(5, 'Nguyen Thi E', 'nte@example.com', '0945678901', '654 Pasteur, HCM', 'Nu', '1995-03-18'),
(6, 'Hoang Van F', 'hvf@example.com', '0956789012', '987 Hai Ba Trung, HCM', 'Nam', '1988-12-22'),
(7, 'Vu Thi G', 'vtg@example.com', '0967890123', '111 Pham Ngu Lao, HCM', 'Nu', '1980-08-30'),
(8, 'Le Van H', 'lvh@example.com', '0978901234', '222 Cong Quynh, HCM', 'Nam', '1975-06-25'),
(9, 'Tran Thi I', 'tti@example.com', '0989012345', '333 Vo Van Kiet, HCM', 'Nu', '1992-04-10'),
(10, 'Phan Van J', 'pvj@example.com', '0990123456', '444 Ly Tu Trong, HCM', 'Nam', '1985-01-15'),
(11, '', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `facilities`
--

CREATE TABLE `facilities` (
  `facility_id` int(11) NOT NULL,
  `facility_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `facilities`
--

INSERT INTO `facilities` (`facility_id`, `facility_name`) VALUES
(1, 'Wifi'),
(2, 'Tivi'),
(3, 'Điều hòa'),
(4, 'Máy sưởi'),
(5, 'Bồn tắm'),
(6, 'Ban công'),
(7, 'Quầy minibar'),
(8, 'Tủ lạnh'),
(9, 'Máy sấy tóc'),
(10, 'Bàn làm việc');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_details`
--

CREATE TABLE `payment_details` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_status` enum('Pending','Completed','Failed') DEFAULT NULL,
  `payment_method` enum('PayPal','Stripe','CreditCard') DEFAULT NULL,
  `trans_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_details`
--

INSERT INTO `payment_details` (`payment_id`, `booking_id`, `amount`, `payment_date`, `payment_status`, `payment_method`, `trans_id`) VALUES
(1, 1, 2500000.00, '2024-10-05', 'Completed', 'PayPal', 'TXN_5001'),
(2, 2, 2250000.00, '2024-10-06', 'Pending', 'CreditCard', 'TXN_5002'),
(3, 4, 4500000.00, '2024-10-10', 'Completed', 'Stripe', 'TXN_5003'),
(4, 5, 1800000.00, '2024-10-09', 'Completed', 'PayPal', 'TXN_5004'),
(5, 7, 8000000.00, '2024-10-12', 'Completed', 'Stripe', 'TXN_5005'),
(6, 10, 3000000.00, '2024-10-16', 'Completed', 'CreditCard', 'TXN_5006');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `room_type` varchar(20) DEFAULT NULL,
  `max_adults` int(11) DEFAULT NULL,
  `max_children` int(11) DEFAULT NULL,
  `status` enum('Available','Occupied','Maintenance') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `price`, `room_type`, `max_adults`, `max_children`, `status`, `description`, `image_url`, `availability`) VALUES
(1, 'Phòng Tiêu Chuẩn', 500000.00, 'Standard', 2, 1, 'Available', 'Phòng tiêu chuẩn với đầy đủ tiện nghi', 'image1.jpg', 1),
(2, 'Phòng Deluxe', 750000.00, 'Deluxe', 2, 2, 'Available', 'Phòng rộng rãi với ban công', 'image2.jpg', 1),
(3, 'Phòng Gia Đình', 1000000.00, 'Family', 4, 2, 'Occupied', 'Phòng phù hợp cho gia đình', 'image3.jpg', 0),
(4, 'Phòng Suite', 1500000.00, 'Suite', 2, 2, 'Maintenance', 'Phòng cao cấp với view đẹp', 'image4.jpg', 0),
(5, 'Phòng Đôi', 600000.00, 'Double', 2, 1, 'Available', 'Phòng đôi tiện nghi', 'image5.jpg', 1),
(6, 'Phòng Đơn', 400000.00, 'Single', 1, 0, 'Available', 'Phòng đơn nhỏ gọn', 'image6.jpg', 1),
(7, 'Phòng Executive', 2000000.00, 'Executive', 2, 1, 'Occupied', 'Phòng sang trọng', 'image7.jpg', 0),
(8, 'Phòng Family Deluxe', 1200000.00, 'Family Deluxe', 4, 3, 'Available', 'Phòng gia đình cao cấp', 'image8.jpg', 1),
(9, 'Phòng VIP', 2500000.00, 'VIP', 2, 2, 'Available', 'Phòng VIP với view toàn cảnh', 'image9.jpg', 1),
(10, 'Phòng Tiết Kiệm', 300000.00, 'Budget', 1, 0, 'Available', 'Phòng tiết kiệm cho khách du lịch', 'image10.jpg', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_facilities`
--

CREATE TABLE `room_facilities` (
  `room_id` int(11) DEFAULT NULL,
  `facility_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `room_facilities`
--

INSERT INTO `room_facilities` (`room_id`, `facility_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(2, 6),
(3, 1),
(3, 2),
(3, 5),
(3, 8),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 6),
(4, 7),
(5, 1),
(5, 2),
(5, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_cred`
--

CREATE TABLE `user_cred` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `booking_confirmation`
--
ALTER TABLE `booking_confirmation`
  ADD PRIMARY KEY (`confirmation_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`facility_id`);

--
-- Chỉ mục cho bảng `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Chỉ mục cho bảng `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD KEY `room_id` (`room_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Chỉ mục cho bảng `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `booking_confirmation`
--
ALTER TABLE `booking_confirmation`
  MODIFY `confirmation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `facilities`
--
ALTER TABLE `facilities`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking_confirmation`
--
ALTER TABLE `booking_confirmation`
  ADD CONSTRAINT `booking_confirmation_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

--
-- Các ràng buộc cho bảng `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer_details` (`user_id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Các ràng buộc cho bảng `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

--
-- Các ràng buộc cho bảng `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `room_facilities_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `room_facilities_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`facility_id`);

--
-- Các ràng buộc cho bảng `user_cred`
--
ALTER TABLE `user_cred`
  ADD CONSTRAINT `user_cred_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer_details` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
