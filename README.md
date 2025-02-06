# FlixFlex - Movie Discovery Platform

A movie discovery platform that allows users to explore and manage their favorite movies and TV series. The application integrates with TMDB API to provide comprehensive movie/series information, trailers, and a personalized favorites system. Built with Laravel, Vue.js, and Inertia.js for a seamless single-page application experience.

## Features

- User authentication and profile management
- Browse movies and TV series with pagination
- Add/remove favorites
- Search functionality for movies and series
- Detailed view for each movie/series
- Watch trailers
- Responsive design

## Tech Stack

- Backend: Laravel 11
- Frontend: Vue.js 3 with Inertia.js
- Authentication: Laravel Breeze
- Database: SQLite (MySQL supported)
- API Integration: TMDB API

## Prerequisites

- PHP >= 8.1
- Composer
- Node.js & Yarn/npm
- TMDB API key ([Get it here](https://developer.themoviedb.org))

## Installation

1. Clone the repository:
```bash
git clone https://github.com/benounnas/FlixFlexDemo
cd flixflex
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
yarn install
# or
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your .env file:
```env
DB_CONNECTION=sqlite
TMDB_TOKEN=your_tmdb_api_token
```

For MySQL, update these settings instead:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flixflex
DB_USERNAME=root
DB_PASSWORD=
```

7. Create database and run migrations:
```bash
# For SQLite
touch database/database.sqlite
php artisan migrate

# For MySQL
php artisan migrate
```

## Running the Application

1. Start the Laravel development server:
```bash
php artisan serve
```

2. Start the Vite development server:
```bash
yarn dev
# or
npm run dev
```

Access the application at `http://localhost:8000`

## API Documentation

All endpoints require authentication except the login and registration routes. The application uses the following endpoints:

- `GET /movies` - List all movies (Auth required)
- `GET /movies/{id}` - Get movie details (Auth required)
- `GET /series` - List all TV series (Auth required)
- `GET /series/{id}` - Get series details (Auth required)
- `GET /search` - Search movies and series (Auth required)
- `GET /favorites` - List user favorites (Auth required)
- `POST /favorites/toggle` - Toggle favorite status (Auth required)
