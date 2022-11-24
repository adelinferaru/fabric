<?php

namespace App\Http\Controllers;

use App\Fabric\Interfaces\OmdbApi;
use App\Fabric\Transformers\MovieTransformer;
use App\Http\Requests\SearchMovieRequest;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use App\Services\SearchMovieService;
use http\Env\Request;
use Illuminate\Support\Arr;

class MovieController extends Controller
{
    protected MovieTransformer $movieTransformer;

    /**
     * @param MovieTransformer $movieTransformer
     */
    public function __construct(MovieTransformer $movieTransformer)
    {
        $this->movieTransformer = $movieTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMovieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMovieRequest  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }

    /**
     * Search for movies
     */
    public function search(SearchMovieRequest $searchMovieRequest, OmdbApi $omdbApi, MovieRepository $movieRepository): \Illuminate\Http\JsonResponse
    {
        $searchData = $searchMovieRequest->validated();
        $searchMovieService = new SearchMovieService($omdbApi);
        $searchResults = $searchMovieService->searchMovie($searchData['s']);
        if (isset($searchResults['errors'])) {
            return response()->json(['errors' => $searchResults['errors']], $searchResults['code'] ?? 200);
        }

        $results = $this->movieTransformer->transformCollection($searchResults);
        $movieRepository->upsertMovies($results);

        return response()->json($results);
    }
}
