<!-- James Salverda
     November 5, 2019
     Final Project
     allows the authenticated user to edit a user or choose to delete it -->

     <?php
    require('connect.php');
    
    // UPDATE user if username, email and id are present in POST.
    if ($_POST && isset($_POST['username']) && isset($_POST['userEmail'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id      = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE users SET username = :username, userEmail = :userEmail WHERE userId = :userId";
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);        
        $statement->bindValue(':userEmail', $email);
        $statement->bindValue(':userId', $id, PDO::PARAM_INT);
        
        // Execute the INSERT.
        $statement->execute();
        
        // Redirect after update.
        header("Location: users.php");
        exit;
    } else if (isset($_GET['userId'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
        // Sanitize the id. Like above but this time from INPUT_GET.
        $id = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered id.
        $query = "SELECT * FROM users WHERE userId = :userId";
        $statement = $db->prepare($query);
        $statement->bindValue(':userId', $id, PDO::PARAM_INT);
        
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
        <?php if ($id): ?>

            <input type="hidden" name="id" value="<?= $quote['userId'] ?>">

            <form method="post" action="editUsers.php?userId=<?=$quote['userId']?>">
                <label for="content">Username</label><br>
                <input name="username" id="username" type="text" value="<?= $quote['username'] ?>"><br>
                <br>
                <label>Post</label><br>
                <input name="userEmail" id="userEmail" type="text" value="<?= $quote['userEmail'] ?>"><br>
                <button type="submit">Update</button> 
            </form>
            <form method="post" action="deleteUsers.php" >
                <input type="hidden" name="userId" value="<?= $quote['userId'] ?>">
                <button type="submit" name="delete">Delete</button>
            </form>
        <?php else: ?>
            <p>No quote selected. <a href="?userId=5">Try this link</a>.</p>
        <?php endif ?>
    </div>
</body>
</html>