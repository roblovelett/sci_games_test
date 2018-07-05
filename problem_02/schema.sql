CREATE TABLE `sci_games_test`.`player` (
  `player_id` INT ZEROFILL NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `credits` INT ZEROFILL NOT NULL,
  `lifetime_spins` INT ZEROFILL NOT NULL,
  `salt_value` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`player_id`));