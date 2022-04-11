<?php

namespace App\Controller\Api\Task;

use App\DTO\Task\CreateTaskDTO;
use App\DTO\Task\EditTaskDTO;
use App\DTOBuilder\Task\TaskBuilder;
use App\Entity\Task;
use App\Exception\InvalidStatusException;
use App\Exception\TaskNotFoundException;
use App\Service\Task\CreatorService;
use App\Service\Task\DeleterService;
use App\Service\Task\TaskFinder;
use App\Service\Task\TaskManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    private TaskManager $taskManager;

    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    /**
     * @Route("", methods={"GET"}, name="api_list_task")
     */
    public function index(
        Request $request,
        TaskFinder $finder,
        TaskBuilder $taskBuilder
    ): Response {
        return new JsonResponse(
            $finder->findTasks($request->query->all())
                ->toArray(function (Task $task) use ($taskBuilder) {
                    return $taskBuilder->build($task);
                }),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("", methods={"POST"}, name="api_create_task")
     */
    public function create(CreateTaskDTO $createTaskDTO, CreatorService $creatorService): Response
    {
        $task = $creatorService->create($createTaskDTO);
        return new JsonResponse($task->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods={"PATCH"}, name="api_update_task")
     */
    public function update(int $id, EditTaskDTO $dto): Response
    {
        $task = $this->taskManager->updateTask($dto, $id);
        return new JsonResponse($task->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="api_delete_task")
     * @throws InvalidStatusException
     * @throws TaskNotFoundException
     */
    public function delete(int $id, DeleterService $service): Response
    {
        $service->delete($id);
        return new JsonResponse([], Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/status", methods={"PATCH"}, name="api_change_status_task")
     */
    public function changeStatus(int $id): Response
    {
        $task = $this->taskManager->changeStatus($id);
        return new JsonResponse($task->toArray(), Response::HTTP_OK);
    }
}
