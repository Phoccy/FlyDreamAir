-- ========================================================
-- Project: FlyDreamAir Lounge Management System (LMS)
-- Version: 1.1 (Seed Data Baseline)
-- Description: Test data for eligibility and capacity logic
-- ========================================================

USE `flydreamair_db`;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `bookings`;
TRUNCATE TABLE `users`;
TRUNCATE TABLE `lounges`;
TRUNCATE TABLE `membership_tiers`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. SEED MEMBERSHIP TIERS
INSERT INTO `membership_tiers` (`tier_id`, `tier_name`, `priority_access`) VALUES 
(1, 'FlyDreamBlue', 0),
(2, 'FlyDreamGold', 1);

-- 2. SEED LOUNGES (SYD/MEL Hubs)
INSERT INTO `lounges` (`lounge_id`, `lounge_name`, `airport_code`, `max_capacity`, `vip_buffer`) VALUES 
(1, 'The Sydney Hub', 'SYD', 50, 10),
(2, 'The Melbourne Hub', 'MEL', 40, 8);

-- 3. SEED USERS (Passwords are 'password123')
-- password_hash = BCRYPT hash for 'password123'
INSERT INTO `users` (`tier_id`, `first_name`, `last_name`, `email`, `password_hash`, `is_staff`, `created_at`) VALUES 
-- ELIGIBLE: Gold Member (Joined 2 years ago)
(2, 'Harri', 'Manager', 'harri@flydreamair.com.au', '$2y$10$eImiTXuWVxjW72PDCuyWreQH40M3A98F7Z3F.9z.K7.uA5G1W5u7O', 0, '2024-01-10 10:00:00'),

-- ELIGIBLE: Blue Member (Joined 7 months ago - passes 180 day gate)
(1, 'Anas', 'Analyst', 'anas@flydreamair.com.au', '$2y$10$eImiTXuWVxjW72PDCuyWreQH40M3A98F7Z3F.9z.K7.uA5G1W5u7O', 0, DATE_SUB(NOW(), INTERVAL 190 DAY)),

-- INELIGIBLE: New Blue Member (Joined yesterday - fails 180 day gate)
(1, 'Denisha', 'Designer', 'den@flydreamair.com.au', '$2y$10$eImiTXuWVxjW72PDCuyWreQH40M3A98F7Z3F.9z.K7.uA5G1W5u7O', 0, DATE_SUB(NOW(), INTERVAL 1 DAY)),

-- STAFF: Admin Architect
(2, 'Adam', 'Architect', 'admin@flydreamair.com.au', '$2y$10$eImiTXuWVxjW72PDCuyWreQH40M3A98F7Z3F.9z.K7.uA5G1W5u7O', 1, NOW());

-- 4. SEED BOOKINGS (Active and Future)
INSERT INTO `bookings` (`user_id`, `lounge_id`, `flight_number`, `departure_time`, `amount_paid`, `booking_status`, `qr_code_token`) VALUES 
-- Harri has a flight in 4 hours
(1, 1, 'FDA101', DATE_ADD(NOW(), INTERVAL 4 HOUR), 65.00, 'confirmed', 'QR_HASH_SYD_HARRI_2026'),

-- Anas has a flight in 2 days
(2, 2, 'FDA202', DATE_ADD(NOW(), INTERVAL 2 DAY), 65.00, 'confirmed', 'QR_HASH_MEL_ANAS_2026');