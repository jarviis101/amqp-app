<?php

namespace App\Controller\Api\Task;

use App\DTO\Task\CreateTaskDTO;
use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Service\Task\TaskCreatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", methods={"POST"}, name="api_create_task")
     */
    public function create(CreateTaskDTO $createTaskDTO, TaskCreatorService $creatorService): Response
    {
        $task = $creatorService->create($createTaskDTO);
        return new JsonResponse($task->toArray(), Response::HTTP_OK);
    }

//    /**
//     * @Route("/task/{id}", methods={"GET"})
//     */
//    public function update(Request $request, int $id)
//    {
//        /** @var Task $task */
//        $task = $this->taskRepository->find($id);
////        $task->setTitle('lollll');
////        $this->em->persist($task);
////        $this->em->flush();
////        $task = $this->taskRepository->find(1);
////        dd($task);
////        dd($task->getTasks()->toArray());
//        return new JsonResponse([
//            'id' => $task->getId(),
//            'title' => $task->getTitle(),
//            'description' => $task->getDescription(),
//            'subtasks' => $task->getTasks()->toArray()
//        ], 200);
//    }
}
