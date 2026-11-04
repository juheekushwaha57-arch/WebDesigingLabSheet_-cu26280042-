CREATE USER 'app_user'@'localhost' IDENTIFIED BY 'secure_password_123';
GRANT SELECT, INSERT, UPDATE, DELETE ON webapp_db.* TO 'app_user'@'localhost';
FLUSH PRIVILEGES;
