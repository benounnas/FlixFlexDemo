<?php

namespace App\Enums;

enum MediaType: string
{
    case MOVIE = 'movies';
    case SERIES = 'series';

    public function label(): string
    {
        return match($this) {
            self::MOVIE => 'Movie',
            self::SERIES => 'TV Series'
        };
    }
}