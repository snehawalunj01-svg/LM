<?php
// db_test.php - quick DB connectivity test
require 'include/dbcon.php';
header('Content-Type: text/plain; charset=utf-8');
if (!isset($mysqli)) {
    echo "No DB connection object available\n";
    exit(1);
}
$res = $mysqli->query("SELECT VERSION() AS v");
if ($res && $row = $res->fetch_assoc()) {
    echo "DB version: " . $row['v'] . "\n";
} else {
    echo "DB test failed: " . $mysqli->error . "\n";
}
<?php
// Simple DB connectivity test — deploy this and open /db_test.php in the browser
require __DIR__ . '/include/dbcon.php';
header('Content-Type: text/plain');
if (isset($mysqli) && $mysqli instanceof mysqli) {
    if ($mysqli->ping()) {
        echo "DB OK\n";
    } else {
        echo "DB ERROR: " . $mysqli->connect_error . "\n";
    }
} else {
    echo "DB ERROR: mysqli object not available\n";
}
