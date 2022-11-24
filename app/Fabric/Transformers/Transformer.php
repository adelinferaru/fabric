<?php

namespace App\Fabric\Transformers;

abstract class Transformer
{
    public function transformCollection (array $items): array
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform(array $item):array;
}
