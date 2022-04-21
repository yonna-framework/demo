CREATE TABLE i18n
(
    unique_key text PRIMARY KEY NOT NULL DEFAULT '',
    zh_cn      text             NOT NULL DEFAULT '',
    zh_hk      text             NOT NULL DEFAULT '',
    zh_tw      text             NOT NULL DEFAULT '',
    en_us      text             NOT NULL DEFAULT '',
    ja_jp      text             NOT NULL DEFAULT '',
    ko_kr      text             NOT NULL DEFAULT ''
);
comment on table i18n is 'yonna i18n';
comment on column i18n.unique_key is '验证key';
comment on column i18n.zh_cn is '简体中文';
comment on column i18n.zh_hk is '香港繁体';
comment on column i18n.zh_tw is '台湾繁体';
comment on column i18n.en_us is '美国英语';
comment on column i18n.ja_jp is '日本语';
comment on column i18n.ko_kr is '韩国语';
