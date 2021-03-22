<?php

namespace App\Transformer;

use App\Entity\Script;

class ScriptTransformer
{
    public function transform(Script $entity): array
    {
        return [
            'id' => $entity->getId(),
            'taskId' => $entity->getTask()->getId(),
            'type' => $entity->getType(),
            'label' => $entity->getLabel(),
            'code' => $entity->getCode(),
            'executionOrder' => $entity->getExecutionOrder(),
        ];
    }
}