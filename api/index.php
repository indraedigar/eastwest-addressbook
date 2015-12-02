<?php

date_default_timezone_set('UTC');
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

/** Loading Plugins */
require 'vendor/autoload.php';

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */

$app = new \Slim\Slim(array(
    'debug' => true
));

//header('Access-Control-Allow-Origin: http://teambnw.com');
header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods', 'DELETE');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

require_once('config.php');

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

$app->get(
    '/',
    function () {
        header("Content-Type:application/json");
        $template = '[{"name":"Indra"},{"name":"Manjesh"},{"name":"Divya"},{"name":"Supritha","mobile":"987654321"}]';
        echo $template;
    }
);
$app->get(
    '/contacts',
    function () {
        header("Content-Type:application/json");
        $template = '[{"name":"Indra"},{"name":"Manjesh"},{"name":"Divya"},{"name":"Supritha","mobile":"987654321"}]';
        echo $template;
    }
);

// Database Table Corresponding Routes
include('services/hotels.php');

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();

