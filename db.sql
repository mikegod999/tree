CREATE DATABASE IF NOT EXISTS `tree_db`;
USE `tree_db`;

CREATE TABLE IF NOT EXISTS `tree_node`
(
    `id`        INT NOT NULL AUTO_INCREMENT,
    `parent_id` INT          DEFAULT NULL,
    `title`     VARCHAR(250) DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `parent_id` (`parent_id`)
) COLLATE = 'utf8mb4_0900_ai_ci';