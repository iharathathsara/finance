-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.31 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table matara_investment_db.client
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `insurance_file_id` int DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `name_with_initial` varchar(50) DEFAULT NULL,
  `address` text,
  `dob` varchar(50) DEFAULT NULL,
  `nic` varchar(50) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `user_title_id` int DEFAULT NULL,
  `nic_font_img_path` text,
  `nic_back_img_path` text,
  `spouse_full_name` varchar(50) DEFAULT NULL,
  `spouse_nic` varchar(50) DEFAULT NULL,
  `spouse_tel` varchar(50) DEFAULT NULL,
  `spouse_profession` varchar(50) DEFAULT NULL,
  `business_name` varchar(50) DEFAULT NULL,
  `business_address` text,
  `business_reg_no` varchar(50) DEFAULT NULL,
  `business_nature` varchar(50) DEFAULT NULL,
  `employment_income` double DEFAULT NULL,
  `other_income` double DEFAULT NULL,
  `living_cost` double DEFAULT NULL,
  `loan_repayment` double DEFAULT NULL,
  `equipment_type_id` int DEFAULT NULL,
  `supplier` varchar(50) DEFAULT NULL,
  `required_item_type` varchar(50) DEFAULT NULL,
  `required_item_facility_amount` double DEFAULT NULL,
  `requied_item_color` varchar(50) DEFAULT NULL,
  `required_item_lease_period` varchar(50) DEFAULT NULL,
  `purpose_of_use` text,
  `other_details` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_client_user_title` (`user_title_id`),
  KEY `FK_client_insurance_file` (`insurance_file_id`),
  CONSTRAINT `FK_client_insurance_file` FOREIGN KEY (`insurance_file_id`) REFERENCES `insurance_file` (`id`),
  CONSTRAINT `FK_client_user_title` FOREIGN KEY (`user_title_id`) REFERENCES `user_title` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.client: ~5 rows (approximately)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`id`, `insurance_file_id`, `full_name`, `name_with_initial`, `address`, `dob`, `nic`, `tel`, `mobile`, `user_title_id`, `nic_font_img_path`, `nic_back_img_path`, `spouse_full_name`, `spouse_nic`, `spouse_tel`, `spouse_profession`, `business_name`, `business_address`, `business_reg_no`, `business_nature`, `employment_income`, `other_income`, `living_cost`, `loan_repayment`, `equipment_type_id`, `supplier`, `required_item_type`, `required_item_facility_amount`, `requied_item_color`, `required_item_lease_period`, `purpose_of_use`, `other_details`, `created_at`, `updated_at`) VALUES
	(1, 3, 'aa', 'aa', 'aa', 'aaa', 'aaa', '0833838377', '0847473839', 2, 'resources//images//66c58cec8c964.jpeg', 'resources//images//66c58cec8c967.jpeg', '', '', '', '', 'aaa', 'aaa', 'aaa', 'aaa', 2534, 6456, 345, 3456, 2, 'aa', 'aaa', 565, 'zzx', 'zxz', 'zx', '', '2024-08-21 12:15:00', '2024-08-21 12:15:00'),
	(2, 1, 'b', 'b', 'b', 'b', 'b', '0833838377', '0847473839', 1, 'resources//images//66cf84ec01abe.jpeg', 'resources//images//66cf84ec01ac2.jpeg', '', '', '', '', 'b', 'b', 'b', 'b', 20000, 0, 10000, 0, 1, 'b', 'b', 3, 'b', 'b', 'b', '', '2024-08-29 00:05:48', '2024-08-29 01:43:32'),
	(3, 2, 'aa', 'aaa', 'a', '2024-08-14', 'a', '0833838377', '0776574839', 1, 'resources//images//66d01b49825d7.png', 'resources//images//66d01b5a27e74.jpeg', '', '', '', '', 'a', 'a', 'a', 'a', 2534, 7676, 87, 5, 1, 'a', 'a', 7, 'a', 'a', 'a', '', '2024-08-29 11:59:10', '2024-08-29 12:25:22'),
	(4, 4, 'a', 'a', 'a', 'a', 'a', '0833838377', '0847473839', 1, 'resources//images//66d0b97a07279.svg', 'resources//images//66d0b97a0727e.png', '', '', '', '', 'a', 'a', 'a', 'a', 60000, 10000, 10000, 0, 2, 'a', 'a', 1, 'a', 'a', 'a', '', '2024-08-29 23:40:02', '2024-08-29 23:40:02'),
	(5, 5, 'a', 'a', 'a', 'a', 'aa', '0833838377', '0847473839', 1, 'resources//images//66d48a27157bb.png', 'resources//images//66d48a27157bd.png', 'a', 'a', '0877675656', 'a', 'a', 'a', 'a', 'a', 60000, 10000, 10000, 0, 2, 'a', 'a', 23, 'a', 'a', 'a', '', '2024-09-01 21:07:11', '2024-09-01 21:10:24'),
	(6, 7, 'aa', 'a', 'a', 'a', '1212', '0833838377', '0847473839', 2, 'resources//images//67057099beb74.png', 'resources//images//67057099bf0fe.png', '', '', '', '', 'a', 'a', 'a', 'a', 100000, 20000, 10000, 0, 1, 'a', 'a', 112, 'a', '12', 'a', '', '2024-10-08 23:15:35', '2024-10-08 23:19:13');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.client_bank
CREATE TABLE IF NOT EXISTS `client_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_client_bank_client` (`client_id`),
  CONSTRAINT `FK_client_bank_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.client_bank: ~5 rows (approximately)
/*!40000 ALTER TABLE `client_bank` DISABLE KEYS */;
INSERT INTO `client_bank` (`id`, `name`, `account_no`, `type`, `client_id`) VALUES
	(1, 'sd', 'sf', 'cd', 1),
	(13, 'a', 'a', 'a', 3),
	(15, 'b', 'b', 'b', 2),
	(16, 'a', 'a', 'a', 4),
	(18, 'a', 'a', 'a', 5),
	(23, 'a', 'a', 'a', 6);
/*!40000 ALTER TABLE `client_bank` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.client_creadit_facility
CREATE TABLE IF NOT EXISTS `client_creadit_facility` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institute` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `present_outstanding` double DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_client_creadit_facility_client` (`client_id`),
  CONSTRAINT `FK_client_creadit_facility_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.client_creadit_facility: ~0 rows (approximately)
/*!40000 ALTER TABLE `client_creadit_facility` DISABLE KEYS */;
INSERT INTO `client_creadit_facility` (`id`, `institute`, `amount`, `present_outstanding`, `client_id`) VALUES
	(2, 'a', 23, 23, 5);
/*!40000 ALTER TABLE `client_creadit_facility` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.client_property
CREATE TABLE IF NOT EXISTS `client_property` (
  `id` int NOT NULL AUTO_INCREMENT,
  `location` varchar(50) DEFAULT NULL,
  `extent` varchar(50) DEFAULT NULL,
  `approximate_value` double DEFAULT NULL,
  `mortgaged` varchar(50) DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__client` (`client_id`),
  CONSTRAINT `FK__client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.client_property: ~3 rows (approximately)
/*!40000 ALTER TABLE `client_property` DISABLE KEYS */;
INSERT INTO `client_property` (`id`, `location`, `extent`, `approximate_value`, `mortgaged`, `client_id`) VALUES
	(1, 'aaa', '12', 234, 'false', 1),
	(4, 'aaa', '34', 234, 'false', 3),
	(6, 'b', '12', 1, 'false', 2),
	(8, 'a', 'a', 23, 'false', 5);
/*!40000 ALTER TABLE `client_property` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.client_vehicle
CREATE TABLE IF NOT EXISTS `client_vehicle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(50) DEFAULT NULL,
  `vehicle_type_id` int DEFAULT NULL,
  `market_value` double DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_client_vehicle_client` (`client_id`),
  KEY `FK_client_vehicle_vehicle_type` (`vehicle_type_id`),
  CONSTRAINT `FK_client_vehicle_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  CONSTRAINT `FK_client_vehicle_vehicle_type` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.client_vehicle: ~0 rows (approximately)
/*!40000 ALTER TABLE `client_vehicle` DISABLE KEYS */;
INSERT INTO `client_vehicle` (`id`, `reg_no`, `vehicle_type_id`, `market_value`, `client_id`) VALUES
	(23, 'a', 1, 23, 5);
/*!40000 ALTER TABLE `client_vehicle` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.factory_fitted_accessory
CREATE TABLE IF NOT EXISTS `factory_fitted_accessory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.factory_fitted_accessory: ~11 rows (approximately)
/*!40000 ALTER TABLE `factory_fitted_accessory` DISABLE KEYS */;
INSERT INTO `factory_fitted_accessory` (`id`, `name`) VALUES
	(1, 'A/C'),
	(2, 'C/D'),
	(3, 'Radio'),
	(4, 'T.V.'),
	(5, 'Aerial'),
	(6, 'PWR. Steering'),
	(7, 'Alloy Wheels'),
	(8, 'Air Bag'),
	(9, 'Centrl. Looking'),
	(10, 'PWR. Shutters'),
	(11, 'Fog Lamps'),
	(12, 'Buffer Lamps'),
	(13, 'PWR Mirror');
/*!40000 ALTER TABLE `factory_fitted_accessory` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.file_approved_payment
CREATE TABLE IF NOT EXISTS `file_approved_payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_id` int DEFAULT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `approved_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_file_approved_payment_insurance_file` (`file_id`) USING BTREE,
  CONSTRAINT `FK_file_approved_payment_insurance_file` FOREIGN KEY (`file_id`) REFERENCES `insurance_file` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.file_approved_payment: ~3 rows (approximately)
/*!40000 ALTER TABLE `file_approved_payment` DISABLE KEYS */;
INSERT INTO `file_approved_payment` (`id`, `file_id`, `bank_name`, `payment_date`, `check_no`, `amount`, `approved_date`) VALUES
	(2, 5, 'aa', '2024-09-02', 'aa', 21, '2024-09-01 22:50:49'),
	(3, 6, 'aaa', '2024-10-01', 'aaaa', 1212, '2024-10-08 18:32:11'),
	(4, 4, 'asas', '2024-10-01', '1212', 100000, '2024-10-09 16:37:27'),
	(5, 1, 'aa', '2024-10-31', 'ass', 100000, '2024-10-31 18:28:36');
/*!40000 ALTER TABLE `file_approved_payment` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.file_installment_payment
CREATE TABLE IF NOT EXISTS `file_installment_payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `balance` double DEFAULT '0',
  `paid_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_file_installment_payment_insurance_file` (`file_id`),
  KEY `FK_file_installment_payment_user` (`user_id`),
  CONSTRAINT `FK_file_installment_payment_insurance_file` FOREIGN KEY (`file_id`) REFERENCES `insurance_file` (`id`),
  CONSTRAINT `FK_file_installment_payment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.file_installment_payment: ~27 rows (approximately)
/*!40000 ALTER TABLE `file_installment_payment` DISABLE KEYS */;
INSERT INTO `file_installment_payment` (`id`, `file_id`, `user_id`, `amount`, `balance`, `paid_date`) VALUES
	(1, 1, 1, 1000, 0, '2024-08-21'),
	(2, 2, 1, 2000, 0, '2024-08-24'),
	(3, 1, 1, 2000, 0, '2024-08-30'),
	(4, 4, 1, 108.36, 0, '2024-08-30'),
	(5, 5, 1, 1841, -0, '2024-09-01'),
	(6, 5, 1, 1841, -0, '2024-09-01'),
	(7, 5, 1, 1841, -0, '2024-09-01'),
	(8, 5, 1, 1841, -0, '2024-09-01'),
	(9, 5, 1, 1841, -0, '2024-09-01'),
	(10, 5, 1, 1841, -0, '2024-09-01'),
	(11, 5, 1, 1841, -0, '2024-09-01'),
	(12, 5, 1, 1841, -0, '2024-09-01'),
	(13, 5, 1, 1841, -0, '2024-09-01'),
	(14, 5, 1, 1841, -0, '2024-09-01'),
	(15, 5, 1, 1841, -0, '2024-09-01'),
	(16, 5, 1, 1841, -0, '2024-09-01'),
	(17, 5, 1, 1841, -0, '2024-09-01'),
	(18, 5, 1, 1841, -0, '2024-09-01'),
	(19, 5, 1, 1841, -0, '2024-09-01'),
	(20, 4, 2, 224.96, 0, '2024-10-09'),
	(21, 4, 2, 108.36, 0, '2024-10-09'),
	(22, 4, 2, 108.36, 0, '2024-10-08'),
	(23, 4, 2, 108.36, 0, '2024-10-09'),
	(24, 4, 2, 108.36, 0, '2024-10-09'),
	(25, 4, 2, 108.36, 0, '2024-10-09'),
	(26, 4, 2, 108.36, 0, '2024-10-09'),
	(27, 4, 2, 108.36, 0, '2024-10-09'),
	(28, 4, 2, 108.36, 0, '2024-10-10');
/*!40000 ALTER TABLE `file_installment_payment` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.file_payments
CREATE TABLE IF NOT EXISTS `file_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `insurance_file_id` int DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `loan_tenure` int DEFAULT NULL,
  `precentage` double DEFAULT NULL,
  `other_details` text,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_file_payments_insurance_file` (`insurance_file_id`),
  CONSTRAINT `FK_file_payments_insurance_file` FOREIGN KEY (`insurance_file_id`) REFERENCES `insurance_file` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.file_payments: ~2 rows (approximately)
/*!40000 ALTER TABLE `file_payments` DISABLE KEYS */;
INSERT INTO `file_payments` (`id`, `insurance_file_id`, `amount`, `loan_tenure`, `precentage`, `other_details`, `created_date`) VALUES
	(1, 4, 1000, 12, 51.5, '', '2024-08-30 00:10:30'),
	(2, 2, 120000, 24, 30, '', '2024-08-30 01:22:44'),
	(3, 5, 20000, 15, 52, 'aaaaa', '2024-09-01 21:09:35'),
	(4, 1, 100000, 12, 51.5, '', '2024-10-31 18:29:20'),
	(5, 8, 10000, 12, 50, '', '2024-11-07 21:25:33');
/*!40000 ALTER TABLE `file_payments` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.file_service_charge
CREATE TABLE IF NOT EXISTS `file_service_charge` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_id` int DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_file_service_charge_insurance_file` (`file_id`),
  CONSTRAINT `FK_file_service_charge_insurance_file` FOREIGN KEY (`file_id`) REFERENCES `insurance_file` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.file_service_charge: ~0 rows (approximately)
/*!40000 ALTER TABLE `file_service_charge` DISABLE KEYS */;
INSERT INTO `file_service_charge` (`id`, `file_id`, `amount`, `date`) VALUES
	(1, 5, 20000, '2024-10-09');
/*!40000 ALTER TABLE `file_service_charge` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.file_type
CREATE TABLE IF NOT EXISTS `file_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.file_type: ~2 rows (approximately)
/*!40000 ALTER TABLE `file_type` DISABLE KEYS */;
INSERT INTO `file_type` (`id`, `name`) VALUES
	(1, 'Motor Cycle'),
	(2, 'Motor Trycycle'),
	(3, 'Motor Car');
/*!40000 ALTER TABLE `file_type` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.guarantor
CREATE TABLE IF NOT EXISTS `guarantor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `insurance_file_id` int DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `name_with_initial` varchar(50) DEFAULT NULL,
  `address` text,
  `dob` varchar(50) DEFAULT NULL,
  `nic` varchar(50) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `user_title_id` int DEFAULT NULL,
  `nic_font_img_path` text,
  `nic_back_img_path` text,
  `spouse_full_name` varchar(50) DEFAULT NULL,
  `spouse_nic` varchar(50) DEFAULT NULL,
  `spouse_tel` varchar(50) DEFAULT NULL,
  `spouse_profession` varchar(50) DEFAULT NULL,
  `business_name` varchar(50) DEFAULT NULL,
  `business_address` text,
  `business_reg_no` varchar(50) DEFAULT NULL,
  `business_nature` varchar(50) DEFAULT NULL,
  `employment_income` double DEFAULT NULL,
  `other_income` double DEFAULT NULL,
  `living_cost` double DEFAULT NULL,
  `loan_repayment` double DEFAULT NULL,
  `other_details` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_guarantor_insurance_file` (`insurance_file_id`),
  KEY `FK_guarantor_user_title` (`user_title_id`),
  CONSTRAINT `FK_guarantor_insurance_file` FOREIGN KEY (`insurance_file_id`) REFERENCES `insurance_file` (`id`),
  CONSTRAINT `FK_guarantor_user_title` FOREIGN KEY (`user_title_id`) REFERENCES `user_title` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.guarantor: ~5 rows (approximately)
/*!40000 ALTER TABLE `guarantor` DISABLE KEYS */;
INSERT INTO `guarantor` (`id`, `insurance_file_id`, `full_name`, `name_with_initial`, `address`, `dob`, `nic`, `tel`, `mobile`, `user_title_id`, `nic_font_img_path`, `nic_back_img_path`, `spouse_full_name`, `spouse_nic`, `spouse_tel`, `spouse_profession`, `business_name`, `business_address`, `business_reg_no`, `business_nature`, `employment_income`, `other_income`, `living_cost`, `loan_repayment`, `other_details`, `created_at`, `updated_at`) VALUES
	(1, 1, 'a', 'a', 'a', 'a', 'a', '0877767666', '0988777665', 1, 'resources//images//66d04fb67d3c3.jpeg', 'resources//images//66d04fb67d8ab.jpeg', '', '', '', '', 'a', 'a', 'a', 'a', 2342, 0, 23, 0, '', '2024-08-29 15:46:01', '2024-08-29 16:08:46'),
	(4, 3, 'c', 'c', 'c', 'c', 'c', '0877767666', '0775031532', 2, 'resources//images//66d054c2d09f9.png', 'resources//images//66d054c2d0dc4.svg', '', '', '', '', 'c', 'c', 'c', 'c', 2323, 0, 34, 0, '', '2024-08-29 16:30:18', '2024-08-29 16:30:18'),
	(5, 4, 'b', 'b', 'b', 'b', 'b', '0877767666', '0988777665', 2, 'resources//images//66d0b9d7a2f85.png', 'resources//images//66d0b9d7a2f8e.png', '', '', '', '', 'b', 'b', 'b', 'b', 50000, 0, 10000, 0, '', '2024-08-29 23:41:35', '2024-08-29 23:41:35'),
	(6, 2, 'c', 'c', 'c', 'c', 'c', '0877767666', '0775031532', 1, 'resources//images//66d0cb283a436.png', 'resources//images//66d0cb283a8d1.png', '', '', '', '', 'c', 'c', 'c', 'c', 2323, 0, 34, 0, '', '2024-08-30 00:55:28', '2024-08-30 00:55:28'),
	(7, 5, 'b', 'b', 'b', 'b', 'b', '0877767666', '0988777665', 1, 'resources//images//66d48a61da2e3.png', 'resources//images//66d48a61da2e5.png', 'b', 'b', '0786787674', 'b', 'b', 'b', 'b', 'b', 200000, 60000, 10000, 200, '', '2024-09-01 21:08:09', '2024-09-01 21:08:09');
/*!40000 ALTER TABLE `guarantor` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.guarantor_bank
CREATE TABLE IF NOT EXISTS `guarantor_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `guarantor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_guarantor_bank_guarantor` (`guarantor_id`),
  CONSTRAINT `FK_guarantor_bank_guarantor` FOREIGN KEY (`guarantor_id`) REFERENCES `guarantor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.guarantor_bank: ~5 rows (approximately)
/*!40000 ALTER TABLE `guarantor_bank` DISABLE KEYS */;
INSERT INTO `guarantor_bank` (`id`, `name`, `account_no`, `type`, `guarantor_id`) VALUES
	(4, 'a', 'a', 'a', 1),
	(10, 'c', 'c', 'c', 4),
	(11, 'b', 'b', 'b', 5),
	(12, 'c', 'c', 'c', 6),
	(13, 'b', '2', '3', 7);
/*!40000 ALTER TABLE `guarantor_bank` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.guarantor_creadit_facility
CREATE TABLE IF NOT EXISTS `guarantor_creadit_facility` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institute` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `present_outstanding` double DEFAULT NULL,
  `guarantor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__guarantor` (`guarantor_id`),
  CONSTRAINT `FK__guarantor` FOREIGN KEY (`guarantor_id`) REFERENCES `guarantor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.guarantor_creadit_facility: ~1 rows (approximately)
/*!40000 ALTER TABLE `guarantor_creadit_facility` DISABLE KEYS */;
INSERT INTO `guarantor_creadit_facility` (`id`, `institute`, `amount`, `present_outstanding`, `guarantor_id`) VALUES
	(1, 'b', 23, 23, 7);
/*!40000 ALTER TABLE `guarantor_creadit_facility` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.guarantor_property
CREATE TABLE IF NOT EXISTS `guarantor_property` (
  `id` int NOT NULL AUTO_INCREMENT,
  `location` varchar(50) DEFAULT NULL,
  `extent` varchar(50) DEFAULT NULL,
  `approximate_value` double DEFAULT NULL,
  `mortgaged` varchar(50) DEFAULT NULL,
  `guarantor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_guarantor_property_guarantor` (`guarantor_id`),
  CONSTRAINT `FK_guarantor_property_guarantor` FOREIGN KEY (`guarantor_id`) REFERENCES `guarantor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.guarantor_property: ~2 rows (approximately)
/*!40000 ALTER TABLE `guarantor_property` DISABLE KEYS */;
INSERT INTO `guarantor_property` (`id`, `location`, `extent`, `approximate_value`, `mortgaged`, `guarantor_id`) VALUES
	(1, 'cc', '12', 12, 'false', 6),
	(2, 'b', '23', 23, 'false', 7);
/*!40000 ALTER TABLE `guarantor_property` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.guarantor_vehicle
CREATE TABLE IF NOT EXISTS `guarantor_vehicle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(50) DEFAULT NULL,
  `vehicle_type_id` int DEFAULT NULL,
  `market_value` double DEFAULT NULL,
  `guarantor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_guarantor_vehicle_guarantor` (`guarantor_id`),
  KEY `FK_guarantor_vehicle_vehicle_type` (`vehicle_type_id`),
  CONSTRAINT `FK_guarantor_vehicle_guarantor` FOREIGN KEY (`guarantor_id`) REFERENCES `guarantor` (`id`),
  CONSTRAINT `FK_guarantor_vehicle_vehicle_type` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.guarantor_vehicle: ~0 rows (approximately)
/*!40000 ALTER TABLE `guarantor_vehicle` DISABLE KEYS */;
INSERT INTO `guarantor_vehicle` (`id`, `reg_no`, `vehicle_type_id`, `market_value`, `guarantor_id`) VALUES
	(1, 'b', 2, 23, 7);
/*!40000 ALTER TABLE `guarantor_vehicle` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.insurance_file
CREATE TABLE IF NOT EXISTS `insurance_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_no` varchar(50) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `file_type_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_insurance_file_user` (`user_id`),
  KEY `FK_insurance_file_file_type` (`file_type_id`),
  CONSTRAINT `FK_insurance_file_file_type` FOREIGN KEY (`file_type_id`) REFERENCES `file_type` (`id`),
  CONSTRAINT `FK_insurance_file_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.insurance_file: ~5 rows (approximately)
/*!40000 ALTER TABLE `insurance_file` DISABLE KEYS */;
INSERT INTO `insurance_file` (`id`, `file_no`, `user_id`, `file_type_id`, `created_at`, `updated_at`) VALUES
	(1, '0001/12/07/24', 1, 1, '2024-08-21 11:37:51', '2024-08-21 11:37:51'),
	(2, '0012/12/07/24', 1, 1, '2024-08-21 11:38:16', '2024-08-21 11:38:16'),
	(3, '0002/12/07/24', 1, 1, '2024-08-21 11:39:49', '2024-08-21 11:39:49'),
	(4, '3338', 1, 2, '2024-08-29 23:38:14', '2024-08-29 23:38:14'),
	(5, 'test', 1, 2, '2024-09-01 21:06:07', '2024-09-01 21:06:07'),
	(6, 'abcd', 1, 2, '2024-10-07 19:50:35', '2024-10-07 19:50:35'),
	(7, 'aaaa', 1, 2, '2024-10-08 21:43:55', '2024-10-08 21:43:55'),
	(8, '123', 1, 1, '2024-11-07 19:26:19', '2024-11-07 19:26:19');
/*!40000 ALTER TABLE `insurance_file` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.insurance_file_status
CREATE TABLE IF NOT EXISTS `insurance_file_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `insurance_file_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `message` text,
  `status_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_insurance_file_status_insurance_file` (`insurance_file_id`),
  KEY `FK_insurance_file_status_user` (`user_id`),
  KEY `FK_insurance_file_status_status` (`status_id`) USING BTREE,
  CONSTRAINT `FK_insurance_file_status_insurance_file` FOREIGN KEY (`insurance_file_id`) REFERENCES `insurance_file` (`id`),
  CONSTRAINT `FK_insurance_file_status_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `FK_insurance_file_status_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.insurance_file_status: ~9 rows (approximately)
/*!40000 ALTER TABLE `insurance_file_status` DISABLE KEYS */;
INSERT INTO `insurance_file_status` (`id`, `insurance_file_id`, `user_id`, `message`, `status_id`, `created_at`, `updated_at`) VALUES
	(1, 5, 1, '', 2, '2024-10-08 17:24:03', '2024-10-08 18:27:54'),
	(2, 6, 2, '', 2, '2024-10-08 17:59:26', '2024-10-08 17:59:26'),
	(3, 4, 2, '', 2, '2024-10-08 18:25:17', '2024-10-09 16:36:58'),
	(4, 5, 2, '', 2, '2024-10-08 18:25:31', '2024-10-08 18:25:37'),
	(5, 6, 1, '', 2, '2024-10-08 18:31:55', '2024-10-08 18:31:55'),
	(6, 4, 1, '', 2, '2024-10-09 16:36:20', '2024-10-09 16:36:20'),
	(7, 1, 1, '', 2, '2024-10-31 18:28:10', '2024-10-31 18:28:10'),
	(8, 3, 1, '', 2, '2024-11-07 19:21:56', '2024-11-07 19:21:56'),
	(9, 2, 1, '', 2, '2024-11-07 19:22:06', '2024-11-07 19:22:06');
/*!40000 ALTER TABLE `insurance_file_status` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.inventory
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `desc` text,
  `img1` text,
  `img2` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.inventory: ~1 rows (approximately)
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` (`id`, `title`, `desc`, `img1`, `img2`) VALUES
	(2, 'item 2', 'desc', 'resources//images//6722782882ecf.svg', 'resources//images//67227828836be.png');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.leaves
CREATE TABLE IF NOT EXISTS `leaves` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `days` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.leaves: ~2 rows (approximately)
/*!40000 ALTER TABLE `leaves` DISABLE KEYS */;
INSERT INTO `leaves` (`id`, `name`, `days`) VALUES
	(1, 'Sik Leaves', 7),
	(2, 'Casual Leaves', 7),
	(3, 'Vacation Leaves', 14);
/*!40000 ALTER TABLE `leaves` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.payment_anual_presentage
CREATE TABLE IF NOT EXISTS `payment_anual_presentage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `value` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.payment_anual_presentage: ~0 rows (approximately)
/*!40000 ALTER TABLE `payment_anual_presentage` DISABLE KEYS */;
INSERT INTO `payment_anual_presentage` (`id`, `value`) VALUES
	(1, 51.5);
/*!40000 ALTER TABLE `payment_anual_presentage` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.status: ~2 rows (approximately)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`, `name`) VALUES
	(1, 'Pending'),
	(2, 'Approved');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(50) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `name_with_initial` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `nic` varchar(10) DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `address` varchar(50) DEFAULT NULL,
  `user_type_id` int DEFAULT NULL,
  `user_status_id` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_user_user_type` (`user_type_id`),
  KEY `FK_user_user_status` (`user_status_id`),
  CONSTRAINT `FK_user_user_status` FOREIGN KEY (`user_status_id`) REFERENCES `user_status` (`id`),
  CONSTRAINT `FK_user_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.user: ~1 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `emp_no`, `full_name`, `name_with_initial`, `email`, `mobile`, `nic`, `password`, `address`, `user_type_id`, `user_status_id`, `created_at`, `updated_at`) VALUES
	(1, 'SA 0001', 'ihara thathsara', 'W.G.Ihara Thathsara', 'iharathathsara31@gmail.com', '0763947527', '123456', '$2y$10$y35Z55bkgLpP7KQb/xDBie/o.lVw0F3EwPx/kBpLyRRGQvqWo.0Tu', '"Seth Sisila", Kaduruduwa, Wanchawala, Galle', 1, 1, '2024-08-13 15:34:21', '2024-08-31 12:29:18'),
	(2, '1111', 'Wijesiri Gunawardhana Ihara Thathsara', 'wgIhara Thathsara', 'iharathathsara0@gmail.com', '0763947527', '12345678', '$2y$10$OtgidCjceU7zxmBQu66X9us8ZpdMa0Xao5U4sdBNsDWYL5E8xIFQu', '"Seth Sisila", Kaduruduwa, Wanchawala, Galle', 2, 1, '2024-10-08 17:24:55', '2024-10-08 17:24:55');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.user_has_leaves
CREATE TABLE IF NOT EXISTS `user_has_leaves` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `leaves_id` int DEFAULT NULL,
  `days` int DEFAULT NULL,
  `leave_date` date DEFAULT NULL,
  `status` int DEFAULT NULL,
  `approved_user_id` int DEFAULT NULL,
  `other_details` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_user_has_leaves_user` (`user_id`),
  KEY `FK_user_has_leaves_leaves` (`leaves_id`),
  KEY `FK_user_has_leaves_user_2` (`approved_user_id`),
  CONSTRAINT `FK_user_has_leaves_leaves` FOREIGN KEY (`leaves_id`) REFERENCES `leaves` (`id`),
  CONSTRAINT `FK_user_has_leaves_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_user_has_leaves_user_2` FOREIGN KEY (`approved_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.user_has_leaves: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_has_leaves` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_has_leaves` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.user_status
CREATE TABLE IF NOT EXISTS `user_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.user_status: ~2 rows (approximately)
/*!40000 ALTER TABLE `user_status` DISABLE KEYS */;
INSERT INTO `user_status` (`id`, `name`) VALUES
	(1, 'Active'),
	(2, 'Inactive');
/*!40000 ALTER TABLE `user_status` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.user_title
CREATE TABLE IF NOT EXISTS `user_title` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.user_title: ~4 rows (approximately)
/*!40000 ALTER TABLE `user_title` DISABLE KEYS */;
INSERT INTO `user_title` (`id`, `name`) VALUES
	(1, 'Mr.'),
	(2, 'Mrs.'),
	(3, 'Miss.'),
	(4, 'Other');
/*!40000 ALTER TABLE `user_title` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.user_type
CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.user_type: ~4 rows (approximately)
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` (`id`, `name`) VALUES
	(1, 'Super Admin'),
	(2, 'Director'),
	(3, 'Manager'),
	(4, 'Back Officer'),
	(5, 'Cashier');
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.vehicle
CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `insurance_file_id` int NOT NULL DEFAULT '0',
  `vehicle_type_id` int NOT NULL DEFAULT '0',
  `proposer` varchar(50) DEFAULT NULL,
  `reg_no` varchar(50) DEFAULT NULL,
  `engine_no` varchar(50) DEFAULT NULL,
  `chassis_no` varchar(50) DEFAULT NULL,
  `dateOfInspection` date DEFAULT NULL,
  `meter_reading` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `valuers_name` varchar(50) DEFAULT NULL,
  `enstimate_value` varchar(50) DEFAULT NULL,
  `manufacture_year` varchar(50) DEFAULT NULL,
  `inspect_at` varchar(50) DEFAULT NULL,
  `insurance_renew_date` date DEFAULT NULL,
  `license_renew_date` date DEFAULT NULL,
  `vehicle_rb_img_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `vehicle_front_img_path` text,
  `vehicle_back_img_path` text,
  `vehicle_engine_img_path` text,
  `vehicle_chassis_img_path` text,
  `other_accessories` text,
  `duplicate_key` varchar(50) DEFAULT NULL,
  `vehicle_body_type_id` int DEFAULT NULL,
  `generalApperanceStatus` int DEFAULT NULL,
  `painWorkStatus` int DEFAULT NULL,
  `painWorkColor` varchar(50) DEFAULT NULL,
  `upholsteryStatus` int DEFAULT NULL,
  `upholsteryColor` varchar(50) DEFAULT NULL,
  `rightFrontTyreStatus` int DEFAULT NULL,
  `leftFrontTyreStatus` int DEFAULT NULL,
  `rightRearTyreStatus` int DEFAULT NULL,
  `leftRearTyreStatus` int DEFAULT NULL,
  `batteryStatus` int DEFAULT NULL,
  `other_details` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_vehicle_vehicle_type` (`vehicle_type_id`),
  KEY `FK_vehicle_vehicle_body_type` (`vehicle_body_type_id`),
  KEY `FK_vehicle_vehicle_accessory_status` (`generalApperanceStatus`),
  KEY `FK_vehicle_vehicle_accessory_status_2` (`painWorkStatus`),
  KEY `FK_vehicle_vehicle_accessory_status_3` (`upholsteryStatus`),
  KEY `FK_vehicle_vehicle_accessory_status_4` (`rightFrontTyreStatus`),
  KEY `FK_vehicle_vehicle_accessory_status_5` (`leftFrontTyreStatus`),
  KEY `FK_vehicle_vehicle_accessory_status_6` (`rightRearTyreStatus`),
  KEY `FK_vehicle_vehicle_accessory_status_7` (`leftRearTyreStatus`),
  KEY `FK_vehicle_vehicle_accessory_status_8` (`batteryStatus`),
  KEY `FK_vehicle_insurance_file` (`insurance_file_id`),
  CONSTRAINT `FK_vehicle_insurance_file` FOREIGN KEY (`insurance_file_id`) REFERENCES `insurance_file` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_accessory_status` FOREIGN KEY (`generalApperanceStatus`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_accessory_status_2` FOREIGN KEY (`painWorkStatus`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_accessory_status_3` FOREIGN KEY (`upholsteryStatus`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_accessory_status_4` FOREIGN KEY (`rightFrontTyreStatus`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_accessory_status_5` FOREIGN KEY (`leftFrontTyreStatus`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_accessory_status_6` FOREIGN KEY (`rightRearTyreStatus`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_accessory_status_7` FOREIGN KEY (`leftRearTyreStatus`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_accessory_status_8` FOREIGN KEY (`batteryStatus`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_body_type` FOREIGN KEY (`vehicle_body_type_id`) REFERENCES `vehicle_body_type` (`id`),
  CONSTRAINT `FK_vehicle_vehicle_type` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.vehicle: ~2 rows (approximately)
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
INSERT INTO `vehicle` (`id`, `insurance_file_id`, `vehicle_type_id`, `proposer`, `reg_no`, `engine_no`, `chassis_no`, `dateOfInspection`, `meter_reading`, `model`, `valuers_name`, `enstimate_value`, `manufacture_year`, `inspect_at`, `insurance_renew_date`, `license_renew_date`, `vehicle_rb_img_path`, `vehicle_front_img_path`, `vehicle_back_img_path`, `vehicle_engine_img_path`, `vehicle_chassis_img_path`, `other_accessories`, `duplicate_key`, `vehicle_body_type_id`, `generalApperanceStatus`, `painWorkStatus`, `painWorkColor`, `upholsteryStatus`, `upholsteryColor`, `rightFrontTyreStatus`, `leftFrontTyreStatus`, `rightRearTyreStatus`, `leftRearTyreStatus`, `batteryStatus`, `other_details`, `created_at`, `updated_at`) VALUES
	(1, 4, 2, 'c', 'c', 'c', 'c', '2024-08-06', 'c', 'c', 'c', 'c', '21', 'c', '2024-08-15', '2024-08-20', 'resources//images//66d0bd46d443a.png', 'resources//images//66d0bd46d48b5.png', 'resources//images//66d0bd46da6c3.png', 'resources//images//66d0bd46dabbb.png', 'resources//images//66d0bd46daf98.png', '', 'false', 1, 2, 3, 'c', 3, 'c', NULL, NULL, NULL, NULL, 2, '', '2024-08-29 23:47:08', '2024-08-29 23:56:14'),
	(2, 2, 1, 'aa', 'aaa', 'aaa', 'aaa', '2024-08-01', 'aaa', 'aaa', 'aaa', 'a', '12', 'a', '2024-08-13', '2024-08-13', 'resources//images//66d0d0883a027.png', 'resources//images//66d0d0883a6b3.png', 'resources//images//66d0d0883aca6.png', 'resources//images//66d0d0883b29b.png', 'resources//images//66d0d0883b7c9.png', '', 'false', 2, 2, 2, 'c', 3, 's', NULL, NULL, NULL, NULL, 1, '', '2024-08-30 01:16:21', '2024-08-30 01:18:24'),
	(3, 5, 2, 'c', 'c', 'c', 'c', '2024-09-10', 'c', 'c', 'c', 'c', '2323', 'aaaa', '2024-09-05', '2024-09-07', 'resources//images//66d48a9b194f7.png', 'resources//images//66d48a9b19a52.png', 'resources//images//66d48a9b19e46.png', 'resources//images//66d48a9b1a0fd.png', 'resources//images//66d48a9b1a34f.png', '', 'false', 2, 1, 2, 'c', 2, 'c', NULL, NULL, NULL, NULL, 1, '', '2024-09-01 21:09:07', '2024-09-01 21:09:07'),
	(4, 6, 1, 'test', 'test', 'test', 'test', '2024-10-01', 'test', 'test', 'test', 'test', '2020', 'test', '2024-10-02', '2024-10-04', 'resources//images//6703ee7ac7470.png', 'resources//images//6703ee7ac7a7d.png', 'resources//images//6703ee7ac7e4f.png', 'resources//images//6703ee7ac82ad.png', 'resources//images//6703ee7ac85ae.png', '', 'false', 1, 1, 2, 'test', 3, 'test', NULL, NULL, NULL, NULL, 4, '', '2024-10-07 19:51:46', '2024-10-07 19:51:46'),
	(5, 7, 1, 'c', 'c', 'c', 'c', '2024-10-01', 'c', 'c', 'c', 'c', '1212', 'c', '2024-10-03', '2024-10-04', 'resources/add-image.png', 'resources//images//67057f69a9a50.png', 'resources/add-image.png', 'resources/add-image.png', 'resources/add-image.png', '', 'false', 1, 1, 1, 'c', 2, 'c', NULL, NULL, NULL, NULL, 2, '', '2024-10-09 00:22:08', '2024-10-09 00:22:25');
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.vehicle_accessory_status
CREATE TABLE IF NOT EXISTS `vehicle_accessory_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.vehicle_accessory_status: ~4 rows (approximately)
/*!40000 ALTER TABLE `vehicle_accessory_status` DISABLE KEYS */;
INSERT INTO `vehicle_accessory_status` (`id`, `name`) VALUES
	(1, 'Very Good'),
	(2, 'Good'),
	(3, 'Fair'),
	(4, 'Poor');
/*!40000 ALTER TABLE `vehicle_accessory_status` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.vehicle_body_type
CREATE TABLE IF NOT EXISTS `vehicle_body_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.vehicle_body_type: ~4 rows (approximately)
/*!40000 ALTER TABLE `vehicle_body_type` DISABLE KEYS */;
INSERT INTO `vehicle_body_type` (`id`, `name`) VALUES
	(1, 'Open Body'),
	(2, 'Full Closed'),
	(3, 'Flat Bed'),
	(4, 'Freezer');
/*!40000 ALTER TABLE `vehicle_body_type` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.vehicle_has_factory_fitted_accessory
CREATE TABLE IF NOT EXISTS `vehicle_has_factory_fitted_accessory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int DEFAULT NULL,
  `factory_fitted_accessory_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vehicle_has_factory_fitted_accessory_vehicle` (`vehicle_id`),
  KEY `FK_vehicle_has_factory_fitted_accessory_factory_fitted_accessory` (`factory_fitted_accessory_id`),
  CONSTRAINT `FK_vehicle_has_factory_fitted_accessory_factory_fitted_accessory` FOREIGN KEY (`factory_fitted_accessory_id`) REFERENCES `factory_fitted_accessory` (`id`),
  CONSTRAINT `FK_vehicle_has_factory_fitted_accessory_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.vehicle_has_factory_fitted_accessory: ~5 rows (approximately)
/*!40000 ALTER TABLE `vehicle_has_factory_fitted_accessory` DISABLE KEYS */;
INSERT INTO `vehicle_has_factory_fitted_accessory` (`id`, `vehicle_id`, `factory_fitted_accessory_id`) VALUES
	(1, 3, 1),
	(2, 3, 4),
	(3, 3, 10),
	(4, 4, 1),
	(5, 4, 10),
	(7, 5, 11);
/*!40000 ALTER TABLE `vehicle_has_factory_fitted_accessory` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.vehicle_type
CREATE TABLE IF NOT EXISTS `vehicle_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.vehicle_type: ~2 rows (approximately)
/*!40000 ALTER TABLE `vehicle_type` DISABLE KEYS */;
INSERT INTO `vehicle_type` (`id`, `name`) VALUES
	(1, 'Motor Cycle'),
	(2, 'Motor Trycycle'),
	(3, 'Motor Car');
/*!40000 ALTER TABLE `vehicle_type` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.vehicle_type_has_tyre
CREATE TABLE IF NOT EXISTS `vehicle_type_has_tyre` (
  `id` int NOT NULL DEFAULT '0',
  `vehicle_type_id` int DEFAULT NULL,
  `vehicle_tyre_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vehicle_type_has_tyre_vehicle_type` (`vehicle_type_id`),
  KEY `FK_vehicle_type_has_tyre_vehicle_tyre` (`vehicle_tyre_id`),
  CONSTRAINT `FK_vehicle_type_has_tyre_vehicle_type` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`),
  CONSTRAINT `FK_vehicle_type_has_tyre_vehicle_tyre` FOREIGN KEY (`vehicle_tyre_id`) REFERENCES `vehicle_tyre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.vehicle_type_has_tyre: ~9 rows (approximately)
/*!40000 ALTER TABLE `vehicle_type_has_tyre` DISABLE KEYS */;
INSERT INTO `vehicle_type_has_tyre` (`id`, `vehicle_type_id`, `vehicle_tyre_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 2, 1),
	(4, 2, 5),
	(5, 2, 6),
	(6, 3, 3),
	(7, 3, 4),
	(8, 3, 5),
	(9, 3, 6);
/*!40000 ALTER TABLE `vehicle_type_has_tyre` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.vehicle_tyre
CREATE TABLE IF NOT EXISTS `vehicle_tyre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.vehicle_tyre: ~6 rows (approximately)
/*!40000 ALTER TABLE `vehicle_tyre` DISABLE KEYS */;
INSERT INTO `vehicle_tyre` (`id`, `name`) VALUES
	(1, 'Front Tyre'),
	(2, 'Rear Tyre'),
	(3, 'Front Right Tyre'),
	(4, 'Front Left Tyre'),
	(5, 'Rear Right Tyre'),
	(6, 'Rear Left Tyre');
/*!40000 ALTER TABLE `vehicle_tyre` ENABLE KEYS */;

-- Dumping structure for table matara_investment_db.vehicle_tyre_status
CREATE TABLE IF NOT EXISTS `vehicle_tyre_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int DEFAULT NULL,
  `vehicle_tyre_id` int DEFAULT NULL,
  `vehicle_accessory_status_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vehicle_tyre_status_vehicle` (`vehicle_id`),
  KEY `FK_vehicle_tyre_status_vehicle_tyre` (`vehicle_tyre_id`),
  KEY `FK_vehicle_tyre_status_vehicle_accessory_status` (`vehicle_accessory_status_id`),
  CONSTRAINT `FK_vehicle_tyre_status_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
  CONSTRAINT `FK_vehicle_tyre_status_vehicle_accessory_status` FOREIGN KEY (`vehicle_accessory_status_id`) REFERENCES `vehicle_accessory_status` (`id`),
  CONSTRAINT `FK_vehicle_tyre_status_vehicle_tyre` FOREIGN KEY (`vehicle_tyre_id`) REFERENCES `vehicle_tyre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table matara_investment_db.vehicle_tyre_status: ~16 rows (approximately)
/*!40000 ALTER TABLE `vehicle_tyre_status` DISABLE KEYS */;
INSERT INTO `vehicle_tyre_status` (`id`, `vehicle_id`, `vehicle_tyre_id`, `vehicle_accessory_status_id`) VALUES
	(5, 1, 1, 1),
	(6, 1, 5, 1),
	(7, 1, 6, 2),
	(8, NULL, 1, 2),
	(9, NULL, 2, 3),
	(10, NULL, 1, 2),
	(11, NULL, 2, 3),
	(14, 2, 1, 2),
	(15, 2, 2, 3),
	(16, 3, 1, 2),
	(17, 3, 5, 3),
	(18, 3, 6, 4),
	(19, 4, 1, 3),
	(20, 4, 2, 2),
	(23, 5, 1, 3),
	(24, 5, 2, 2);
/*!40000 ALTER TABLE `vehicle_tyre_status` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
