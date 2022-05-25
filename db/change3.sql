ALTER TABLE `contacts` CHANGE `FirstName` `Name` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `contacts` CHANGE `Country` `Service` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `contacts` CHANGE `State` `FindUs` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `contacts` CHANGE `Email` `Email` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;