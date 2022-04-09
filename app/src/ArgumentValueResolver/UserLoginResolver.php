<?php

namespace App\ArgumentValueResolver;

use App\DTO\Auth\LoginDTO as ResolvedObject;
use App\Exception\ValidationException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserLoginResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return ResolvedObject::class === $argument->getType();
    }

    /**
     * @throws ValidationException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /** @var string $data */
        $data = $request->getContent();
        /** @var ResolvedObject $object */
        $object = $this->serializer->deserialize($data, ResolvedObject::class, 'json');

        if (count($errors = $this->validator->validate($object))) throw new ValidationException(
            $errors->get(0)->getMessage()
        );

        yield $object;
    }
}