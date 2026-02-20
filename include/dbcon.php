<?php 
// server, user, password, database, port
$con = mysqli_connect("library-db.cfik8aewcbl1.ap-south-1.rds.amazonaws.com","admin","Admin098","library-db");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
