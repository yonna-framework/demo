<?php

use Yonna\Config\Crypto;

Crypto::set('io_token', Crypto::env('CRYPTO_IO_TOKEN'));
Crypto::set('io_token_secret', Crypto::env('CRYPTO_IO_TOKEN_SECRET'));
Crypto::set('io_request_protocol', Crypto::env('CRYPTO_IO_REQUEST_PROTOCOL'));
Crypto::set('io_request_type', Crypto::env('CRYPTO_IO_REQUEST_TYPE'));
Crypto::set('io_request_secret', Crypto::env('CRYPTO_IO_REQUEST_SECRET'));
Crypto::set('io_request_iv', Crypto::env('CRYPTO_IO_REQUEST_IV'));

Crypto::set('package_type', Crypto::env('CRYPTO_PACKAGE_TYPE'));
Crypto::set('package_secret', Crypto::env('CRYPTO_PACKAGE_SECRET'));
Crypto::set('package_iv', Crypto::env('CRYPTO_PACKAGE_IV'));
