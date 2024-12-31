-- MySQL dump 10.13  Distrib 8.0.37, for Linux (x86_64)
--
-- Host: localhost    Database: matarain_matarainvesmentcompany_db
-- ------------------------------------------------------
-- Server version	8.0.37

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES (2,6,'Palliyaguru sella waduge malinth bimsara nadeeshan','P.S.W.Malith Bimsara Nadeeshan','Waduge parawahera kakanadura','2000/03/25','20000850581','0703528496','0703528496',1,'resources//images//66cd8add16f63.jpeg','resources//images//66cd890fe62b1.jpeg','','','','','-','-','-','-',60000,0,15000,0,1,'-','Honda',1,'Black','-','-','','2024-08-27 07:59:27','2024-08-27 08:14:21');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_bank`
--

DROP TABLE IF EXISTS `client_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_client_bank_client` (`client_id`),
  CONSTRAINT `FK_client_bank_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_bank`
--

LOCK TABLES `client_bank` WRITE;
/*!40000 ALTER TABLE `client_bank` DISABLE KEYS */;
INSERT INTO `client_bank` VALUES (7,'BOC matara','89137255','Saving',2);
/*!40000 ALTER TABLE `client_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_creadit_facility`
--

DROP TABLE IF EXISTS `client_creadit_facility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_creadit_facility` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institute` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `present_outstanding` double DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_client_creadit_facility_client` (`client_id`),
  CONSTRAINT `FK_client_creadit_facility_client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_creadit_facility`
--

LOCK TABLES `client_creadit_facility` WRITE;
/*!40000 ALTER TABLE `client_creadit_facility` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_creadit_facility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_property`
--

DROP TABLE IF EXISTS `client_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_property` (
  `id` int NOT NULL AUTO_INCREMENT,
  `location` varchar(50) DEFAULT NULL,
  `extent` varchar(50) DEFAULT NULL,
  `approximate_value` double DEFAULT NULL,
  `mortgaged` varchar(50) DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__client` (`client_id`),
  CONSTRAINT `FK__client` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_property`
--

LOCK TABLES `client_property` WRITE;
/*!40000 ALTER TABLE `client_property` DISABLE KEYS */;
INSERT INTO `client_property` VALUES (7,'-','1',0,'false',2);
/*!40000 ALTER TABLE `client_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_vehicle`
--

DROP TABLE IF EXISTS `client_vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_vehicle` (
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_vehicle`
--

LOCK TABLES `client_vehicle` WRITE;
/*!40000 ALTER TABLE `client_vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factory_fitted_accessory`
--

DROP TABLE IF EXISTS `factory_fitted_accessory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factory_fitted_accessory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factory_fitted_accessory`
--

LOCK TABLES `factory_fitted_accessory` WRITE;
/*!40000 ALTER TABLE `factory_fitted_accessory` DISABLE KEYS */;
INSERT INTO `factory_fitted_accessory` VALUES (1,'A/C'),(2,'C/D'),(3,'Radio'),(4,'T.V.'),(5,'Aerial'),(6,'PWR. Steering'),(7,'Alloy Wheels'),(8,'Air Bag'),(9,'Centrl. Looking'),(10,'PWR. Shutters'),(11,'Fog Lamps'),(12,'Buffer Lamps'),(13,'PWR Mirror');
/*!40000 ALTER TABLE `factory_fitted_accessory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_approved_payment`
--

DROP TABLE IF EXISTS `file_approved_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_approved_payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_id` int DEFAULT NULL,
  `bank_name` varchar(50) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_file_approved_payment_insurance_file` (`file_id`) USING BTREE,
  CONSTRAINT `FK_file_approved_payment_insurance_file` FOREIGN KEY (`file_id`) REFERENCES `insurance_file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_approved_payment`
--

LOCK TABLES `file_approved_payment` WRITE;
/*!40000 ALTER TABLE `file_approved_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `file_approved_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_installment_payment`
--

DROP TABLE IF EXISTS `file_installment_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_installment_payment` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_installment_payment`
--

LOCK TABLES `file_installment_payment` WRITE;
/*!40000 ALTER TABLE `file_installment_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `file_installment_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_payments`
--

DROP TABLE IF EXISTS `file_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_payments` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_payments`
--

LOCK TABLES `file_payments` WRITE;
/*!40000 ALTER TABLE `file_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `file_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_type`
--

DROP TABLE IF EXISTS `file_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `file_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_type`
--

LOCK TABLES `file_type` WRITE;
/*!40000 ALTER TABLE `file_type` DISABLE KEYS */;
INSERT INTO `file_type` VALUES (1,'Motor Cycle'),(2,'Motor Trycycle'),(3,'Motor Car');
/*!40000 ALTER TABLE `file_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guarantor`
--

DROP TABLE IF EXISTS `guarantor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guarantor` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guarantor`
--

LOCK TABLES `guarantor` WRITE;
/*!40000 ALTER TABLE `guarantor` DISABLE KEYS */;
/*!40000 ALTER TABLE `guarantor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guarantor_bank`
--

DROP TABLE IF EXISTS `guarantor_bank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guarantor_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `account_no` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `guarantor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_guarantor_bank_guarantor` (`guarantor_id`),
  CONSTRAINT `FK_guarantor_bank_guarantor` FOREIGN KEY (`guarantor_id`) REFERENCES `guarantor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guarantor_bank`
--

LOCK TABLES `guarantor_bank` WRITE;
/*!40000 ALTER TABLE `guarantor_bank` DISABLE KEYS */;
/*!40000 ALTER TABLE `guarantor_bank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guarantor_creadit_facility`
--

DROP TABLE IF EXISTS `guarantor_creadit_facility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guarantor_creadit_facility` (
  `id` int NOT NULL AUTO_INCREMENT,
  `institute` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `present_outstanding` double DEFAULT NULL,
  `guarantor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__guarantor` (`guarantor_id`),
  CONSTRAINT `FK__guarantor` FOREIGN KEY (`guarantor_id`) REFERENCES `guarantor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guarantor_creadit_facility`
--

LOCK TABLES `guarantor_creadit_facility` WRITE;
/*!40000 ALTER TABLE `guarantor_creadit_facility` DISABLE KEYS */;
/*!40000 ALTER TABLE `guarantor_creadit_facility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guarantor_property`
--

DROP TABLE IF EXISTS `guarantor_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guarantor_property` (
  `id` int NOT NULL AUTO_INCREMENT,
  `location` varchar(50) DEFAULT NULL,
  `extent` varchar(50) DEFAULT NULL,
  `approximate_value` double DEFAULT NULL,
  `mortgaged` varchar(50) DEFAULT NULL,
  `guarantor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_guarantor_property_guarantor` (`guarantor_id`),
  CONSTRAINT `FK_guarantor_property_guarantor` FOREIGN KEY (`guarantor_id`) REFERENCES `guarantor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guarantor_property`
--

LOCK TABLES `guarantor_property` WRITE;
/*!40000 ALTER TABLE `guarantor_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `guarantor_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guarantor_vehicle`
--

DROP TABLE IF EXISTS `guarantor_vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guarantor_vehicle` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guarantor_vehicle`
--

LOCK TABLES `guarantor_vehicle` WRITE;
/*!40000 ALTER TABLE `guarantor_vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `guarantor_vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurance_file`
--

DROP TABLE IF EXISTS `insurance_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `insurance_file` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurance_file`
--

LOCK TABLES `insurance_file` WRITE;
/*!40000 ALTER TABLE `insurance_file` DISABLE KEYS */;
INSERT INTO `insurance_file` VALUES (6,'3381',6,1,'2024-08-27 07:20:43','2024-08-27 07:20:43'),(8,'3383/08/30/24',7,2,'2024-08-30 10:26:05','2024-08-30 10:26:05');
/*!40000 ALTER TABLE `insurance_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurance_file_status`
--

DROP TABLE IF EXISTS `insurance_file_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `insurance_file_status` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurance_file_status`
--

LOCK TABLES `insurance_file_status` WRITE;
/*!40000 ALTER TABLE `insurance_file_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `insurance_file_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leaves`
--

DROP TABLE IF EXISTS `leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leaves` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `days` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leaves`
--

LOCK TABLES `leaves` WRITE;
/*!40000 ALTER TABLE `leaves` DISABLE KEYS */;
INSERT INTO `leaves` VALUES (1,'Sik Leaves',7),(2,'Casual Leaves',7),(3,'Vacation Leaves',14);
/*!40000 ALTER TABLE `leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'Pending'),(2,'Approved');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(50) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `name_with_initial` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(10) DEFAULT NULL,
  `nic` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'SA 0001','ihara thathsara','W.G.Ihara Thathsara','iharathathsara31@gmail.com','0763947527','12345678','$2y$10$q9/Zim9AbZmdoTvMqk6nNOM90uDByD2nGES8EW30FmFEuvi5U..jK','\"Seth Sisila\", Kaduruduwa, Wanchawala, Galle',1,1,'2024-08-13 10:04:21','2024-08-17 12:28:26'),(4,'SA 0002','Dandunnage Manila Chamara','D.M Chamara','manilachamara@yahoo.com','0718886130','862200110V','$2y$10$/WFU3W2/SJDKWms0JzPEyO27MuNX.3R.naWzZNxDzI6f1p2gYcwH6','No 29,Southern pride,kaduruduwa ,Galle',1,1,'2024-08-20 07:37:04','2024-08-20 07:37:04'),(6,'EMP 0001','Nanayakkara Halloluwage Maheshi Udarashmi','N.H Maheshi Udarashmi','maheshiudarashminanayakkara@gmail.com','0713459260','997253574V','$2y$10$hAq8Y26enRFafmCnFyWlDOiyj2XxasmVLf5xEXBfPmCz.b2/v9ZBK','No 53/G paranawaththa hena akurugoda sulthanagoda',4,1,'2024-08-21 05:45:02','2024-08-21 05:45:02'),(7,'H/4865 /19','Hewa Maddumage kasun Nadeesha','H M K Nadeesha ','knadeesha88@gmail.com','0773504355','198808402480','$2y$10$6ctQsq9FUBApLhN5l76/juMznRtKS0oPDkTVS.b9Aqq/x/aPEwDUy','No10 uyanwatta, matara',3,1,'2024-08-21 06:03:08','2024-08-21 06:03:48'),(8,'D 002','Aruma thanthirige Dayapala','A.T Dayapala ','atdayapala@gmail.com','0777416687','413361974V','$2y$10$5zXx0Qonb5s52UBWWBC/U.ivFYRKfu1uA0cBF.IWfJXRJcElJH5qC','No 528, Pelana, Weligama',2,1,'2024-08-27 06:11:03','2024-08-27 06:23:42');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_has_leaves`
--

DROP TABLE IF EXISTS `user_has_leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_has_leaves` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_has_leaves`
--

LOCK TABLES `user_has_leaves` WRITE;
/*!40000 ALTER TABLE `user_has_leaves` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_has_leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_status`
--

LOCK TABLES `user_status` WRITE;
/*!40000 ALTER TABLE `user_status` DISABLE KEYS */;
INSERT INTO `user_status` VALUES (1,'Active'),(2,'Inactive');
/*!40000 ALTER TABLE `user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_title`
--

DROP TABLE IF EXISTS `user_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_title` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_title`
--

LOCK TABLES `user_title` WRITE;
/*!40000 ALTER TABLE `user_title` DISABLE KEYS */;
INSERT INTO `user_title` VALUES (1,'Mr.'),(2,'Mrs.'),(3,'Miss.'),(4,'Other');
/*!40000 ALTER TABLE `user_title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_type`
--

LOCK TABLES `user_type` WRITE;
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` VALUES (1,'Super Admin'),(2,'Director'),(3,'Manager'),(4,'Back Officer'),(5,'Cashier');
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle`
--

LOCK TABLES `vehicle` WRITE;
/*!40000 ALTER TABLE `vehicle` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_accessory_status`
--

DROP TABLE IF EXISTS `vehicle_accessory_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_accessory_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_accessory_status`
--

LOCK TABLES `vehicle_accessory_status` WRITE;
/*!40000 ALTER TABLE `vehicle_accessory_status` DISABLE KEYS */;
INSERT INTO `vehicle_accessory_status` VALUES (1,'Very Good'),(2,'Good'),(3,'Fair'),(4,'Poor');
/*!40000 ALTER TABLE `vehicle_accessory_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_body_type`
--

DROP TABLE IF EXISTS `vehicle_body_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_body_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_body_type`
--

LOCK TABLES `vehicle_body_type` WRITE;
/*!40000 ALTER TABLE `vehicle_body_type` DISABLE KEYS */;
INSERT INTO `vehicle_body_type` VALUES (1,'Open Body'),(2,'Full Closed'),(3,'Flat Bed'),(4,'Freezer');
/*!40000 ALTER TABLE `vehicle_body_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_has_factory_fitted_accessory`
--

DROP TABLE IF EXISTS `vehicle_has_factory_fitted_accessory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_has_factory_fitted_accessory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int DEFAULT NULL,
  `factory_fitted_accessory_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vehicle_has_factory_fitted_accessory_vehicle` (`vehicle_id`),
  KEY `FK_vehicle_has_factory_fitted_accessory_factory_fitted_accessory` (`factory_fitted_accessory_id`),
  CONSTRAINT `FK_vehicle_has_factory_fitted_accessory_factory_fitted_accessory` FOREIGN KEY (`factory_fitted_accessory_id`) REFERENCES `factory_fitted_accessory` (`id`),
  CONSTRAINT `FK_vehicle_has_factory_fitted_accessory_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_has_factory_fitted_accessory`
--

LOCK TABLES `vehicle_has_factory_fitted_accessory` WRITE;
/*!40000 ALTER TABLE `vehicle_has_factory_fitted_accessory` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_has_factory_fitted_accessory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_type`
--

DROP TABLE IF EXISTS `vehicle_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_type`
--

LOCK TABLES `vehicle_type` WRITE;
/*!40000 ALTER TABLE `vehicle_type` DISABLE KEYS */;
INSERT INTO `vehicle_type` VALUES (1,'Motor Cycle'),(2,'Motor Trycycle'),(3,'Motor Car');
/*!40000 ALTER TABLE `vehicle_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_type_has_tyre`
--

DROP TABLE IF EXISTS `vehicle_type_has_tyre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_type_has_tyre` (
  `id` int NOT NULL DEFAULT '0',
  `vehicle_type_id` int DEFAULT NULL,
  `vehicle_tyre_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vehicle_type_has_tyre_vehicle_type` (`vehicle_type_id`),
  KEY `FK_vehicle_type_has_tyre_vehicle_tyre` (`vehicle_tyre_id`),
  CONSTRAINT `FK_vehicle_type_has_tyre_vehicle_type` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_type` (`id`),
  CONSTRAINT `FK_vehicle_type_has_tyre_vehicle_tyre` FOREIGN KEY (`vehicle_tyre_id`) REFERENCES `vehicle_tyre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_type_has_tyre`
--

LOCK TABLES `vehicle_type_has_tyre` WRITE;
/*!40000 ALTER TABLE `vehicle_type_has_tyre` DISABLE KEYS */;
INSERT INTO `vehicle_type_has_tyre` VALUES (1,1,1),(2,1,2),(3,2,1),(4,2,5),(5,2,6),(6,3,3),(7,3,4),(8,3,5),(9,3,6);
/*!40000 ALTER TABLE `vehicle_type_has_tyre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_tyre`
--

DROP TABLE IF EXISTS `vehicle_tyre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_tyre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_tyre`
--

LOCK TABLES `vehicle_tyre` WRITE;
/*!40000 ALTER TABLE `vehicle_tyre` DISABLE KEYS */;
INSERT INTO `vehicle_tyre` VALUES (1,'Front Tyre'),(2,'Rear Tyre'),(3,'Front Right Tyre'),(4,'Front Left Tyre'),(5,'Rear Right Tyre'),(6,'Rear Left Tyre');
/*!40000 ALTER TABLE `vehicle_tyre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_tyre_status`
--

DROP TABLE IF EXISTS `vehicle_tyre_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_tyre_status` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_tyre_status`
--

LOCK TABLES `vehicle_tyre_status` WRITE;
/*!40000 ALTER TABLE `vehicle_tyre_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_tyre_status` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-31 12:35:54
