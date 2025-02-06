<?php

namespace App\Http\Controllers;

use App\Enums\MediaType;
use App\Models\Favorite;
use App\Services\TMDBService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SeriesController extends Controller
{
    protected $tmdb;

    public function __construct(TMDBService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $response = $this->tmdb->getSeries($page);

        $series = !empty($response['data']) ? collect($response['data'])->map(function($serie) {
            return [
                'id' => $serie['id'] ?? null,
                'name' => $serie['name'] ?? '',
                'poster_path' => $serie['poster_path'] ?? null,
                'first_air_date' => $serie['first_air_date'] ?? null,
                'vote_average' => $serie['vote_average'] ?? 0,
                'overview' => $serie['overview'] ?? ''
            ];
        }) : collect([]);

        return Inertia::render('Series/Index', [
            'series' => $series,
            'currentPage' => $response['meta']['current_page'] ?? 1,
            'totalPages' => $response['meta']['last_page'] ?? 1,
            'totalResults' => $response['meta']['total'] ?? 0
        ]);
    }

    public function show($id)
    {
        $data = $this->tmdb->getSerie($id);

        if (empty($data)) {
            abort(404);
        }

        $is_favorite = Favorite::where('user_id', auth()->id())
            ->where('media_id', $id)
            ->where('media_type', MediaType::SERIES)
            ->exists();

        return Inertia::render('Series/Show', [
            'serie' => [
                'id' => $data['id'] ?? null,
                'name' => $data['name'] ?? '',
                'poster_path' => $data['poster_path'] ?? null,
                'backdrop_path' => $data['backdrop_path'] ?? null,
                'first_air_date' => $data['first_air_date'] ?? null,
                'last_air_date' => $data['last_air_date'] ?? null,
                'vote_average' => $data['vote_average'] ?? 0,
                'overview' => $data['overview'] ?? '',
                'number_of_seasons' => $data['number_of_seasons'] ?? 0,
                'number_of_episodes' => $data['number_of_episodes'] ?? 0,
                'status' => $data['status'] ?? 'Unknown',
                'genres' => $data['genres'] ?? [],
                'created_by' => $data['created_by'] ?? [],
                'seasons' => $data['seasons'] ?? [],
                'videos' => $data['videos'] ?? null,
                'is_favorite' => $is_favorite
            ]
        ]);
    }
}