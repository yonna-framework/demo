insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `component_data`)
values ('work', 'job', 'integer', 1, 'checkbox', 'db:default.data_work.name');

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `component_data`)
values ('hobby', 'hobby', 'integer', 1, 'checkbox', 'db:default.data_hobby.name');

insert into `user_meta_category` (`key`, `label`, `value_format`, `status`, `component`, `component_data`)
values ('speciality', 'strong point', 'integer', 1, 'checkbox', 'db:default.data_speciality.name');

insert into `essay_category` (`name`, `status`, `sort`)
values ('党建园地', 2, 9);
insert into `essay_category` (`name`, `status`, `sort`)
values ('精彩回放', 2, 8);
insert into `essay_category` (`name`, `status`, `sort`)
values ('知识普及', 2, 7);
insert into `essay_category` (`name`, `status`, `sort`)
values ('帮助', 2, 6);