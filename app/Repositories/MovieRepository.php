<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Models\Poster;
use Illuminate\Support\Arr;

class MovieRepository
{
    public function upsertMovies (array $data) {
        $movies = [];
        $posters = [];
        foreach ($data as $movie) {
            $movies [] = Arr::except($movie, ['poster']);
            if (strlen($movie['poster']) > 4) {
                $posters [] = [
                    'movie_id' => $movie['id'],
                    'poster' => $movie['poster']
                ];
            }
        }

        if (count($movies)) {
            Movie::upsert($movies, ['id']);
        }

        if(count($posters)) {
            Poster::upsert($posters, ['movie_id']);
        }
    }
}
