<!-- James Salverda
     November 19, 2019
     Final Project
     logs out the user once the logout button has been clicked -->

<?php
    session_start();
    session_unset();
    session_destroy();

    header("Location: blog.php");
?>