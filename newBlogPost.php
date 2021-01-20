<!-- James Salverda
     November 5, 2019
     Final Project
     allows an signed in user to create a new post. -->

<?php
    require 'connect.php';
    
    session_start();

    if(isset($_POST['title']) && isset($_POST['content'])){
        $content = strip_tags($_POST['content'], "<sub><sup><i><u><b>");
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (strlen($_POST['title']) > 0 && strlen($_POST['content']) > 0) {
            $query = "INSERT INTO blog (title, content, createdBy) VALUES (:title, :content, :createdBy)";

            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':createdBy', $_SESSION['username']);
            $statement->execute();
            header("Location: blog.php");
            exit();
        }
    }

    
   

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CacheGrab</title>
    <link rel="stylesheet" type="text/css" href="finalcss.css" />
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() {
                new nicEditor({buttonList : ['bold','italic','underline','strikeThrough','subscript','superscript']}).panelInstance('content');
        });
        //]]>
    </script>
</head>
<body>

    <header>
        <div id="SuperTitle">
            <h1>Super Powered Battle Friends</h1>
        </div>
        <nav>
            <a href="homePage.php">Home</a>
            <a href="characterPage.php">Characters</a>
            <a href="stagePage.php">Stages</a>
            <a href="aboutUsPage.php">About Us</a>
            <a href="blog.php">Blog</a>
        </nav>
    </header>

    <div id="New">
        <form method="post" action="newBlogPost.php">
            <label for="content">Title</label><br>
            <input name="title" id="title" type="text"><br>
            <br>
            <label>Post</label><br>
            <textarea rows="25" cols="100" name="content" id="content"></textarea><br>
            <button type="submit">Add</button>
        </form>
    </div>

</body>
</html>