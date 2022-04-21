<?php

use Yonna\I18n\Config as I18nConf;
use Yonna\Log\Config as LogConf;

// i18n
I18nConf::setDatabase('default');
I18nConf::setAuto('redis');

// log
LogConf::setFilePathRoot(realpath(__DIR__ . '/../../'));
LogConf::setFileExpireDay(30); // 30 days
LogConf::setDatabase('default');

/**
 * 装载quickStart
 */
App\Install::log();
App\Install::i18n();
App\Install::xoss();
App\Install::essay();
App\Install::sdk();
App\Install::user();
App\Install::userMetaCategory();
App\Install::data();
App\Install::license();
App\Install::league();
App\Install::leagueMember();
App\Install::feedback();
App\Install::stat();
App\Install::me();
