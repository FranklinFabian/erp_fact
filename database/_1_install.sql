-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: 181.188.168.179    Database: db_sales
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acc_coa`
--

DROP TABLE IF EXISTS `acc_coa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acc_coa` (
  `HeadCode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HeadName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `PHeadName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `HeadLevel` int(11) NOT NULL,
  `IsActive` tinyint(1) NOT NULL,
  `IsTransaction` tinyint(1) NOT NULL,
  `IsGL` tinyint(1) NOT NULL,
  `HeadType` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `IsBudget` tinyint(1) NOT NULL,
  `IsDepreciation` tinyint(1) NOT NULL,
  `DepreciationRate` decimal(18,2) NOT NULL,
  `CreateBy` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CreateDate` datetime NOT NULL,
  `UpdateBy` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `UpdateDate` datetime NOT NULL,
  PRIMARY KEY (`HeadName`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acc_coa`
--

LOCK TABLES `acc_coa` WRITE;
/*!40000 ALTER TABLE `acc_coa` DISABLE KEYS */;
INSERT INTO `acc_coa` VALUES ('502000006','0-','Account Payable',3,1,1,0,'L',0,0,0.00,'1','2019-12-19 11:39:48','','0000-00-00 00:00:00'),('102030000001','1-Walking Customer','Customer Receivable',4,1,1,0,'A',0,0,0.00,'1','2019-11-16 08:44:42','','0000-00-00 00:00:00'),('50202','Account Payable','Current Liabilities',2,1,0,1,'L',0,0,0.00,'admin','2015-10-15 19:50:43','','2019-09-05 00:00:00'),('10203','Account Receivable','Current Asset',2,1,0,0,'A',0,0,0.00,'','2019-09-05 00:00:00','admin','2013-09-18 15:29:35'),('1','Assets','COA',0,1,0,0,'A',0,0,0.00,'','2019-09-05 00:00:00','','2019-09-05 00:00:00'),('10201','Cash & Cash Equivalent','Current Asset',2,1,0,1,'A',0,0,0.00,'1','2019-06-25 13:47:29','admin','2015-10-15 15:57:55'),('1020102','Cash At Bank','Cash & Cash Equivalent',3,1,0,1,'A',0,0,0.00,'1','2019-03-18 06:08:18','admin','2015-10-15 15:32:42'),('1020101','Cash In Hand','Cash & Cash Equivalent',3,1,1,0,'A',0,0,0.00,'1','2019-01-26 07:38:48','admin','2016-05-23 12:05:43'),('102','Current Asset','Assets',1,1,0,0,'A',0,0,0.00,'','2019-09-05 00:00:00','admin','2018-07-07 11:23:00'),('502','Current Liabilities','Liabilities',1,1,0,0,'L',0,0,0.00,'anwarul','2014-08-30 13:18:20','admin','2015-10-15 19:49:21'),('1020301','Customer Receivable','Account Receivable',3,1,0,1,'A',0,0,0.00,'1','2019-01-24 12:10:05','admin','2018-07-07 12:31:42'),('401','Default expense','Expence',1,1,1,0,'E',1,1,1.00,'1','2019-12-21 09:00:55','','0000-00-00 00:00:00'),('50204','Employee Ledger','Current Liabilities',2,1,0,1,'L',0,0,0.00,'1','2019-04-08 10:36:32','','2019-09-05 00:00:00'),('403','Employee Salary','Expence',1,1,1,0,'E',0,1,1.00,'1','2019-06-17 11:44:52','','2019-09-05 00:00:00'),('2','Equity','COA',0,1,0,0,'L',0,0,0.00,'','2019-09-05 00:00:00','','2019-09-05 00:00:00'),('4','Expence','COA',0,1,0,0,'E',0,0,0.00,'','2019-09-05 00:00:00','','2019-09-05 00:00:00'),('3','Income','COA',0,1,0,0,'I',0,0,0.00,'','2019-09-05 00:00:00','','2019-09-05 00:00:00'),('5','Liabilities','COA',0,1,0,0,'L',0,0,0.00,'admin','2013-07-04 12:32:07','admin','2015-10-15 19:46:54'),('1020302','Loan Receivable','Account Receivable',3,1,0,1,'A',0,0,0.00,'1','2019-01-26 07:37:20','','2019-09-05 00:00:00'),('101','Non Current Assets','Assets',1,1,0,0,'A',0,0,0.00,'','2019-09-05 00:00:00','admin','2015-10-15 15:29:11'),('501','Non Current Liabilities','Liabilities',1,1,0,0,'L',0,0,0.00,'anwarul','2014-08-30 13:18:20','admin','2015-10-15 19:49:21'),('402','Product Purchase','Expence',1,1,0,0,'E',0,0,0.00,'2','2018-07-07 14:00:16','admin','2015-10-15 18:37:42'),('303','Product Sale','Income',1,1,1,0,'I',0,0,0.00,'1','2019-06-17 08:22:42','','2019-09-05 00:00:00'),('304','Service Income','Income',1,1,1,0,'I',0,0,0.00,'1','2019-06-17 11:31:11','','2019-09-05 00:00:00');
/*!40000 ALTER TABLE `acc_coa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acc_transaction`
--

DROP TABLE IF EXISTS `acc_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acc_transaction` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `VNo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Vtype` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VDate` date DEFAULT NULL,
  `COAID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Narration` text COLLATE utf8_unicode_ci,
  `Debit` decimal(18,2) DEFAULT NULL,
  `Credit` decimal(18,2) DEFAULT NULL,
  `IsPosted` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreateBy` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateDate` datetime DEFAULT NULL,
  `IsAppove` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acc_transaction`
--

LOCK TABLES `acc_transaction` WRITE;
/*!40000 ALTER TABLE `acc_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `acc_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_setting`
--

DROP TABLE IF EXISTS `app_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `localhserver` varchar(250) DEFAULT NULL,
  `onlineserver` varchar(250) DEFAULT NULL,
  `hotspot` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_setting`
--

LOCK TABLES `app_setting` WRITE;
/*!40000 ALTER TABLE `app_setting` DISABLE KEYS */;
INSERT INTO `app_setting` VALUES (1,'https://192.168.1.153/saleserp_sas_v-2','https://saleserpnew.bdtask.com/saleserp_v9.3-demo','https://192.168.1.167/saleserp');
/*!40000 ALTER TABLE `app_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `att_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `sign_in` varchar(30) NOT NULL,
  `sign_out` varchar(30) NOT NULL,
  `staytime` varchar(30) NOT NULL,
  PRIMARY KEY (`att_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_add`
--

DROP TABLE IF EXISTS `bank_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bank_add` (
  `bank_id` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `ac_name` varchar(250) DEFAULT NULL,
  `ac_number` varchar(250) DEFAULT NULL,
  `branch` varchar(250) DEFAULT NULL,
  `signature_pic` varchar(250) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_add`
--

LOCK TABLES `bank_add` WRITE;
/*!40000 ALTER TABLE `bank_add` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_add` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_summary`
--

DROP TABLE IF EXISTS `bank_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bank_summary` (
  `bank_id` varchar(250) DEFAULT NULL,
  `description` text,
  `deposite_id` varchar(250) DEFAULT NULL,
  `date` varchar(250) DEFAULT NULL,
  `ac_type` varchar(50) DEFAULT NULL,
  `dr` float DEFAULT NULL,
  `cr` float DEFAULT NULL,
  `ammount` float DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_summary`
--

LOCK TABLES `bank_summary` WRITE;
/*!40000 ALTER TABLE `bank_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `bank_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_information`
--

DROP TABLE IF EXISTS `company_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_information` (
  `company_id` varchar(250) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `website` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_information`
--

LOCK TABLES `company_information` WRITE;
/*!40000 ALTER TABLE `company_information` DISABLE KEYS */;
INSERT INTO `company_information` VALUES ('1','Bdtask Ltd','bdtask@gmail.com','4th Floor Mannan Plaza,Khilkhet,Dhaka-1229','01852376598','httpss://www.bdtask.com/',1);
/*!40000 ALTER TABLE `company_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_tbl`
--

DROP TABLE IF EXISTS `currency_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currency_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(50) NOT NULL,
  `icon` text NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_tbl`
--

LOCK TABLES `currency_tbl` WRITE;
/*!40000 ALTER TABLE `currency_tbl` DISABLE KEYS */;
INSERT INTO `currency_tbl` VALUES (1,'Dollar','$'),(2,'BDT','à§³'),(3,'Bolivianos','Bs');
/*!40000 ALTER TABLE `currency_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_information`
--

DROP TABLE IF EXISTS `customer_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_information` (
  `customer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_mobile` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `status` int(2) NOT NULL COMMENT '1=paid,2=credit',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_information`
--

LOCK TABLES `customer_information` WRITE;
/*!40000 ALTER TABLE `customer_information` DISABLE KEYS */;
INSERT INTO `customer_information` VALUES (1,'Walking Customer','Default Customer','','',1,'2020-02-09 08:49:06','1');
/*!40000 ALTER TABLE `customer_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_ledger`
--

DROP TABLE IF EXISTS `customer_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_ledger` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(100) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `invoice_no` bigint(20) DEFAULT NULL,
  `receipt_no` varchar(50) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT '0.00',
  `description` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `date` varchar(250) DEFAULT NULL,
  `receipt_from` varchar(50) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `d_c` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_ledger`
--

LOCK TABLES `customer_ledger` WRITE;
/*!40000 ALTER TABLE `customer_ledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_banking_add`
--

DROP TABLE IF EXISTS `daily_banking_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `daily_banking_add` (
  `banking_id` varchar(255) NOT NULL,
  `date` datetime DEFAULT NULL,
  `bank_id` varchar(100) DEFAULT NULL,
  `deposit_type` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `description` text,
  `amount` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_banking_add`
--

LOCK TABLES `daily_banking_add` WRITE;
/*!40000 ALTER TABLE `daily_banking_add` DISABLE KEYS */;
/*!40000 ALTER TABLE `daily_banking_add` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_closing`
--

DROP TABLE IF EXISTS `daily_closing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `daily_closing` (
  `closing_id` varchar(255) NOT NULL,
  `last_day_closing` float NOT NULL,
  `cash_in` float NOT NULL,
  `cash_out` float NOT NULL,
  `date` varchar(250) NOT NULL,
  `amount` float NOT NULL,
  `adjustment` float DEFAULT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_closing`
--

LOCK TABLES `daily_closing` WRITE;
/*!40000 ALTER TABLE `daily_closing` DISABLE KEYS */;
/*!40000 ALTER TABLE `daily_closing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designation`
--

DROP TABLE IF EXISTS `designation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(150) NOT NULL,
  `details` text NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designation`
--

LOCK TABLES `designation` WRITE;
/*!40000 ALTER TABLE `designation` DISABLE KEYS */;
/*!40000 ALTER TABLE `designation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_config`
--

DROP TABLE IF EXISTS `email_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocol` text NOT NULL,
  `smtp_host` text NOT NULL,
  `smtp_port` text NOT NULL,
  `smtp_user` varchar(35) NOT NULL,
  `smtp_pass` varchar(35) NOT NULL,
  `mailtype` varchar(30) DEFAULT NULL,
  `isinvoice` tinyint(4) NOT NULL,
  `isservice` tinyint(4) NOT NULL,
  `isquotation` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_config`
--

LOCK TABLES `email_config` WRITE;
/*!40000 ALTER TABLE `email_config` DISABLE KEYS */;
INSERT INTO `email_config` VALUES (1,'ssmtp','ssl://ssmtp.gmail.com','25','demo@gmail.com','demo123456','html',0,0,0);
/*!40000 ALTER TABLE `email_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_history`
--

DROP TABLE IF EXISTS `employee_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `rate_type` int(11) NOT NULL,
  `hrate` float NOT NULL,
  `email` varchar(50) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `address_line_1` text NOT NULL,
  `address_line_2` text NOT NULL,
  `image` text,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_history`
--

LOCK TABLES `employee_history` WRITE;
/*!40000 ALTER TABLE `employee_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_salary_payment`
--

DROP TABLE IF EXISTS `employee_salary_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_salary_payment` (
  `emp_sal_pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `generate_id` int(11) NOT NULL,
  `employee_id` varchar(50) CHARACTER SET latin1 NOT NULL,
  `total_salary` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total_working_minutes` varchar(50) CHARACTER SET latin1 NOT NULL,
  `working_period` varchar(50) CHARACTER SET latin1 NOT NULL,
  `payment_due` varchar(50) CHARACTER SET latin1 NOT NULL,
  `payment_date` varchar(50) CHARACTER SET latin1 NOT NULL,
  `paid_by` varchar(50) CHARACTER SET latin1 NOT NULL,
  `salary_month` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`emp_sal_pay_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_salary_payment`
--

LOCK TABLES `employee_salary_payment` WRITE;
/*!40000 ALTER TABLE `employee_salary_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_salary_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_salary_setup`
--

DROP TABLE IF EXISTS `employee_salary_setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee_salary_setup` (
  `e_s_s_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `sal_type` varchar(30) NOT NULL,
  `salary_type_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `create_date` date DEFAULT NULL,
  `update_date` datetime(6) DEFAULT NULL,
  `update_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `gross_salary` float NOT NULL,
  PRIMARY KEY (`e_s_s_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_salary_setup`
--

LOCK TABLES `employee_salary_setup` WRITE;
/*!40000 ALTER TABLE `employee_salary_setup` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_salary_setup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `type` varchar(100) NOT NULL,
  `voucher_no` varchar(50) NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense`
--

LOCK TABLES `expense` WRITE;
/*!40000 ALTER TABLE `expense` DISABLE KEYS */;
/*!40000 ALTER TABLE `expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_item`
--

DROP TABLE IF EXISTS `expense_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_item_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_item`
--

LOCK TABLES `expense_item` WRITE;
/*!40000 ALTER TABLE `expense_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `expense_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `total_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `prevous_due` decimal(20,2) NOT NULL DEFAULT '0.00',
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice` bigint(20) NOT NULL,
  `invoice_discount` decimal(10,2) DEFAULT '0.00' COMMENT 'invoice discount',
  `total_discount` decimal(10,2) DEFAULT '0.00' COMMENT 'total invoice discount',
  `total_tax` decimal(10,2) DEFAULT '0.00',
  `sales_by` varchar(50) NOT NULL,
  `invoice_details` text NOT NULL,
  `status` int(2) NOT NULL,
  `bank_id` varchar(30) DEFAULT NULL,
  `payment_type` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_details_id` varchar(100) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `serial_no` varchar(30) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `supplier_rate` float DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `discount_per` varchar(15) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(12,0) DEFAULT NULL,
  `due_amount` decimal(10,2) DEFAULT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_details`
--

LOCK TABLES `invoice_details` WRITE;
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `language` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  `english` text,
  `spanish` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=877 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language`
--

LOCK TABLES `language` WRITE;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT INTO `language` VALUES (1,'user_profile','User Profile','Perfil del usuario'),(2,'setting','Setting','Ajuste'),(3,'language','Language','Idioma'),(4,'manage_users','Manage Users','Gestión de usuarios'),(5,'add_user','Add User','Agregar usuario'),(6,'manage_company','Manage Company','Manejo de la empresa'),(7,'web_settings','Software Settings','Configuración de software'),(8,'manage_accounts','Manage Accounts','Cuentas de administración'),(9,'create_accounts','Create Account','Crear una cuenta'),(10,'manage_bank','Manage Bank','de Bank'),(11,'add_new_bank','Add New Bank','Añadir nuevo banco'),(12,'settings','Settings','Ajustes'),(13,'closing_report','Closing Report',', informe de cierre'),(14,'closing','Closing','Clausura'),(15,'cheque_manager','Cheque Manager','Cheque del encargado'),(16,'accounts_summary','Accounts Summary','Resumen de cuentas'),(17,'expense','Expense','Gastos'),(18,'income','Income','Ingresos'),(19,'accounts','Accounts','Cuentas'),(20,'stock_report','Stock Report','Informe de la'),(21,'stock','Stock','Valores'),(22,'pos_invoice','POS Sale','Venta POS'),(23,'manage_invoice','Manage Sale','propietario de Sale'),(24,'new_invoice','New Sale','nuevo Venta'),(25,'invoice','Sale','Rebaja'),(26,'manage_purchase','Manage Purchase','Manejo de Compra'),(27,'add_purchase','Add Purchase','Añadir Compra'),(28,'purchase','Purchase','Compra'),(29,'paid_customer','Paid Customer','A cargo del cliente'),(30,'manage_customer','Manage Customer','Manejo de cliente'),(31,'add_customer','Add Customer','Agregar al cliente'),(32,'customer','Customer','Cliente'),(33,'supplier_payment_actual','Supplier Payment Ledger','Surtidor Pago Ledger'),(34,'supplier_sales_summary','Supplier Sales Summary','Resumen de ventas con proveedor'),(35,'supplier_sales_details','Supplier Sales Details','Detalles del Proveedor de ventas'),(36,'supplier_ledger','Supplier Ledger','Ledger proveedor'),(37,'manage_supplier','Manage Supplier','Manejo de proveedores'),(38,'add_supplier','Add Supplier','Agregar Proveedor'),(39,'supplier','Supplier','Proveedor'),(40,'product_statement','Product Statement','Declaración de producto'),(41,'manage_product','Manage Product','Manejo de Producto'),(42,'add_product','Add Product','Añadir Producto'),(43,'product','Product','Producto'),(44,'manage_category','Manage Category','gestionar categoría'),(45,'add_category','Add Category','añadir categoría'),(46,'category','Category','Categoría'),(47,'sales_report_product_wise','Sales Report (Product Wise)','Informe de ventas (Producto Wise)'),(48,'purchase_report','Purchase Report','Informe de compra'),(49,'sales_report','Sales Report','Reporte de ventas'),(50,'todays_report','Todays Report','Informe del día de hoy'),(51,'report','Report','Reporte'),(52,'dashboard','Dashboard','Tablero'),(53,'online','Online','En línea'),(54,'logout','Logout','Cerrar sesión'),(55,'change_password','Change Password','Cambia la contraseña'),(56,'total_purchase','Total Purchase','total Compra'),(57,'total_amount','Total Amount','Cantidad total'),(58,'supplier_name','Supplier Name','Nombre del proveedor'),(59,'invoice_no','Invoice No','Factura no'),(60,'purchase_date','Purchase Date','Fecha de compra'),(61,'todays_purchase_report','Todays Purchase Report','Informe del día de hoy de compra'),(62,'total_sales','Total Sales','Ventas totales'),(63,'customer_name','Customer Name','Nombre del cliente'),(64,'sales_date','Sales Date','Sales Fecha'),(65,'todays_sales_report','Todays Sales Report','Informe de ventas del día de hoy'),(66,'home','Home','Hogar'),(67,'todays_sales_and_purchase_report','Todays sales and purchase report','De hoy y el informe de ventas de compra'),(68,'total_ammount','Total Amount','Cantidad total'),(69,'rate','Rate','Velocidad'),(70,'product_model','Product Model','Modelo del Producto'),(71,'product_name','Product Name','nombre del producto'),(72,'search','Search','Buscar'),(73,'end_date','End Date','Fecha final'),(74,'start_date','Start Date','Fecha de inicio'),(75,'total_purchase_report','Total Purchase Report','Informe total de compra'),(76,'total_sales_report','Total Sales Report','Informe de ventas totales'),(77,'total_seles','Total Sales','Ventas totales'),(78,'all_stock_report','All Stock Report','Todo de Informe'),(79,'search_by_product','Search By Product','Búsqueda por Producto'),(80,'date','Date','Fecha'),(81,'print','Print','Impresión'),(82,'stock_date','Stock Date','Ce la Fecha'),(83,'print_date','Print Date','Fecha de impresion'),(84,'sales','Sales','Ventas'),(85,'price','Price','Precio'),(86,'sl','SL.','SL.'),(87,'add_new_category','Add new category','Añadir nueva categoria'),(88,'category_name','Category Name','nombre de la categoría'),(89,'save','Save','Salvar'),(90,'delete','Delete','Eliminar'),(91,'update','Update','Actualizar'),(92,'action','Action','Acción'),(93,'manage_your_category','Manage your category ','Administrar su categoría'),(94,'category_edit','Category Edit','Editar la categoría'),(95,'status','Status','Estado'),(96,'active','Active','Activo'),(97,'inactive','Inactive','Inactivo'),(98,'save_changes','Save Changes','Guardar cambios'),(99,'save_and_add_another','Save And Add Another','Guardar y añadir otro'),(100,'model','Model','Modelo'),(101,'supplier_price','Supplier Price','Precio con proveedor'),(102,'sell_price','Sale Price','Precio de venta'),(103,'image','Image','Imagen'),(104,'select_one','Select One','Seleccione uno'),(105,'details','Details','detalles'),(106,'new_product','New Product','Nuevo producto'),(107,'add_new_product','Add new product','Agregar nuevo producto'),(108,'barcode','Barcode','Código de barras'),(109,'qr_code','Qr-Code','Código QR'),(110,'product_details','Product Details','Detalles de producto'),(111,'manage_your_product','Manage your product','Manejo de su producto'),(112,'product_edit','Product Edit','Editar producto'),(113,'edit_your_product','Edit your product','Editar su producto'),(114,'cancel','Cancel','Cancelar'),(115,'incl_vat','Incl. Vat','Incl. IVA'),(116,'money','TK','TK'),(117,'grand_total','Grand Total','Gran total'),(118,'quantity','Qnty','Qnty'),(119,'product_report','Product Report','Informe producto'),(120,'product_sales_and_purchase_report','Product sales and purchase report','Las ventas de productos y el informe de la compra'),(121,'previous_stock','Previous Stock','Anterior de la'),(122,'out','Out','Fuera'),(123,'in','In','En'),(124,'to','To','A'),(125,'previous_balance','Previous Credit Balance','Anterior balance de crédito'),(126,'customer_address','Customer Address','Dirección del cliente'),(127,'customer_mobile','Customer Mobile','Cliente móvil'),(128,'customer_email','Customer Email','Correo electrónico del cliente'),(129,'add_new_customer','Add new customer','Añadir nuevo cliente'),(130,'balance','Balance','Equilibrar'),(131,'mobile','Mobile','Móvil'),(132,'address','Address','Habla a'),(133,'manage_your_customer','Manage your customer','Manejo de su cliente'),(134,'customer_edit','Customer Edit','Editar cliente'),(135,'paid_customer_list','Paid Customer List','Lista de clientes pagados'),(136,'ammount','Amount','Cantidad'),(137,'customer_ledger','Customer Ledger','Ledger cliente'),(138,'manage_customer_ledger','Manage Customer Ledger','Manejo de Ledger al cliente'),(139,'customer_information','Customer Information','Información al cliente'),(140,'debit_ammount','Debit Amount','Cantidad de débito'),(141,'credit_ammount','Credit Amount','Monto de crédito'),(142,'balance_ammount','Balance Amount','Balance total'),(143,'receipt_no','Receipt NO','recibo NO'),(144,'description','Description','Descripción'),(145,'debit','Debit','Débito'),(146,'credit','Credit','Crédito'),(147,'item_information','Item Information','Información del artículo'),(148,'total','Total','Total'),(149,'please_select_supplier','Please Select Supplier','Por favor seleccione Proveedor'),(150,'submit','Submit','Enviar'),(151,'submit_and_add_another','Submit And Add Another One','Enviar y añadir otro'),(152,'add_new_item','Add New Item','Agregar ítem nuevo'),(153,'manage_your_purchase','Manage your purchase','Gestionar su compra'),(154,'purchase_edit','Purchase Edit','compra Editar'),(155,'purchase_ledger','Purchase Ledger','Libro mayor de compra'),(156,'invoice_information','Sale Information','Información de venta'),(157,'paid_ammount','Paid Amount','Monto de pago'),(158,'discount','Dis./Pcs.','Dis./Pcs.'),(159,'save_and_paid','Save And Paid','Guardar y pagado'),(160,'payee_name','Payee Name','Nombre del beneficiario'),(161,'manage_your_invoice','Manage your Sale','Gestionar su venta'),(162,'invoice_edit','Sale Edit','Editar la venta'),(163,'new_pos_invoice','New POS Sale','Nuevo punto de venta Venta'),(164,'add_new_pos_invoice','Add new pos Sale','Añadir nueva pos venta'),(165,'product_id','Product ID','identificación de producto'),(166,'paid_amount','Paid Amount','Monto de pago'),(167,'authorised_by','Authorised By','Autorizado por'),(168,'checked_by','Checked By','Revisado por'),(169,'received_by','Received By','Recibido por'),(170,'prepared_by','Prepared By','Preparado por'),(171,'memo_no','Memo No','Memo no'),(172,'website','Website','Sitio web'),(173,'email','Email','Email'),(174,'invoice_details','Sale Details','Detalles de venta'),(175,'reset','Reset','Reiniciar'),(176,'payment_account','Payment Account','Cuenta de pago'),(177,'bank_name','Bank Name','Nombre del banco'),(178,'cheque_or_pay_order_no','Cheque/Pay Order No','Compruebe / Pago de orden'),(179,'payment_type','Payment Type','Tipo de pago'),(180,'payment_from','Payment From','Pago de'),(181,'payment_date','Payment Date','Fecha de pago'),(182,'add_income','Add Income','Añadir Ingresos'),(183,'cash','Cash','Efectivo'),(184,'cheque','Cheque','Cheque'),(185,'pay_order','Pay Order','Orden de pago'),(186,'payment_to','Payment To','Pago Para'),(187,'total_outflow_ammount','Total Expense Amount','La cantidad total de gastos'),(188,'transections','Transections','transección'),(189,'accounts_name','Accounts Name','Nombre cuentas'),(190,'outflow_report','Expense Report','Informe de gastos'),(191,'inflow_report','Income Report','Informe de ingresos'),(192,'all','All','Todos'),(193,'account','Account','Cuenta'),(194,'from','From','Desde'),(195,'account_summary_report','Account Summary Report','Informe de resumen de cuenta'),(196,'search_by_date','Search By Date','Buscar por fecha'),(197,'cheque_no','Cheque No','No se compruebe'),(198,'name','Name','Nombre'),(199,'closing_account','Closing Account','cuenta cerrando'),(200,'close_your_account','Close your account','Cerrar su cuenta'),(201,'last_day_closing','Last Day Closing','Cierre Último día'),(202,'cash_in','Cash In','Dinero en efectivo en'),(203,'cash_out','Cash Out','Reintegro'),(204,'cash_in_hand','Cash In Hand','Dinero en efectivo'),(205,'add_new_bank','Add New Bank','Añadir nuevo banco'),(206,'day_closing','Day Closing','día de cierre'),(207,'account_closing_report','Account Closing Report','Cuenta, informe de cierre'),(208,'last_day_ammount','Last Day Amount','Último día Cantidad'),(209,'adjustment','Adjustment','Ajustamiento'),(210,'pay_type','Pay Type','Tipo de pago'),(211,'customer_or_supplier','Customer,Supplier Or Others','Cliente, proveedor o Otros'),(212,'transection_id','Transections ID','transección ID'),(213,'accounts_summary_report','Accounts Summary Report','Cuentas Informe resumido'),(214,'bank_list','Bank List','Lista de bancos'),(215,'bank_edit','Bank Edit','Banco Editar'),(216,'debit_plus','Debit (+)','Débito (+)'),(217,'credit_minus','Credit (-)','Crédito (-)'),(218,'account_name','Account Name','Nombre de la cuenta'),(219,'account_type','Account Type','Tipo de cuenta'),(220,'account_real_name','Account Real Name','Cuenta Nombre real'),(221,'manage_account','Manage Account','Administrar cuenta'),(222,'company_name','Niha International','Niha Internacional'),(223,'edit_your_company_information','Edit your company information','Editar su información de la compañía'),(224,'company_edit','Company Edit','la empresa Other'),(225,'admin','Admin','Administración'),(226,'user','User','Usuario'),(227,'password','Password','Contraseña'),(228,'last_name','Last Name','Apellido'),(229,'first_name','First Name','Nombre de pila'),(230,'add_new_user_information','Add new user information','Añadir nueva información de usuario'),(231,'user_type','User Type','Tipo de usuario'),(232,'user_edit','User Edit','Editar usuario'),(233,'rtr','RTR','RTR'),(234,'ltr','LTR','LTR'),(235,'ltr_or_rtr','LTR/RTR','LTR / RTR'),(236,'footer_text','Footer Text','Texto de pie de página'),(237,'favicon','Favicon','favicon'),(238,'logo','Logo','Logo'),(239,'update_setting','Update Setting','Ajuste de actualización'),(240,'update_your_web_setting','Update your web setting','Actualizar la configuración de Web'),(241,'login','Login','Iniciar sesión'),(242,'your_strong_password','Your strong password','Su contraseña segura'),(243,'your_unique_email','Your unique email','Su correo electrónico única'),(244,'please_enter_your_login_information','Please enter your login information.','Por favor, introduzca su información de registro.'),(245,'update_profile','Update Profile','Actualización del perfil'),(246,'your_profile','Your Profile','Tu perfil'),(247,'re_type_password','Re-Type Password','Vuelva a escribir la contraseña'),(248,'new_password','New Password','Nueva contraseña'),(249,'old_password','Old Password','Contraseña anterior'),(250,'new_information','New Information','Nueva información'),(251,'old_information','Old Information','Información de edad'),(252,'change_your_information','Change your information','Cambiar su información'),(253,'change_your_profile','Change your profile','Cambiar el perfil'),(254,'profile','Profile','Perfil'),(255,'wrong_username_or_password','Wrong User Name Or Password !','Nombre de usuario o contraseña incorrectos !'),(256,'successfully_updated','Successfully Updated.','Actualizado exitosamente.'),(257,'blank_field_does_not_accept','Blank Field Does Not Accept !','El campo en blanco no acepta!'),(258,'successfully_changed_password','Successfully changed password.','Se ha cambiado correctamente la contraseña.'),(259,'you_are_not_authorised_person','You are not authorised person !','No está autorizado persona!'),(260,'password_and_repassword_does_not_match','Passwor and re-password does not match !','Passwor y volver a la contraseña no coincide!'),(261,'new_password_at_least_six_character','New Password At Least 6 Character.','Nueva contraseña de al menos 6 caracteres.'),(262,'you_put_wrong_email_address','You put wrong email address !','Pones dirección de correo electrónico equivocada!'),(263,'cheque_ammount_asjusted','Cheque amount adjusted.','Comprobar la cantidad se ajusta.'),(264,'successfully_payment_paid','Successfully Payment Paid.','Éxito del pago pagado.'),(265,'successfully_added','Successfully Added.','Agregado exitosamente.'),(266,'successfully_updated_2_closing_ammount_not_changeale','Successfully Updated -2. Note: Closing Amount Not Changeable.','Actualizado con éxito -2. Nota: Cierre cantidad que no modificable.'),(267,'successfully_payment_received','Successfully Payment Received.','Con éxito el pago recibido.'),(268,'already_inserted','Already Inserted !','Ya insertada!'),(269,'successfully_delete','Successfully Delete.','Eliminar éxito.'),(270,'successfully_created','Successfully Created.','Creado con éxito.'),(271,'logo_not_uploaded','Logo not uploaded !','Logo no ha subido!'),(272,'favicon_not_uploaded','Favicon not uploaded !','Favicon no ha subido!'),(273,'supplier_mobile','Supplier Mobile','proveedor móvil'),(274,'supplier_address','Supplier Address','Dirección proveedor'),(275,'supplier_details','Supplier Details','proveedor Detalles'),(276,'add_new_supplier','Add New Supplier','Agregar nuevo Proveedor'),(277,'manage_suppiler','Manage Supplier','Manejo de proveedores'),(278,'manage_your_supplier','Manage your supplier','Administrar su proveedor'),(279,'manage_supplier_ledger','Manage supplier ledger','Administrar libro mayor proveedor'),(280,'invoice_id','Invoice ID','ID de factura'),(281,'deposite_id','Deposite ID','deposit ID'),(282,'supplier_actual_ledger','Supplier Payment Ledger','Surtidor Pago Ledger'),(283,'supplier_information','Supplier Information','Información del proveedor'),(284,'event','Event','Evento'),(285,'add_new_income','Add New Income','Añadir nuevos ingresos'),(286,'add_expese','Add Expense','Agregar Gasto'),(287,'add_new_expense','Add New Expense','Añadir nuevo gasto'),(288,'total_inflow_ammount','Total Income Amount','Monto total de los ingresos'),(289,'create_new_invoice','Create New Sale','Crear nueva venta'),(290,'create_pos_invoice','Create POS Sale','Crear POS Venta'),(291,'total_profit','Total Profit','Beneficio total'),(292,'monthly_progress_report','Monthly Progress Report','Reporte de progreso mensual'),(293,'total_invoice','Total Sale','Venta total'),(294,'account_summary','Account Summary','Resumen de la cuenta'),(295,'total_supplier','Total Supplier','Proveedor total'),(296,'total_product','Total Product','Producto total'),(297,'total_customer','Total Customer','total del cliente'),(298,'supplier_edit','Supplier Edit','Editar proveedor'),(299,'add_new_invoice','Add New Sale','Añadir nueva venta'),(300,'add_new_purchase','Add new purchase','Añadir nueva compra'),(301,'currency','Currency','Moneda'),(302,'currency_position','Currency Position','Posición de divisas'),(303,'left','Left','Izquierda'),(304,'right','Right','Derecho'),(305,'add_tax','Add Tax','Añadir Tributaria'),(306,'manage_tax','Manage Tax','Manejo de Impuestos'),(307,'add_new_tax','Add new tax','Añadir nuevo impuesto'),(308,'enter_tax','Enter Tax','introducir impuestos'),(309,'already_exists','Already Exists !','Ya existe !'),(310,'successfully_inserted','Successfully Inserted.','Insertado éxito.'),(311,'tax','Tax','Impuesto'),(312,'tax_edit','Tax Edit','Editar impuestos'),(313,'product_not_added','Product not added !','El producto no ha añadido!'),(314,'total_tax','Total Tax','Total impuestos'),(315,'manage_your_supplier_details','Manage your supplier details.','Manejo de los datos de su proveedor.'),(316,'invoice_description','Lorem Ipsum is sim ply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is sim ply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy','Lorem Ipsum es ply sim maniquí Lorem Ipsum es simplemente maniquí Lorem Ipsum es simplemente maniquí Lorem Ipsum es simplemente maniquí Lorem Ipsum es simplemente maniquí Lorem Ipsum es ply sim maniquí Lorem Ipsum es simplemente maniquí Lorem Ipsum es simplemente maniquí Lorem Ipsum es simplemente maniquí Lorem Ipsum es simplemente ficticio'),(317,'thank_you_for_choosing_us','Thank you very much for choosing us.','Muchas gracias por su preferencia.'),(318,'billing_date','Billing Date','Fecha de facturación'),(319,'billing_to','Billing To','Facturación a'),(320,'billing_from','Billing From','A partir de la facturación'),(321,'you_cant_delete_this_product','Sorry !!  You can\'t delete this product.This product already used in calculation system!','Lo siento !! No se puede eliminar este producto producto.Este ya utilizado en el sistema de cálculo!'),(322,'old_customer','Old Customer','viejo cliente'),(323,'new_customer','New Customer','Nuevo cliente'),(324,'new_supplier','New Supplier','Nuevo proveedor'),(325,'old_supplier','Old Supplier','Proveedor de edad'),(326,'credit_customer','Credit Customer','El crédito a clientes'),(327,'account_already_exists','This Account Already Exists !','Esta cuenta ya existe !'),(328,'edit_income','Edit Income','Editar Ingresos'),(329,'you_are_not_access_this_part','You are not authorised person !','No está autorizado persona!'),(330,'account_edit','Account Edit','Editar cuenta'),(331,'due','Due','Debido'),(332,'expense_edit','Expense Edit','gasto Editar'),(333,'please_select_customer','Please select customer !','Por favor, seleccione al cliente!'),(334,'profit_report','Profit Report (Sale Wise)','Informe beneficio (Venta Wise)'),(335,'total_profit_report','Total profit report','Informe del total de ganancias'),(336,'please_enter_valid_captcha','Please enter valid captcha.','Por favor, introduzca código de imagen válida.'),(337,'category_not_selected','Category not selected.','Categoría no seleccionado.'),(338,'supplier_not_selected','Supplier not selected.','El proveedor no seleccionado.'),(339,'please_select_product','Please select product.','Por favor seleccione su producto.'),(340,'product_model_already_exist','Product model already exist !','Modelo del producto ya existe!'),(341,'invoice_logo','Sale Logo','Logo'),(342,'available_qnty','Av. Qnty.','AV. Qnty.'),(343,'you_can_not_buy_greater_than_available_cartoon','You can not select grater than available cartoon !','No se puede seleccionar rallador de dibujos animados disponible!'),(344,'customer_details','Customer details','Detalles del cliente'),(345,'manage_customer_details','Manage customer details.','Manejo de los datos del cliente.'),(346,'site_key','Captcha Site Key','Captcha Site Key'),(347,'secret_key','Captcha Secret Key','Captcha clave secreta'),(348,'captcha','Captcha','Captcha'),(349,'cartoon_quantity','Cartoon Quantity','Cantidad de dibujos animados'),(350,'total_cartoon','Total Cartoon','dibujos animados total'),(351,'cartoon','Cartoon','Dibujos animados'),(352,'item_cartoon','Item/Cartoon','Artículo / de dibujos animados'),(353,'product_and_supplier_did_not_match','Product and supplier did not match !','Producto y el distribuidor no se correspondían!'),(354,'if_you_update_purchase_first_select_supplier_then_product_and_then_quantity','If you update purchase,first select supplier then product and then update qnty.','Si actualiza compra, primero seleccione a continuación proveedor de productos y actualización qnty.'),(355,'item','Item','Articulo'),(356,'manage_your_credit_customer','Manage your credit customer','Administrar su crédito cliente'),(357,'total_quantity','Total Quantity','Cantidad total'),(358,'quantity_per_cartoon','Quantity per cartoon','Cantidad por dibujos animados'),(359,'barcode_qrcode_scan_here','Barcode or QR-code scan here','Código de barras o código QR de Análisis Aquí'),(360,'synchronizer_setting','Synchronizer Setting','Ajuste del sincronizador'),(361,'data_synchronizer','Data Synchronizer','sincronizador de datos'),(362,'hostname','Host name','nombre de host'),(363,'username','User Name','Nombre de usuario'),(364,'ftp_port','FTP Port','Puerto FTP'),(365,'ftp_debug','FTP Debug','FTP depuración'),(366,'project_root','Project Root','raíz del proyecto'),(367,'please_try_again','Please try again','Inténtalo de nuevo'),(368,'save_successfully','Save successfully','Guardar éxito'),(369,'synchronize','Synchronize','Sincronizar'),(370,'internet_connection','Internet Connection','Conexión a Internet'),(371,'outgoing_file','Outgoing File','archivo saliente'),(372,'incoming_file','Incoming File','Archivo de entrada'),(373,'ok','Ok','Okay'),(374,'not_available','Not Available','No disponible'),(375,'available','Available','Disponible'),(376,'download_data_from_server','Download data from server','descargar datos desde un servidor'),(377,'data_import_to_database','Data import to database','importación de datos a la base de datos'),(378,'data_upload_to_server','Data uplod to server','Datos uplod al servidor'),(379,'please_wait','Please Wait','Por favor espera'),(380,'ooops_something_went_wrong','Oooops Something went wrong !','Oooops Algo salió mal!'),(381,'upload_successfully','Upload successfully','Sube éxito'),(382,'unable_to_upload_file_please_check_configuration','Unable to upload file please check configuration','No se puede subir por favor configuración de comprobación del archivo'),(383,'please_configure_synchronizer_settings','Please configure synchronizer settings','Por favor ajustes de configuración del sincronizador'),(384,'download_successfully','Download successfully','descargar correctamente'),(385,'unable_to_download_file_please_check_configuration','Unable to download file please check configuration','No se ha podido comprobar configuración favor de descarga de archivos'),(386,'data_import_first','Data import past','Los datos del pasado importación'),(387,'data_import_successfully','Data import successfully','Importación de datos de éxito'),(388,'unable_to_import_data_please_check_config_or_sql_file','Unable to import data please check config or sql file','No es posible importar datos de configuración complacer cheque o archivo sql'),(389,'total_sale_ctn','Total Sale Ctn','Venta total CTN'),(390,'in_qnty','In Qnty.','En Qnty.'),(391,'out_qnty','Out Qnty.','Qnty a cabo.'),(392,'stock_report_supplier_wise','Stock Report (Supplier Wise)','Informe de la (Proveedor Wise)'),(393,'all_stock_report_supplier_wise','Stock Report (Suppler Wise)','Informe de la (Suppler Wise)'),(394,'select_supplier','Select Supplier','Seleccione Proveedor'),(395,'stock_report_product_wise','Stock Report (Product Wise)','Informe de la (Producto Wise)'),(396,'phone','Phone','Teléfono'),(397,'select_product','Select Product','Seleccionar producto'),(398,'in_quantity','In Qnty.','En Qnty.'),(399,'out_quantity','Out Qnty.','Qnty a cabo.'),(400,'in_taka','In TK.','En TK.'),(401,'out_taka','Out TK.','TK cabo.'),(402,'commission','Commission','Comisión'),(403,'generate_commission','Generate Commssion','generar commssion'),(404,'commission_rate','Commission Rate','Porcentaje de comision'),(405,'total_ctn','Total Ctn.','CTN total.'),(406,'per_pcs_commission','Per PCS Commission','Comisión por PCS'),(407,'total_commission','Total Commission','total Comisión'),(408,'enter','Enter','Entrar'),(409,'please_add_walking_customer_for_default_customer','Please add \'Walking Customer\' for default customer.','Por favor, añada \'Cliente Caminar\' para el cliente por defecto.'),(410,'supplier_ammount','Supplier Amount','Monto proveedor'),(411,'my_sale_ammount','My Sale Amount','Mi Importe ventas'),(412,'signature_pic','Signature Picture','firma Imagen'),(413,'branch','Branch','Rama'),(414,'ac_no','A/C Number','A Número / C'),(415,'ac_name','A/C Name','A / C Nombre'),(416,'bank_transaction','Bank Transaction','Transacción bancaria'),(417,'bank','Bank','Banco'),(418,'withdraw_deposite_id','Withdraw / Deposite ID','Retirar / deposite ID'),(419,'bank_ledger','Bank Ledger','Banco Ledger'),(420,'note_name','Note Name','nota Nombre'),(421,'pcs','Pcs.','Pcs.'),(422,'1','1','1'),(423,'2','2','2'),(424,'5','5','5'),(425,'10','10','10'),(426,'20','20','20'),(427,'50','50','50'),(428,'100','100','100'),(429,'500','500','500'),(430,'1000','1000','1000'),(431,'total_discount','Total Discount','Descuento total'),(432,'product_not_found','Product not found !','Producto no encontrado !'),(433,'this_is_not_credit_customer','This is not credit customer !','Esto no es cliente de crédito!'),(434,'personal_loan','Personal Loan','Préstamo personal'),(435,'add_person','Add Person','Agregar persona'),(436,'add_loan','Add Loan','Añadir Préstamo'),(437,'add_payment','Add Payment','Agregar Pago'),(438,'manage_person','Manage Person','Manejo persona'),(439,'personal_edit','Person Edit','Editar persona'),(440,'person_ledger','Person Ledger','persona Ledger'),(441,'backup_restore','Backup ','Apoyo'),(442,'database_backup','Database backup','Copia de seguridad de base de datos'),(443,'file_information','File information','Informacion del archivo'),(444,'filename','Filename','Nombre del archivo'),(445,'size','Size','Talla'),(446,'backup_date','Backup date','fecha de copia de seguridad'),(447,'backup_now','Backup now','Copia ahora'),(448,'restore_now','Restore now','restaurar ahora'),(449,'are_you_sure','Are you sure ?','Estás seguro ?'),(450,'download','Download','Descargar'),(451,'backup_and_restore','Backup','Apoyo'),(452,'backup_successfully','Backup successfully','Copia de seguridad con éxito'),(453,'delete_successfully','Delete successfully','eliminar correctamente'),(454,'stock_ctn','Stock/Qnt','Stock / Qnt'),(455,'unit','Unit','Unidad'),(456,'meter_m','Meter (M)','Meter (M)'),(457,'piece_pc','Piece (Pc)','Pieza (Pc)'),(458,'kilogram_kg','Kilogram (Kg)','Kilogramo (kg)'),(459,'stock_cartoon','Stock Cartoon','de dibujos animados'),(460,'add_product_csv','Add Product (CSV)','Añadir Producto (CSV)'),(461,'import_product_csv','Import product (CSV)','producto de importación (CSV)'),(462,'close','Close','Cerca'),(463,'download_example_file','Download example file.','Descargar archivo de ejemplo.'),(464,'upload_csv_file','Upload CSV File','Carga de archivos CSV'),(465,'csv_file_informaion','CSV File Information','Información del archivo CSV'),(466,'out_of_stock','Out Of Stock','Agotado'),(467,'others','Others','Otros'),(468,'full_paid','Full Paid','total pagado'),(469,'successfully_saved','Your Data Successfully Saved','Sus datos se han guardado correctamente'),(470,'manage_loan','Manage Loan','Manejo de Préstamo'),(471,'receipt','Receipt','Recibo'),(472,'payment','Payment','Pago'),(473,'cashflow','Daily Cash Flow','Flujo de Caja diaria'),(474,'signature','Signature','Firma'),(475,'supplier_reports','Supplier Reports','Informes proveedor'),(476,'generate','Generate','Generar'),(477,'todays_overview','Todays Overview','Descripción general del día de hoy'),(478,'last_sales','Last Sales','últimos Ventas'),(479,'manage_transaction','Manage Transaction','Manejo de Transacción'),(480,'daily_summary','Daily Summary','Resumen diario'),(481,'daily_cash_flow','Daily Cash Flow','Flujo de Caja diaria'),(482,'custom_report','Custom Report','informe personalizado'),(483,'transaction','Transaction','Transacción'),(484,'receipt_amount','Receipt Amount','importe del recibo'),(485,'transaction_details_datewise','Transaction Details Datewise','Detalles de Transacción DATEwise'),(486,'cash_closing','Cash Closing','Cierre de caja'),(487,'you_can_not_buy_greater_than_available_qnty','You can not buy greater than available qnty.','No se puede comprar mayor que qnty disponible.'),(488,'supplier_id','Supplier ID','Identificación del proveedor'),(489,'category_id','Category ID','categoria ID'),(490,'select_report','Select Report','Seleccionar informe'),(491,'supplier_summary','Supplier summary','resumen de proveedores'),(492,'sales_payment_actual','Sales payment actual','el pago real de las ventas'),(493,'today_already_closed','Today already closed.','Hoy en día ya se cerró.'),(494,'root_account','Root Account','cuenta raíz'),(495,'office','Office','Oficina'),(496,'loan','Loan','Préstamo'),(497,'transaction_mood','Transaction Mood','transacción del estado de ánimo'),(498,'select_account','Select Account','Seleccionar cuenta'),(499,'add_receipt','Add Receipt','Agregar Recibo'),(500,'update_transaction','Update Transaction','Actualización de Transacción'),(501,'no_stock_found','No Stock Found !','Sin inventario encontrado!'),(502,'admin_login_area','Admin Login Area','Administrador Login'),(503,'print_qr_code','Print QR Code','Imprimir Código QR'),(504,'discount_type','Discount Type','Tipo de descuento'),(505,'discount_percentage','Discount','Descuento'),(506,'fixed_dis','Fixed Dis.','Dis fijos.'),(507,'return','Return','Regreso'),(508,'stock_return_list','Stock Return List','Lista de Retorno'),(509,'wastage_return_list','Wastage Return List','Lista desperdicio Retorno'),(510,'return_invoice','Sale Return','venta Retorno'),(511,'sold_qty','Sold Qty','Cantidad vendida'),(512,'ret_quantity','Return Qty','Cantidad de retorno'),(513,'deduction','Deduction','Deducción'),(514,'check_return','Check Return','Compruebe Retorno'),(515,'reason','Reason','Razón'),(516,'usablilties','Usability','usabilidad'),(517,'adjs_with_stck','Adjust With Stock','Con ajuste de la'),(518,'return_to_supplier','Return To Supplier','Devolución al proveedor'),(519,'wastage','Wastage','Pérdida'),(520,'to_deduction','Total Deduction ','Deducción total'),(521,'nt_return','Net Return Amount','Net Return Cantidad'),(522,'return_list','Return List','Lista de retorno'),(523,'add_return','Add Return','Añadir Retorno'),(524,'per_qty','Purchase Qty','Cantidad de compra'),(525,'return_supplier','Supplier Return','proveedor Retorno'),(526,'stock_purchase','Stock Purchase Price','Precio de compra de acciones'),(527,'stock_sale','Stock Sale Price','Stock Precio de Venta'),(528,'supplier_return','Supplier Return','proveedor Retorno'),(529,'purchase_id','Purchase ID','Identificación de compra'),(530,'return_id','Return ID','Volver ID'),(531,'supplier_return_list','Supplier Return List','Lista de proveedores de retorno'),(532,'c_r_slist','Stock Return Stock','Archivo regreso de la'),(533,'wastage_list','Wastage List','Lista desperdicio'),(534,'please_input_correct_invoice_id','Please Input a Correct Sale ID','Por favor introduce una Venta ID correcta'),(535,'please_input_correct_purchase_id','Please Input Your Correct  Purchase ID','Por favor introduzca su ID de compra correcta'),(536,'add_more','Add More','Añadir más'),(537,'prouct_details','Product Details','Detalles de producto'),(538,'prouct_detail','Product Details','Detalles de producto'),(539,'stock_return','Stock Return','Devolución de stock'),(540,'choose_transaction','Select Transaction','Seleccionar Transacción'),(541,'transection_category','Select  Category','Selecciona una categoría'),(542,'transaction_categry','Select Category','selecciona una categoría'),(543,'search_supplier','Search Supplier','búsqueda Proveedor'),(544,'customer_id','Customer ID','Identificación del cliente'),(545,'search_customer','Search Customer Invoice','Factura de búsqueda de atención al cliente'),(546,'serial_no','SN','SN'),(547,'item_discount','Item Discount','Descuento de artículos'),(548,'invoice_discount','Sale Discount','Descuento venta'),(549,'add_unit','Add Unit','Añadir Unidad'),(550,'manage_unit','Manage Unit','Manejo de la unidad'),(551,'add_new_unit','Add New Unit','Anadir unidad'),(552,'unit_name','Unit Name','Nombre de la unidad'),(553,'payment_amount','Payment Amount','Monto del pago'),(554,'manage_your_unit','Manage Your Unit','Administre su Unidad'),(555,'unit_id','Unit ID','ID de unidad'),(556,'unit_edit','Unit Edit','unidad de edición'),(557,'vat','Vat','IVA'),(558,'sales_report_category_wise','Sales Report (Category wise)','Informe de ventas (Categoría sabia)'),(559,'purchase_report_category_wise','Purchase Report (Category wise)','Informe de compra (Categoría sabia)'),(560,'category_wise_purchase_report','Category wise purchase report','Categoría informe compra inteligente'),(561,'category_wise_sales_report','Category wise sales report','Categoría informe de ventas sabia'),(562,'best_sale_product','Best Sale Product','La mejor venta del producto'),(563,'all_best_sales_product','All Best Sales Products','Todos los mejores productos de venta'),(564,'todays_customer_receipt','Todays Customer Receipt','Del día de hoy recibo del cliente'),(565,'not_found','Record not found','Registro no encontrado'),(566,'collection','Collection','Colección'),(567,'increment','Increment','Incremento'),(568,'accounts_tree_view','Accounts Tree View','Cuentas de vista de árbol'),(569,'debit_voucher','Debit Voucher','vale de débito'),(570,'voucher_no','Voucher No','No se vale de'),(571,'credit_account_head','Credit Account Head','Cabeza Cuenta de crédito'),(572,'remark','Remark','Observación'),(573,'code','Code','Código'),(574,'amount','Amount','Cantidad'),(575,'approved','Approved','Aprobado'),(576,'debit_account_head','Debit Account Head','Cabeza Cuenta de débito'),(577,'credit_voucher','Credit Voucher','documento de tarjeta'),(578,'find','Find','Encontrar'),(579,'transaction_date','Transaction Date','Fecha de Transacción'),(580,'voucher_type','Voucher Type','Tipo de vales'),(581,'particulars','Particulars','Informe detallado'),(582,'with_details','With Details','Con detalles'),(583,'general_ledger','General Ledger','Libro mayor'),(584,'general_ledger_of','General ledger of','libro mayor de'),(585,'pre_balance','Pre Balance','pre Equilibrio'),(586,'current_balance','Current Balance','Saldo actual'),(587,'to_date','To Date','Hasta la fecha'),(588,'from_date','From Date','Partir de la fecha'),(589,'trial_balance','Trial Balance','Balance de comprobación'),(590,'authorized_signature','Authorized Signature','Firma autorizada'),(591,'chairman','Chairman','Presidente'),(592,'total_income','Total Income','Ingresos totales'),(593,'statement_of_comprehensive_income','Statement of Comprehensive Income','Estado del resultado integral'),(594,'profit_loss','Profit Loss','Pérdida de beneficios'),(595,'cash_flow_report','Cash Flow Report','Informe de flujo de efectivo'),(596,'cash_flow_statement','Cash Flow Statement','Estado de Flujos de Efectivo'),(597,'amount_in_dollar','Amount In Dollar','Monto en dólares'),(598,'opening_cash_and_equivalent','Opening Cash and Equivalent','Apertura de efectivo y equivalentes'),(599,'coa_print','Coa Print','Coa Imprimir'),(600,'cash_flow','Cash Flow','Flujo de efectivo'),(601,'cash_book','Cash Book','Libro de pago'),(602,'bank_book','Bank Book','Banco de libros'),(603,'c_o_a','Chart of Account','Plan de cuentas'),(604,'journal_voucher','Journal Voucher','Documento preliminar'),(605,'contra_voucher','Contra Voucher','Contra vale'),(606,'voucher_approval','Vouchar Approval','Aprobación Vouchar'),(607,'supplier_payment','Supplier Payment','Pago a Proveedores'),(608,'customer_receive','Customer Receive','Recibir al cliente'),(609,'gl_head','General Head','Cabeza general'),(610,'account_code','Account Head','Cabeza de cuenta'),(611,'opening_balance','Opening Balance','Saldo de apertura'),(612,'head_of_account','Head of Account','Jefe de Cuenta'),(613,'inventory_ledger','Inventory Ledger','libro de inventario'),(614,'newpassword','New Password','Nueva contraseña'),(615,'password_recovery','Password Recovery','Recuperación de contraseña'),(616,'forgot_password','Forgot Password ??','Se te olvidó tu contraseña ??'),(617,'send','Send','Enviar'),(618,'due_report','Due Report','debido Informe'),(619,'due_amount','Due Amount','Cantidad debida'),(620,'download_sample_file','Download Sample File','Ejemplo de archivo de descarga'),(621,'customer_csv_upload','Customer Csv Upload','Subir al cliente Csv'),(622,'csv_supplier','Csv Upload Supplier','Csv Subir Proveedor'),(623,'csv_upload_supplier','Csv Upload Supplier','Csv Subir Proveedor'),(624,'previous','Previous','Anterior'),(625,'net_total','Net Total','Total neto'),(626,'currency_list','Currency List','Lista Currency'),(627,'currency_name','Currency Name','Nombre moneda'),(628,'currency_icon','Currency Symbol','Símbolo de moneda'),(629,'add_currency','Add Currency','Agregar moneda'),(630,'role_permission','Role Permission','permiso papel'),(631,'role_list','Role List','Lista de roles'),(632,'user_assign_role','User Assign Role','Usuario de asignar funciones'),(633,'permission','Permission','Permiso'),(634,'add_role','Add Role','Agregar Rol'),(635,'add_module','Add Module','Agregar módulo'),(636,'module_name','Module Name','Nombre del módulo'),(637,'office_loan','Office Loan','Préstamo Oficina'),(638,'add_menu','Add Menu','Añadir menú'),(639,'menu_name','Menu Name','Nombre del menú'),(640,'sl_no','Sl No','Si. No'),(641,'create','Create','Crear'),(642,'read','Read','Leer'),(643,'role_name','Role Name','Nombre de rol'),(644,'qty','Quantity','Cantidad'),(645,'max_rate','Max Rate','Máxima calificación'),(646,'min_rate','Min Rate','min Rate'),(647,'avg_rate','Average Rate','Tasa promedio'),(648,'role_permission_added_successfully','Role Permission Successfully Added','Permiso función satisfactoria Por'),(649,'update_successfully','Successfully Updated','Actualizado exitosamente'),(650,'role_permission_updated_successfully','Role Permission Successfully Updated ','Permiso papel actualizado correctamente'),(651,'shipping_cost','Shipping Cost','Costo de envío'),(652,'in_word','In Word ','En palabra'),(653,'shipping_cost_report','Shipping Cost Report','El costo de envío de informes'),(654,'cash_book_report','Cash Book Report','Informe del libro de caja'),(655,'inventory_ledger_report','Inventory Ledger Report','Informe de inventario de Ledger'),(656,'trial_balance_with_opening_as_on','Trial Balance With Opening As On','Balance de comprobación con la apertura Como En'),(657,'type','Type','Tipo'),(658,'taka_only','Taka Only','Sólo taka'),(659,'item_description','Desc','Desc'),(660,'sold_by','Sold By','Vendido por'),(661,'user_wise_sales_report','User Wise Sales Report','Usuario Wise Informe de ventas'),(662,'user_name','User Name','Nombre de usuario'),(663,'total_sold','Total Sold','total vendido'),(664,'user_wise_sale_report','User Wise Sales Report','Usuario Wise Informe de ventas'),(665,'barcode_or_qrcode','Barcode/QR-code','Código de barras / código QR'),(666,'category_csv_upload','Category Csv  Upload','Categoría Csv Subir'),(667,'unit_csv_upload','Unit Csv Upload','Unidad Csv Subir'),(668,'invoice_return_list','Sales Return list','Lista de Ventas Retorno'),(669,'invoice_return','Sales Return','ventas Retorno'),(670,'tax_report','Tax Report','Informe fiscal'),(671,'select_tax','Select Tax','Seleccione Tributaria'),(672,'hrm','HRM','HRM'),(673,'employee','Employee','Empleado'),(674,'add_employee','Add Employee','Añadir Empleado'),(675,'manage_employee','Manage Employee','Manejo del Empleado'),(676,'attendance','Attendance','Asistencia'),(677,'add_attendance','Attendance','Asistencia'),(678,'manage_attendance','Manage Attendance','Manejo de Asistencia'),(679,'payroll','Payroll','Nómina de sueldos'),(680,'add_payroll','Payroll','Nómina de sueldos'),(681,'manage_payroll','Manage Payroll','Manejo de nómina'),(682,'employee_type','Employee Type','Tipo de empleado'),(683,'employee_designation','Employee Designation','Designación del empleado'),(684,'designation','Designation','Designacion'),(685,'add_designation','Add Designation','Añadir Designación'),(686,'manage_designation','Manage Designation','Manejo de Designación'),(687,'designation_update_form','Designation Update form','formulario de designación de actualización'),(688,'picture','Picture','Imagen'),(689,'country','Country','País'),(690,'blood_group','Blood Group','Grupo sanguíneo'),(691,'address_line_1','Address Line 1','Dirección Línea 1'),(692,'address_line_2','Address Line 2','Dirección Línea 2'),(693,'zip','Zip code','Código postal'),(694,'city','City','Ciudad'),(695,'hour_rate_or_salary','Houre Rate/Salary','Houre Rate / salario'),(696,'rate_type','Rate Type','Tipo de cambio'),(697,'hourly','Hourly','Cada hora'),(698,'salary','Salary','Salario'),(699,'employee_update','Employee Update','empleado de actualización'),(700,'checkin','Check In','Registrarse'),(701,'employee_name','Employee Name','Nombre de empleado'),(702,'checkout','Check Out','Revisa'),(703,'confirm_clock','Confirm Clock','Confirmar Reloj'),(704,'stay','Stay Time','Tiempo de permanencia'),(705,'sign_in','Sign In','Registrarse'),(706,'check_in','Check In','Registrarse'),(707,'single_checkin','Single Check In','Comprobar sola En'),(708,'bulk_checkin','Bulk Check In','Entradas a granel'),(709,'successfully_checkout','Successfully Checkout','Pedido con éxito'),(710,'attendance_report','Attendance Report','Reporte de asistencia'),(711,'datewise_report','Date Wise Report','Fecha Wise Informe'),(712,'employee_wise_report','Employee Wise Report','Empleado Informe Wise'),(713,'date_in_time_report','Date In Time Report','En fecha Hora del informe'),(714,'request','Request','Solicitud'),(715,'sign_out','Sign Out','Desconectar'),(716,'work_hour','Work Hours','Horas laborales'),(717,'s_time','Start Time','Hora de inicio'),(718,'e_time','In Time','A tiempo'),(719,'salary_benefits_type','Benefits Type','Tipo beneficios'),(720,'salary_benefits','Salary Benefits','Los beneficios salariales'),(721,'beneficial_list','Benefit List','Lista beneficio'),(722,'add_beneficial','Add Benefits','Más prestaciones'),(723,'add_benefits','Add Benefits','Más prestaciones'),(724,'benefits_list','Benefit List','Lista beneficio'),(725,'benefit_type','Benefit Type','Tipo de beneficio'),(726,'benefits','Benefit','Beneficio'),(727,'manage_benefits','Manage Benefits','Manejo de Beneficios'),(728,'deduct','Deduct','Deducir'),(729,'add','Add','Añadir'),(730,'add_salary_setup','Add Salary Setup','Añadir instalación de Salario'),(731,'manage_salary_setup','Manage Salary Setup','Gestionar el programa de instalación de sueldos'),(732,'basic','Basic','Básico'),(733,'salary_type','Salary Type','Tipo de sueldo'),(734,'addition','Addition','Adición'),(735,'gross_salary','Gross Salary','Salario bruto'),(736,'set','Set','Conjunto'),(737,'salary_generate','Salary Generate','Generar salario'),(738,'manage_salary_generate','Manage Salary Generate','Administrar Salario Generar'),(739,'sal_name','Salary Name','Nombre salario'),(740,'gdate','Generated Date','Fecha generada'),(741,'generate_by','Generated By','Generado por'),(742,'the_salary_of','The Salary of ','El salario de'),(743,'already_generated',' Already Generated','ya generado'),(744,'salary_month','Salary Month','Mes salario'),(745,'successfully_generated','Successfully Generated','Generado con éxito'),(746,'salary_payment','Salary Payment','Pago de salario'),(747,'employee_salary_payment','Employee Salary Payment','El pago de sueldos de los empleados'),(748,'total_salary','Total Salary','Salario total'),(749,'total_working_minutes','Total Working Hours','El total de horas de trabajo'),(750,'working_period','Working Period','Período de trabajo'),(751,'paid_by','Paid By','Pagado por'),(752,'pay_now','Pay Now ','Pagar ahora'),(753,'confirm','Confirm','Confirmar'),(754,'successfully_paid','Successfully Paid','A cargo con éxito'),(755,'add_incometax','Add Income Tax','Añadir Impuesto sobre la Renta'),(756,'setup_tax','Setup Tax','Impuestos configuración'),(757,'start_amount','Start Amount','Inicio Cuantía'),(758,'end_amount','End Amount','fin Cantidad'),(759,'tax_rate','Tax Rate','Tasa de impuesto'),(760,'setup','Setup','Preparar'),(761,'manage_income_tax','Manage Income Tax','Manejo de impuesto sobre la renta'),(762,'income_tax_updateform','Income tax Update form','Impuesto sobre la renta formulario de Actualización'),(763,'positional_information','Positional Information','La información de posición'),(764,'personal_information','Personal Information','Informacion personal'),(765,'timezone','Time Zone','Zona horaria'),(766,'sms','SMS','SMS'),(767,'sms_configure','SMS Configure','Configurar SMS'),(768,'url','URL','URL'),(769,'sender_id','Sender ID','identificación del remitente'),(770,'api_key','Api Key','Clave API'),(771,'gui_pos','GUI POS','GUI POS'),(772,'manage_service','Manage Service','administrar servicio'),(773,'service','Service','Servicio'),(774,'add_service','Add Service','Añadir servicio'),(775,'service_edit','Service Edit','servicio de edición'),(776,'service_csv_upload','Service CSV Upload','Servicio CSV Subir'),(777,'service_name','Service Name','Nombre del Servicio'),(778,'charge','Charge','Cargar'),(779,'service_invoice','Service Invoice','servicio de factura'),(780,'service_discount','Service Discount','Descuento servicio'),(781,'hanging_over','ETD','ETD'),(782,'service_details','Service Details','Detalles de servicio'),(783,'tax_settings','Tax Settings','Ajustes fiscales'),(784,'default_value','Default Value','Valor por defecto'),(785,'number_of_tax','Number of Tax','Número de impuestos'),(786,'please_select_employee','Please Select Employee','Por favor, seleccione Empleado'),(787,'manage_service_invoice','Manage Service Invoice','Administrar el servicio de Factura'),(788,'update_service_invoice','Update Service Invoice','Servicio de actualización de facturas'),(789,'customer_wise_tax_report','Customer Wise  Tax Report','Cliente Informe fiscal Wise'),(790,'service_id','Service Id','ID de servicio'),(791,'invoice_wise_tax_report','Invoice Wise Tax Report','Informe de factura de impuestos Wise'),(792,'reg_no','Reg No','Sin reg'),(793,'update_now','Update Now','Actualizar ahora'),(794,'import','Import','Importar'),(795,'add_expense_item','Add Expense Item','Agregar elemento de gastos'),(796,'manage_expense_item','Manage Expense Item','Administrar artículo de gastos'),(797,'add_expense','Add Expense','Agregar Gasto'),(798,'manage_expense','Manage Expense','Administrar el gasto'),(799,'expense_statement','Expense Statement','Declaración de gastos'),(800,'expense_type','Expense Type','Tipo de gasto'),(801,'expense_item_name','Expense Item Name','Gasto Nombre del elemento'),(802,'stock_purchase_price','Stock Purchase Price','Precio de compra de acciones'),(803,'purchase_price','Purchase Price','Precio de compra'),(804,'customer_advance','Customer Advance','Avance al cliente'),(805,'advance_type','Advance Type','Tipo de antemano'),(806,'restore','Restore','Restaurar'),(807,'supplier_advance','Supplier Advance','proveedor Avance'),(808,'please_input_correct_invoice_no','Please Input Correct Invoice NO','Por favor entrada correcta factura n'),(809,'backup','Back Up','Apoyo'),(810,'app_setting','App Settings','Ajustes de Aplicacion'),(811,'local_server_url','Local Server Url','URL del servidor local'),(812,'online_server_url','Online Server Url','URL del servidor en línea'),(813,'connet_url','Connected Hotspot Ip/url','Conectado hotspot IP / URL'),(814,'update_your_app_setting','Update Your App Setting','Actualizar la aplicación Configuración'),(815,'select_category','Select Category','selecciona una categoría'),(816,'mini_invoice','Mini Invoice','Mini factura'),(817,'purchase_details','Purchase Details','Detalles de la compra'),(818,'disc','Dis %','Dis%'),(819,'serial','Serial','De serie'),(820,'transaction_head','Transaction Head','Cabeza de transacciones'),(821,'transaction_type','Transaction Type','tipo de transacción'),(822,'return_details','Return Details','Detalles de la vuelta'),(823,'return_to_customer','Return To Customer','Volver al Cliente'),(824,'sales_and_purchase_report_summary','Sales And Purchase Report Summary','Venta y compra Resumen del informe'),(825,'add_person_officeloan','Add Person (Office Loan)','Agregar persona (Préstamo de oficina)'),(826,'add_loan_officeloan','Add Loan (Office Loan)','Añadir Préstamo (Oficina de Préstamo)'),(827,'add_payment_officeloan','Add Payment (Office Loan)','Agregar Pago (Préstamo de oficina)'),(828,'manage_loan_officeloan','Manage Loan (Office Loan)','Manejo de Préstamo (Oficina de Préstamo)'),(829,'add_person_personalloan','Add Person (Personal Loan)','Agregar persona (préstamo personal)'),(830,'add_loan_personalloan','Add Loan (Personal Loan)','Añadir préstamo (préstamo personal)'),(831,'add_payment_personalloan','Add Payment (Personal Loan)','Agregar Pago (préstamo personal)'),(832,'manage_loan_personalloan','Manage Loan (Personal)','Manejo de Préstamo (Personal)'),(833,'hrm_management','Human Resource','Recursos humanos'),(834,'cash_adjustment','Cash Adjustment','Ajuste de dinero en efectivo'),(835,'adjustment_type','Adjustment Type','Tipo de ajuste'),(836,'change','Change','Cambio'),(837,'sale_by','Sale By','Por la venta'),(838,'salary_date','Salary Date','Fecha salario'),(839,'earnings','Earnings','Ganancias'),(840,'total_addition','Total Addition','Suma total'),(841,'total_deduction','Total Deduction','Deducción total'),(842,'net_salary','Net Salary','Sueldo neto'),(843,'ref_number','Reference Number','Número de referencia'),(844,'name_of_bank','Name Of Bank','Nombre del banco'),(845,'salary_slip','Salary Slip','Nómina'),(846,'basic_salary','Basic Salary','Salario base'),(847,'return_from_customer','Return From Customer','Regreso de Cliente'),(848,'quotation','Quotation','Cotización'),(849,'add_quotation','Add Quotation','Añadir Cotización'),(850,'manage_quotation','Manage Quotation','Manejo de Cotización'),(851,'terms','Terms','Condiciones'),(852,'send_to_customer','Sent To Customer','Enviado al cliente'),(853,'quotation_no','Quotation No','Cita No'),(854,'quotation_date','Quotation Date','Cita Fecha'),(855,'total_service_tax','Total Service Tax','Servicio de Impuestos total'),(856,'totalservicedicount','Total Service Discount','Descuento Servicio Total'),(857,'item_total','Item Total','Total'),(858,'service_total','Service Total','servicio total'),(859,'quot_description','Quotation Description','Descripción de cotización'),(860,'sub_total','Sub Total','Sub total'),(861,'mail_setting','Mail Setting','Ajuste electrónico'),(862,'mail_configuration','Mail Configuration','Configuración de correo'),(863,'mail','Mail','Correo'),(864,'protocol','Protocol','Protocolo'),(865,'smtp_host','SMTP Host','Host SMTP'),(866,'smtp_port','SMTP Port','Puerto SMTP'),(867,'sender_mail','Sender Mail','mail Sender'),(868,'mail_type','Mail Type','Tipo de correo'),(869,'html','HTML','HTML'),(870,'text','TEXT','TEXTO'),(871,'expiry_date','Expiry Date','Fecha de caducidad'),(872,'api_secret','Api Secret','Api secreto'),(873,'please_config_your_mail_setting',NULL,'#VALUE!'),(874,'quotation_successfully_added','Quotation Successfully Added','Cita con éxito Añadido'),(875,'add_to_invoice','Add To Invoice','Añadir a la factura'),(876,'added_to_invoice','Added To Invoice','Agregó a la factura');
/*!40000 ALTER TABLE `language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `directory` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'invoice',NULL,NULL,NULL,1),(2,'customer',NULL,NULL,NULL,1),(3,'product',NULL,NULL,NULL,1),(4,'supplier',NULL,NULL,NULL,1),(5,'purchase',NULL,NULL,NULL,1),(6,'stock',NULL,NULL,NULL,1),(7,'return',NULL,NULL,NULL,1),(8,'report',NULL,NULL,NULL,1),(9,'accounts',NULL,NULL,NULL,1),(10,'bank',NULL,NULL,NULL,1),(11,'tax',NULL,NULL,NULL,1),(12,'hrm_management',NULL,NULL,NULL,1),(13,'service',NULL,NULL,NULL,1),(14,'commission',NULL,NULL,NULL,1),(15,'setting',NULL,NULL,NULL,1),(16,'quotation',NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `cash_date` varchar(20) NOT NULL,
  `1000n` varchar(11) NOT NULL,
  `500n` varchar(11) NOT NULL,
  `100n` varchar(11) NOT NULL,
  `50n` varchar(11) NOT NULL,
  `20n` varchar(11) NOT NULL,
  `10n` varchar(11) NOT NULL,
  `5n` varchar(11) NOT NULL,
  `2n` varchar(11) NOT NULL,
  `1n` varchar(30) NOT NULL,
  `grandtotal` varchar(30) NOT NULL,
  PRIMARY KEY (`note_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_checkout`
--

DROP TABLE IF EXISTS `payment_checkout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_checkout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `payment_duration` int(11) NOT NULL COMMENT 'Month',
  `device_id` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=install,1=payment',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_checkout`
--

LOCK TABLES `payment_checkout` WRITE;
/*!40000 ALTER TABLE `payment_checkout` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_checkout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll_tax_setup`
--

DROP TABLE IF EXISTS `payroll_tax_setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payroll_tax_setup` (
  `tax_setup_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `start_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `end_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `rate` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`tax_setup_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll_tax_setup`
--

LOCK TABLES `payroll_tax_setup` WRITE;
/*!40000 ALTER TABLE `payroll_tax_setup` DISABLE KEYS */;
/*!40000 ALTER TABLE `payroll_tax_setup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_information`
--

DROP TABLE IF EXISTS `person_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `person_information` (
  `person_id` varchar(50) NOT NULL,
  `person_name` varchar(50) NOT NULL,
  `person_phone` varchar(50) NOT NULL,
  `person_address` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_information`
--

LOCK TABLES `person_information` WRITE;
/*!40000 ALTER TABLE `person_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `person_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_ledger`
--

DROP TABLE IF EXISTS `person_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `person_ledger` (
  `transaction_id` varchar(50) NOT NULL,
  `person_id` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `debit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `details` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=no paid,2=paid',
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_ledger`
--

LOCK TABLES `person_ledger` WRITE;
/*!40000 ALTER TABLE `person_ledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `person_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_loan`
--

DROP TABLE IF EXISTS `personal_loan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_loan` (
  `per_loan_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(30) NOT NULL,
  `person_id` varchar(30) NOT NULL,
  `debit` decimal(12,2) DEFAULT '0.00',
  `credit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `date` varchar(30) NOT NULL,
  `details` varchar(100) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=no paid,2=paid',
  PRIMARY KEY (`per_loan_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_loan`
--

LOCK TABLES `personal_loan` WRITE;
/*!40000 ALTER TABLE `personal_loan` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_loan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesonal_loan_information`
--

DROP TABLE IF EXISTS `pesonal_loan_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pesonal_loan_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` varchar(50) NOT NULL,
  `person_name` varchar(50) NOT NULL,
  `person_phone` varchar(30) NOT NULL,
  `person_address` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesonal_loan_information`
--

LOCK TABLES `pesonal_loan_information` WRITE;
/*!40000 ALTER TABLE `pesonal_loan_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `pesonal_loan_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_category` (
  `category_id` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_information`
--

DROP TABLE IF EXISTS `product_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(100) NOT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` float DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `tax` float DEFAULT NULL COMMENT 'Tax in %',
  `serial_no` varchar(200) DEFAULT NULL,
  `product_model` varchar(100) DEFAULT NULL,
  `product_details` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `tax0` text,
  `tax1` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_information`
--

LOCK TABLES `product_information` WRITE;
/*!40000 ALTER TABLE `product_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_purchase`
--

DROP TABLE IF EXISTS `product_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) NOT NULL,
  `chalan_no` varchar(100) NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `grand_total_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_discount` decimal(10,2) DEFAULT NULL,
  `purchase_date` varchar(50) DEFAULT NULL,
  `purchase_details` text,
  `status` int(2) NOT NULL,
  `bank_id` varchar(30) DEFAULT NULL,
  `payment_type` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_purchase`
--

LOCK TABLES `product_purchase` WRITE;
/*!40000 ALTER TABLE `product_purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_purchase_details`
--

DROP TABLE IF EXISTS `product_purchase_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_purchase_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_detail_id` varchar(100) DEFAULT NULL,
  `purchase_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_purchase_details`
--

LOCK TABLES `product_purchase_details` WRITE;
/*!40000 ALTER TABLE `product_purchase_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_purchase_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_return`
--

DROP TABLE IF EXISTS `product_return`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_return` (
  `return_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `product_id` varchar(20) CHARACTER SET latin1 NOT NULL,
  `invoice_id` varchar(20) CHARACTER SET latin1 NOT NULL,
  `purchase_id` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `date_purchase` varchar(20) CHARACTER SET latin1 NOT NULL,
  `date_return` varchar(30) CHARACTER SET latin1 NOT NULL,
  `byy_qty` float NOT NULL,
  `ret_qty` float NOT NULL,
  `customer_id` varchar(20) CHARACTER SET latin1 NOT NULL,
  `supplier_id` varchar(30) CHARACTER SET latin1 NOT NULL,
  `product_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deduction` float NOT NULL,
  `total_deduct` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_ret_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `net_total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `reason` text CHARACTER SET latin1 NOT NULL,
  `usablity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_return`
--

LOCK TABLES `product_return` WRITE;
/*!40000 ALTER TABLE `product_return` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_return` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_service`
--

DROP TABLE IF EXISTS `product_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax0` text,
  `tax1` text,
  PRIMARY KEY (`service_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_service`
--

LOCK TABLES `product_service` WRITE;
/*!40000 ALTER TABLE `product_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quot_products_used`
--

DROP TABLE IF EXISTS `quot_products_used`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quot_products_used` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quot_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `serial_no` varchar(30) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `used_qty` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `supplier_rate` float DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `discount_per` varchar(15) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quot_products_used`
--

LOCK TABLES `quot_products_used` WRITE;
/*!40000 ALTER TABLE `quot_products_used` DISABLE KEYS */;
/*!40000 ALTER TABLE `quot_products_used` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation`
--

DROP TABLE IF EXISTS `quotation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotation` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `quotation_id` varchar(30) NOT NULL,
  `quot_description` text NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `quotdate` date NOT NULL,
  `expire_date` date DEFAULT NULL,
  `item_total_amount` decimal(12,2) NOT NULL,
  `item_total_dicount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_total_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `service_total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `service_total_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `service_total_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quot_dis_item` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quot_dis_service` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quot_no` varchar(50) NOT NULL,
  `create_by` varchar(30) NOT NULL,
  `create_date` date NOT NULL,
  `update_by` varchar(30) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `cust_show` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `quot_no` (`quot_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation`
--

LOCK TABLES `quotation` WRITE;
/*!40000 ALTER TABLE `quotation` DISABLE KEYS */;
/*!40000 ALTER TABLE `quotation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_service_used`
--

DROP TABLE IF EXISTS `quotation_service_used`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotation_service_used` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quot_id` varchar(20) NOT NULL,
  `service_id` int(11) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_service_used`
--

LOCK TABLES `quotation_service_used` WRITE;
/*!40000 ALTER TABLE `quotation_service_used` DISABLE KEYS */;
/*!40000 ALTER TABLE `quotation_service_used` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_taxinfo`
--

DROP TABLE IF EXISTS `quotation_taxinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotation_taxinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `relation_id` varchar(30) NOT NULL,
  `tax0` text,
  `tax1` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_taxinfo`
--

LOCK TABLES `quotation_taxinfo` WRITE;
/*!40000 ALTER TABLE `quotation_taxinfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `quotation_taxinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_module_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `create` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `update` tinyint(1) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_module_id` (`fk_module_id`) USING BTREE,
  KEY `fk_user_id` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permission`
--

LOCK TABLES `role_permission` WRITE;
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_sheet_generate`
--

DROP TABLE IF EXISTS `salary_sheet_generate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salary_sheet_generate` (
  `ssg_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `gdate` varchar(30) DEFAULT NULL,
  `start_date` varchar(30) CHARACTER SET latin1 NOT NULL,
  `end_date` varchar(30) CHARACTER SET latin1 NOT NULL,
  `generate_by` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ssg_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_sheet_generate`
--

LOCK TABLES `salary_sheet_generate` WRITE;
/*!40000 ALTER TABLE `salary_sheet_generate` DISABLE KEYS */;
/*!40000 ALTER TABLE `salary_sheet_generate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_type`
--

DROP TABLE IF EXISTS `salary_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salary_type` (
  `salary_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `sal_name` varchar(100) NOT NULL,
  `salary_type` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY (`salary_type_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_type`
--

LOCK TABLES `salary_type` WRITE;
/*!40000 ALTER TABLE `salary_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `salary_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_role`
--

DROP TABLE IF EXISTS `sec_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sec_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_role`
--

LOCK TABLES `sec_role` WRITE;
/*!40000 ALTER TABLE `sec_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `sec_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_userrole`
--

DROP TABLE IF EXISTS `sec_userrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sec_userrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roleid` int(11) NOT NULL,
  `createby` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createdate` datetime NOT NULL,
  UNIQUE KEY `ID` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_userrole`
--

LOCK TABLES `sec_userrole` WRITE;
/*!40000 ALTER TABLE `sec_userrole` DISABLE KEYS */;
/*!40000 ALTER TABLE `sec_userrole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_invoice`
--

DROP TABLE IF EXISTS `service_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_no` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `employee_id` varchar(100) DEFAULT NULL,
  `customer_id` varchar(30) NOT NULL,
  `total_amount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `total_discount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `invoice_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `previous` decimal(10,2) NOT NULL DEFAULT '0.00',
  `details` varchar(250) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_invoice`
--

LOCK TABLES `service_invoice` WRITE;
/*!40000 ALTER TABLE `service_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_invoice_details`
--

DROP TABLE IF EXISTS `service_invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `service_inv_id` varchar(30) NOT NULL,
  `qty` decimal(10,2) NOT NULL DEFAULT '0.00',
  `charge` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_invoice_details`
--

LOCK TABLES `service_invoice_details` WRITE;
/*!40000 ALTER TABLE `service_invoice_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_settings`
--

DROP TABLE IF EXISTS `sms_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(100) DEFAULT NULL,
  `api_secret` varchar(100) DEFAULT NULL,
  `from` varchar(100) DEFAULT NULL,
  `isinvoice` int(11) NOT NULL DEFAULT '0',
  `isservice` int(11) NOT NULL DEFAULT '0',
  `isreceive` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_settings`
--

LOCK TABLES `sms_settings` WRITE;
/*!40000 ALTER TABLE `sms_settings` DISABLE KEYS */;
INSERT INTO `sms_settings` VALUES (1,'5d6db102011','456452dfgdf','8801645452',0,0,0);
/*!40000 ALTER TABLE `sms_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_module`
--

DROP TABLE IF EXISTS `sub_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `image` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `directory` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_module`
--

LOCK TABLES `sub_module` WRITE;
/*!40000 ALTER TABLE `sub_module` DISABLE KEYS */;
INSERT INTO `sub_module` VALUES (1,1,'new_invoice',NULL,NULL,'new_invoice',1),(2,1,'manage_invoice',NULL,NULL,'manage_invoice',1),(3,1,'pos_invoice',NULL,NULL,'pos_invoice',1),(4,9,'c_o_a',NULL,NULL,'show_tree',1),(5,9,'supplier_payment',NULL,NULL,'supplier_payment',1),(6,9,'customer_receive',NULL,NULL,'customer_receive',1),(7,9,'debit_voucher',NULL,NULL,'debit_voucher',1),(8,9,'credit_voucher',NULL,NULL,'credit_voucher',1),(9,9,'voucher_approval',NULL,NULL,'aprove_v',1),(10,9,'contra_voucher',NULL,NULL,'contra_voucher',1),(11,9,'journal_voucher',NULL,NULL,'journal_voucher',1),(12,9,'report',NULL,NULL,'ac_report',1),(13,9,'cash_book',NULL,NULL,'cash_book',1),(14,9,'Inventory_ledger',NULL,NULL,'inventory_ledger',1),(15,9,'bank_book',NULL,NULL,'bank_book',1),(16,9,'general_ledger',NULL,NULL,'general_ledger',1),(17,9,'trial_balance',NULL,NULL,'trial_balance',1),(18,9,'cash_flow',NULL,NULL,'cash_flow_report',1),(19,9,'coa_print',NULL,NULL,'coa_print',1),(21,3,'category',NULL,NULL,'manage_category',1),(22,3,'add_product',NULL,NULL,'create_product',1),(23,3,'import_product_csv',NULL,NULL,'add_product_csv',1),(24,3,'manage_product',NULL,NULL,'manage_product',1),(25,2,'add_customer',NULL,NULL,'add_customer',1),(26,2,'manage_customer',NULL,NULL,'manage_customer',1),(27,2,'credit_customer',NULL,NULL,'credit_customer',1),(28,2,'paid_customer',NULL,NULL,'paid_customer',1),(30,3,'unit',NULL,NULL,'manage_unit',1),(31,4,'add_supplier',NULL,NULL,'add_supplier',1),(32,4,'manage_supplier',NULL,NULL,'manage_supplier',1),(33,4,'supplier_ledger',NULL,NULL,'supplier_ledger_report',1),(35,5,'add_purchase',NULL,NULL,'add_purchase',1),(36,5,'manage_purchase',NULL,NULL,'manage_purchase',1),(37,7,'return',NULL,NULL,'add_return',1),(38,7,'stock_return_list',NULL,NULL,'return_list',1),(39,7,'supplier_return_list',NULL,NULL,'supplier_return_list',1),(40,7,'wastage_return_list',NULL,NULL,'wastage_return_list',1),(41,11,'tax_settings',NULL,NULL,'tax_settings',1),(43,6,'stock_report',NULL,NULL,'stock_report',1),(46,8,'closing',NULL,NULL,'add_closing',1),(47,8,'closing_report',NULL,NULL,'closing_report',1),(48,8,'todays_report',NULL,NULL,'all_report',1),(49,8,'todays_customer_receipt',NULL,NULL,'todays_customer_receipt',1),(50,8,'sales_report',NULL,NULL,'todays_sales_report',1),(51,8,'due_report',NULL,NULL,'retrieve_dateWise_DueReports',1),(52,8,'purchase_report',NULL,NULL,'todays_purchase_report',1),(53,8,'purchase_report_category_wise',NULL,NULL,'purchase_report_category_wise',1),(54,8,'sales_report_product_wise',NULL,NULL,'product_sales_reports_date_wise',1),(55,8,'sales_report_category_wise',NULL,NULL,'sales_report_category_wise',1),(56,10,'add_new_bank',NULL,NULL,'add_bank',1),(57,10,'bank_transaction',NULL,NULL,'bank_transaction',1),(58,10,'manage_bank',NULL,NULL,'bank_list',1),(59,14,'generate_commission',NULL,NULL,'commission',1),(60,12,'add_designation',NULL,NULL,'add_designation',1),(61,12,'manage_designation',NULL,NULL,'manage_designation',1),(62,12,'add_employee',NULL,NULL,'add_employee',1),(63,12,'manage_employee',NULL,NULL,'manage_employee',1),(64,12,'add_attendance',NULL,NULL,'add_attendance',1),(65,12,'manage_attendance',NULL,NULL,'manage_attendance',1),(66,12,'attendance_report',NULL,NULL,'attendance_report',1),(67,12,'add_benefits',NULL,NULL,'add_benefits',1),(68,12,'manage_benefits',NULL,NULL,'manage_benefits',1),(69,12,'add_salary_setup',NULL,NULL,'add_salary_setup',1),(70,12,'manage_salary_setup',NULL,NULL,'manage_salary_setup',1),(71,12,'salary_generate',NULL,NULL,'salary_generate',1),(72,12,'manage_salary_generate',NULL,NULL,'manage_salary_generate',1),(73,12,'salary_payment',NULL,NULL,'salary_payment',1),(74,12,'add_expense_item',NULL,NULL,'add_expense_item',1),(75,12,'manage_expense_item',NULL,NULL,'manage_expense_item',1),(76,12,'add_expense',NULL,NULL,'add_expense',1),(77,12,'manage_expense',NULL,NULL,'manage_expense',1),(78,12,'expense_statement',NULL,NULL,'expense_statement',1),(79,12,'add_person_officeloan',NULL,NULL,'add1_person',1),(80,12,'add_loan_officeloan',NULL,NULL,'add_office_loan',1),(81,12,'add_payment_officeloan',NULL,NULL,'add_loan_payment',1),(82,12,'manage_loan_officeloan',NULL,NULL,'manage1_person',1),(83,12,'add_person_personalloan',NULL,NULL,'add_person',1),(84,12,'add_loan_personalloan',NULL,NULL,'add_loan',1),(85,12,'add_payment_personalloan',NULL,NULL,'add_payment',1),(86,12,'manage_loan_personalloan',NULL,NULL,'manage_person',1),(87,15,'manage_company',NULL,NULL,'manage_company',1),(88,15,'add_user',NULL,NULL,'add_user',1),(89,15,'manage_users',NULL,NULL,'manage_user',1),(90,15,'language',NULL,NULL,'add_language',1),(91,15,'currency',NULL,NULL,'add_currency',1),(92,15,'setting',NULL,NULL,'soft_setting',1),(93,15,'add_role',NULL,NULL,'add_role',1),(94,15,'role_list',NULL,NULL,'role_list',1),(95,15,'user_assign_role',NULL,NULL,'user_assign',1),(96,15,'Permission',NULL,NULL,NULL,1),(97,8,'shipping_cost_report',NULL,NULL,'shipping_cost_report',1),(98,8,'user_wise_sales_report',NULL,NULL,'user_wise_sales_report',1),(99,8,'invoice_return',NULL,NULL,'invoice_return',1),(100,8,'supplier_return',NULL,NULL,'supplier_return',1),(101,8,'tax_report',NULL,NULL,'tax_report',1),(102,8,'profit_report',NULL,NULL,'profit_report',1),(103,11,'add_incometax',NULL,NULL,'add_incometax',1),(104,11,'manage_income_tax',NULL,NULL,'manage_income_tax',1),(105,13,'add_service',NULL,NULL,'create_service',1),(106,13,'manage_service',NULL,NULL,'manage_service',1),(107,13,'service_invoice',NULL,NULL,'service_invoice',1),(108,13,'manage_service_invoice',NULL,NULL,'manage_service_invoice',1),(109,11,'tax_report',NULL,NULL,'tax_report',1),(110,11,'invoice_wise_tax_report',NULL,NULL,'invoice_wise_tax_report',1),(111,2,'customer_advance',NULL,NULL,'customer_advance',1),(112,4,'supplier_advance',NULL,NULL,'supplier_advance',1),(113,2,'customer_ledger',NULL,NULL,'customer_ledger',1),(114,1,'gui_pos',NULL,NULL,'gui_pos',1),(115,15,'sms_configure',NULL,NULL,'sms_configure',1),(116,15,'backup_restore',NULL,NULL,'back_up',1),(117,15,'import',NULL,NULL,'sql_import',1),(118,15,'restore',NULL,NULL,'restore',1),(119,16,'add_quotation',NULL,NULL,'add_quotation',1),(120,16,'manage_quotation',NULL,NULL,'manage_quotation',1),(121,16,'add_to_invoice',NULL,NULL,'add_to_invoice',1);
/*!40000 ALTER TABLE `sub_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_information`
--

DROP TABLE IF EXISTS `supplier_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_information` (
  `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `details` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`supplier_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_information`
--

LOCK TABLES `supplier_information` WRITE;
/*!40000 ALTER TABLE `supplier_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_ledger`
--

DROP TABLE IF EXISTS `supplier_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_ledger` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(100) NOT NULL,
  `supplier_id` bigint(20) DEFAULT NULL,
  `chalan_no` varchar(100) DEFAULT NULL,
  `deposit_no` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `d_c` varchar(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_ledger`
--

LOCK TABLES `supplier_ledger` WRITE;
/*!40000 ALTER TABLE `supplier_ledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_product`
--

DROP TABLE IF EXISTS `supplier_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_product` (
  `supplier_pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(30) CHARACTER SET utf8 NOT NULL,
  `products_model` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `supplier_price` float DEFAULT NULL,
  PRIMARY KEY (`supplier_pr_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_product`
--

LOCK TABLES `supplier_product` WRITE;
/*!40000 ALTER TABLE `supplier_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `synchronizer_setting`
--

DROP TABLE IF EXISTS `synchronizer_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `synchronizer_setting` (
  `id` int(11) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `port` varchar(10) NOT NULL,
  `debug` varchar(10) NOT NULL,
  `project_root` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `synchronizer_setting`
--

LOCK TABLES `synchronizer_setting` WRITE;
/*!40000 ALTER TABLE `synchronizer_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `synchronizer_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_collection`
--

DROP TABLE IF EXISTS `tax_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `relation_id` varchar(30) NOT NULL,
  `tax0` text,
  `tax1` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_collection`
--

LOCK TABLES `tax_collection` WRITE;
/*!40000 ALTER TABLE `tax_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_information`
--

DROP TABLE IF EXISTS `tax_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_information` (
  `tax_id` varchar(15) NOT NULL,
  `tax` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_information`
--

LOCK TABLES `tax_information` WRITE;
/*!40000 ALTER TABLE `tax_information` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_settings`
--

DROP TABLE IF EXISTS `tax_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default_value` float NOT NULL,
  `tax_name` varchar(250) NOT NULL,
  `nt` int(11) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `is_show` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_settings`
--

LOCK TABLES `tax_settings` WRITE;
/*!40000 ALTER TABLE `tax_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `units` (
  `unit_id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `unit_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_login`
--

DROP TABLE IF EXISTS `user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` int(2) DEFAULT NULL,
  `security_code` varchar(255) DEFAULT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_login`
--

LOCK TABLES `user_login` WRITE;
/*!40000 ALTER TABLE `user_login` DISABLE KEYS */;
INSERT INTO `user_login` VALUES (1,'1','admin@admin.com','25f60bf2cef24aba573b66ebeb73bd70',1,NULL,1);
/*!40000 ALTER TABLE `user_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(15) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `company_name` varchar(250) DEFAULT NULL,
  `address` text,
  `phone` varchar(20) DEFAULT NULL,
  `gender` int(2) DEFAULT NULL,
  `date_of_birth` varchar(255) DEFAULT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'1','User','Admin',NULL,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `web_setting`
--

DROP TABLE IF EXISTS `web_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `web_setting` (
  `setting_id` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `invoice_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `timezone` varchar(150) NOT NULL,
  `currency_position` varchar(10) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `rtr` varchar(255) DEFAULT NULL,
  `captcha` int(11) DEFAULT '1' COMMENT '0=active,1=inactive',
  `site_key` varchar(250) DEFAULT NULL,
  `secret_key` varchar(250) DEFAULT NULL,
  `discount_type` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_setting`
--

LOCK TABLES `web_setting` WRITE;
/*!40000 ALTER TABLE `web_setting` DISABLE KEYS */;
INSERT INTO `web_setting` VALUES (1,'https://softest8.bdtask.com/saleserp_sas_v-2/./my-assets/image/logo/ffe35e6d55cf1335245f7cf31c1c9add.png','https://softest8.bdtask.com/saleserp_sas_v-2/./my-assets/image/logo/6b599751b8cad1afe5f7aeb8dcd03a31.png','https://softest8.bdtask.com/saleserp_sas_v-2/my-assets/image/logo/0bb2ee8377d8672d55b553ef11f07d69.png','Bs','America/La_Paz','0','Copyright© 2018-2019 Progreso. Todos los derechos reservados','spanish','0',1,'','',1);
/*!40000 ALTER TABLE `web_setting` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-03 21:39:21
