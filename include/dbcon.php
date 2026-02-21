<?php
// include/dbcon.php
// Read DB configuration from environment variables (Elastic Beanstalk / CodeBuild / ECS compatible)
$dbhost = getenv('DB_HOST') ?: getenv('RDS_HOSTNAME') ?: 'library-db.cfik8aewcbl1.ap-south-1.rds.amazonaws.com';
$dbport = getenv('DB_PORT') ?: getenv('RDS_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: getenv('RDS_DB_NAME') ?: 'library-db';
$dbuser = getenv('DB_USER') ?: getenv('RDS_USERNAME') ?: 'admin';
$dbpass = getenv('DB_PASS') ?: getenv('RDS_PASSWORD') ?: 'Admin098';
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
