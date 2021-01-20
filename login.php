<!-- James Salverda
     November 19, 2019
     Final Project
     Checks if the user exists and if so, logs them in -->

<?php
    require('connect.php');

    $error = "";

    if(isset($_POST['login'])){
    
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(empty($username) || empty($password)){
            $error = "Username or Password field empty";

        } else {
            $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->execute();

            

            if($row = $statement->fetch()){
                $pwdCheck = password_verify($password, $row['password']);
                if($pwdCheck == false){
                    $error = "Password is Incorrect";
                } elseif ($pwdCheck == true){
                    session_start();
                    $_SESSION['userId'] = $row['userId'];
                    $_SESSION['username'] = $row['username'];
                    $error = "login success";

                    header("Location: blog.php");
                    exit();
                } else {
                    $error = "pls halp";
                }
            } else {
                $error = "Username Inccorect or Doesn't Exist";
            }
        }
    }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CacheGrab</title>
</head>
<body>
    <?=$error?><br>
</body>
</html>