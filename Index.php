<?php
session_start();
$DB_HOST="localhost";
$DB_USER="root";
$DB_PASS="";

$con = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS);

if(!$con){
    die("Could not connect ".mysqli_connect_error());
}

$_SESSION["footPrint"]=array();

mysqli_query($con,'SET NAMES UTF8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <link rel="stylesheet" type="text/css" href="CSS/header.css" />
    <link rel="stylesheet" type="text/css" href="CSS/gallery.css" />
    <link rel="stylesheet" type="text/css" href="CSS/rankingList.css" />
    <link rel="stylesheet" type="text/css" href="CSS/footer.css" />
    <link rel="stylesheet" href="CSS/font-awesome/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="JS/header.js"></script>
    <script src="JS/index.js"></script>

    <title>Art Store</title>
</head>
<body>
    <?php echo include "phpModule/Header.php" ?>

    <div id="search">
        <input type="search" name="search" placeholder="Search" autocomplete="off"><a href="Search.php"><button onclick="searchBtn()">
                <i class="fa fa-search"></i></button></a>
    </div>

    <div id="gallery">
            <ul id="carousel">
                <?php
                mysqli_select_db($con, 'project_2');
                $sql = "SELECT artworkID,title,artist,description,imageFileName FROM artworks WHERE orderID is NULL ORDER BY view DESC LIMIT 4";
                $result = mysqli_query($con,$sql);
                echo '<script>var gWorks = [];</script>';
                while($row = $result->fetch_assoc()){
                    echo '<li><div class="galleryImage"><div class="detail" style="background-image: url(images/img/'.$row['imageFileName'].')">';
                    echo '<div class = gWork>'.$row['title'].'</div>';
                    echo '<div class = gArtist>'.$row['artist'].'</div>';
                    if(strlen($row['description'])>250){
                        $subDescription = substr($row['description'],0,250)."...";
                        echo '<div class="gIntro">'.$subDescription.'</div>';
                    }
                    else
                        echo '<div class="gIntro">'.$row['description'].'</div></div></div></li>';
                    echo '<script>gWorks.push('.$row['artworkID'].');</script>';
                }
                ?>
            </ul>
            <p class="left arrow"><i class="fa fa-angle-left" onclick="changeImgMinus()"></i></p>
            <p class="right arrow"><i class="fa fa-angle-right" onclick="changeImgPlus()"></i></p>
            <div class="trig">
                <span class="fa fa-check-circle-o" id="firstDot" onclick="changeByDot(1)"></span>
                <span class="fa fa-circle" id="secondDot" onclick="changeByDot(2)"></span>
                <span class="fa fa-circle" id="thirdDot" onclick="changeByDot(3)"></span>
                <span class="fa fa-circle" id="forthDot" onclick="changeByDot(4)"></span>
            </div>
            <a href="ArtDemo.php" id="demoUrl"> <div id="learnMore">Learn more</div></a>
        </div>

    <div id="rankingList">
        <a href="#"><div class="hotLabel-popularWorks">Popular works</div></a>
        <div class="hot Works">
                <ul class="rankingBlocks">
                    <?php
                    $sql = "SELECT artworkID,title,artist,description,imageFileName FROM artworks WHERE orderID is NULL ORDER BY view DESC LIMIT 4,3";
                    $result = mysqli_query($con,$sql);

                    while($row = $result->fetch_assoc()){
                        echo '<li><a href="ArtDemo.php?workID='.$row['artworkID'].'"><div class="block">';
                        echo '<div class="work" style="background-image: url(images/img/'.$row['imageFileName'].')"></div>';
                        echo '<div class="workName">'.$row['title'].'</div>';
                        echo '<div class="workArtist">'.$row['artist'].'</div>';
                        if(strlen($row['description'])>100){
                            $subDescription = substr($row['description'],0,100)."...";
                            echo '<div class="workIntro">'.$subDescription.'</div>';
                        }
                        else
                            echo '<div class="workIntro">'.$row['description'].'</div>';
                        echo '</div></a></li>';
                        }
                        ?>
                </ul>
            </div>
        <a href="#"><div class="hotLabel-newWorks">Newest works</div></a>
        <div class="hot Newest">
                <ul class="rankingBlocks">
                    <?php
                    $sql = "SELECT artworkID,title,artist,description,imageFileName FROM artworks WHERE orderID is NULL ORDER BY timeReleased DESC LIMIT 3";
                    $result = mysqli_query($con,$sql);

                    while($row = $result->fetch_assoc()){
                        echo '<li><a href="ArtDemo.php?workID='.$row['artworkID'].'"><div class="block">';
                        echo '<div class="newWork" style="background-image: url(images/img/'.$row['imageFileName'].')"></div>';
                        echo '<div class="newName">'.$row['title'].'</div>';
                        echo '<div class="newArtist">'.$row['artist'].'</div>';
                        if(strlen($row['description'])>100){
                            $subDescription = substr($row['description'],0,100)."...";
                            echo '<div class="workIntro">'.$subDescription.'</div>';
                        }
                        else
                            echo '<div class="workIntro">'.$row['description'].'</div>';
                        echo '</div></a></li>';
                    }
                    ?>
                </ul>
            </div>
    </div>

    <?php echo include "phpModule/Footer.php"; ?>
</body>
</html>

