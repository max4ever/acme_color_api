CREATE DATABASE `colorsdb`;

CREATE TABLE `colorsdb`.`color`
(
    `id`       INT         NOT NULL AUTO_INCREMENT,
    `name`     VARCHAR(50) NOT NULL,
    `hexValue` VARCHAR(6)  NOT NULL,
    PRIMARY KEY (`id`)
);
INSERT INTO `colorsdb`.`color` (`name`, `hexValue`) VALUES ('red', 'FFRRGG');
INSERT INTO `colorsdb`.`color` (`name`, `hexValue`) VALUES ('blue', 'FFGGZZ');
