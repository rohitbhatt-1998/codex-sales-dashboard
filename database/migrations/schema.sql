CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  created_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(120) NOT NULL UNIQUE,
  setting_value TEXT NULL,
  updated_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  custom_fields JSON NULL,
  call_status ENUM('Not Called','Calling','Completed','Failed') NOT NULL DEFAULT 'Not Called',
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS knowledge_base (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  file_type VARCHAR(20) NOT NULL,
  stored_path VARCHAR(255) NOT NULL,
  extracted_text MEDIUMTEXT NULL,
  created_at DATETIME NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS call_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  customer_id INT NOT NULL,
  provider_used VARCHAR(30) NOT NULL,
  ai_provider_used VARCHAR(30) NOT NULL,
  conversation LONGTEXT NOT NULL,
  duration_seconds INT NOT NULL,
  lead_status ENUM('Hot','Warm','Cold') NOT NULL,
  created_at DATETIME NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);
