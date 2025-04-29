<?php
    session_start();
    require_once 'functions/functions.php';

    // Set the initial values for the book form
    $edit_data = [
        'id'               => '',
        'title'            => '',
        'author'           => '',
        'description'      => '',
        'price'            => '',
        'publication_date' => '',
        'language'         => '',
        'pages'            => '',
    ];
    $edit_mode = false;

    // Add record on submit button press
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_button"])) {
        // Your existing add code...
        $title            = $_POST["title"];
        $author           = $_POST["author"];
        $description      = $_POST["description"];
        $price            = $_POST["price"];
        $publication_date = $_POST["publication_date"];
        $language         = $_POST["language"];
        $pages            = $_POST["pages"];

        if (empty($title)) {
            $_SESSION["error"] = "Please enter the Book Title";
        } elseif (empty($author)) {
            $_SESSION["error"] = "Please enter the Author Name";
        } elseif (empty($description)) {
            $_SESSION["error"] = "Please enter the Book Description";
        } elseif (empty($price)) {
            $_SESSION["error"] = "Please enter the Price";
        } elseif (empty($publication_date)) {
            $_SESSION["error"] = "Please enter the Publish Date";
        } elseif (empty($language)) {
            $_SESSION["error"] = "Please enter the Language";
        } elseif (empty($pages)) {
            $_SESSION["error"] = "Please enter the Pages";
        } else {
            $result = insert_book($title, $author, $description, $price, $publication_date, $language, $pages);
            if ($result) {
                $_SESSION["success"] = "Book added successfully";
            } else {
                $_SESSION["error"] = "Failed to insert Book";
            }
        }

        // Redirect to the same page to avoid resubmission alert
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    // Update record method (for editing the book)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_button"])) {
        // Get the form values to update the book
        $id               = $_POST["id"];
        $title            = $_POST["title"];
        $author           = $_POST["author"];
        $description      = $_POST["description"];
        $price            = $_POST["price"];
        $publication_date = $_POST["publication_date"];
        $language         = $_POST["language"];
        $pages            = $_POST["pages"];

        // Call your update function (you need to implement `update_book` function)
        $result = update_book($id, $title, $author, $description, $price, $publication_date, $language, $pages);

        if ($result) {
            $_SESSION["success"] = "Book updated successfully";
        } else {
            $_SESSION["error"] = "Failed to update Book";
        }

        // Redirect to the same page to avoid resubmission alert
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    // Delete record method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete_button'])) {
        $id = $_POST["id"];

        $result = delete_book($id);
        if ($result) {
            $_SESSION["success"] = "Book deleted successfully";
        } else {
            $_SESSION["error"] = "Failed to delete Book";
        }

        // Redirect to the same page to avoid resubmission alert
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }

    // Edit record method (fetch data for editing)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_button"])) {
        $edit_mode = true;
        $id        = $_POST["id"];

        $book = fetch_one_book($id);
        if ($book) {
            $edit_data = $book;
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: white;
        }
        .table th, .table td {
            color: white;
        }
        .table-dark {
            background-color: #1e1e1e;
        }
        .alert {
            margin-bottom: 20px;
        }
        .form-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .table th, .table td {
            padding-left: 20px;
            padding-right: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION["error"]; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php unset($_SESSION["error"]);endif; ?>

    <?php if (isset($_SESSION["success"])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION["success"]; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php unset($_SESSION["success"]);endif; ?>

    <h2 class="mb-4" style="color:white">
        <?php echo $edit_mode ? 'Edit Book Record' : 'Add New Book'; ?>
    </h2>

    <!-- Form Container -->
    <div class="form-container">
    <form class="row g-3" method="post">
        <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">

        <!-- Book Title -->
        <div class="col-md-4">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="title" placeholder="Book Title" name="title" value="<?php echo $edit_data['title']; ?>" required>
        </div>

        <!-- Author -->
        <div class="col-md-4">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" placeholder="Author" name="author" value="<?php echo $edit_data['author']; ?>" required>
        </div>

        <!-- Description -->
        <div class="col-md-4">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" placeholder="Description" name="description" value="<?php echo $edit_data['description']; ?>" required>
        </div>

        <!-- Price -->
        <div class="col-md-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" placeholder="Price" name="price" value="<?php echo $edit_data['price']; ?>" required>
        </div>

        <!-- Publish Date -->
        <div class="col-md-3">
            <label for="publication_date" class="form-label">Publish Date</label>
            <input type="date" class="form-control" id="publication_date" placeholder="Publication Date" name="publication_date" value="<?php echo $edit_data['publication_date']; ?>" required>
        </div>

        <!-- Language -->
        <div class="col-md-3">
            <label for="language" class="form-label">Language</label>
            <input type="text" class="form-control" id="language" placeholder="Language" name="language" value="<?php echo $edit_data['language']; ?>" required>
        </div>

        <!-- Pages -->
        <div class="col-md-3">
            <label for="pages" class="form-label">Pages</label>
            <input type="number" class="form-control" id="pages" placeholder="Pages" name="pages" value="<?php echo $edit_data['pages']; ?>" required>
        </div>

        <!-- Submit Button -->
        <div class="col-md-12 mt-5">
            <button type="submit" class="btn btn-<?php echo $edit_mode ? 'success' : 'primary'; ?> w-100" name="<?php echo $edit_mode ? 'update_button' : 'add_button'; ?>">
                <?php echo $edit_mode ? 'Update' : 'Add Book'; ?>
            </button>
        </div>
        </form>
    </div>


    <hr class="my-4" style="color:white">

    <h3 class="mb-3 mt-5 text-start" style="color:white">Books Records</h3>
    <table class="table text-center table-borderless table-sm">
        <thead>
            <tr class="table-dark table-active">
                <th class="pt-3 pb-3" style="border-top-left-radius: 10px;">ID</th>
                <th class="pt-3 pb-3">Title</th>
                <th class="pt-3 pb-3">Author</th>
                <th class="pt-3 pb-3">Price</th>
                <th class="pt-3 pb-3">Language</th>
                <th class="pt-3 pb-3">Publication Date</th> <!-- Added column -->
                <th class="pt-3 pb-3">Pages</th> <!-- Added column -->
                <th class="pt-3 pb-3" style="border-top-right-radius: 10px;">Actions</th>
            </tr>
        </thead>
        <tbody class="table-dark">
        <?php
            $books = fetch_all_books(); // Fetch all books from the database
            foreach ($books as $book):
        ?>
            <tr>
                <td class="py-3"><?php echo $book['id']; ?></td>
                <td class="py-3"><?php echo $book['title']; ?></td>
                <td class="py-3"><?php echo $book['author']; ?></td>
                <td class="py-3"><?php echo $book['price']; ?></td>
                <td class="py-3"><?php echo $book['language']; ?></td>
                <td class="py-3"><?php echo $book['publication_date']; ?></td> <!-- Added value -->
                <td class="py-3"><?php echo $book['pages']; ?></td> <!-- Added value -->
                <td class="py-3">
                    <div class="d-flex justify-content-center gap-2">
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                            <button class="btn btn-sm btn-warning ps-4 pe-4" name="edit_button">Edit</button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                            <button class="btn btn-sm btn-danger ps-3 pe-3" name="delete_button">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
