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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" type="text/css" href="CSS/header.css" />
    <link rel="stylesheet" type="text/css" href="CSS/artDemo.css" />
    <link rel="stylesheet" type="text/css" href="CSS/footer.css" />
    <link rel="stylesheet" href="CSS/font-awesome/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="JS/header.js"></script>
    <script src="JS/artDemo.js"></script>

    <title>Art Store</title>
</head>
<body>
    <?php echo include "phpModule/Header.php"; ?>
    <?php include "phpModule/FootPrint.php"?>
    <div id="footPrint">
        <p><a href="Index.php">Home Page</a><?php updateFootPrint("Item Detail"); showFootPrint();?></p>
    </div>
    <div id="headerBack"></div>

    <div id="search">
        <input type="search" name="search" placeholder="Search" autocomplete="off"><a href="Search.php"><button onclick="searchBtn()">
                <i class="fa fa-search"></i></button></a>
    </div>

    <?php
    mysqli_select_db($con, 'project_2');
    $sql = "SELECT * FROM artworks WHERE artworkID = ".$_GET['workID'];
    $result = mysqli_query($con,$sql);
    $row = $result->fetch_assoc();

    $view = $row['view']+1;
    $sql = "UPDATE artworks SET view = '".$view."' WHERE artworkID = ".$_GET['workID'];
    mysqli_query($con,$sql);

    echo '<script>var artworkID = '.$_GET['workID'].'</script>';
    ?>

    <section id="artDetail">
        <div id="container">
            <table class="detailDisplay">
                <tr>
                    <td>
                        <div class="imgContainer">
                            <img class="show" src="<?php echo 'images/img/'.$row['imageFileName']?>">
                        </div>
                    </td>
                    <td>
                        <div class="detailContainer">
                            <p class="workName"><?php echo $row['title']?></p>
                            <p class="artistName">By <a href="Search.php<?php echo '?key='.$row['artist'].'&choose=artist'?>" class="findArtist"><?php echo $row['artist']?></a><span class="hotPoint"><i class="fa fa-eye" ></i>&nbsp;<?php echo $view ?></span></p>
                            <p class="description"><?php echo $row['description']?></p>

                            <div class="buttons">
                                <button name="favoriteButton" class="noAdded" onclick="addFavChange(this)"><i class="fa fa-star" ></i>&nbsp;Add to my favorites</button>
                                <button name="shoppingCartButton" class="noAdded"><i class="fa fa-shopping-cart" ></i>&nbsp;Add to shopping cart</button>
                            </div>

                            <div class="details">
                                <p class="detail"><span>Date: </span><span class="content"><?php echo $row['yearOfWork']?></span></p>
                                <p class="detail"><span>Genre: </span><span class="content"><?php echo $row['genre']?></span></p>
                                <p class="detail"><span>Dimensions: </span><span class="content"><?php echo $row['width']?> × <?php echo $row['height']?> cm</span></p>
                                <p class="detail" id="workPrice"><span>Price: </span><span class="content"><i class="fa fa-dollar"></i><?php echo $row['price']?></span></p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </section>

    <?php echo include "phpModule/Footer.php"; ?>
</body>
</html>