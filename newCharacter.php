<!-- James Salverda
     November 12, 2019
     Final Project
     Adds a New Character to the Db -->


<?php
    require 'connect.php';
    require 'authenticate.php';

    if(isset($_POST['update'])){
        $newFileName = $_POST['imgName'];
        if(empty($newFileName)){
            $newFileName = "OhNO";
        }else{
            $newFileName = strtolower(str_replace(" ", "-", $newFileName));
        }
        
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $desc = strip_tags($_POST['description'], "<sub><sup><i><u><b>");
        $file = $_FILES['file'];
        

        $fileName = $file["name"];
        $fileType = $file["type"];
        $fileTempName = $file["tmp_name"];
        $fileError = $file["error"];
        $fileSize = $file["size"];

        $fileExt = explode(".", $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array("jpg", "jpeg", "png", "gif", " ");

         if(in_array($fileActualExt, $allowed) || empty($fileType)){
            //if($fileError == 0){
                if($fileSize < 1000000){
                    $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
                    $fileDestination = "images/characters/" . $imageFullName;

                    $query = "INSERT INTO characters (name, description, imgName) VALUES (:name, :description, :imgName)";

                    $statement = $db->prepare($query);
                    $statement->bindValue(':name', $name);
                    $statement->bindValue(':description', $desc);
                    $statement->bindValue(':imgName', $imageFullName);
                    $statement->execute();

                    move_uploaded_file($fileTempName, $fileDestination);

                    header("Location: characterPage.php");
                    exit();
                }else{
                    echo "File Size is Too Big";
                }
            // }else{
            //     echo "Error";
            // }
         }else{
             echo "Incorrect File Type";
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
                new nicEditor({buttonList : ['bold','italic','underline','strikeThrough','subscript','superscript']}).panelInstance('description');
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
        <form method="post" action="newCharacter.php" enctype="multipart/form-data">
            <label for="content">Name</label><br>
            <input name="name" id="name" type="text"><br>
            <br>
            <label>Description</label><br>
            <textarea rows="25" cols="100" name="description" id="description"></textarea><br>
            <input type="file" name="file"><br>
            <label>Image Name</label><br>
            <input type="text" name="imgName">
            <button type="submit" name="update">Add</button>
        </form>
    </div>

</body>
</html>