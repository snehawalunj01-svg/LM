<?php
$dbhost = getenv('DB_HOST') ?: getenv('RDS_HOSTNAME');
$dbport = getenv('DB_PORT') ?: getenv('RDS_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: getenv('RDS_DB_NAME');
$dbuser = getenv('DB_USER') ?: getenv('RDS_USERNAME');
$dbpass = getenv('DB_PASS') ?: getenv('RDS_PASSWORD');

$mysqli = @new mysqli($dbhost, $dbuser, $dbpass, $dbname, (int)$dbport);
if ($mysqli && !$mysqli->connect_error) {
    echo "DB OK";
} else {
    echo "DB ERROR: " . ($mysqli ? $mysqli->connect_error : 'unable to construct mysqli');
}