CREATE SCHEMA IF NOT EXISTS `slate`;

USE `slate`;

-- Create the account table
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `uid` varchar(32) NOT NULL,
    `username` varchar(255) NOT NULL,
    CONSTRAINT PK_ID PRIMARY KEY (`id`),
    CONSTRAINT UN_UID UNIQUE KEY (`uid`)
);

INSERT INTO
    `account`
        (`uid`, `username`)
VALUES
    ('8af70f72422af513ab06142b03e7175b', 'admin'),
    ('eae8110a79a9ffb89d7761d517cb6763', 'john.smith');

DROP TABLE IF EXISTS `cookie`;
-- Create the cookie table
CREATE TABLE `cookie` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `account_uid` varchar(32) NOT NULL,
    `value` varchar(255) NOT NULL,
    CONSTRAINT PK_ID PRIMARY KEY (`id`)
);

INSERT INTO
    `cookie`
        (`account_uid`, `value`)
VALUES
    -- admin
    ('8af70f72422af513ab06142b03e7175b', '9bda7bd97e7f99f043d0938a99580a06'),
    ('8af70f72422af513ab06142b03e7175b', '7d97bb33b7ef4d59a427d32a165a6726'),
    ('8af70f72422af513ab06142b03e7175b', 'b7919f5044bc54dc481b3fe04e19ac08'),
    ('8af70f72422af513ab06142b03e7175b', 'b95220e343c31b53745a66f18e7c958f'),
    ('8af70f72422af513ab06142b03e7175b', '7889f906beea4241edce5137b2c2145a'),

    -- john.smith
    ('eae8110a79a9ffb89d7761d517cb6763', '65f8942407da08e0b442ff026c13503c'),
    ('eae8110a79a9ffb89d7761d517cb6763', '03592b8a43a4dc56e33b1695d201271a'),
    ('eae8110a79a9ffb89d7761d517cb6763', '5cca4288962d47a430da11e6d3c02e59'),
    ('eae8110a79a9ffb89d7761d517cb6763', 'cd16c3868c03690c0d9cdc7bb7c9c8ac'),
    ('eae8110a79a9ffb89d7761d517cb6763', '1d1ada223d9198c3264474df4f8da9fe')
;