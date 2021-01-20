<!-- James Salverda
     November 5, 2019
     Final Project
     prompts user for username and password when they want to edit or create a post -->

<?php


  define('ADMIN_LOGIN','cachegrab');

  define('ADMIN_PASSWORD','lunasux');


  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])

      || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)

      || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {

    header('HTTP/1.1 401 Unauthorized');

    header('WWW-Authenticate: Basic realm="CacheGrab"');

    exit("Access Denied: Username and password required.");

  }

   

?>