create table `sdk`
(
    `key`   char(255) not null comment 'key',
    `value` char(255) not null comment '配置值',
    primary key (`key`)
) engine = innodb comment 'SDK配置表';

create table `sdk_wxmp_user`
(
    `openid`     char(255) not null comment 'openid',
    `unionid`    char(255) not null comment 'unionid',
    `sex`        char(255) not null comment '性别[1男2女]',
    `nickname`   char(255) not null comment '昵称',
    `headimgurl` char(255) not null comment '头像',
    `language`   char(255) not null comment '语言',
    `city`       char(255) not null comment '城市',
    `province`   char(255) not null comment '省份',
    `country`    char(255) not null comment '国家',
    primary key (`openid`)
) engine = innodb comment 'SDK-微信公众号用户信息数据';

insert into `sdk`
values ('baidu_appid', ''),
       ('baidu_secret', ''),
       ('wxmp_appid', ''),
       ('wxmp_secret', '');