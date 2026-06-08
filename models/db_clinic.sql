-- ============================================================
--  models/db_clinic.sql  –  Clinic Queue Management System
--  Improved version with timestamps and email
-- ============================================================

CREATE DATABASE IF NOT EXISTS db_clinic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_clinic;

-- ─── USERS ───────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NULL UNIQUE,
    full_name   VARCHAR(100) NOT NULL,
    age         TINYINT UNSIGNED,
    password    VARCHAR(255) NOT NULL,          -- bcrypt hash
    role        ENUM('patient','doctor','admin') NOT NULL DEFAULT 'patient',
    is_online   TINYINT(1) NOT NULL DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ─── SERVICES ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS services (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ─── APPOINTMENTS (scheduled / book.php) ─────────────────────
CREATE TABLE IF NOT EXISTS appointments (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    patient_id  INT,                                -- NULL for guest bookings
    full_name   VARCHAR(100) NOT NULL,
    phone       VARCHAR(20)  NOT NULL,
    appt_date   DATE         NOT NULL,
    reason      VARCHAR(100) NOT NULL,
    status      ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status)
);

-- ─── TICKETS (walk-ins / consult.php) ────────────────────────
CREATE TABLE IF NOT EXISTS tickets (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    full_name     VARCHAR(100) NOT NULL,
    phone         VARCHAR(20)  NOT NULL,
    reason        VARCHAR(100) NOT NULL,
    ticket_number VARCHAR(10)  NOT NULL,           -- e.g. TKT-001
    status        ENUM('waiting','serving','completed','no_show') NOT NULL DEFAULT 'waiting',
    cancelled_by  INT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cancelled_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status)
);

-- ─── ACTIVITY LOG ────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS activity_log (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    logged_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
--  SEED DATA
-- ============================================================

INSERT IGNORE INTO users (username, email, full_name, age, password, role, is_online) VALUES
('admin',   'admin@clinic.local', 'Admin Leo',   30, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin',   1),
('dreyes',  'dreyes@clinic.local','Dr. Reyes',   45, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'doctor',  1),
('dsantos', 'dsantos@clinic.local','Dr. Santos',  38, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'doctor',  0),
('jdoe',    'jdoe@patient.local',  'John Doe',    28, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'patient', 0);

INSERT IGNORE INTO services (name, description) VALUES
('General Checkup',      'Routine physical examination and health assessment.'),
('Pediatric Consult',    'Child health consultations for ages 0–12.'),
('Vaccination',          'Immunization services for all ages.'),
('Prescription Renewal', 'Review and renewal of existing prescriptions.');
