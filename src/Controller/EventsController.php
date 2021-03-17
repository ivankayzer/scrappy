<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Transformer\TransformerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}