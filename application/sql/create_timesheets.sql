-- Payroll Timesheets Table
CREATE TABLE IF NOT EXISTS `geopos_timesheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `job_code_id` int(11) DEFAULT NULL,
  `clock_in` datetime NOT NULL,
  `clock_out` datetime NOT NULL,
  `total_hours` decimal(5,2) NOT NULL DEFAULT '0.00',
  `is_overtime` tinyint(1) NOT NULL DEFAULT '0',
  `note` text,
  `status` varchar(20) DEFAULT 'Pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `job_code_id` (`job_code_id`),
  KEY `clock_in` (`clock_in`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
