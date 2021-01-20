<!-- James Salverda
     November 19, 2019
     Final Project
     signup page for new users -->

<?php
    require('connect.php');

    $error = "";

    if(isset($_POST['signupSubmit'])){
    
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $checkPassword = filter_input(INPUT_POST, 'passwordCheck', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(empty($username) || empty($email) || empty($password) || empty($checkPassword)){
            $error = "Input is Empty";

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = "Enter a Valid Email";

        } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            $error = "Usernames Cannot have Special Characters";

        } elseif ($password != $checkPassword){
            $error = "Passwords Do Not Match";

        } else {
            $query = "SELECT username FROM users WHERE username = :username LIMIT 1";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->execute();

            $row = $statement->fetch();
            if ($row[0] == $username){
                $error = "Username already taken";

            } else {
                $query = "INSERT INTO users (username, userEmail, password) VALUES (:username, :userEmail, :password)";

                $statement = $db->prepare($query);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':userEmail', $email);

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $statement->bindValue(':password', $hashedPassword);
                $statement->execute();

                header("Location: blog.php");
                exit();
            }
        }
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
        <form action="signup.php" method="post">
            <input type="text" name="username" placeholder="Username"><br>
            <input type="email" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="password" name="passwordCheck" placeholder="Re-Type Password"><br>
            <?=$error?><br>
            <button type="submit" name="signupSubmit">Signup!</button>
        </form>
    </div>
</body>
</html>