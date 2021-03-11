<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Transformer\TransformerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class TasksController extends AbstractController
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var TransformerManager
     */
    private $transformerManager;

    public function __construct(TaskRepository $taskRepository, TransformerManager $transformerManager)
    {
        $this->taskRepository = $taskRepository;
        $this->transformerManager = $transformerManager;
    }

    public function index(): Response
    {
        return $this->render('tasks.html.twig');
    }

    public function all(Security $security): Response
    {
        $tasks = $this->taskRepository->findAllForUser($security->getUser()->getId());

        return new JsonResponse([
            'tasks' => $this->transformerManager->transformMany($tasks)
        ]);
    }

    public function store(Request $request, Security $security): Response
    {
        $task = new Task();
        $task->setUser($security->getUser());
        $task->setName($request->request->get('name'));
        $task->setUrl($request->request->get('url'));
        $task->setCheckFrequency($request->request->get('checkFrequency'));
        $task->setHoursOfActivity($request->request->get('hoursOfActivity'));
        $task->setStatus($request->request->get('status'));
        $task->setNotificationChannel($request->request->get('notificationChannel'));

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse([
            'task' => $this->transformerManager->transform($task)
        ]);
    }
}