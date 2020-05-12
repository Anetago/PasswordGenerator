<?php

namespace Anetago\Web\PasswordGenerator;

use Anetago\Web\PasswordGenerator\Tests\Cases\NotTestImplementException;
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
    if ($function === 'mb_str_split') {
        return PasswordGeneratorTest::$mbStrSplitExists;
    }

    return \function_exists($function);
}


function mb_str_split($str, $split_length, $encoding)
{
    if (!\function_exists("mb_str_split")) {
        throw new NotTestImplementException();
    }

    return \mb_str_split($str, $split_length, $encoding);
}