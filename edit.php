<?php

/*******w******** 
    
    Name: Jake Licmo
    Date: Febuary 11, 2024
    Description: edit.php for Assignment 3. Displays the edit page with Update and Delete controls.

****************/

require('connect.php');
require('authenticate.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM blog WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(':id', $id);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);


// Delete Post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $query = "DELETE FROM blog WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);

    if ($statement->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting record";
    }
}

// Edit Post
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update']) && !empty($_POST['title']) && !empty($_POST['content'])) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "UPDATE blog SET title = :title, content = :content WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id);

    if ($statement->execute()) {
        header("Location: index.php?id={$id}");
        exit;
    } else {
        echo "Error updating record";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Edit this Post!</title>
</head>
<body>
    <header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
    </header>

    <?php include('nav.php');?>

    <main class = "containerpy-1">
        <form action="edit.php?id=<?= $row['id'] ?>" method="POST">
            <h2>Edit Post</h2>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" minlength="1" required value="<?= $row['title'] ?>">
            </div>
            <br>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea type="text" name="content" id="content" cols="30" rows="10" minlength="1" required font-family="Arial"><?= $row['content'] ?></textarea>
            </div>

            <button type="submit" class="button-primary" name="update">Update post</button>
        </form>
        <br>

        <form action="edit.php?id=<?= $row['id'] ?>" method="POST">
            <button type="submit" class="button-delete" name="delete" onclick="return confirm('Are you sure you want to delete this post?')">Delete post</button>
        </form>
        <br>

        <?php include('footer.php');?>
    </main>
</body>
</html>