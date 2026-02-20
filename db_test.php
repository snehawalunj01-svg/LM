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
