CREATE TABLE `log`
(
    `id`          bigint          NOT NULL AUTO_INCREMENT COMMENT 'id',
    `key`         char(255)       NOT NULL DEFAULT 'default' COMMENT 'key',
    `type`        char(255)       NOT NULL DEFAULT 'info' COMMENT '类型',
    `record_time` bigint unsigned NOT NULL COMMENT '当记录时间戳',
    `data`        json COMMENT 'data',
    PRIMARY KEY (`id`)
) ENGINE = INNODB COMMENT 'yonna log';