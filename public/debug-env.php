<?php
// Debug script to see all available environment variables
echo "<!DOCTYPE html>";
echo "<html><head><style>body{font-family:monospace;margin:20px;} table{border-collapse:collapse;} td,th{border:1px solid #ccc;padding:5px;text-align:left;}</style></head><body>";
echo "<h1>Environment Variables Debug</h1>";

echo "<h2>$_ENV</h2>";
if (empty($_ENV)) {
    echo "<p style='color:red;'>$_ENV is empty!</p>";
} else {
    echo "<table>";
    echo "<tr><th>Key</th><th>Value</th></tr>";
    foreach ($_ENV as $key => $value) {
        $displayValue = (strpos($key, 'password') !== false || strpos($key, 'PASSWORD') !== false) 
            ? '***hidden***' 
            : htmlspecialchars($value);
        echo "<tr><td>" . htmlspecialchars($key) . "</td><td>" . $displayValue . "</td></tr>";
    }
    echo "</table>";
}

echo "<h2>$_SERVER (filtered)</h2>";
if (empty($_SERVER)) {
    echo "<p style='color:red;'>$_SERVER is empty!</p>";
} else {
    echo "<table>";
    echo "<tr><th>Key</th><th>Value</th></tr>";
    foreach ($_SERVER as $key => $value) {
        if (is_string($value)) {
            $displayValue = (strpos($key, 'password') !== false || strpos($key, 'PASSWORD') !== false) 
                ? '***hidden***' 
                : htmlspecialchars($value);
            echo "<tr><td>" . htmlspecialchars($key) . "</td><td>" . $displayValue . "</td></tr>";
        }
    }
    echo "</table>";
}

echo "<h2>getenv() test</h2>";
echo "<p>CI_ENVIRONMENT: " . var_export(getenv('CI_ENVIRONMENT'), true) . "</p>";
echo "<p>database.default.hostname: " . var_export(getenv('database.default.hostname'), true) . "</p>";
echo "<p>PORT: " . var_export(getenv('PORT'), true) . "</p>";

echo "</body></html>";
