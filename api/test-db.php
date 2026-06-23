<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<html><head><title>CodeManthan Diagnostics</title><style>body { font-family: sans-serif; padding: 20px; line-height: 1.6; } pre { background: #f4f4f4; padding: 15px; border: 1px solid #ddd; }</style></head><body>";
echo "<h2>CodeManthan On-Server Diagnostics</h2>";

// 1. PHP Version
echo "<strong>PHP Version:</strong> " . PHP_VERSION . "<br>";

// 2. Check MongoDB Extension
echo "<strong>MongoDB Extension Loaded:</strong> " . (extension_loaded('mongodb') ? "<span style='color:green;'>YES</span>" : "<span style='color:red;'>NO</span>") . "<br>";

// 3. Test MongoDB connection
echo "<h3>Testing MongoDB Atlas Connection</h3>";
$uri = getenv('MONGODB_URI') ?: (isset($_ENV['MONGODB_URI']) ? $_ENV['MONGODB_URI'] : null);

if (!$uri) {
    echo "<span style='color:red;'>Error: MONGODB_URI environment variable is empty or not found in server context.</span><br>";
} else {
    // Mask password in output for security
    $masked_uri = preg_replace('/:(.*)@/', ':******@', $uri);
    echo "Connecting to: <code>" . htmlspecialchars($masked_uri) . "</code><br>";
    
    try {
        if (class_exists('MongoDB\Driver\Manager')) {
            $manager = new MongoDB\Driver\Manager($uri);
            $command = new MongoDB\Driver\Command(['ping' => 1]);
            $cursor = $manager->executeCommand('admin', $command);
            echo "<span style='color:green;'>Success: Connection to MongoDB Atlas established successfully! Ping response received.</span><br>";
        } else {
            echo "<span style='color:red;'>Error: MongoDB Driver Manager class is missing in PHP runtime.</span><br>";
        }
    } catch (\Exception $e) {
        echo "<span style='color:red;'>Connection Failed:</span> " . htmlspecialchars($e->getMessage()) . "<br>";
    }
}

// 4. Check application storage write access
echo "<h3>Testing Write Access in /tmp</h3>";
$test_path = "/tmp/storage/framework/views";
if (is_dir($test_path)) {
    $test_file = $test_path . "/test_write.txt";
    if (@file_put_contents($test_file, 'test')) {
        echo "<span style='color:green;'>Success: View cache storage folder is writable.</span><br>";
        @unlink($test_file);
    } else {
        echo "<span style='color:red;'>Error: Failed to write to temporary view cache storage.</span><br>";
    }
} else {
    echo "<span style='color:red;'>Error: Path $test_path does not exist.</span><br>";
}

// 5. Test Laravel Autoloader
echo "<h3>Testing Composer Autoloader</h3>";
$autoloader = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloader)) {
    echo "<span style='color:green;'>Success: vendor/autoload.php exists.</span><br>";
} else {
    echo "<span style='color:red;'>Error: vendor/autoload.php does not exist! Composer dependencies did not install correctly.</span><br>";
}

echo "<br><hr><h3>PHP Information</h3>";
phpinfo();
echo "</body></html>";
