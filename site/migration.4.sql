ALTER TABLE `articles` ENGINE=MYISAM;

CREATE FULLTEXT INDEX search_index
ON articles(title, body, excerpt);

insert into site_configs(key_name, key_value, editable) values('contact_phone', '0264-457.552 (tel/fax), 0733-070.590', 1);
insert into site_configs(key_name, key_value, editable) values('contact_email', 'secretariat@scoalachristiana.ro', 1);

REPLACE INTO site_configs (key_name , key_value) VALUES('migration_level', 4); 


