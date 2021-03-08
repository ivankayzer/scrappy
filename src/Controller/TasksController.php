<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use App\Transformer\TransformerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}