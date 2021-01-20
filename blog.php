<!-- James Salverda
     November 19, 2019
     Final Project
     Shows postings made by signed in users -->

<?php
    require('connect.php');

    $query = "SELECT * FROM blog ORDER BY postID DESC";

    $statement = $db->prepare($query);

    $statement->execute(); 

    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CacheGrab</title>
    <link rel="stylesheet" type="text/css" href="finalcss.css" />
</head>
<body>

    <header>
        <div id="signUpTitle">
            <div id="SuperTitle">
                <h1>Super Powered Battle Friends</h1>
            </div>
            
            <div id="loginBar">
                <?php
                    if(isset($_SESSION['username'])){
                        echo "<p>You Are Logged In</p>";
                    }
                ?>
            </div>
            <div id="logoutBar">
                <?php
                    if(isset($_SESSION['username'])){
                        echo '<form action="logout.php">
                                <button>Logout</button>
                            </form>';
                    } else {
                        echo '<form action="login.php" method="post">
                                <input type="text" name="username" placeholder="Username...">
                                <input type="password" name="password" placeholder="Password...">
                                <button type="submit" name="login">Login</button>  
                            </form>
                            <form action="signup.php">
                                <button>Signup</button>
                            </form>';
                    }
                ?>
            </div>
        </div>
        <nav>
            <a href="homePage.php">Home</a>
            <a href="characterPage.php">Characters</a>
            <a href="stagePage.php">Stages</a>
            <a href="aboutUsPage.php">About Us</a>
            <a href="blog.php">Blog</a>
        </nav>
    </header>

    <div id="update">
        <?php
            if(isset($_SESSION['username'])){
                echo '<form action="newBlogPost.php">
                        <button >Add an Update</button>
                    </form>';
            }
        ?>
   </div>

    
    <?php while ($row = $statement->fetch()): ?>
        <div id="updates">
            <h3><a href="fullBlogPost.php?postID=<?=$row['postID']?>"><?= $row['title'] ?></a></h3><p><?= $row['createdBy']?></p>         
            <?php if(isset($_SESSION['username'])) : ?>
                <a href="editBlog.php?postID=<?=$row['postID']?>">Edit</a>
            <?php endif ?>
        </div>
    <?php endwhile ?>
    
    
</body>
<footer>
    <a href="users.php">Users</a>
</footer>
</html>