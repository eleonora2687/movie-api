# Movie API

This is a Laravel-based Movie API that fetches and stores movie and TV show data from TMDB (The Movie Database).

## Prerequisites

Before running the project, ensure you have the following installed:
- PHP (>= 8.0)
- Composer
- MySQL or any other supported database
- Laravel (>= 9.x)
- A TMDB API key ([Get it here](https://www.themoviedb.org/))

## Installation Steps

Follow these steps to set up and run the project:

### 1. Clone the Repository
```bash
git clone https://github.com/eleonora2687/movie-api.git
cd movie-api
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Set Up Environment File
Copy the example environment file and configure it:
```bash
cp .env.example .env
```

### 4. Add Your TMDB API Key
Edit the `.env` file and add the following line:
```env
TMDB_API_KEY=your_tmdb_api_key_here
```
Replace `your_tmdb_api_key_here` with your actual TMDB API key.

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Database Migrations
Ensure your database is configured in `.env`, then execute:
```bash
php artisan migrate
```

### 7. Fetch Movies and TV Shows Data
Run the following Artisan command to populate the database:
```bash
php artisan fetch:movies-tvshows
```

### 8. Start the Laravel Development Server
```bash
php artisan serve
```
This will start the server at `http://127.0.0.1:8000/`.

## API Usage
You can now interact with the Movie API using endpoints like:
- `GET /movies` - Fetch all movies
- `GET /tvshows` - Fetch all TV shows
- `GET /movies/{id}` - Fetch details of a specific movie
- `GET /tvshows/{id}` - Fetch details of a specific TV show

## Troubleshooting
If you run into issues, try the following:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```
Then rerun `php artisan fetch:movies-tvshows` and `php artisan serve`.

## License
This project is licensed under the MIT License.

