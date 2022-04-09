<?php

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyRegisteredException extends Exception
{
    /**
     * @var string
     */
    protected $message = "User already register";

    /**
     * @var int
     */
    protected $code = Response::HTTP_CONFLICT;
}