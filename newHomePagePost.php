<!-- James Salverda
     November 5, 2019
     Final Project
     allows an authorized user to create a new update. prompts user to sign in if not previously signed in-->

<?php
    require 'connect.php';
    require 'authenticate.php';
    
    if(isset($_POST['title']) && isset($_POST['content'])){
        $content = strip_tags($_POST['content'], "<sub><sup><i><u><b>");
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (strlen($_POST['title']) > 0 && strlen($_POST['content']) > 0) {
            $query = "INSERT INTO homepage (title, content) VALUES (:title, :content)";

            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->execute();
            header("Location: homePage.php");
            exit();
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CacheGrab</title>
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
        <div id="searchBar">
            <form action="searchHomePage.php" method="post">
                <input type="text" name="search" placeholder="Search for Updates...">
                <input type="submit" value="Go">
            </form>
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
        <form method="post" action="newHomePagePost.php">
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