create table `essay_category`
(
    `id`       bigint unsigned auto_increment not null comment 'id',
    `upper_id` bigint unsigned                not null default 0 comment 'essay_category_id',
    `user_id`  bigint unsigned                not null default 0 comment 'user_id',
    `name`     char(255)                      not null default '' comment '分类名称',
    `logo`     varchar(1024)                  not null default '' comment 'logo图片',
    `status`   tinyint                        not null default 1 comment '状态[-1审核驳回,1待审核,2审核通过]',
    `sort`     bigint                         not null default 0 comment '排序[降序]',
    primary key (`id`),
    unique key (`upper_id`, `name`),
    index (`status`)
) engine = innodb comment '文章分类';

create table `essay`
(
    `id`           bigint unsigned auto_increment not null comment 'id',
    `user_id`      bigint unsigned                not null default 0 comment 'user_id',
    `category_id`  bigint unsigned                not null default 0 comment 'essay_category_id',
    `status`       tinyint                        not null default -1 comment '状态[-1无效,1有效]',
    `is_excellent` tinyint                        not null default -1 comment '是否精华[1是,-1否]',
    `likes`        bigint unsigned                not null default 0 comment '点赞量',
    `views`        bigint unsigned                not null default 0 comment '浏览量',
    `title`        char(255)                      not null default '' comment '文章标题',
    `content`      text                           not null comment '文章内容',
    `author`       char(255)                      not null default '' comment '作者',
    `publish_time` bigint unsigned                not null comment '发布时间戳',
    `sort`         bigint                         not null default 0 comment '排序[降序]',
    primary key (`id`),
    index (`user_id`, `category_id`, `status`)
) engine = innodb comment '文章';