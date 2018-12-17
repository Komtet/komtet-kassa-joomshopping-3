CREATE TABLE IF NOT EXISTS `#__jshopping_order_fiscalization_status` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`order_id` int(10) NOT NULL,
	`status` varchar(25),
	`description` varchar(25),

	PRIMARY KEY (`id`),
	KEY `order_id` (`order_id`)
);
