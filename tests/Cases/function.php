<?php

namespace Anetago\Web\SecurePasswordGenerator;

use Anetago\Web\SecurePasswordGenerator\Tests\Cases\SecurePasswordGeneratorTest;

/**
 * Override function_exists
 */
function function_exists($function)
{
    if ($function === 'random_int') {
        return SecurePasswordGeneratorTest::$randomIntExists;
    }
    if ($function === 'openssl_random_pseudo_bytes') {
        return SecurePasswordGeneratorTest::$opensslExists;
    }
    return \function_exists($function);
}
