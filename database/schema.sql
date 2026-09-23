CREATE DATABASE IF NOT EXISTS `edoc`;
USE `edoc`;

-- Admin Table
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`aemail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`aemail`, `apassword`) VALUES
('admin@edoc.com', '123');

-- Specialties Table
DROP TABLE IF EXISTS `specialties`;
CREATE TABLE `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `specialties` (`id`, `sname`) VALUES
(1, 'Cardiology'),
(2, 'Dentistry'),
(3, 'Orthopedics'),
(4, 'Ophthalmology'),
(5, 'Pediatrics');

-- Doctor Table
DROP TABLE IF EXISTS `doctor`;
CREATE TABLE `doctor` (
  `docid` int(11) NOT NULL AUTO_INCREMENT,
  `docemail` varchar(255) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  `docpassword` varchar(255) DEFAULT NULL,
  `docnic` varchar(15) DEFAULT NULL,
  `doctel` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL,
  PRIMARY KEY (`docid`),
  KEY `specialties` (`specialties`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `doctor` (`docemail`, `docname`, `docpassword`, `docnic`, `doctel`, `specialties`) VALUES
('drkumar@example.com', 'Dr. Kumar Sharma', 'password1', 'IN1234567', '+91-9876543210', 1),
('drpatel@example.com', 'Dr. Patel Gupta', 'password2', 'IN2345678', '+91-8765432109', 2),
('drsingh@example.com', 'Dr. Singh Kapoor', 'password3', 'IN3456789', '+91-7654321098', 3),
('drsharma@example.com', 'Dr. Sharma Reddy', 'password4', 'IN4567890', '+91-6543210987', 1),
('drjoshi@example.com', 'Dr. Joshi Verma', 'password5', 'IN5678901', '+91-5432109876', 2);

-- Patient Table
DROP TABLE IF EXISTS `patient`;
CREATE TABLE `patient` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pnic` varchar(15) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `ptel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `patient` (`pemail`, `pname`, `ppassword`, `paddress`, `pnic`, `pdob`, `ptel`) VALUES
('neha@example.com', 'Neha Patel', 'password1', '123, ABC Street, Mumbai', 'IN1234567', '1990-05-15', '+91-9876543210'),
('raj@example.com', 'Raj Kumar', 'password2', '456, XYZ Road, Delhi', 'IN2345678', '1985-08-20', '+91-8765432109'),
('priya@example.com', 'Priya Sharma', 'password3', '789, LMN Avenue, Bangalore', 'IN3456789', '1992-03-10', '+91-7654321098'),
('anil@example.com', 'Anil Gupta', 'password4', '012, PQR Colony, Chennai', 'IN4567890', '1988-11-25', '+91-6543210987'),
('sneha@example.com', 'Sneha Singh', 'password5', '345, DEF Street, Kolkata', 'IN5678901', '1994-07-05', '+91-5432109876');

-- Schedule Table
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `scheduleid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL,
  PRIMARY KEY (`scheduleid`),
  KEY `docid` (`docid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `schedule` (`docid`, `title`, `scheduledate`, `scheduletime`, `nop`) VALUES
('1', 'General Checkup', '2024-05-01', '09:00:00', 10),
('2', 'Dental Consultation', '2024-05-02', '10:30:00', 8),
('3', 'Orthopedic Appointment', '2024-05-03', '11:15:00', 6),
('4', 'Eye Examination', '2024-05-04', '14:00:00', 12),
('5', 'Pediatric Checkup', '2024-05-05', '15:45:00', 9);

-- Appointment Table
DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment` (
  `appoid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  PRIMARY KEY (`appoid`),
  KEY `pid` (`pid`),
  KEY `scheduleid` (`scheduleid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `appointment` (`pid`, `apponum`, `scheduleid`, `appodate`) VALUES
(101, 1, 201, '2024-05-01'),
(102, 2, 202, '2024-05-02'),
(103, 3, 203, '2024-05-03'),
(104, 4, 204, '2024-05-04'),
(105, 5, 205, '2024-05-05');

-- Webuser Table
DROP TABLE IF EXISTS `webuser`;
CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@edoc.com', 'a'),
('drjoshi@example.com', 'd'),
('amara@edoc.com', 'd'),
('patient@edoc.com', 'p'),
('snehasingh@gmail.com', 'p');