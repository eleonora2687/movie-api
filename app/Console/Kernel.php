<?php

namespace App\Console;

use App\Console\Commands\FetchMoviesAndTVshows;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        FetchMoviesAndTVshows::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Empty the movie and TV show tables
            \DB::table('popular_movies')->truncate();
            \DB::table('upcoming_movies')->truncate();
            \DB::table('top_rated_movies')->truncate();

            \DB::table('popular_tv_shows')->truncate();
            \DB::table('on_the_air_tv_shows')->truncate();
            \DB::table('top_rated_tv_shows')->truncate();

            // Fetch new data by calling the custom command
            $this->call('fetch:movies-tvshows');
        })->sundays()->at('09:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');  // Load commands from the correct directory

        require base_path('routes/console.php');
    }
}
