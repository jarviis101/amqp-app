<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyRegisteredException extends Exception
{
    /**
     * @var string
     */
    protected $message = "User already registered.";

    /**
     * @var int
     */
    protected $code = Response::HTTP_CONFLICT;
}