<?php

namespace App\DTO\Auth;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AuthDTO
{
    /**
     * @JMS\Type("string")
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    public string $email;

    /**
     * @JMS\Type("string")
     * @Assert\NotBlank()
     */
    public string $username;

    /**
     * @JMS\Type("string")
     * @Assert\NotBlank()
     */
    public string $password;
}