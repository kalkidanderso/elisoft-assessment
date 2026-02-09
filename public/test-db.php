<?php
/**
 * Database Connection Test Script for Render
 * Visit: https://your-app.onrender.com/test-db.php
 * 
 * This script tests:
 * 1. Database connection
 * 2. Whether tables exist
 * 3. Whether demo users exist
 */

// Helper function to get environment variable from multiple sources
function getEnvVar($key, $default = null) {
    // Also try underscore version (Docker-friendly)
    $underscoreKey = str_replace('.', '_', $key);
    
    // Check $_ENV first (Render uses this)
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
        return $_ENV[$key];
    }
    if ($underscoreKey !== $key && isset($_ENV[$underscoreKey]) && $_ENV[$underscoreKey] !== '') {
        return $_ENV[$underscoreKey];
    }
    
    // Check $_SERVER
    if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
        return $_SERVER[$key];
    }
    if ($underscoreKey !== $key && isset($_SERVER[$underscoreKey]) && $_SERVER[$underscoreKey] !== '') {
        return $_SERVER[$underscoreKey];
    }
    
    // Check getenv()
    $value = getenv($key);
    if ($value !== false && $value !== '') {
        return $value;
    }
    if ($underscoreKey !== $key) {
        $value = getenv($underscoreKey);
        if ($value !== false && $value !== '') {
            return $value;
        }
    }
    
    return $default;
}

// Read .env file if it exists (for local testing)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B'\"");
            if (!getEnvVar($key)) {
                $_ENV[$key] = $value;
            }
        }
    }
}

echo "<!DOCTYPE html>";
echo "<html><head><style>body{font-family:Arial,sans-serif;margin:20px;}</style></head><body>";
echo "<h1>Database Connection Test</h1>";
echo "<hr>";

// Get environment variables
echo "<h2>1. Environment Variables</h2>";
echo "CI_ENVIRONMENT: " . (getEnvVar('CI_ENVIRONMENT') ?: 'not set') . "<br>";
echo "DB Driver: " . (getEnvVar('database.default.DBDriver') ?: 'not set') . "<br>";
echo "DB Host: " . (getEnvVar('database.default.hostname') ?: 'not set') . "<br>";
echo "DB Name: " . (getEnvVar('database.default.database') ?: 'not set') . "<br>";
echo "DB User: " . (getEnvVar('database.default.username') ?: 'not set') . "<br>";
echo "DB Port: " . (getEnvVar('database.default.port') ?: 'not set') . "<br>";
echo "<hr>";

// Test database connection
echo "<h2>2. Database Connection Test</h2>";
try {
    $dbHost = getEnvVar('database.default.hostname');
    $dbName = getEnvVar('database.default.database');
    $dbUser = getEnvVar('database.default.username');
    $dbPass = getEnvVar('database.default.password');
    $dbPort = getEnvVar('database.default.port') ?: '5432';
    $dbDriver = getEnvVar('database.default.DBDriver') ?: 'Postgre';
    
    if (!$dbHost || !$dbName || !$dbUser) {
        echo "<strong style='color:orange'>⚠️ Missing database configuration in environment variables!</strong><br><br>";
        echo "<p>Check Render Dashboard → Web Service → Environment tab and verify these are set:</p>";
        echo "<ul>";
        echo "<li>database.default.DBDriver</li>";
        echo "<li>database.default.hostname</li>";
        echo "<li>database.default.database</li>";
        echo "<li>database.default.username</li>";
        echo "<li>database.default.password</li>";
        echo "<li>database.default.port</li>";
        echo "</ul>";
        throw new Exception("Missing database configuration in environment variables!");
    }
    
    if ($dbDriver === 'Postgre') {
        $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo "✅ <strong style='color:green'>Connected to PostgreSQL successfully!</strong><br>";
        echo "Database: {$dbName}<br>";
        echo "Host: {$dbHost}:{$dbPort}<br>";
    } else {
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName}";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo "✅ <strong style='color:green'>Connected to MySQL successfully!</strong><br>";
    }
    echo "<hr>";
    
    // Check if tables exist
    echo "<h2>3. Tables Check</h2>";
    if ($dbDriver === 'Postgre') {
        $stmt = $pdo->query("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename");
    } else {
        $stmt = $pdo->query("SHOW TABLES");
    }
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($tables) > 0) {
        echo "✅ <strong style='color:green'>Found " . count($tables) . " tables:</strong><br>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>{$table}</li>";
        }
        echo "</ul>";
    } else {
        echo "❌ <strong style='color:red'>No tables found! You need to import schema.postgres.sql</strong><br>";
        echo "<p><strong>Action Required:</strong></p>";
        echo "<ol>";
        echo "<li>Go to Render Dashboard → PostgreSQL service</li>";
        echo "<li>Click 'Query' or 'PSQL Console'</li>";
        echo "<li>Copy contents of <a href='https://github.com/kalkidanderso/elisoft-assessment/blob/main/database/schema.postgres.sql' target='_blank'>database/schema.postgres.sql</a></li>";
        echo "<li>Paste and run the SQL in the console</li>";
        echo "</ol>";
    }
    echo "<hr>";
    
    // Check if users exist
    echo "<h2>4. Demo Users Check</h2>";
    try {
        $stmt = $pdo->query("SELECT id, username, full_name, role FROM users ORDER BY id");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($users) > 0) {
            echo "✅ <strong style='color:green'>Found " . count($users) . " users:</strong><br>";
            echo "<table border='1' cellpadding='5' style='border-collapse:collapse;margin-top:10px;'>";
            echo "<tr style='background:#f0f0f0;'><th>ID</th><th>Username</th><th>Full Name</th><th>Role</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['id']}</td>";
                echo "<td><strong>{$user['username']}</strong></td>";
                echo "<td>{$user['full_name']}</td>";
                echo "<td>{$user['role']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br><p style='background:#d4edda;padding:10px;border:1px solid #c3e6cb;border-radius:5px;'>";
            echo "✅ <strong style='color:green'>Database is ready! You can now login.</strong><br>";
            echo "Try: <a href='/login'>Login Page</a> with <code>admin</code> / <code>password</code>";
            echo "</p>";
        } else {
            echo "❌ <strong style='color:red'>Users table is empty!</strong><br>";
            echo "The schema.postgres.sql file should have inserted demo users.";
        }
    } catch (PDOException $e) {
        echo "❌ <strong style='color:red'>Users table does not exist!</strong><br>";
        echo "Error: " . htmlspecialchars($e->getMessage()) . "<br>";
        echo "<p>You need to import schema.postgres.sql</p>";
    }
    
} catch (PDOException $e) {
    echo "❌ <strong style='color:red'>Database connection failed!</strong><br>";
    echo "Error: " . htmlspecialchars($e->getMessage()) . "<br><br>";
    echo "<p><strong>Possible issues:</strong></p>";
    echo "<ul>";
    echo "<li>Wrong database credentials in Render environment variables</li>";
    echo "<li>Database host is internal (should be external with .oregon-postgres.render.com)</li>";
    echo "<li>PostgreSQL service is not running</li>";
    echo "</ul>";
} catch (Exception $e) {
    echo "❌ <strong style='color:red'>Configuration error!</strong><br>";
    echo "Error: " . htmlspecialchars($e->getMessage()) . "<br>";
}

echo "</body></html>";
