DROP TABLE IF EXISTS `Champion`;
DROP TABLE IF EXISTS `Region`;
DROP TABLE IF EXISTS `Damage`;
DROP TABLE IF EXISTS `Role`;
DROP TABLE IF EXISTS `Plays`;
DROP TABLE IF EXISTS `Uses`;
DROP TABLE IF EXISTS `StartItem`;

-- Create the Champion table with following properties:
-- championID - an auto incrementing integer which is the primary key
-- name - a varchar of maximum length 255, cannot be null
-- baseAD - an integer
-- baseArmor - an integer
-- baseHP - an integer
-- baseMP - an integer
-- fk_regionID - an integer which is a foreign key reference to Region.regionID
-- fk_damageID - an integer which is a foreign key reference to Damage.damageID
-- the name of the project should be unique in this table
CREATE TABLE `Champion`(
`championID` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`baseAD` int(11),
`baseArmor` int(11),
`baseHP` int(11),
`baseMP` int(11),
`fk_regionID` int(11),
`fk_damageID` int(11),
PRIMARY KEY (`championID`),
FOREIGN KEY (`fk_regionID`) REFERENCES `Region` (`regionID`),
FOREIGN KEY (`fk_damageID`) REFERENCES `Damage` (`damageID`),
UNIQUE KEY (`name`)
) ENGINE=InnoDB;

-- Create the Region Table with following properties:
-- regionID- an auto incrementing integer which is the primary key
-- name - a varchar of maximum length 255, cannot be null
-- the name of the Region should be unique in this table
CREATE TABLE `Region`(
`regionID` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
PRIMARY KEY (`regionID`),
UNIQUE KEY (`name`)
) ENGINE=InnoDB;

-- Create the Damage Table with following properties:
-- damageID- an auto incrementing integer which is the primary key
-- type - a varchar of maximum length 255, cannot be null
-- the type of the Damage should be unique in this table
CREATE TABLE `Damage`(
`damageID` int(11) NOT NULL AUTO_INCREMENT,
`type` varchar(255) NOT NULL,
PRIMARY KEY (`damageID`),
UNIQUE KEY (`type`)
) ENGINE=InnoDB;

-- Create the Role Table with following properties:
-- roleID- an auto incrementing integer which is the primary key
-- type - a varchar of maximum length 255, cannot be null
-- the type of the Role should be unique in this table
CREATE TABLE `Role`(
`roleID` int(11) NOT NULL AUTO_INCREMENT,
`type` varchar(255) NOT NULL,
PRIMARY KEY (`roleID`),
UNIQUE KEY (`type`)
) ENGINE=InnoDB;

-- Create the StarterItem Table with following properties:
-- itemID- an auto incrementing integer which is the primary key
-- name - a varchar of maximum length 255, cannot be null
-- the name of the StarterItem should be unique in this table
CREATE TABLE `StarterItem`(
`itemID` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
PRIMARY KEY (`itemID`),
UNIQUE KEY (`name`)
) ENGINE=InnoDB;

-- ------------------ Relationship Tables ------------------------
-- Create the Plays table with following properties:
-- fk_roleID - an integer which is a foreign key reference to Role.roleID
-- fk_championID - an integer which is a foreign key reference to Champion.championID
-- both properties are primary keys for this table
CREATE TABLE `Plays`(
`fk_roleID` int(11) NOT NULL,
`fk_championID` int(11) NOT NULL,
PRIMARY KEY (`fk_roleID`, `fk_championID`),
FOREIGN KEY (`fk_roleID`) REFERENCES `Role` (`roleID`) ON DELETE CASCADE,
FOREIGN KEY (`fk_championID`) REFERENCES `Champion` (`championID`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Create the Usess table with following properties:
-- fk_itemID - an integer which is a foreign key reference to StarterItem.itemID
-- fk_championID - an integer which is a foreign key reference to Champion.championID
-- both properties are primary keys for this table
CREATE TABLE `Uses`(
`fk_itemID` int(11) NOT NULL,
`fk_championID` int(11) NOT NULL,
PRIMARY KEY (`fk_itemID`, `fk_championID`),
FOREIGN KEY (`fk_itemID`) REFERENCES `StarterItem` (`itemID`) ON DELETE CASCADE,
FOREIGN KEY (`fk_championID`) REFERENCES `Champion` (`championID`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --------------------Insert to Tables -------------------------
INSERT INTO Region (name) VALUES
('Bandle City'),
('Bilgewater'),
('Demacia'),
('Freljord'),
('Ionia'),
('Mount Targon'),
('Noxus'),
('Piltover'),
('Shadow Isles'),
('Shurima'),
('Void'),
('Zaun');

INSERT INTO Damage (type) VALUES
('Physical Damage'),
('Magic Damage'),
('Mixed Damage');

INSERT INTO Role (type) VALUES
('Assassin'),
('Fighter'),
('Mage'),
('Marksman'),
('Support'),
('Tank');

INSERT INTO StarterItem (name) VALUES
('Amplifying Tome'),
('Ancient Coin'),
('Boots of Speed'),
('Corrupting Potion'),
('Cloth Armor'),
('Dorans Blade'),
('Dorans Ring'),
('Dorans Shield'),
('Refillable Potion'),
('Relic Shield'),
('Ruby Crystal'),
('Spellthiefs Edge'),
('Health Potion'),
('Hunters Talisman');

INSERT INTO Champion (name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES
('Ahri', 53, 20.9, 334, 514, (SELECT regionID FROM Region WHERE name = 'Ionia'), (SELECT damageID FROM Damage WHERE type = 'Magic Damage'));

INSERT INTO Champion (name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES
('Akali', 58.4, 26.4, 0, 588, (SELECT regionID FROM Region WHERE name = 'Ionia'), (SELECT damageID FROM Damage WHERE type = 'Mixed Damage')),
('Ashe', 56.5, 21.2, 280, 528, (SELECT regionID FROM Region WHERE name = 'Freljord'), (SELECT damageID FROM Damage WHERE type = 'Physical Damage')),
('Soraka', 50, 23.4, 351, 529, (SELECT regionID FROM Region WHERE name = 'Ionia'), (SELECT damageID FROM Damage WHERE type = 'Magic Damage')),
('Lux', 53.5, 18.7, 384, 478, (SELECT regionID FROM Region WHERE name = 'Demacia'), (SELECT damageID FROM Damage WHERE type = 'Magic Damage'));

INSERT INTO Champion (name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES
('Jinx', 58.5, 22.9, 246, 518, (SELECT regionID FROM Region WHERE name = 'Zaun'), (SELECT damageID FROM Damage WHERE type = 'Physical Damage')),
('Janna', 52, 19.4, 410, 487, (SELECT regionID FROM Region WHERE name = 'Zaun'), (SELECT damageID FROM Damage WHERE type = 'Magic Damage'));

INSERT INTO Champion (name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES
('Caitlyn', 53.7, 22.9, 314, 524, (SELECT regionID FROM Region WHERE name = 'Piltover'), (SELECT damageID FROM Damage WHERE type = 'Physical Damage')),
('Jayce', 50.4, 22.4, 357, 571, (SELECT regionID FROM Region WHERE name = 'Piltover'), (SELECT damageID FROM Damage WHERE type = 'Physical Damage')),
('Ziggs', 54.2, 21.5, 384, 524, (SELECT regionID FROM Region WHERE name = 'Piltover'), (SELECT damageID FROM Damage WHERE type = 'Magic Damage')),
('Ezreal', 55.7, 21.9, 361, 484, (SELECT regionID FROM Region WHERE name = 'Piltover'), (SELECT damageID FROM Damage WHERE type = 'Mixed Damage'));

INSERT INTO Champion (name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES
('Anivia', 51.4, 21.2, 396, 468, (SELECT regionID FROM Region WHERE name = 'Freljord'), (SELECT damageID FROM Damage WHERE type = 'Magic Damage')),
('Udyr', 58.3, 25.5, 270, 593, (SELECT regionID FROM Region WHERE name = 'Freljord'), (SELECT damageID FROM Damage WHERE type = 'Mixed Damage'));

INSERT INTO Champion (name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES
('Jhin', 53, 20, 300, 540, (SELECT regionID FROM Region WHERE name = 'Ionia'), (SELECT damageID FROM Damage WHERE type = 'Physical Damage'));

INSERT INTO Champion (name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES
('Lucian', 57.5, 24, 349, 554, (SELECT regionID FROM Region WHERE name = 'Demacia'), (SELECT damageID FROM Damage WHERE type = 'Physical Damage'));

INSERT INTO Champion (name, baseAD, baseArmor, baseMP, baseHP, fk_regionID, fk_damageID) VALUES
('Kalista', 62.9, 19, 232, 518, (SELECT regionID FROM Region WHERE name = 'Shadow Isles'), (SELECT damageID FROM Damage WHERE type = 'Physical Damage')),
('Thersh', 47.7, 16, 274, 561, (SELECT regionID FROM Region WHERE name = 'Shadow Isles'), (SELECT damageID FROM Damage WHERE type = 'Magic Damage')),
('Yorick', 57, 30, 300, 580, (SELECT regionID FROM Region WHERE name = 'Shadow Isles'), (SELECT damageID FROM Damage WHERE type = 'Mixed Damage'));























