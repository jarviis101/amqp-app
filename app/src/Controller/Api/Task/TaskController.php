<?php

namespace App\Controller\Api\Task;

use App\DTO\Task\CreateTaskDTO;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private EntityManagerInterface $em;
    private TaskRepository $taskRepository;
    public function __construct(EntityManagerInterface $em, TaskRepository $taskRepository)
    {
        $this->em = $em;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/task", methods={"POST"}, name="api_create_task")
     */
    public function create(CreateTaskDTO $createTaskDTO)
    {

    }

    /**
     * @Route("/task", methods={"GET"})
     */
    public function index(Request $request)
    {
        $task = new Task('lol', 'lol2');
        $parentTaskId = null;
        if ($parentTaskId) {
            /** @var Task|null $parent */
            $parent = $this->taskRepository->find($parentTaskId);
            $parent?->addTask($task);
        }
        $this->em->persist($task);
        $this->em->flush();
        return new JsonResponse([], 200);
    }

    /**
     * @Route("/task/{id}", methods={"GET"})
     */
    public function update(Request $request, int $id)
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);
//        $task->setTitle('lollll');
//        $this->em->persist($task);
//        $this->em->flush();
//        $task = $this->taskRepository->find(1);
//        dd($task);
//        dd($task->getTasks()->toArray());
        return new JsonResponse([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'subtasks' => $task->getTasks()->toArray()
        ], 200);
    }
}
