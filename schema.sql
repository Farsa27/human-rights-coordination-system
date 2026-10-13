-- Human Rights Coordination System: database schema and sample data
-- Import this file in phpMyAdmin (Import tab) or run:
--   mysql -u root < database/schema.sql

CREATE DATABASE IF NOT EXISTS Human_Rights_Coordination_System
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE Human_Rights_Coordination_System;

-- Users. Admins are users with is_admin = 1.
CREATE TABLE user (
  User_Id      INT AUTO_INCREMENT PRIMARY KEY,
  User_name    VARCHAR(100) NOT NULL,
  Password     VARCHAR(255) NOT NULL,
  Phone_Number VARCHAR(20)  NOT NULL,
  is_admin     TINYINT(1)   NOT NULL DEFAULT 0
);

-- Donators: a user and the amount they have pledged.
CREATE TABLE donator (
  D_Id   INT PRIMARY KEY,
  Amount DECIMAL(12, 2) NOT NULL,
  FOREIGN KEY (D_Id) REFERENCES user (User_Id) ON DELETE CASCADE
);

-- Underprivileged users: one help request per user, reviewed by an admin.
CREATE TABLE underprivileged_user (
  U_ID      INT PRIMARY KEY,
  Amount    DECIMAL(12, 2) NOT NULL,
  Details   TEXT,
  Documents VARCHAR(255),
  Status    ENUM('pending', 'approved', 'denied') NOT NULL DEFAULT 'pending',
  FOREIGN KEY (U_ID) REFERENCES user (User_Id) ON DELETE CASCADE
);

-- Institutions for the five fundamental rights.
-- The first letter of Id gives the category:
-- F = Food, C = Clothes, M = Health care, E = Education, S = Shelter.
CREATE TABLE human_rights_institution (
  Id               VARCHAR(10)  PRIMARY KEY,
  Institution_Name VARCHAR(150) NOT NULL,
  Price_Range      VARCHAR(30)  NOT NULL,
  City_corporation VARCHAR(10)  NOT NULL  -- North, South or Both
);

-- Category-specific details (disjoint specialisation of human_rights_institution).
CREATE TABLE food (
  F_Id   VARCHAR(10) PRIMARY KEY,
  Number VARCHAR(20),
  FOREIGN KEY (F_Id) REFERENCES human_rights_institution (Id) ON DELETE CASCADE
);

CREATE TABLE clothes (
  C_Id   VARCHAR(10) PRIMARY KEY,
  Number VARCHAR(20),
  FOREIGN KEY (C_Id) REFERENCES human_rights_institution (Id) ON DELETE CASCADE
);

CREATE TABLE health_care (
  M_Id    VARCHAR(10) PRIMARY KEY,
  Hotline VARCHAR(20),
  FOREIGN KEY (M_Id) REFERENCES human_rights_institution (Id) ON DELETE CASCADE
);

CREATE TABLE education (
  E_Id VARCHAR(10) PRIMARY KEY,
  Type VARCHAR(50),
  FOREIGN KEY (E_Id) REFERENCES human_rights_institution (Id) ON DELETE CASCADE
);

CREATE TABLE shelter (
  S_Id                VARCHAR(10) PRIMARY KEY,
  Hotel_Agent_Number  VARCHAR(20),
  House_Agent_Number  VARCHAR(20),
  FOREIGN KEY (S_Id) REFERENCES human_rights_institution (Id) ON DELETE CASCADE
);

-- ---------------------------------------------------------------------------
-- Sample data (fictional names, for trying the app locally)
-- ---------------------------------------------------------------------------

-- Demo accounts. Change these passwords before using the app anywhere else.
INSERT INTO user (User_name, Password, Phone_Number, is_admin) VALUES
  ('admin',     'admin123', '01700000000', 1),
  ('demo_user', 'demo123',  '01800000000', 0);

INSERT INTO human_rights_institution (Id, Institution_Name, Price_Range, City_corporation) VALUES
  ('F001', 'Sample Community Kitchen',   'Low',            'North'),
  ('F002', 'Sample Family Restaurant',   'Medium',         'South'),
  ('F003', 'Sample Fine Dining',         'High',           'North'),
  ('C001', 'Sample Clothing Market',     'Low',            'South'),
  ('C002', 'Sample Fashion Store',       'High to medium', 'Both'),
  ('M001', 'Sample Public Hospital',     'Low',            'Both'),
  ('M002', 'Sample Private Clinic',      'High',           'North'),
  ('E001', 'Sample Government School',   'Low',            'South'),
  ('E002', 'Sample Private University',  'High',           'North'),
  ('S001', 'Sample Hostel',              'medium to low',  'South'),
  ('S002', 'Sample Apartment Agency',    'High to medium', 'North');

INSERT INTO food        VALUES ('F001', '01711111111'), ('F002', '01711111112'), ('F003', '01711111113');
INSERT INTO clothes     VALUES ('C001', '01722222221'), ('C002', '01722222222');
INSERT INTO health_care VALUES ('M001', '01733333331'), ('M002', '01733333332');
INSERT INTO education   VALUES ('E001', 'School'),      ('E002', 'University');
INSERT INTO shelter     VALUES ('S001', '01744444441', NULL), ('S002', NULL, '01744444442');
