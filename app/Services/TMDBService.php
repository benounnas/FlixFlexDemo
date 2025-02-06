<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class TMDBService
{
    private string $baseUrl = 'https://api.themoviedb.org/3';
    private string $token;
    private int $limit = 10;

    public function __construct()
    {
        $this->token = config('services.tmdb.token');
    }

    private function get($endpoint, $params = [])
    {
        return Http::withToken($this->token)
            ->withHeaders(['accept' => 'application/json'])
            ->get($this->baseUrl . $endpoint, $params);
    }

    public function getMovies($page = 1)
    {
        try {
            $response = $this->get('/movie/popular', ['page' => $page]);
            $data = $response->json();

            return [
                'data' => array_slice($data['results'] ?? [], 0, $this->limit),
                'meta' => [
                    'current_page' => $data['page'] ?? $page,
                    'total' => $data['total_results'] ?? 0,
                    'last_page' => $data['total_pages'] ?? 1
                ]
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'meta' => [
                    'current_page' => $page,
                    'total' => 0,
                    'last_page' => 1
                ]
            ];
        }
    }

    public function getMovie($id)
    {
        try {
            $response = $this->get("/movie/{$id}", ['append_to_response' => 'videos']);
            return $response->json() ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getSeries($page = 1)
    {
        try {
            $response = $this->get('/tv/popular', ['page' => $page]);
            $data = $response->json();

            return [
                'data' => array_slice($data['results'] ?? [], 0, $this->limit),
                'meta' => [
                    'current_page' => $data['page'] ?? $page,
                    'total' => $data['total_results'] ?? 0,
                    'last_page' => $data['total_pages'] ?? 1
                ]
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'meta' => [
                    'current_page' => $page,
                    'total' => 0,
                    'last_page' => 1
                ]
            ];
        }
    }

    public function getSerie($id)
    {
        try {
            $response = $this->get("/tv/{$id}", ['append_to_response' => 'videos']);
            return $response->json() ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function search($query, $page = 1)
    {
        try {
            $response = $this->get('/search/multi', [
                'query' => $query,
                'page' => $page
            ]);
            $data = $response->json();

            return [
                'data' => array_slice($data['results'] ?? [], 0, $this->limit),
                'meta' => [
                    'current_page' => $data['page'] ?? $page,
                    'total' => $data['total_results'] ?? 0,
                    'last_page' => $data['total_pages'] ?? 1
                ]
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'meta' => [
                    'current_page' => $page,
                    'total' => 0,
                    'last_page' => 1
                ]
            ];
        }
    }
}