<?php

namespace App\Exceptions;

use Exception;

/**
 * Class BaseException
 */
class BaseException extends Exception
{
    /**
     * @param string   $errorMessage
     * @param int|null $errorCode
     *
     * @return string
     */
    protected function errorMessageFormat(string $errorMessage, int $errorCode = null): string
    {
        $errorCode = $errorCode ?? $this->getCode();

        return 'Exception : Error on line ' . $this->getLine() . ' in ' .
            $this->getFile() . ' : ' . $errorMessage . ', Code: ' . $errorCode;
    }
}
