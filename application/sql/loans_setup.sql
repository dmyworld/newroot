CREATE TABLE IF NOT EXISTS `geopos_employee_loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(16,2) NOT NULL DEFAULT '0.00',
  `installment` decimal(16,2) NOT NULL DEFAULT '0.00',
  `account_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Due',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `note` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `geopos_employee_loan_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `date` date NOT NULL,
  `method` varchar(50) NOT NULL DEFAULT 'Cash',
  `note` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
