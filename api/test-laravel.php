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
    
    echo "<h2>Laravel Instance Created</h2>";
    
    // 3. Step-by-Step Manual Boot (to catch the primary exception before the Handler runs)
    $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        // Skipping HandleExceptions so it doesn't mask the error!
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];
    
    foreach ($bootstrappers as $bootstrapper) {
        echo "Running bootstrapper: <code>" . htmlspecialchars($bootstrapper) . "</code>... ";
        $app->make($bootstrapper)->bootstrap($app);
        echo "<span style='color:green;'>SUCCESS</span><br>";
    }
    
    echo "<h3 style='color:green;'>All Bootstrappers completed successfully! No boot-level exceptions.</h3>";
    
} catch (\Exception $e) {
    echo "<h2 style='color:red;'>Primary Laravel Exception Caught</h2>";
    echo "<strong>Class:</strong> " . get_class($e) . "<br>";
    echo "<strong>Message:</strong> <span style='color:red; font-weight:bold;'>" . htmlspecialchars($e->getMessage()) . "</span><br>";
    echo "<strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")<br>";
    echo "<h4>Stack Trace:</h4>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
} catch (\Throwable $t) {
    echo "<h2 style='color:red;'>Primary Laravel Fatal Error / Throwable Caught</h2>";
    echo "<strong>Class:</strong> " . get_class($t) . "<br>";
    echo "<strong>Message:</strong> <span style='color:red; font-weight:bold;'>" . htmlspecialchars($t->getMessage()) . "</span><br>";
    echo "<strong>File:</strong> " . htmlspecialchars($t->getFile()) . " (Line " . $t->getLine() . ")<br>";
    echo "<h4>Stack Trace:</h4>";
    echo "<pre>" . htmlspecialchars($t->getTraceAsString()) . "</pre>";
}
