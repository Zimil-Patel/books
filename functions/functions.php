<?php
require_once __DIR__ . '/../db_connect.php';
require 'db_connect.php';

// FETCH ALL BOOKS RECORDS
function fetch_all_books()
{
    global $conn;
    $query  = 'SELECT * FROM books';
    $result = mysqli_query($conn, $query);
    $books  = [];

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($books, $row);
    }

    return $books;

}

// FETCH PARTICULAR BOOK BY ID
function fetch_one_book($id)
{
    global $conn;
    $query  = "SELECT * FROM books WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $book   = mysqli_fetch_assoc($result);
    return $book;
}

// INSERT BOOK
function insert_book($title, $author, $description, $price, $publish_date, $language, $pages)
{
    global $conn;
    $query = "INSERT INTO books(title, author, description, price, publication_date, language, pages)
            VALUES ('$title', '$author', '$description', '$price', '$publish_date', '$language', '$pages')";
    $result = mysqli_query($conn, $query);
    return $result;
}

// UPDATE BOOK RECORD BY ID
function update_book($id, $title, $author, $description, $price, $publish_date, $language, $pages)
{
    global $conn;
    $query = "UPDATE books SET title = '$title', author = '$author', description = '$description', price = '$price',
            language = '$language', pages = '$pages' WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return $result;
}

// DELETE BOOK BY ID
function delete_book($id)
{
    global $conn;
    $query  = "DELETE FROM books WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return $result;
}
