create table `user_identity`
(
    `user_id`            bigint unsigned not null comment 'user_id',
    `name`               char(255)       not null default '' comment '身份证姓名（真实姓名）',
    `card_no`            char(255)       not null default '' comment '身份证号',
    `card_pic_front`     json comment '身份证正面',
    `card_pic_back`      json comment '身份证背面',
    `card_pic_take`      json comment '身份证手持',
    `card_expire_date`   bigint          not null comment '身份证过期日期戳',
    `auth_status`        tinyint         not null default 1 comment '实名认证状态[-1未通过,1待认证,2认证中,10已认证]',
    `auth_reject_reason` varchar(1024)   not null default '' comment '实名认证拒绝理由',
    primary key (`user_id`)
) engine = innodb comment '用户身份证拓展';