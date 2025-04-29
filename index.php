<?php
    require_once 'functions/functions.php';

    // Handle book insertion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title            = $_POST['title'];
        $author           = $_POST['author'];
        $description      = $_POST['description'];
        $price            = $_POST['price'];
        $publication_date = $_POST['publication_date'];
        $language         = $_POST['language'];
        $pages            = $_POST['pages'];

        insert_book($title, $author, $description, $price, $publication_date, $language, $pages);
    }

    $books = fetch_all_books();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Book Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        .card {
            background-color: #1e1e1e;
        }
        .form-control, .form-select {
            background-color: #2c2c2c;
            color: #ffffff;
            border: 1px solid #444;
        }
        .table-dark th, .table-dark td {
            vertical-align: middle;
        }
    </style>
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4 text-center">📚 Book Manager</h2>

    <!-- Book Form -->
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <h5 class="card-title">Add a New Book</h5>
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input required name="title" class="form-control" placeholder="Title">
                    </div>
                    <div class="col-md-6">
                        <input required name="author" class="form-control" placeholder="Author">
                    </div>
                    <div class="col-md-12">
                        <textarea required name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="col-md-4">
                        <input required name="price" type="number" step="0.01" class="form-control" placeholder="Price">
                    </div>
                    <div class="col-md-4">
                        <input required name="publication_date" type="date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input required name="language" class="form-control" placeholder="Language">
                    </div>
                    <div class="col-md-2">
                        <input required name="pages" type="number" class="form-control" placeholder="Pages">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success w-100">Add Book</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Book Table -->
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">All Books</h5>
            <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Price</th>
                            <th>Pages</th>
                            <th>Language</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo $book['id']?></td>
                                <td><?php echo htmlspecialchars($book['title'])?></td>
                                <td><?php echo htmlspecialchars($book['author'])?></td>
                                <td>$<?php echo $book['price']?></td>
                                <td><?php echo $book['pages']?></td>
                                <td><?php echo htmlspecialchars($book['language'])?></td>
                                <td><?php echo $book['publication_date']?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
