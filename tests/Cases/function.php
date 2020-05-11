<?php

namespace Anetago\Web\PasswordGenerator;

use Anetago\Web\PasswordGenerator\Tests\Cases\PasswordGeneratorTest;

/**
 * Override function_exists
 */
function function_exists($function)
{
    if ($function === 'random_int') {
        return PasswordGeneratorTest::$randomIntExists;
    }
    if ($function === 'openssl_random_pseudo_bytes') {
        return PasswordGeneratorTest::$opensslExists;
    }
    return \function_exists($function);
}
