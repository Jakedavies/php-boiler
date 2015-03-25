
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255),
    `password` VARCHAR(255),
    `type` VARCHAR(255),
    `com-code` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- charity
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `charity`;

CREATE TABLE `charity`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `owner` INTEGER,
    `description` TEXT,
    `preview` VARCHAR(255),
    PRIMARY KEY (`id`),
    INDEX `fi_CHARITY_USER` (`owner`),
    CONSTRAINT `FK_CHARITY_USER`
        FOREIGN KEY (`owner`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
