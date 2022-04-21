<?php


use Yonna\IO\Config;

Config::setCryptoProtocol(Config::env('IO_CRYPTO_PROTOCOL'));

Config::setCryptoType(Config::env('IO_CRYPTO_TYPE'));

Config::setCryptoSecret(Config::env('IO_CRYPTO_SECRET'));

Config::setCryptoIv(Config::env('IO_CRYPTO_IV'));