<?php

/*******w******** 
    
    Name: Jake Licmo
    Date: Febuary 11, 2024
    Description: post.php for Assignment 3. Displays the page to upload a new blogpost.

****************/

require('authenticate.php');
require('connect.php');

if ($_POST && !empty($_POST['title']) && !empty($_POST['content']))
{
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "INSERT INTO blog (title,content) values (:title, :content)";
    $statement = $db->prepare($query);

    $statement ->bindvalue(':title', $title);
    $statement ->bindvalue(':content', $content);

    if($statement->execute())
    {
        echo "Success";
    }

    header("Location: index.php?{$id}");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Blog Post!</title>
</head>
<body>
    <header class="header">
        <div class="text-center">
            <h1>My Blog</h1>
        </div>
    </header>

    <?php include('nav.php');?>

    <main class ="containerpy-1" id="create-post">
        <form action="post.php" method = "POST">
            <h2>New Post</h2>

            <div class = "form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id = "title" minlength ="1" required>
            </div>

            <div class = "form-group">
                <label for="content">Content</label>
                <textarea type="text" name="content" id = "content" cols="30" rows="10" minlength ="1" required font-family="Arial"></textarea>
            </div>

            <button type = "submit" class = "button-primary">Submit post</button>
        </form>

        <br>
    <?php include('footer.php');?>
    </main>
</body>
</html>