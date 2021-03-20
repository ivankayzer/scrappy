<?php

namespace App\Controller;

use App\Entity\Script;
use App\Entity\Task;
use App\Repository\ScriptRepository;
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

    /**
     * @var ScriptRepository
     */
    private ScriptRepository $scriptRepository;

    public function __construct(TaskRepository $taskRepository, TransformerManager $transformerManager, ScriptRepository $scriptRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->transformerManager = $transformerManager;
        $this->scriptRepository = $scriptRepository;
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

    public function getById(int $id): Response
    {
        $task = $this->taskRepository->find($id);

        return new JsonResponse([
            'task' => $this->transformerManager->transform($task)
        ]);
    }

    public function store(Request $request, Security $security): Response
    {
        $task = new Task();
        $task->setUser($security->getUser());

        $task = $this->fillTaskFromRequest($request, $task);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse([
            'task' => $this->transformerManager->transform($task)
        ]);
    }

    public function update(int $id, Request $request): Response
    {
        $task = $this->taskRepository->find($id);

        $task = $this->fillTaskFromRequest($request, $task);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse([
            'task' => $this->transformerManager->transform($task)
        ]);
    }

    public function updateScripts(int $taskId, Request $request): Response
    {
        /** @var Script[] $scripts */
        $scripts = $this->scriptRepository->findAllForTaskIdOrderedByExecutionOrder($taskId);
        $task = $this->taskRepository->find($taskId);
        $entityManager = $this->getDoctrine()->getManager();

        foreach ($scripts as $script) {
            $updatedScript = array_filter($request->request->get('scripts'), function ($upScript) use ($script) {
               return $upScript['id'] === $script->getId();
            });

            if (!count($updatedScript)) {
                $entityManager->remove($script);
                continue;
            }

            $updatedScript = $updatedScript[0];

            $script->setType($updatedScript['type']);
            $script->setCode($updatedScript['code']);
            $script->setExecutionOrder($updatedScript['executionOrder']);
            $script->setLabel($updatedScript['label']);

            $entityManager->persist($script);
        }

        $newScripts = array_filter($request->request->get('scripts'), function ($script) {
           return !$script['id'];
        });

        foreach ($newScripts as $newScript) {
            $script = new Script();
            $script->setTask($task);
            $script->setType($newScript['type']);
            $script->setCode($newScript['code']);
            $script->setExecutionOrder($newScript['executionOrder']);
            $script->setLabel($newScript['label']);

            $entityManager->persist($script);
        }

        $entityManager->flush();

        return new JsonResponse();
    }

    public function delete(int $id): Response
    {
        $task = $this->taskRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($task);
        $entityManager->flush();

        return new JsonResponse();
    }

    public function changeStatus(int $id, Request $request): Response
    {
        $task = $this->taskRepository->find($id);

        $task->setStatus($request->request->get('status'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse([
            'task' => $this->transformerManager->transform($task)
        ]);
    }

    public function getScriptsByTaskId(int $taskId)
    {
        $scripts = $this->scriptRepository->findAllForTaskIdOrderedByExecutionOrder($taskId);

        return new JsonResponse([
            'scripts' => $this->transformerManager->transformMany($scripts)
        ]);
    }

    private function fillTaskFromRequest(Request $request, Task $task): Task
    {
        $task->setName($request->request->get('name'));
        $task->setUrl($request->request->get('url'));
        $task->setCheckFrequency($request->request->get('checkFrequency'));
        $task->setHoursOfActivity($request->request->get('hoursOfActivity'));
        $task->setStatus($request->request->get('status'));
        $task->setNotificationChannel($request->request->get('notificationChannel'));

        return $task;
    }
}