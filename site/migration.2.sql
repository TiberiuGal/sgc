ALTER TABLE site_configs ADD editable BOOLEAN DEFAULT 0; 

INSERT INTO `sgc_web`.`site_configs` (`id`, `key_name`, `key_value`, `editable`) VALUES ('1', 'partners', 'Michelin, Coca-Cola, Naturlich, Apache', '1'); 

REPLACE INTO site_configs (key_name , key_value) VALUES('migration_level', 2); 