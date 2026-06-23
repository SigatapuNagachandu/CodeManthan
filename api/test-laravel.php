<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // 1. Load Autoloader
    if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
        throw new \Exception("Autoloader vendor/autoload.php not found. Run composer install.");
    }
    require __DIR__.'/../vendor/autoload.php';
    
    // 2. Load Laravel Application Bootstrap
    if (!file_exists(__DIR__.'/../bootstrap/app.php')) {
        throw new \Exception("Bootstrap bootstrap/app.php not found.");
    }
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    echo "<h2>Laravel Bootstrap Success!</h2>";
    echo "Laravel Version: " . $app->version() . "<br>";
    echo "Storage Path: " . $app->storagePath() . "<br>";
    
    // 3. Test handle HTTP kernel request
    echo "<h3>Testing HTTP Kernel Boot</h3>";
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    echo "Kernel resolved. Capturing request...<br>";
    $request = Illuminate\Http\Request::capture();
    
    echo "Sending request to router...<br>";
    $response = $kernel->handle($request);
    
    echo "<strong>Response status:</strong> " . $response->getStatusCode() . "<br>";
    echo "<hr><h4>Response Content:</h4>";
    $response->sendContent();
    
    $kernel->terminate($request, $response);
    
} catch (\Exception $e) {
    echo "<h2 style='color:red;'>Laravel Exception Caught</h2>";
    echo "<strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "<strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")<br>";
    echo "<h4>Stack Trace:</h4>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
} catch (\Throwable $t) {
    echo "<h2 style='color:red;'>Laravel Fatal Error / Throwable Caught</h2>";
    echo "<strong>Message:</strong> " . htmlspecialchars($t->getMessage()) . "<br>";
    echo "<strong>File:</strong> " . htmlspecialchars($t->getFile()) . " (Line " . $t->getLine() . ")<br>";
    echo "<h4>Stack Trace:</h4>";
    echo "<pre>" . htmlspecialchars($t->getTraceAsString()) . "</pre>";
}
