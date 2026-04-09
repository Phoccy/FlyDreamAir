-- ========================================================
-- Project: FlyDreamAir Lounge Management System (LMS)
-- Version: 1.1 (Production Baseline)
-- Architect: Adam
-- Target: MySQL 8.0+ / Strict Mode
-- ========================================================

DROP DATABASE IF EXISTS `flydreamair_db`;
CREATE DATABASE `flydreamair_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `flydreamair_db`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------
-- 1. Table: membership_tiers
-- ---------------------------------------------------------
CREATE TABLE `membership_tiers` (
  `tier_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `tier_name` varchar(20) NOT NULL UNIQUE, -- 'FlyDreamBlue', 'FlyDreamGold'
  `priority_access` boolean DEFAULT FALSE,
  PRIMARY KEY (`tier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 2. Table: lounges
-- ---------------------------------------------------------
CREATE TABLE `lounges` (
  `lounge_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `lounge_name` varchar(50) NOT NULL,
  `airport_code` char(3) NOT NULL,
  `max_capacity` smallint unsigned NOT NULL,
  `vip_buffer` smallint unsigned DEFAULT 5,
  PRIMARY KEY (`lounge_id`),
  -- CONSTRAINT: Only support SYD and MEL for the Australian Pilot
  CONSTRAINT `chk_airport_code` CHECK (`airport_code` IN ('SYD', 'MEL')),
  CONSTRAINT `chk_capacity_logic` CHECK (`max_capacity` > `vip_buffer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 3. Table: users
-- ---------------------------------------------------------
CREATE TABLE `users` (
  `user_id` int unsigned NOT NULL AUTO_INCREMENT,
  `tier_id` tinyint unsigned NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `is_staff` boolean DEFAULT FALSE,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  -- VIRTUAL COLUMN: Automates the 180-day eligibility check
  `eligible_from_date` DATE GENERATED ALWAYS AS (DATE_ADD(CAST(`created_at` AS DATE), INTERVAL 180 DAY)) VIRTUAL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_tier` 
    FOREIGN KEY (`tier_id`) REFERENCES `membership_tiers` (`tier_id`) 
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Table: bookings (Fixed for MySQL Determinism)
CREATE TABLE `bookings` (
  `booking_id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `lounge_id` tinyint unsigned NOT NULL,
  `flight_number` varchar(10) NOT NULL,
  `departure_time` datetime NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 65.00,
  `booking_status` enum('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
  `payment_id` varchar(100) DEFAULT NULL, 
  `qr_code_token` varchar(64) NOT NULL UNIQUE,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`booking_id`),
  CONSTRAINT `chk_minimum_payment` CHECK (`amount_paid` >= 65.00),
  CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_booking_lounge` FOREIGN KEY (`lounge_id`) REFERENCES `lounges` (`lounge_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TRIGGER: Enforce the 7-day advance and future-flight rules
DELIMITER //
CREATE TRIGGER `before_booking_insert`
BEFORE INSERT ON `bookings`
FOR EACH ROW
BEGIN
    -- Check: Cannot book flights in the past
    IF NEW.departure_time < NOW() THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Cannot book a flight in the past.';
    END IF;

    -- Check: Cannot book more than 7 days in advance
    IF NEW.departure_time > DATE_ADD(NOW(), INTERVAL 7 DAY) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Bookings are only permitted within 7 days of departure.';
    END IF;
END;
//
DELIMITER ;

SET FOREIGN_KEY_CHECKS = 1;