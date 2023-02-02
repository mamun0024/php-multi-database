<?php

namespace App\Exceptions;

/**
 * Class BaseException
 */
class SqlQueryBuilderException extends BaseException
{
    /**
     * @param string   $errorMessage
     * @param int|null $errorCode
     *
     * @return string
     */
    protected function errorMessage(string $errorMessage, int $errorCode = null): string
    {
        return $this->errorMessageFormat($errorMessage, $errorCode);
    }
}
