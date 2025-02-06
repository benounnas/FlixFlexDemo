<?php

namespace App\Http\Controllers;

use App\Enums\MediaType;
use App\Http\Requests\User\ToggleFavoriteRequest;
use App\Models\Favorite;
use App\Services\TMDBService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function toggleFavorite(ToggleFavoriteRequest $request)
    {

        $existing = Favorite::where([
            'user_id' => auth()->user()->id,
            'media_id' => $request->validated('media_id'),
            'media_type' => $request->validated('media_type')
        ])->first();

        $message = $existing ? 'Removed from favorites' : 'Added to favorites';

        $existing ? $existing->delete() : Favorite::create([
            'user_id' => auth()->user()->id,
            'media_id' => $request->validated('media_id'),
            'media_type' => $request->validated('media_type')
        ]);

        return redirect()->route($request->get('media_type') . '.show', $request->validated('media_id'))
            ->with('message', $message);
    }

    public function favorites(Request $request)
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->get()
            ->groupBy('media_type');

        $tmdb = new TMDBService();


        return Inertia::render('User/Favorites', [
            'movies' => collect($favorites[MediaType::MOVIE->value] ?? [])->map(fn($fav) => $tmdb->getMovie($fav->media_id)),
            'series' => collect($favorites[MediaType::SERIES->value] ?? [])->map(fn($fav) => $tmdb->getSerie($fav->media_id))
        ]);
    }

    public function search(Request $request)
    {
        //$query = $request->validate(['q' => 'required|string|min:2']);
        $tmdb = new TMDBService();
        $results = $tmdb->search($request->get('q'), $request->get('page', 1));

        return Inertia::render('Search/Index', [
            'results' => $results['data'],
            'meta' => $results['meta'],
            'query' => $request->get('q'),
        ]);
    }
}
