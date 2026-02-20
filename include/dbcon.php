<?php
// include/dbcon.php
$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbName = getenv('DB_NAME') ?: 'project_library';
$dbPort = getenv('DB_PORT') ?: 3306;

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName, (int)$dbPort);
if ($mysqli->connect_errno) {
    error_log("DB connect error: " . $mysqli->connect_error);
    die("Database connection error.");
}
$mysqli->set_charset("utf8mb4");