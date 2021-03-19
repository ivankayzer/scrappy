<?php

namespace App\Transformer;

use App\Entity\Event;
use App\Entity\Script;
use App\Entity\Task;
use App\Entity\TaskExecutionHistory;
use Psr\Container\ContainerInterface;

class TransformerManager
{
    public $dictionary = [
        Task::class => TaskTransformer::class,
        TaskExecutionHistory::class => TaskExecutionHistoryTransformer::class,
        Event::class => EventTransformer::class,
        Script::class => ScriptTransformer::class,
    ];

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function transform($entity): array
    {
        $transformerClass = $this->dictionary[get_class($entity)];

        $transformer = $this->container->get($transformerClass);

        return $transformer->transform($entity);
    }

    public function transformMany(array $entities): array
    {
        $transformed = [];

        foreach ($entities as $entity) {
            $transformed[] = $this->transform($entity);
        }

        return $transformed;
    }
}