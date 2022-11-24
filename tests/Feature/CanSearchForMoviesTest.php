<?php

it('does not start a movie search without a "s" parameter', function () {
    $response = $this->postJson('/api/search', []);
    $response->assertStatus(422);
});

it('performs a search for a movie with a valid "s" parameter', function() {
    $response = $this->postJson('/api/search', ['s' => 'Matrix']);
    $response->assertStatus(200);
});

it('returns 10 results when searching for "Matrix"', function() {
    $response = $this->postJson('/api/search', ['s' => 'Matrix']);
    $response->assertStatus(200);
    $results = $response->json();
    expect($results)->toBeArray();
    expect(count($results))->toBe(10);
});

it('stores all the returned results in DB', function(){
    $response = $this->postJson('/api/search', ['s' => 'Matrix']);
    $results = $response->json();

    foreach ($results as $result) {
        $movie = \App\Models\Movie::where('id', $result['id'])->first();
        expect($movie)->not->toBeEmpty();

        if($result['poster'] != 'N/A') {
            $poster = \App\Models\Poster::where('movie_id', $result['id'])->where('poster', $result['poster'])->first();
            expect($poster)->not->toBeEmpty();
        }
    }
});
