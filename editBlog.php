<!-- James Salverda
     November 5, 2019
     Final Project
     allows the signed in  user to edit a post or choose to delete it -->

<?php
    require('connect.php');
    session_start();
    
    // UPDATE quote if title, content and id are present in POST.
    if ($_POST && isset($_POST['title']) && isset($_POST['content'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = strip_tags($_POST['content'], "<sub><sup><i><u><b>");
        $id      = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE blog SET title = :title, content = :content, createdBy = :createdBy WHERE postID = :postID";
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);        
        $statement->bindValue(':content', $content);
        $statement->bindValue(':createdBy', $_SESSION['username']);
        $statement->bindValue(':postID', $id, PDO::PARAM_INT);
        
        // Execute the INSERT.
        $statement->execute();
        
        // Redirect after update.
        header("Location: blog.php");
        exit;
    } else if (isset($_GET['postID'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
        // Sanitize the id. Like above but this time from INPUT_GET.
        $id = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered id.
        $query = "SELECT * FROM blog WHERE postID = :postID";
        $statement = $db->prepare($query);
        $statement->bindValue(':postID', $id, PDO::PARAM_INT);
        
        // Execute the SELECT and fetch the single row returned.
        $statement->execute();
        $quote = $statement->fetch();
    } else {
        $id = false; // False if we are not UPDATING or SELECTING.
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
        <?php if ($id): ?>

            <input type="hidden" name="id" value="<?= $quote['postID'] ?>">

            <form method="post" action="editBlog.php?postID=<?=$quote['postID']?>">
                <label for="content">Title</label><br>
                <input name="title" id="title" type="text" value="<?= $quote['title'] ?>"><br>
                <br>
                <label>Post</label><br>
                <textarea rows="25" cols="100" name="content" id="content"><?= $quote['content'] ?></textarea><br>
                <button type="submit">Update</button> 
            </form>
            <form method="post" action="blogDelete.php" >
                <input type="hidden" name="postID" value="<?= $quote['postID'] ?>">
                <button type="submit" name="delete">Delete</button>
            </form>
        <?php else: ?>
            <p>No quote selected. <a href="?postID=10">Try this link</a>.</p>
        <?php endif ?>
    </div>
</body>
</html>