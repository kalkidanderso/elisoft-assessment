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

// Load CodeIgniter bootstrap
require_once __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require_once FCPATH . '../app/Config/Constants.php';

echo "<h1>Database Connection Test</h1>";
echo "<hr>";

// Get environment variables
echo "<h2>1. Environment Variables</h2>";
echo "CI_ENVIRONMENT: " . getenv('CI_ENVIRONMENT') . "<br>";
echo "DB Driver: " . getenv('database.default.DBDriver') . "<br>";
echo "DB Host: " . getenv('database.default.hostname') . "<br>";
echo "DB Name: " . getenv('database.default.database') . "<br>";
echo "DB User: " . getenv('database.default.username') . "<br>";
echo "DB Port: " . getenv('database.default.port') . "<br>";
echo "<hr>";

// Test database connection
echo "<h2>2. Database Connection Test</h2>";
try {
    $dbHost = getenv('database.default.hostname') ?: 'localhost';
    $dbName = getenv('database.default.database') ?: '';
    $dbUser = getenv('database.default.username') ?: '';
    $dbPass = getenv('database.default.password') ?: '';
    $dbPort = getenv('database.default.port') ?: '5432';
    $dbDriver = getenv('database.default.DBDriver') ?: 'Postgre';
    
    if ($dbDriver === 'Postgre') {
        $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo "✅ <strong>Connected to PostgreSQL successfully!</strong><br>";
        echo "Database: {$dbName}<br>";
        echo "Host: {$dbHost}:{$dbPort}<br>";
    } else {
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName}";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo "✅ <strong>Connected to MySQL successfully!</strong><br>";
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
        echo "✅ <strong>Found " . count($tables) . " tables:</strong><br>";
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
        echo "<li>Copy contents of database/schema.postgres.sql</li>";
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
            echo "✅ <strong>Found " . count($users) . " users:</strong><br>";
            echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
            echo "<tr><th>ID</th><th>Username</th><th>Full Name</th><th>Role</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['id']}</td>";
                echo "<td>{$user['username']}</td>";
                echo "<td>{$user['full_name']}</td>";
                echo "<td>{$user['role']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br><strong>✅ Database is ready! You can now login.</strong>";
        } else {
            echo "❌ <strong style='color:red'>Users table is empty!</strong><br>";
            echo "The schema.postgres.sql file should have inserted demo users.";
        }
    } catch (PDOException $e) {
        echo "❌ <strong style='color:red'>Users table does not exist!</strong><br>";
        echo "Error: " . $e->getMessage() . "<br>";
        echo "<p>You need to import schema.postgres.sql</p>";
    }
    
} catch (PDOException $e) {
    echo "❌ <strong style='color:red'>Database connection failed!</strong><br>";
    echo "Error: " . $e->getMessage() . "<br><br>";
    echo "<p><strong>Possible issues:</strong></p>";
    echo "<ul>";
    echo "<li>Wrong database credentials in Render environment variables</li>";
    echo "<li>Database host is internal (should be external with .oregon-postgres.render.com)</li>";
    echo "<li>PostgreSQL service is not running</li>";
    echo "</ul>";
}
