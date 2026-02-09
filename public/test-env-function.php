<?php
// Test if CodeIgniter's env() function is working with underscore variables
require_once __DIR__ . '/../app/Common.php';

echo "<!DOCTYPE html><html><head><style>body{font-family:Arial;margin:20px;}</style></head><body>";
echo "<h1>CodeIgniter env() Function Test</h1>";

// Simulate Render environment
$_ENV['database_default_hostname'] = 'dpg-d64v7n7fte5s738i6uig-a';
$_ENV['database_default_database'] = 'elisoft_assessment';
$_ENV['database_default_DBDriver'] = 'Postgre';

echo "<h2>Testing env() function with underscore variables:</h2>";
echo "<p>env('database.default.hostname'): <strong>" . env('database.default.hostname', 'NOT FOUND') . "</strong></p>";
echo "<p>env('database.default.database'): <strong>" . env('database.default.database', 'NOT FOUND') . "</strong></p>";
echo "<p>env('database.default.DBDriver'): <strong>" . env('database.default.DBDriver', 'NOT FOUND') . "</strong></p>";

if (env('database.default.hostname') === 'dpg-d64v7n7fte5s738i6uig-a') {
    echo "<p style='background:#d4edda;padding:10px;border:1px solid #c3e6cb;'>✅ <strong>SUCCESS!</strong> env() correctly reads underscore variables!</p>";
} else {
    echo "<p style='background:#f8d7da;padding:10px;border:1px solid #f5c6cb;'>❌ <strong>FAILED!</strong> env() is not finding underscore variables.</p>";
}

echo "</body></html>";
