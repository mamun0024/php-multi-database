<?php

namespace App\Exceptions;

/**
 * Class BaseException
 */
class SqlQueryBuilderException extends BaseException
{
    /**
     * @param string|null $errorMessage
     *
     * @return string
     */
    public function errorMessage(string $errorMessage = null): string
    {
        return $this->errorMessageFormat($errorMessage);
    }
}
