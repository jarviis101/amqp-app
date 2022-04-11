<?php

namespace App\ArgumentValueResolver\Task;

use App\DTO\Task\EditTaskDTO as ResolvedObject;
use App\Entity\Priority;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class EditTaskResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return ResolvedObject::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /** @var stdClass $data */
        $data = json_decode($request->getContent());

        $object = new ResolvedObject();
        $object->priority = isset($data->priority) ? new Priority($data->priority) : null;
        $object->title = $data->title ?? null;
        $object->description = $data->description ?? null;
        $object->status = $data->status ?? null;

        yield $object;
    }
}
