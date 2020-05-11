<?php

namespace Anetago\Web\SecurePasswordGenerator\Tests\Cases;

use Anetago\Web\SecurePasswordGenerator\Exception\NotImplementException;
use Anetago\Web\SecurePasswordGenerator\Tests\OverrideTestCase;
use InvalidArgumentException;

class SecurePasswordGeneratorTest extends OverrideTestCase
{
    /**
     * 
     */
    public static $opensslExists = true;
    public static $randomIntExists = true;


    protected function setUp(): void
    {
        self::$opensslExists = true;
        self::$randomIntExists = true;
    }

    public function testInitialize()
    {
        $obj = new MockSecurePasswordGenerator();
        $this->assertTrue($obj->get_use_random_int());
    }

    public function testcheckFunctionThrowsNotImplementException()
    {
        self::$randomIntExists = false;
        self::$opensslExists = false;
        $this->expectException(NotImplementException::class);

        $obj = new MockSecurePasswordGenerator(false);
        $obj->checkFunctionFacade();
    }

    public function testGetLength()
    {
        $obj = new MockSecurePasswordGenerator();
        $expected = 12;
        $actual = $obj->getLength();

        $this->assertEquals($expected, $actual);

        $expected2 = $obj->getLength();
        $actual2 = $obj->getLengthFacade();

        $this->assertEquals($expected2, $actual2);
    }

    public function testSetLength()
    {
        $obj = new MockSecurePasswordGenerator();
        for ($expected = 1; $expected <= 128; $expected++) {
            $obj->setLength($expected);
            $actual = $obj->getLength();
            $this->assertEquals($expected, $actual);
        }
    }

    public function testSetLengthThrowsInvalidArgumentExceptionLessThan1()
    {
        $threshold = 0;

        $this->expectException(InvalidArgumentException::class);
        $obj = new MockSecurePasswordGenerator();
        $obj->setLength($threshold);
    }

    public function testSetLengthThrowsInvalidArgumentExceptionMoreThan128()
    {
        $threshold = 129;

        $this->expectException(InvalidArgumentException::class);
        $obj = new MockSecurePasswordGenerator();
        $obj->setLength($threshold);
    }

    public function testUseNumeric()
    {
        $expected = false;

        $obj = new MockSecurePasswordGenerator();
        $obj->useNumeric($expected);
        $actual = $obj->getUseNumeric();

        $this->assertEquals($expected, $actual);

        $expected2 = true;
        $obj->useNumeric($expected2);
        $actual2 = $obj->getUseNumeric();

        $this->assertEquals($expected2, $actual2);
    }

    public function testUseLowerAlphabet()
    {
        $expected = false;

        $obj = new MockSecurePasswordGenerator();
        $obj->useLowerAlphabet($expected);
        $actual = $obj->getUseLowerAlphabet();

        $this->assertEquals($expected, $actual);

        $expected2 = true;
        $obj->useLowerAlphabet($expected2);
        $actual2 = $obj->getUseLowerAlphabet();

        $this->assertEquals($expected2, $actual2);
    }

    public function testUseUpperAlphabet()
    {
        $expected = false;

        $obj = new MockSecurePasswordGenerator();
        $obj->useUpperAlphabet($expected);
        $actual = $obj->getUseUpperAlphabet();

        $this->assertEquals($expected, $actual);

        $expected2 = true;
        $obj->useUpperAlphabet($expected2);
        $actual2 = $obj->getUseUpperAlphabet();

        $this->assertEquals($expected2, $actual2);
    }

    public function testUseSymbols()
    {
        $expected = false;

        $obj = new MockSecurePasswordGenerator();
        $obj->useSymbols($expected);
        $actual = $obj->getUseSymbols();

        $this->assertEquals($expected, $actual);

        $expected2 = true;
        $obj->useSymbols($expected2);
        $actual2 = $obj->getUseSymbols();

        $this->assertEquals($expected2, $actual2);
    }

    public function testSetSymbols()
    {
        $expected = '!"#';

        $obj = new MockSecurePasswordGenerator();
        $obj->setSymbols($expected);
        $actual = $obj->getSymbolsFacade();

        $this->assertEquals($expected, $actual);

        $expected2 = '!@#$%^&*()こんにちわ';
        $obj->setSymbols($expected2);
        $actual2 = $obj->getSymbolsFacade();

        $this->assertEquals($expected2, $actual2);
    }

    public function testSetSymbolsDuplicatedChacters()
    {
        $expected = '!"#';
        $obj = new MockSecurePasswordGenerator();
        $obj->setSymbols($expected . $expected);
        $actual = $obj->getSymbolsFacade();

        $this->assertEquals($expected, $actual);

        $expected2 = '!@#$%^&*()こんにちわ';
        $obj->setSymbols($expected2 . $expected2);
        $actual2 = $obj->getSymbolsFacade();

        $this->assertEquals($expected2, $actual2);
    }

    public function testSetSymbolsIncludingAlphabet()
    {
        $expected = '!"#';

        $obj = new MockSecurePasswordGenerator();
        $obj->setSymbols($expected . 'abcxyzABCXYZ01289');
        $actual = $obj->getSymbolsFacade();

        $this->assertEquals($expected, $actual);
    }


    private function prepareDepencency()
    {
        $this->setDependencies([
            "testUseNumeric", "testUseLowerAlphabet", "testUseUpperAlphabet", "testUseSymbols", "testSetSymbols", "testSetSymbolsDuplicatedChacters", "testSetSymbolsIncludingAlphabet"
        ]);
    }

    public function testPrepareKeySpaceCaseEmpty()
    {
        $this->prepareDepencency();

        $obj = new MockSecurePasswordGenerator(false);
        $obj->useNumeric(false);
        $obj->useLowerAlphabet(false);
        $obj->useUpperAlphabet(false);
        $obj->useSymbols(false);

        $obj->setSymbols('!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~');
        $obj->prepareFacade();

        $expected01 = '';
        $actual01 = $obj->getKeySpaceFacade();
        $this->assertEquals($expected01, $actual01);
    }

    public function testPrepareKeySpaceCaseOnlyNumeric()
    {
        $this->prepareDepencency();

        $obj = new MockSecurePasswordGenerator(false);
        $obj->useNumeric(true);
        $obj->useLowerAlphabet(false);
        $obj->useUpperAlphabet(false);
        $obj->useSymbols(false);

        $obj->setSymbols('!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~');
        $obj->prepareFacade();

        $expected01 = '0123456789';
        $actual01 = $obj->getKeySpaceFacade();
        $this->assertEquals($expected01, $actual01);
    }

    public function testPrepareKeySpaceCaseOnlyLowerAlphabet()
    {
        $this->prepareDepencency();

        $obj = new MockSecurePasswordGenerator(false);
        $obj->useNumeric(false);
        $obj->useLowerAlphabet(true);
        $obj->useUpperAlphabet(false);
        $obj->useSymbols(false);

        $obj->setSymbols('!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~');
        $obj->prepareFacade();

        $expected01 = 'abcdefghijklmnopqrstuvwxyz';
        $actual01 = $obj->getKeySpaceFacade();
        $this->assertEquals($expected01, $actual01);
    }

    public function testPrepareKeySpaceCaseOnlyUpperAlphabet()
    {
        $this->prepareDepencency();

        $obj = new MockSecurePasswordGenerator(false);
        $obj->useNumeric(false);
        $obj->useLowerAlphabet(false);
        $obj->useUpperAlphabet(true);
        $obj->useSymbols(false);

        $obj->setSymbols('!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~');
        $obj->prepareFacade();

        $expected01 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $actual01 = $obj->getKeySpaceFacade();
        $this->assertEquals($expected01, $actual01);
    }


    public function testPrepareKeySpaceCaseOnlySymbols()
    {
        $this->prepareDepencency();

        $obj = new MockSecurePasswordGenerator(false);
        $obj->useNumeric(false);
        $obj->useLowerAlphabet(false);
        $obj->useUpperAlphabet(false);
        $obj->useSymbols(true);

        $obj->setSymbols('!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~');
        $obj->prepareFacade();

        $expected01 = '!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~';
        $actual01 = $obj->getKeySpaceFacade();
        $this->assertEquals($expected01, $actual01);
    }

    public function testPrepareKeySpaceCaseMultiCase()
    {
        $this->prepareDepencency();

        $obj = new MockSecurePasswordGenerator(false);
        $obj->useNumeric(true);
        $obj->useLowerAlphabet(true);
        $obj->useUpperAlphabet(true);
        $obj->useSymbols(true);

        $obj->setSymbols('!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~');
        $obj->prepareFacade();

        $expected01 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~';
        $actual01 = $obj->getKeySpaceFacade();
        $this->assertEquals($expected01, $actual01);
    }


    public function testGenerateUseRandomInt()
    {
        self::$opensslExists = false;
        self::$randomIntExists = true;

        $obj = new MockSecurePasswordGenerator();
        $password = $obj->generate();

        $expectLength = $obj->getLength();
        $actualLength = strlen($password);
        $this->assertEquals($expectLength, $actualLength);

        $password2 = $obj->generate();
        $this->assertNotEquals($password, $password2);
    }

    public function testGenerateUseOpenSSL()
    {
        self::$opensslExists = true;
        self::$randomIntExists = false;

        $obj = new MockSecurePasswordGenerator();
        $password = $obj->generate();

        $expectLength = $obj->getLength();
        $actualLength = strlen($password);
        $this->assertEquals($expectLength, $actualLength);

        $password2 = $obj->generate();
        $this->assertNotEquals($password, $password2);
    }
}
