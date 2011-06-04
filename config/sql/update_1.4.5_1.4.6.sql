ALTER TABLE  `transactions` ADD  `status_id` VARCHAR( 2 ) NOT NULL AFTER  `marker_id` ,
ADD  `controller` VARCHAR( 16 ) NOT NULL AFTER  `status_id` ,
ADD  `action` VARCHAR( 16 ) NOT NULL AFTER  `controller` ,
ADD  `ip` VARCHAR( 16 ) NOT NULL AFTER  `action`
