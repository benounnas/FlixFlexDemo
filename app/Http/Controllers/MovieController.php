<?php

namespace App\Http\Controllers;

use App\Enums\MediaType;
use App\Models\Favorite;
use App\Services\TMDBService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    protected $tmdb;

    public function __construct(TMDBService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $response = $this->tmdb->getMovies($page);

        $movies = !empty($response['data']) ? $response['data'] : [];

        return Inertia::render('Movies/Index', [
            'movies' => $movies,
            'currentPage' => $response['meta']['current_page'] ?? 1,
            'totalPages' => $response['meta']['last_page'] ?? 1,
            'totalResults' => $response['meta']['total'] ?? 0
        ]);
    }

    public function show($id)
    {
        $data = $this->tmdb->getMovie($id);

        if (empty($data)) {
            abort(404);
        }

        $is_favorite = Favorite::where('user_id', auth()->id())
            ->where('media_id', $id)
            ->where('media_type', MediaType::MOVIE)
            ->exists();

        $movie = array_merge([
            'id' => $data['id'] ?? null,
            'title' => $data['title'] ?? '',
            'poster_path' => $data['poster_path'] ?? null,
            'backdrop_path' => $data['backdrop_path'] ?? null,
            'release_date' => $data['release_date'] ?? null,
            'vote_average' => $data['vote_average'] ?? 0,
            'overview' => $data['overview'] ?? '',
            'runtime' => $data['runtime'] ?? 0,
            'status' => $data['status'] ?? 'Unknown',
            'genres' => $data['genres'] ?? [],
            'production_companies' => $data['production_companies'] ?? [],
            'spoken_languages' => $data['spoken_languages'] ?? [],
            'videos' => $data['videos'] ?? null,
        ], ['is_favorite' => $is_favorite]);

        return Inertia::render('Movies/Show', ['movie' => $movie]);
    }
}