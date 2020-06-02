ALTER TABLE `ip_expenses` ADD COLUMN `expenses_project_id` INT(20) DEFAULT 0;
ALTER TABLE `ip_expenses` ADD COLUMN `expenses_amount_euro` decimal(20,2) DEFAULT 0;
ALTER TABLE `ip_expenses` ADD COLUMN `expenses_currency` varchar(250) DEFAULT 'dollar';
