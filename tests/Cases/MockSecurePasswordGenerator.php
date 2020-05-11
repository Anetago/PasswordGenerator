<?php

namespace Anetago\Web\SecurePasswordGenerator\Tests\Cases;

use Anetago\Web\SecurePasswordGenerator\SecurePasswordGenerator;

final class MockSecurePasswordGenerator extends SecurePasswordGenerator
{

    /**
     * Override
     */
    public function __construct(bool $runParent = true)
    {
        if ($runParent) {
            parent::__construct();
        }
    }

    public function getUseNumeric()
    {
        return $this->useNumeric;
    }

    public function getUseLowerAlphabet()
    {
        return $this->useLowerAlphabet;
    }

    public function getUseUpperAlphabet()
    {
        return $this->useUpperAlphabet;
    }

    public function getUseSymbols()
    {
        return $this->useSymbols;
    }

    public function getIsRemovedSimilarCharacters()
    {
        return $this->isRemovedSimilarCharacters;
    }

    public function getLengthFacade()
    {
        return $this->length;
    }

    public function getSymbolsFacade()
    {
        return $this->symbols;
    }

    public function getKeySpaceFacade()
    {
        return $this->keySpace;
    }
    
    public function get_use_random_int()
    {
        return $this->use_random_int;
    }

    public function checkFunctionFacade()
    {
        $this->checkFunction();
    }

    public function prepareFacade()
    {
        $this->prepare();
    }
}
