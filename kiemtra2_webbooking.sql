-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 13, 2024 lúc 10:10 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Cơ sở dữ liệu: `kiemtra2_webbooking`

-- Cấu trúc bảng cho bảng `booking_confirmation`
CREATE TABLE `booking_confirmation` (
  `confirmation_id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) DEFAULT NULL,
  `qr_code` varchar(100) DEFAULT NULL,
  `confirmation_date` date DEFAULT NULL,
  PRIMARY KEY (`confirmation_id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng `booking_confirmation`
INSERT INTO `booking_confirmation` (`confirmation_id`, `booking_id`, `qr_code`, `confirmation_date`) VALUES
(1, 1, 'QR_ORD_1001', '2024-10-01'),
(2, 4, 'QR_ORD_1004', '2024-10-05'),
(3, 5, 'QR_ORD_1005', '2024-10-06'),
(4, 7, 'QR_ORD_1007', '2024-10-08'),
(5, 10, 'QR_ORD_1010', '2024-10-11');

-- Cấu trúc bảng cho bảng `booking_order`
CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `booking_status` enum('Pending','Confirmed','Cancelled') DEFAULT NULL,
  `order_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `user_id` (`user_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng `booking_order`
INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `booking_status`, `order_id`) VALUES
(1, 1, 1, '2024-10-01', '2024-10-05', 'Confirmed', 'ORD_1001'),
(2, 2, 2, '2024-10-03', '2024-10-06', 'Pending', 'ORD_1002'),
(3, 3, 3, '2024-10-04', '2024-10-08', 'Cancelled', 'ORD_1003'),
(4, 4, 4, '2024-10-05', '2024-10-10', 'Confirmed', 'ORD_1004'),
(5, 5, 5, '2024-10-06', '2024-10-09', 'Confirmed', 'ORD_1005'),
(6, 6, 6, '2024-10-07', '2024-10-11', 'Pending', 'ORD_1006'),
(7, 7, 7, '2024-10-08', '2024-10-12', 'Confirmed', 'ORD_1007'),
(8, 8, 8, '2024-10-09', '2024-10-14', 'Cancelled', 'ORD_1008'),
(9, 9, 9, '2024-10-10', '2024-10-15', 'Pending', 'ORD_1009'),
(10, 10, 10, '2024-10-11', '2024-10-16', 'Confirmed', 'ORD_1010');

-- Cấu trúc bảng cho bảng `customer_details`
CREATE TABLE `customer_details` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `ho_ten` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `so_dien_thoai` varchar(15) DEFAULT NULL,
  `dia_chi` varchar(100) DEFAULT NULL,
  `gioi_tinh` enum('Nam','Nu') DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Đang đổ dữ liệu cho bảng `customer_details`
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
(10, 'Phan Van J', 'pvj@example.com', '0990123456', '444 Ly Tu Trong, HCM', 'Nam', '1985-01-15');

-- Thực hiện các ràng buộc ngoại khóa
ALTER TABLE `booking_confirmation`
  ADD CONSTRAINT `booking_confirmation_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer_details` (`user_id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

ALTER TABLE `room_facilities`
  ADD CONSTRAINT `room_facilities_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `room_facilities_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`facility_id`);

ALTER TABLE `user_cred`
  ADD CONSTRAINT `user_cred_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer_details` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
