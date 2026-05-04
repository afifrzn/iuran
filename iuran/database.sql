-- =============================================
-- Database: iuran_db
-- =============================================

CREATE DATABASE IF NOT EXISTS iuran_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE iuran_db;

CREATE TABLE IF NOT EXISTS members (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nama        VARCHAR(100) NOT NULL,
    tipe        ENUM('makan','tanpa') NOT NULL DEFAULT 'tanpa',
    status_tf   ENUM('FALSE','DONE') NOT NULL DEFAULT 'FALSE',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data awal dari spreadsheet
INSERT INTO members (nama, tipe, status_tf) VALUES
('Vito',    'tanpa', 'FALSE'),
('Widi',    'tanpa', 'FALSE'),
('Owi',     'tanpa', 'FALSE'),
('Fara',    'tanpa', 'FALSE'),
('Ryan',    'tanpa', 'FALSE'),
('Ragil',   'tanpa', 'FALSE'),
('Debby',   'tanpa', 'FALSE'),
('Ezar',    'tanpa', 'FALSE'),
('Tio',     'tanpa', 'FALSE'),
('Devan',   'tanpa', 'FALSE'),
('Iqbal',   'tanpa', 'FALSE'),
('Balgis',  'tanpa', 'FALSE'),
('Akram',   'tanpa', 'FALSE'),
('Abi P',   'tanpa', 'FALSE'),
('Aiman',   'tanpa', 'FALSE'),
('Valen',   'tanpa', 'FALSE'),
('Nabil',   'tanpa', 'FALSE'),
('Kenji',   'tanpa', 'FALSE'),
('Rafa',    'makan', 'FALSE'),
('Mela',    'makan', 'FALSE'),
('Desthrie','makan', 'FALSE'),
('Rendy',   'makan', 'FALSE'),
('Axel',    'makan', 'FALSE'),
('Azizah',  'makan', 'FALSE'),
('Tarisa',  'makan', 'FALSE'),
('Ayu',     'makan', 'FALSE'),
('Nio',     'makan', 'FALSE'),
('Salwa',   'makan', 'FALSE'),
('Elma',    'makan', 'FALSE'),
('Radit',   'makan', 'FALSE'),
('Ryu',     'makan', 'FALSE'),
('Fawaz',   'makan', 'FALSE'),
('Abi',     'makan', 'FALSE'),
('Adib',    'makan', 'FALSE'),
('Elang',   'makan', 'FALSE'),
('Bagus',   'makan', 'FALSE'),
('Ramzi',   'makan', 'FALSE'),
('Naila',   'makan', 'FALSE'),
('Arga',    'makan', 'FALSE'),
('Attaya',  'makan', 'FALSE'),
('Afif',    'makan', 'FALSE'),
('Farel',   'makan', 'FALSE');
