-- A.09: Create database using phpMyAdmin / SQL
CREATE DATABASE IF NOT EXISTS cisc3003_scenarioa
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE cisc3003_scenarioa;

-- A.10: SQL INSERT INTO - Create users table
CREATE TABLE IF NOT EXISTS users (
    id          INT(11)      NOT NULL AUTO_INCREMENT,
    full_name   VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    phone       VARCHAR(20)  DEFAULT NULL,
    gender      ENUM('male','female','other') DEFAULT NULL,
    country     VARCHAR(50)  DEFAULT NULL,
    hobbies     TEXT         DEFAULT NULL,
    message     TEXT         DEFAULT NULL,
    newsletter  TINYINT(1)   DEFAULT 0,
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;