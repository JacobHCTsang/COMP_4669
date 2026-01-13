<?php
    /*same code as comp4669_lab1_par2.php file*/

    /*please note this file is already included in comp4669_part1*/
    session_start();

    /* Generate a new CSRF token after every GET request */
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    /* Validate token on POST */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            !isset($_POST['csrf_token']) ||
            !isset($_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            die('CSRF validation failed');
        }

        //unset after successful use
        unset($_SESSION['csrf_token']);
    }
?>

<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
?>