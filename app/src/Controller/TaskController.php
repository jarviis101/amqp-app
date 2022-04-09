<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/task", methods={"GET"})
     */
    public function index(Request $request)
    {
        $task = new Task('lol', 'lol2');
        $this->em->persist($task);
        $this->em->flush();
        dd($task);
    }

    /**
     * @Route("/task/{id}", methods={"GET"})
     */
    public function update(Request $request, int $id)
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);
        $task->setTitle('lollll');
        $this->em->persist($task);
        $this->em->flush();
        dd($task);
    }
}
