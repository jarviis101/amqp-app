<?php

namespace App\ArgumentValueResolver\Auth;

use App\Exception\UserAlreadyRegisteredException;
use App\Exception\ValidationException;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use App\DTO\Auth\RegisterDTO as ResolvedObject;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRegisterResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;
    private UserRepository $repository;
    private ValidatorInterface $validator;

    public function __construct(
        SerializerInterface $serializer,
        UserRepository $repository,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return ResolvedObject::class === $argument->getType();
    }

    /**
     * @throws UserAlreadyRegisteredException
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

        if ($this->repository->count(['email' => $object->email])) {
            throw new UserAlreadyRegisteredException();
        }
        yield $object;
    }
}
