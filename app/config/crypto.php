<?php

use PhpureCore\Config\Crypto;

Crypto::set('io_token', getenv('CRYPTO_IO_TOKEN'));
Crypto::set('io_token_secret', getenv('CRYPTO_IO_TOKEN_SECRET'));
Crypto::set('io_request_protocol', getenv('CRYPTO_IO_REQUEST_PROTOCOL'));
Crypto::set('io_request_type', getenv('CRYPTO_IO_REQUEST_TYPE'));
Crypto::set('io_request_secret', getenv('CRYPTO_IO_REQUEST_SECRET'));
Crypto::set('io_request_iv', getenv('CRYPTO_IO_REQUEST_IV'));
Crypto::set('package_type', getenv('CRYPTO_PACKAGE_TYPE'));
Crypto::set('package_secret', getenv('CRYPTO_PACKAGE_SECRET'));
Crypto::set('package_iv', getenv('CRYPTO_PACKAGE_IV'));
