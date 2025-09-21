-- MySQL Database Setup for Task Manager API
-- Run this script as root user: mysql -u root -p < setup_mysql.sql

CREATE DATABASE IF NOT EXISTS task_manager_api;
USE task_manager_api;

-- Create user for the application
CREATE USER IF NOT EXISTS 'task_manager_user'@'localhost' IDENTIFIED BY 'task_manager_password';

-- Grant all privileges on the database
GRANT ALL PRIVILEGES ON task_manager_api.* TO 'task_manager_user'@'localhost';

-- Flush privileges to ensure they take effect
FLUSH PRIVILEGES;

-- Show the created database
SHOW DATABASES;
