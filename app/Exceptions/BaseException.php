<?php

namespace App\Exceptions;

use Exception;

/**
 * Class BaseException
 */
class BaseException extends Exception
{
    /**
     * @param string|null $errorMessage
     *
     * @return string
     */
    protected function errorMessageFormat(string $errorMessage = null): string
    {
        return 'Exception : Error on line ' . $this->getLine() . ' in '
            . $this->getFile() . ' : ' . $errorMessage;
    }
}
