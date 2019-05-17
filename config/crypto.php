<?php

use PhpureCore\Config\Crypto;

Crypto::set('io_secret', getenv('CRYPTO_IO_SECRET'));
Crypto::set('io_request_type', getenv('CRYPTO_IO_REQUEST_TYPE'));
Crypto::set('io_request_key', getenv('CRYPTO_IO_REQUEST_KEY'));
Crypto::set('io_request_iv', getenv('CRYPTO_IO_REQUEST_IV'));
Crypto::set('package_type', getenv('CRYPTO_PACKAGE_TYPE'));
Crypto::set('package_key', getenv('CRYPTO_PACKAGE_KEY'));
Crypto::set('package_iv', getenv('CRYPTO_PACKAGE_IV'));