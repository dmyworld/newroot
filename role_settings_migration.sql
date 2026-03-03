CREATE TABLE `geopos_system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL UNIQUE,
  `setting_value` longtext NOT NULL,
  `access_level` enum('public', 'role_specific', 'super_admin_only') NOT NULL DEFAULT 'public',
  `allowed_roles` json DEFAULT NULL, -- JSON array of role IDs matching geopos_users.roleid (e.g., [2,3]) if 'role_specific'
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
