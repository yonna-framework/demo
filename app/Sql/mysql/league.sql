CREATE TABLE `data_hobby`
(
    `id`     bigint unsigned auto_increment not null comment 'id',
    `name`   char(255)                      not null comment '名称',
    `status` tinyint                        not null default 1 comment '状态[-1无效,1生效]',
    `sort`   bigint                         not null default 0 comment '排序[降序]',
    PRIMARY KEY (`id`),
    UNIQUE KEY (`name`),
    INDEX (`status`)
) ENGINE = INNODB COMMENT '兴趣爱好';

CREATE TABLE `data_work`
(
    `id`     bigint unsigned auto_increment not null comment 'id',
    `name`   char(255)                      not null comment '名称',
    `status` tinyint                        not null default 1 comment '状态[-1无效,1生效]',
    `sort`   bigint                         not null default 0 comment '排序[降序]',
    PRIMARY KEY (`id`),
    UNIQUE KEY (`name`),
    INDEX (`status`)
) ENGINE = INNODB COMMENT '职业工作';

CREATE TABLE `data_speciality`
(
    `id`     bigint unsigned auto_increment not null comment 'id',
    `name`   char(255)                      not null comment '名称',
    `status` tinyint                        not null default 1 comment '状态[-1无效,1生效]',
    `sort`   bigint                         not null default 0 comment '排序[降序]',
    PRIMARY KEY (`id`),
    UNIQUE KEY (`name`),
    INDEX (`status`)
) ENGINE = INNODB COMMENT '特长';

CREATE TABLE `league`
(
    `id`                   bigint unsigned auto_increment not null comment 'id',
    `name`                 char(255)                      not null comment '社团名',
    `slogan`               char(255)                      not null comment '宣传标语',
    `introduction`         text                           not null comment '社团简介',
    `logo_pic`             char(255)                      not null comment 'LOGO图',
    `business_license_pic` char(255)                      not null comment '营业执照',
    `status`               tinyint                        not null default 1 comment '状态[-2作废,-1申请驳回,1待审核,2审核通过]',
    `apply_reason`         char(255)                      not null default '' comment '申请理由',
    `rejection_reason`     char(255)                      not null default '' comment '驳回理由',
    `pass_reason`          char(255)                      not null default '' comment '通过理由',
    `delete_reason`        char(255)                      not null default '' comment '作废理由',
    `apply_time`           bigint unsigned                not null comment '申请日期时间戳',
    `rejection_time`       bigint unsigned                not null comment '驳回日期时间戳',
    `pass_time`            bigint unsigned                not null comment '通过日期时间戳',
    `delete_time`          bigint unsigned                not null comment '作废日期时间戳',
    `sort`                 bigint                         not null default 0 comment '排序[降序]',
    PRIMARY KEY (`id`),
    INDEX (`name`)
) ENGINE = INNODB COMMENT '社团';

CREATE TABLE `league_member`
(
    `id`               bigint unsigned auto_increment not null comment 'id',
    `league_id`        bigint unsigned                not null comment '社团id',
    `user_id`          bigint unsigned                not null comment '成员user_id',
    `permission`       tinyint                        not null comment '权限[1成员 5管理员 10拥有者]',
    `status`           tinyint                        not null default 1 comment '状态[-2作废,-1申请驳回,1待审核,2审核通过]',
    `apply_reason`     char(255)                      not null default '' comment '申请理由',
    `rejection_reason` char(255)                      not null default '' comment '驳回理由',
    `pass_reason`      char(255)                      not null default '' comment '通过理由',
    `delete_reason`    char(255)                      not null default '' comment '作废理由',
    `apply_time`       bigint unsigned                not null comment '申请日期时间戳',
    `rejection_time`   bigint unsigned                not null comment '驳回日期时间戳',
    `pass_time`        bigint unsigned                not null comment '通过日期时间戳',
    `delete_time`      bigint unsigned                not null comment '作废日期时间戳',
    PRIMARY KEY (`id`)
) ENGINE = INNODB COMMENT '社团成员';

CREATE TABLE `league_associate_hobby`
(
    `league_id` bigint unsigned not null comment '社团id',
    `data_id`   bigint unsigned not null comment '爱好id',
    UNIQUE KEY (`league_id`, `data_id`)
) ENGINE = INNODB COMMENT '社团与爱好关系';

CREATE TABLE `league_associate_work`
(
    `league_id` bigint unsigned not null comment '社团id',
    `data_id`   bigint unsigned not null comment '职业工作id',
    UNIQUE KEY (`league_id`, `data_id`)
) ENGINE = INNODB COMMENT '社团与职业工作关系';

CREATE TABLE `league_associate_speciality`
(
    `league_id` bigint unsigned not null comment '社团id',
    `data_id`   bigint unsigned not null comment '特长id',
    UNIQUE KEY (`league_id`, `data_id`)
) ENGINE = INNODB COMMENT '社团与特长关系';

CREATE TABLE `league_task`
(
    `id`                  bigint unsigned auto_increment not null comment 'id',
    `league_id`           bigint unsigned                not null comment '发起社团league_id,如果是0则是平台发布',
    `user_id`             bigint unsigned                not null comment '发起人user_id',
    `complete_user_id`    bigint unsigned                not null comment '完成人user_id',
    `name`                char(255)                      not null comment '任务名称',
    `introduction`        varchar(1024)                  not null comment '任务介绍',
    `current_number`      int unsigned                   not null default 0 comment '当前人数',
    `people_number`       int unsigned                   not null default 0 comment '最大人数',
    `start_time`          bigint unsigned                not null comment '开始日期时间戳',
    `end_time`            bigint unsigned                not null comment '结束日期时间戳',
    `points`              numeric(7, 1)                  not null default 0.0 comment '任务价值分数',
    `status`              tinyint                        not null default 1 comment '状态[-2作废,-1申请驳回,1待审核,2审核通过,10已完成]',
    `apply_reason`        char(255)                      not null default '' comment '申请理由',
    `rejection_reason`    char(255)                      not null default '' comment '驳回理由',
    `pass_reason`         char(255)                      not null default '' comment '通过理由',
    `delete_reason`       char(255)                      not null default '' comment '作废理由',
    `apply_time`          bigint unsigned                not null comment '申请日期时间戳',
    `rejection_time`      bigint unsigned                not null comment '驳回日期时间戳',
    `pass_time`           bigint unsigned                not null comment '通过日期时间戳',
    `delete_time`         bigint unsigned                not null comment '作废日期时间戳',
    `complete_time`       bigint unsigned                not null comment '完成日期时间戳',
    `event_photos`        varchar(1024)                  not null comment '活动图片',
    `self_evaluation`     numeric(3, 1)                  not null default 0.0 comment '社团自评',
    `platform_evaluation` numeric(3, 1)                  not null default 0.0 comment '平台打分',
    `sort`                bigint                         not null default 0 comment '排序[降序]',
    PRIMARY KEY (`id`),
    INDEX (`user_id`),
    INDEX (`name`)
) ENGINE = INNODB COMMENT '社团任务';

CREATE TABLE `league_task_assign`
(
    `id`          bigint unsigned auto_increment not null comment 'id',
    `task_id`     bigint unsigned                not null comment '参与的任务user_id',
    `league_id`   bigint unsigned                not null comment '参加的社团id',
    `assign_time` bigint unsigned                not null comment '参与日期时间戳',
    PRIMARY KEY (`id`),
    UNIQUE KEY (`task_id`, `league_id`)
) ENGINE = INNODB COMMENT '社团任务分配表(指定社团)';

CREATE TABLE `league_task_joiner`
(
    `id`                bigint unsigned auto_increment not null comment 'id',
    `task_id`           bigint unsigned                not null comment '参与的任务user_id',
    `user_id`           bigint unsigned                not null comment '参与人user_id',
    `league_id`         bigint unsigned                not null comment '参与人当时所在社团id',
    `self_evaluation`   numeric(3, 1)                  not null default 0.0 comment '成员评分',
    `league_evaluation` numeric(3, 1)                  not null default 0.0 comment '社团打分',
    PRIMARY KEY (`id`),
    INDEX (`task_id`, `user_id`)
) ENGINE = INNODB COMMENT '社团任务参加者';
