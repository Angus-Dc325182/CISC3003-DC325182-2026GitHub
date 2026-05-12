
CREATE DATABASE IF NOT EXISTS cisc3003_scenarioc
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE cisc3003_scenarioc;

-- C.03: Users table
CREATE TABLE IF NOT EXISTS users (
    id                  INT(11)      NOT NULL AUTO_INCREMENT,
    full_name           VARCHAR(100) NOT NULL,
    email               VARCHAR(150) NOT NULL UNIQUE,
    password_hash       VARCHAR(255) NOT NULL,
    is_active           TINYINT(1)   NOT NULL DEFAULT 0,
    activation_token    VARCHAR(64)  DEFAULT NULL,
    reset_token         VARCHAR(64)  DEFAULT NULL,
    reset_expires       DATETIME     DEFAULT NULL,
    created_at          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_login          DATETIME     DEFAULT NULL,
    PRIMARY KEY (id),
    INDEX idx_email (email),
    INDEX idx_activation (activation_token),
    INDEX idx_reset (reset_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;