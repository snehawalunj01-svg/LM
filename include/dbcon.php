<?php
// include/dbcon.php
// Read DB configuration from environment variables (Elastic Beanstalk / CodeBuild / ECS compatible)
$dbhost = getenv('DB_HOST') ?: getenv('RDS_HOSTNAME') ?: '127.0.0.1';
$dbport = getenv('DB_PORT') ?: getenv('RDS_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: getenv('RDS_DB_NAME') ?: 'project_library';
$dbuser = getenv('DB_USER') ?: getenv('RDS_USERNAME') ?: 'root';
$dbpass = getenv('DB_PASS') ?: getenv('RDS_PASSWORD') ?: '';
$debug = (getenv('APP_DEBUG') === '1' || getenv('DEBUG') === '1');
if ($debug) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname, (int)$dbport);
if ($mysqli->connect_errno) {
    error_log("DB connect error: " . $mysqli->connect_error);
    http_response_code(500);
    if ($debug) {
        // Show detailed error in development
        exit("Database connection failed: " . $mysqli->connect_error);
    }
    // In production avoid exposing details to users; keep this message generic
    exit("Database connection failed.");
}
$mysqli->set_charset('utf8mb4');

// $mysqli is available for the rest of the app
?>
