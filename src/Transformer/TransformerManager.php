<?php

namespace App\Transformer;

use App\Entity\Task;

class TransformerManager
{
    public $dictionary = [
        Task::class => TaskTransformer::class
    ];

    public function transform($entity): array
    {
        $transformerClass = $this->dictionary[get_class($entity)];

        /** @var TransformerInterface $transformer */
        $transformer = new $transformerClass($entity);

        return $transformer->transform();
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