<?php

namespace App\Fabric\Transformers;

use App\Fabric\Transformers;

class MovieTransformer extends Transformer
{

    public function transform(array $item): array
    {
        // TODO: Implement transform() method.
        return [
            'title' => $item['Title'],
            'year' => $item['Year'],
            'id' => $item['imdbID'],
            'type' => $item['Type'],
            'poster' => $item['Poster'],
        ];
    }
}
