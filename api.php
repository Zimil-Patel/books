<?php

// error_reporting(0);
header("Content-Type: application/json");
require_once 'functions/functions.php';

$response = fetch_all_books();

echo json_encode(
    [
        'status'  => 200,
        'message' => 'Books Fetched Successfully',
        'data'    => $response,
    ]
);
