<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\EventRepository;
use App\Repository\TaskRepository;
use App\Transformer\TransformerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class EventsController extends AbstractController
{
    private TransformerManager $transformerManager;

    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository, TransformerManager $transformerManager)
    {
        $this->transformerManager = $transformerManager;
        $this->eventRepository = $eventRepository;
    }

    public function all(Security $security): Response
    {
        $events = $this->eventRepository->findAllForUser($security->getUser()->getId());

        return new JsonResponse([
            'events' => $this->transformerManager->transformMany($events)
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