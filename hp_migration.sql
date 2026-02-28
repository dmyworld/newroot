CREATE TABLE IF NOT EXISTS `geopos_hp_contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `total_amount` decimal(16,2) NOT NULL,
  `down_payment` decimal(16,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `interest_amount` decimal(16,2) NOT NULL,
  `installment_amount` decimal(16,2) NOT NULL,
  `num_installments` int(11) NOT NULL,
  `frequency` enum('daily','weekly','monthly') NOT NULL DEFAULT 'monthly',
  `start_date` date NOT NULL,
  `status` enum('pending','active','completed','defaulted') NOT NULL DEFAULT 'pending',
  `loc` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `loc` (`loc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `geopos_hp_installments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) NOT NULL,
  `installment_num` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `paid_amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `status` enum('unpaid','partially_paid','paid') NOT NULL DEFAULT 'unpaid',
  `payment_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contract_id` (`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `geopos_hp_guarantors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nic` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`id`),
  KEY `contract_id` (`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
