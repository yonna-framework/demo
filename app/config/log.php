<?php

use Yonna\Log\Config;

// file
Config::setFile('applog');
Config::setFileExpireDay(30); // 30 days

// mongo
Config::setMongoHost('127.0.0.1');
Config::setMongoPort('27017');
Config::setMongoName('yonna');
Config::setMongoAccount('');
Config::setMongoPassword('');
