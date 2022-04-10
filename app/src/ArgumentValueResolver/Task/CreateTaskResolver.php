<?php

namespace App\ArgumentValueResolver\Task;

use App\DTO\Task\CreateTaskDTO;
use App\DTO\Task\CreateTaskDTO as ResolvedObject;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CreateTaskResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return ResolvedObject::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        dd($request->request->all());
        /** @var array $data */
        $data = json_decode($request->getContent());

        dd($data);
//        /** @var ResolvedObject $object */
//        $object = $this->serializer->deserialize($data, ResolvedObject::class, 'json');
//        dd($object);
        $object = new CreateTaskDTO();
        yield $object;
    }
}
