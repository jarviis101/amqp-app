<?php

namespace App\ArgumentValueResolver\Task;

use App\DTO\Task\CreateTaskDTO as ResolvedObject;
use App\Entity\Priority;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\TaskRepository;
use JMS\Serializer\SerializerInterface;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateTaskResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;
    private TaskRepository $repository;
    private Security $security;
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator, TaskRepository $repository, Security $security)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->security = $security;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return ResolvedObject::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /**
         * $request->request->all() -> is empty, maybe resolve this problem
         * @see https://stackoverflow.com/questions/46303170/empty-data-in-symfony-request-object-when-controller-is-called-by-authorize-net
         */
        /** @var stdClass $data */
        $data = json_decode($request->getContent());

        /** @var User $user */
        $user = $this->security->getUser();

        $object = new ResolvedObject();
        $object->priority = new Priority($data->priority ?? Priority::MIN_VALUE);
        $object->title = $data->title ?? "";
        $object->description = $data->description ?? "";
        $object->user = $user;
        if (isset($data->parent_id)) {
            $object->parentTask = $this->repository->find($data->parent_id);
        }

        if (count($errors = $this->validator->validate($object))) throw new ValidationException(
            $errors->get(0)->getMessage()
        );

        yield $object;
    }
}
