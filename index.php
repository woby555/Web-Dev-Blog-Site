<?php

/*******w******** 
    
    Name: Jake Licmo
    Date: Febuary 11, 2024
    Description: index.php for Assignment 3. Displays all blog posts.

****************/

require('connect.php');

$query = "SELECT * FROM blog ORDER BY date_posted DESC LIMIT 5";

$statement = $db->prepare($query);

$statement -> execute();
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
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
    </header>

    <?php include('nav.php');?>

    <main class ="containerpy-1">
        <h2>Recently posted blog entries</h2>

        <?php if ($statement->rowcount() == 0) :?>
                <div class="text-center py-1">
                    <p>No blog entries yet!</p>
                </div>
        <?php exit; endif;?>

        <?php while($row = $statement->fetch()): ?>
            <h3 class = "blog-post-title">
                <a href="show.php?id=<?=$row['id']?>"><?=$row['title']?></a>
            </h3>

            <small class = "blog-post-date">
                Posted on
                <time datetime="<?= $row['date_posted'] ?>">
                    <?= date('F d, Y, h:i A', strtotime($row['date_posted'])) ?>
                </time>
                &ensp;
                <a href="edit.php?id=<?=$row['id']?>" class="blog-post-edit">edit</a>
            </small>
            <br>

            <p class="blog-post-content">
                <?php if(strlen($row['content']) > 200) :?>
                    <?=substr($row['content'], 0 , 200)?>... <a href="show.php?id=<?=$row['id']?>">Read more</a>
                <?php else: ?>
                    <?=$row['content']?>
                <?php endif?>
            </p>

        <?php endwhile;?>

        <?php include('footer.php');?>

    </main>
</body>
</html>