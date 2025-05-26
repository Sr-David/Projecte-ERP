-- MySQL dump 10.13  Distrib 9.1.0, for Linux (x86_64)
--
-- Host: localhost    Database: ERP_CRM
-- ------------------------------------------------------
-- Server version	9.1.0

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
-- Table structure for table `Clients`
--

DROP TABLE IF EXISTS `Clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Clients` (
  `idClient` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `ClientTypeID` int DEFAULT NULL,
  `idEmpresa` int NOT NULL,
  `CreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idClient`),
  KEY `ClientTypeID` (`ClientTypeID`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`ClientTypeID`) REFERENCES `ClientType` (`idClientType`),
  CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ClientType`
--

DROP TABLE IF EXISTS `ClientType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ClientType` (
  `idClientType` int NOT NULL AUTO_INCREMENT,
  `ClientType` varchar(45) NOT NULL,
  `Description` text,
  `idEmpresa` int NOT NULL,
  PRIMARY KEY (`idClientType`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `clienttype_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Where the client''s type is stored';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ProductsServices`
--








DROP TABLE IF EXISTS `ProductsServices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProductsServices` (
  `idProductService` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Description` text,
  `Price` decimal(10,2) NOT NULL,
  `Stock` int NOT NULL,
  `EntryDate` datetime NOT NULL,
  `idEmpresa` int NOT NULL,
  PRIMARY KEY (`idProductService`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `productsservices_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SalesDetails`
--

DROP TABLE IF EXISTS `SalesDetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SalesDetails` (
  `idSaleDetail` int NOT NULL AUTO_INCREMENT,
  `ProposalID` int DEFAULT NULL,
  `ProductServiceID` int DEFAULT NULL,
  `QuantitySold` int NOT NULL,
  `UnitPrice` decimal(10,2) NOT NULL,
  `idEmpresa` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idSaleDetail`),
  KEY `ProposalID` (`ProposalID`),
  KEY `ProductServiceID` (`ProductServiceID`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `salesdetails_ibfk_2` FOREIGN KEY (`ProductServiceID`) REFERENCES `ProductsServices` (`idProductService`),
  CONSTRAINT `salesdetails_ibfk_3` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `SalesProposals`
--

DROP TABLE IF EXISTS `SalesProposals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `SalesProposals` (
  `idSalesProposals` int NOT NULL AUTO_INCREMENT,
  `ClientID` int DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `State` varchar(45) DEFAULT NULL,
  `Details` text,
  `idEmpresa` int NOT NULL,
  PRIMARY KEY (`idSalesProposals`),
  KEY `fk_salesproposals_client` (`ClientID`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `fk_salesproposals_client` FOREIGN KEY (`ClientID`) REFERENCES `Clients` (`idClient`),
  CONSTRAINT `salesproposals_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `UserAdministration`
--

DROP TABLE IF EXISTS `UserAdministration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `UserAdministration` (
  `idEmpresa` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Permissions` text,
  PRIMARY KEY (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Permissions` text,
  `idEmpresa` int NOT NULL,
  PRIMARY KEY (`idUser`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Leads`
--

DROP TABLE IF EXISTS `Leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Leads` (
  `idLead` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `ClientTypeID` int DEFAULT NULL,
  `Source` varchar(100) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'New',
  `Notes` text,
  `CreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `AssignedToID` int DEFAULT NULL,
  `idEmpresa` int NOT NULL,
  PRIMARY KEY (`idLead`),
  KEY `ClientTypeID` (`ClientTypeID`),
  KEY `AssignedToID` (`AssignedToID`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`ClientTypeID`) REFERENCES `ClientType` (`idClientType`),
  CONSTRAINT `leads_ibfk_2` FOREIGN KEY (`AssignedToID`) REFERENCES `UserAdministration` (`idEmpresa`),
  CONSTRAINT `leads_ibfk_3` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

CREATE TABLE `Notes` (
  `idNote` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Content` text,
  `RelatedTo` enum('client','lead','project','sale','general') DEFAULT 'general',
  `RelatedID` int DEFAULT NULL,
  `CreatedBy` int DEFAULT NULL,
  `idEmpresa` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idNote`),
  KEY `idEmpresa` (`idEmpresa`),
  KEY `CreatedBy` (`CreatedBy`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`),
  CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`CreatedBy`) REFERENCES `Users` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci; 

--
-- Table structure for table `Projects`
--

DROP TABLE IF EXISTS `Projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Projects` (
  `idProject` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` text,
  `ClientID` int DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Status` enum('Pending','In Progress','Completed','Cancelled') DEFAULT 'Pending',
  `Budget` decimal(10,2) DEFAULT NULL,
  `BillingType` enum('Fixed','Hourly','None') DEFAULT 'Fixed',
  `Notes` text,
  `idEmpresa` int NOT NULL,
  `CreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `UpdatedAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idProject`),
  KEY `ClientID` (`ClientID`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `Clients` (`idClient`),
  CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`idEmpresa`) REFERENCES `UserAdministration` (`idEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'ERP_CRM'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-07 16:09:49
