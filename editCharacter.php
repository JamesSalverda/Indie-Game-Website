<!-- James Salverda
     November 12, 2019
     Final Project
     allows the authorized user to edit a character or choose to delete it. prompts user to sign in -->

<?php
    require('connect.php');
    require('authenticate.php');
    
    if(isset($_POST['submit'])){
        $newFileName = $_POST['imgName'];
        if(empty($newFileName)){
            $newFileName = "OhNO";
        }else{
            $newFileName = strtolower(str_replace(" ", "-", $newFileName));
        }    
        // UPDATE quote if name, description and id are present in POST.
        if ($_POST && isset($_POST['name']) && isset($_POST['description'])) {
            // Sanitize user input to escape HTML entities and filter out dangerous characters.
            $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = strip_tags($_POST['description'], "<sub><sup><i><u><b>");
            $id      = filter_input(INPUT_GET, 'characterId', FILTER_SANITIZE_NUMBER_INT);
            $imgName = filter_input(INPUT_POST, 'imgName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
                        if($fileSize > 0){
                            $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
                        }else{
                            $imgQuery = "SELECT imgName FROM characters WHERE characterid = :characterId";
                            $imgStatement = $db->prepare($imgQuery);
                            $imgStatement->bindValue(':characterId', $id, PDO::PARAM_INT);
                            $imgStatement->execute();
                            $imgQuote = $imgStatement->fetch();
                            $imageFullName = $imgQuote['imgName'];
                        }
                        
                        $fileDestination = "images/characters/" . $imageFullName;

                        $query     = "UPDATE characters SET name = :name, description = :description, imgName = :imgName WHERE characterId = :characterId";

                        $statement = $db->prepare($query);
                        $statement->bindValue(':name', $name);
                        $statement->bindValue(':description', $description);
                        $statement->bindValue(':imgName', $imageFullName);
                        $statement->bindValue(':characterId', $id, PDO::PARAM_INT);
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
    } else if (isset($_GET['characterId'])) { // Retrieve quote to be edited, if id GET parameter is in URL.
        // Sanitize the id. Like above but this time from INPUT_GET.
        $id = filter_input(INPUT_GET, 'characterId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parametrized SQL query using the filtered id.
        $query = "SELECT * FROM characters WHERE characterId = :characterId";
        $statement = $db->prepare($query);
        $statement->bindValue(':characterId', $id, PDO::PARAM_INT);
        
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
        <?php if ($id): ?>

            <input type="hidden" name="id" value="<?= $quote['characterId'] ?>">

            <form method="post" action="editCharacter.php?characterId=<?=$quote['characterId']?>" enctype="multipart/form-data">
                <label for="content">Name</label><br>
                <input name="name" id="name" type="text" value="<?= $quote['name'] ?>"><br>
                <br>
                <label>Description</label><br>
                <textarea rows="25" cols="100" name="description" id="description"><?= $quote['description'] ?></textarea><br>
                <input type="file" name="file"><br>
                <label>Image Name</label><br>
                <input type="text" name="imgName" value="<?= $quote['imgName'] ?>"><br>
                <button type="submit" name="submit">Update</button> 
            </form>
            <?php if(substr($quote['imgName'], 0, 4) != "OhNO"): ?>
                <form method="post" action="deleteImage.php">
                    <input type="hidden" name="characterId" value="<?= $quote['characterId'] ?>">
                    <button type="submit" name="deleteImage">Delete Image</button>
                </form> 
            <?php endif ?>
            <form method="post" action="deleteCharacter.php" >
                <input type="hidden" name="characterId" value="<?= $quote['characterId'] ?>">
                <button type="submit" name="delete">Delete</button>
            </form>
        <?php else: ?>
            <p>No quote selected. <a href="?characterId=10">Try this link</a>.</p>
        <?php endif ?>
    </div>
</body>
</html>