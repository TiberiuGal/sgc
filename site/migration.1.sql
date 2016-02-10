USE `sgc_web`; 

 
CREATE TABLE `sgc_web`.`media_types`( `id` INT NOT NULL AUTO_INCREMENT, `title` VARCHAR(255) NOT NULL, `description` TEXT, PRIMARY KEY (`id`) ); 
CREATE TABLE `sgc_web`.`resource_media`( `media_type_id` INT NOT NULL, `resource_id` INT NOT NULL, PRIMARY KEY (`media_type_id`, `resource_id`) ); 
INSERT INTO `sgc_web`.`media_types` (`id`, `title`, `description`) VALUES ('1', 'Resurse', 'Fisiere de descarcat din resurse'); 
INSERT INTO `sgc_web`.`media_types` (`id`, `title`, `description`) VALUES ('2', 'Carusel principal', 'Imagini ce apar in caruselul principal'); 
INSERT INTO `sgc_web`.`media_types` (`id`, `title`, `description`) VALUES ('3', 'Galerie Imagini', 'Imagini ce apar in galeria de imagini'); 
 
ALTER TABLE `sgc_web`.`site_configs` ADD UNIQUE INDEX `unique_key` (`key_name`); 

REPLACE INTO site_configs (key_name , key_value) VALUES('migration_level', 1);

