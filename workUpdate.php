<?php
session_start();
$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}

mysqli_query($con,'SET NAMES UTF8');
mysqli_select_db($con, 'project_2');
$sql = "SELECT * FROM artworks WHERE artworkID = '".$_GET['artworkID']."'";
$result = mysqli_query($con,$sql);
$work= $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" type="text/css" href="CSS/header.css" />
    <link rel="stylesheet" type="text/css" href="CSS/workPublish.css" />
    <link rel="stylesheet" type="text/css" href="CSS/footer.css" />
    <link rel="stylesheet" href="CSS/font-awesome/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="JS/header.js"></script>
    <script src="JS/update.js"></script>

    <title>Art Store</title>
</head>
<body>
<?php echo include "phpModule/Header.php"; ?>
<?php include "phpModule/FootPrint.php"?>
<div id="footPrint">
    <p><a href="Index.php">Home Page</a><?php updateFootPrint("Item Update"); showFootPrint();?></p>
</div>
<div id="headerBack"></div>

<div id="search">
    <input type="search" name="search" placeholder="Search" autocomplete="off"><a href="Search.php"><button onclick="searchBtn()">
            <i class="fa fa-search"></i></button></a>
</div>

<section id="artDetail">
    <div id="container">
        <form id="updateForm" enctype="multipart/form-data" method="post">
            <table class="detailDisplay">
                <tr>
                    <td>
                        <div class="imgContainer">
                            <img class="show" src="images/img/<?php echo $work['imageFileName']?>" alt="" id="showImg"><br>
                            <a href="javascript:void(0)" class="a-upload"><input type="file" name="workFile" id="uploadFile" class="detailInput" value="<?php echo $work['artworkID']?>">Click to upload your picture</a>
                        </div>

                    </td>
                    <td>
                        <div class="detailContainer">
                            <input type="text" name="workID" style="display: none" value="<?php echo $work['artworkID']?>">
                            <p class="workName">Title: <input type="text" name="title" class="detailInput" value="<?php echo $work['title']?>"></p>
                            <p class="artistName">Artist: <input type="text" name="artist" class="detailInput" value="<?php echo $work['artist']?>"></p>
                            <textarea class="description" name="description" placeholder="Description" class="detailInput"><?php echo $work['description']?></textarea>
                            <div class="details">
                                <p class="detail"><span>Date: </span><input class="date detailInput" name="date" value="<?php echo $work['yearOfWork']?>"><span class="warning">Integer required <i class="fa fa-exclamation" ></i></span></p>
                                <p class="detail"><span>Genre: </span><input class="genre detailInput" name="genre" value="<?php echo $work['genre']?>"></p>
                                <p class="detail"><span>Dimensions: </span><input class="dimension detailInput" name="width" value="<?php echo $work['width']?>"> × <input class="dimension detailInput" name="height" value="<?php echo $work['height']?>"> cm<span class="warning">Positive required <i class="fa fa-exclamation" ></i></span></p>
                                <p class="detail" id="workPrice"><span>Price: </span><input class="price detailInput" name="price" value="<?php echo $work['price']?>"><i class="fa fa-dollar"></i><span class="warning">Positive integer <i class="fa fa-exclamation" ></i></span></p>
                                <p id="emptyWarning">All the blanks should be filled!</p>
                            </div>
                            <div class="buttons">
                                <button name="resetButton" class="editBtn" type="reset">Reset</button>
                                <button name="publishButton" class="editBtn" type="button" id="publishBtn">Update</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</section>

<?php echo include "phpModule/Footer.php"; ?>
</body>
</html>