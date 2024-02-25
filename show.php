<?php

/*******w******** 
    
    Name: Jake Licmo
    Date: Febuary 11, 2024
    Description: show.php for Assignment 3. Displays the selected post based off its id.

****************/
require('connect.php');


if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


$query = "SELECT * FROM blog WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindParam(':id', $id);
$statement->execute();

$row = $statement->fetch();

if (!$row) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my Blog!</title>
</head>
<body>
    <header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
    </header>

    <?php include('nav.php');?>

    <main class ="containerpy-1">
        <h2><?=$row['title']?></h2>

        <small class="blog-post-date">
            Posted on
            <time datetime="<?= $row['date_posted'] ?>">
                <?= date('F d, Y, h:i A', strtotime($row['date_posted'])) ?>
            </time>
            &ensp;
            <a href="edit.php?id=<?=$row['id']?>" class="blog-post-edit">edit</a>
        </small>
        <br>

        <p class="blog-post-content">
            <?=$row['content']?>
        </p>


    <?php include('footer.php');?>
    </main>
</body>
</html>
