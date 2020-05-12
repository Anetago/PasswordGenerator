[![Build Status](https://travis-ci.org/Anetago/PasswordGenerator.svg?branch=master)](https://travis-ci.org/Anetago/PasswordGenerator)
[![codecov](https://codecov.io/gh/Anetago/PasswordGenerator/branch/master/graph/badge.svg)](https://codecov.io/gh/Anetago/PasswordGenerator)

# Simple Password Generator


## Feature
- Supports CSPRNG algorithm (cryptographically secure pseudo random number generator)
- You choose the function which trims similar-looking characters.

## Prequisiteies
- PHP 7.2 and more (Prefer to the latest version)

## Installation

```
composer require anetago/gen-password
```
or clone git repository

## How to use

### Lightweight
```php
<?php

$generator = new \Anetago\Web\PasswordGenerator\PasswordGenerator();
print_r($generator->generate());
# -> ZPfKLae+.g{M
```

### Configuration
You will be able to set up to detailed settings.

#### ```setLength(int)```
You can be arbitrary length between 1 and 128 characters. By default, password length sets **12 character**.

#### ```useNumeric(bool)```
As you are not output some numeric like `012345678`, you turn 'false'.

#### ```useLowerAlphabet(bool)```
As you are not output some numeric like `abcdefghijklmnopqrstuvwxyz`, you turn `false`.

#### ```useUpperAlphabet(bool)```
As you are not output some numeric like `ABCDEFGHIJKLMNOPQRSTUVWXYZ`, you turn `false`.

#### ```useSymbols(bool)```
As you are not output some numeric like `!"#$%&\'()*+,-./:;<=>?@[\]^_``{\|}~`, you turn `false`.


Examples in detailed settings
```
<?php

$generator = new \Anetago\Web\PasswordGenerator\PasswordGenerator();

$generator->setLength(18);
$generator->useNumeric(false);
$generator->useLowerAlphabet(true);
$generator->useUpperAlphabet(true);
$generator->useSymbols(false);
$generator->useTrimSimilarLooking(true);

print_r($generator->generate());
# ->YSmSXJvyNUtJKnddmc
```

## License
BSD 3-Clause License
