<?php
// header('Content-Type: application/json'); // Set response type to JSON

$host     = "localhost";
$username = "root";
$password = "";
$db_name  = "books_database";
$conn     = null;

try {
    $conn = mysqli_connect($host, $username, $password);

    if (! $conn) {
        throw new Exception("Database Connection Failed: " . mysqli_connect_error());
    }

    if (! mysqli_select_db($conn, $db_name)) {
        throw new Exception("Database Selection Failed: " . mysqli_error($conn));
    }

} catch (Exception $e) {
    echo json_encode(
        [
            'status'  => 500,
            'message' => $e->getMessage(),
        ]
    );
    exit;
}
