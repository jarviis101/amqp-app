<?php

namespace App\DTO\Auth;

use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterDTO extends AuthDTO
{
    /**
     * @JMS\Type("string")
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    public string $email;
}
