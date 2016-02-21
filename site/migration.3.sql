ALTER DATABASE sgc_web CHARACTER SET utf8 COLLATE utf8_unicode_ci; 
ALTER TABLE articles CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci; 
ALTER TABLE menu_items CHARACTER SET utf8 COLLATE utf8_unicode_ci; 
ALTER TABLE resources CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci; 
ALTER TABLE site_configs CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci; 


REPLACE INTO site_configs (key_name , key_value) VALUES('migration_level', 3); 

