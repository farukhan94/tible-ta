<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

// Debug Probe
try {
    $response = $kernel->handle(
        $request = Request::capture()
    );
} catch (\Throwable $e) {
    error_log("CRITICAL ERROR PROBE:");
    error_log("Exception: " . $e->getMessage());
    error_log("Trace: " . $e->getTraceAsString());

    // Check if configuration is loaded
    $appConfig = config('app');
    if ($appConfig) {
        error_log("Config 'app' loaded. Name: " . ($appConfig['name'] ?? 'Unset'));
        error_log("Providers count: " . count($appConfig['providers'] ?? []));
        // Check for TranslationServiceProvider
        $hasTranslator = in_array('Illuminate\Translation\TranslationServiceProvider', $appConfig['providers'] ?? []);
        error_log("TranslationServiceProvider loaded: " . ($hasTranslator ? 'YES' : 'NO'));
    } else {
        error_log("Config 'app' is NULL or Empty!");
    }

    throw $e;
}

$response->send();

$kernel->terminate($request, $response);
