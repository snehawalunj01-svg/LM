<?php
$dbhost = getenv('DB_HOST') ?: getenv('RDS_HOSTNAME');
$dbport = getenv('DB_PORT') ?: getenv('RDS_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: getenv('RDS_DB_NAME');
$dbuser = getenv('DB_USER') ?: getenv('RDS_USERNAME');
$dbpass = getenv('DB_PASS') ?: getenv('RDS_PASSWORD');

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname, (int)$dbport);
if ($mysqli->connect_error) {
    error_log("DB connect error: " . $mysqli->connect_error);
    http_response_code(500);
    exit("Database connection failed");
}
$mysqli->set_charset("utf8mb4");

$conn=mysqli_connect("library-db.cfik8aewcbl1.ap-south-1.rds.amazonaws.com","admin","Admin098","library");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>
