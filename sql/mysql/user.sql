create table `user`
(
    `id`              bigint unsigned auto_increment not null comment '用户id',
    `status`          tinyint                        not null default 1 comment '状态[-10注销,-3冻结,-2审核驳回,1待审核,2审核通过]',
    `password`        char(255)                      not null default '' comment '登录密码，不一定有，如通过微信登录的就没有',
    `inviter_user_id` bigint                         not null default 0 comment '邀请用户id[y_user_id]',
    `register_time`   bigint unsigned                not null comment '注册时间戳',
    primary key (`id`),
    index (`status`)
) engine = innodb comment '用户核心数据';

create table `user_account`
(
    `id`          bigint unsigned auto_increment not null comment '用户id',
    `user_id`     bigint unsigned                not null comment 'user_id',
    `string`      char(255)                      not null default '' comment '账号字串值',
    `type`        char(255)                      not null default '' comment '账号类型[name|phone|email|wx_open_id|wx_union_id]',
    `allow_login` tinyint                        not null default -1 comment '是否允许登录',
    primary key (`id`),
    unique key (`string`)
) engine = innodb comment '用户账号数据';

create table `user_meta_category`
(
    `key`            char(255) not null default '' comment 'meta key',
    `label`          char(255) not null default '' comment '显示文本,建议i18n原型',
    `value_format`   char(255) not null default 'string' comment '数据格式化类型',
    `value_default`  char(255) not null default '' comment '默认值',
    `component`      char(255) not null default '' comment '前端组件',
    `component_data` char(255) not null default '' comment '前端组件数据源',
    `status`         tinyint   not null default -1 comment '状态[-1无效,1有效]',
    `sort`           bigint    not null default 0 comment '排序[降序]',
    primary key (`key`),
    unique key `uk_key` (`key`),
    index (`value_format`),
    index (`component`),
    index (`status`)
) engine = innodb comment '用户可变自定义字段';

create table `user_meta`
(
    `user_id` bigint unsigned not null default 0 comment 'user_id',
    `key`     char(255)       not null default '' comment 'meta key',
    `value`   varchar(1024)   not null default '' comment 'meta value',
    unique key `uk_user_key` (`user_id`, `key`)
) engine = innodb comment '用户可变自定义详细信息';

create table `license`
(
    `id`          bigint unsigned auto_increment not null comment '许可id',
    `upper_id`    bigint unsigned                not null default 0 comment 'license_id',
    `name`        char(255)                      not null default '' comment '许可名字',
    `allow_scope` varchar(2048)                  not null default '' comment '许可支持的allow_scope',
    primary key (`id`),
    unique key (`name`),
    index (`upper_id`)
) engine = innodb comment '许可证关系';

create table `user_license`
(
    `user_id`    bigint unsigned not null comment 'user_id',
    `license_id` char(255)       not null default '' comment 'license_id',
    unique key (`user_id`, `license_id`),
    index (`user_id`),
    index (`license_id`)
) engine = innodb comment '用户许可证关联';

insert into `license` (`name`, `upper_id`, `allow_scope`)
values ('ROOT', 0, ',,,all');

insert into `user` (`password`, `status`, `register_time`)
values ('faa9a6ddddf57436961bf2d2bf4338df', 2, unix_timestamp(now()));

insert into `user_license` (`user_id`, `license_id`)
values (1, 1);

insert into `user_account` (`user_id`, `string`, `type`, `allow_login`)
values (1, 'admin', 'name', 1);

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `sort`)
values ('name', 'name2', 'string', 1, 'input_string', 9);

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `sort`)
values ('nickname', 'nickname', 'string', 1, 'input_string', 8);

insert into `user_meta_category` (`key`, `label`, `value_format`, `value_default`, `status`, `component`,
                                  `component_data`, `sort`)
values ('sex', 'sex', 'integer', '-1', 1, 'select', 'mapping:Yonna_QuickStart_Mapping_User_Sex', 7);

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `sort`)
values ('birth_date', 'birth date', 'date', 1, 'picker_date', 6);

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `sort`)
values ('age', 'age', 'integer', 1, 'input_number', 6);

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `sort`)
values ('region', 'residential region', 'string', 1, 'cascader_region', 5);

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `sort`)
values ('address', 'residential address', 'string', 1, 'input_string', 4);

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `sort`)
values ('avatar', 'avatar', 'string', 1, 'upload_image', 10);