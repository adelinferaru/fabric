<?php

namespace App\Services;

use App\Fabric\Interfaces\MovieSearch;
use App\Fabric\Interfaces\OmdbApi;
use Illuminate\Support\Facades\Http;

class SearchMovieService
{
    protected MovieSearch $movieSearch;

    /**
     * @param MovieSearch $movieSearch
     */
    public function __construct(MovieSearch $movieSearch)
    {
        $this->movieSearch = $movieSearch;
    }


    public function searchMovie(string $searchString): array
    {
        return $this->movieSearch->search($searchString);
    }
}
