<?php
// Change the command below to your specific artisan command
shell_exec('php artisan FetchMoviesAndTVshows');
echo "Command executed successfully at " . date('Y-m-d H:i:s') . PHP_EOL;
file_put_contents('log.txt', "Command executed at " . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
