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
    <link rel="stylesheet" type="text/css" href="CSS/search.css" />
    <link rel="stylesheet" type="text/css" href="CSS/footer.css" />
    <link rel="stylesheet" href="CSS/font-awesome/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="JS/header.js"></script>
    <script src="JS/search.js"></script>

    <title>Art Store</title>
</head>
<body>
    <?php echo include "phpModule/Header.php"; ?>
    <?php include "phpModule/FootPrint.php"?>
    <div id="footPrint">
        <p><a href="Index.php">Home Page</a><?php updateFootPrint("Search"); showFootPrint();?></p>
    </div>
    <div id="headerBack"></div>

    <div id="searchHome">
        <div class="searchInput">
            <div class="searchType" onclick="showList(this)">
                <span class="default" id="keyType">Work Name</span>
                <i class="fa fa-angle-down"></i>
            </div>
            <ul class="typeList">
                <li onclick="changeType(this)">Work Name</li>
                <li onclick="changeType(this)">Artist</li>
                <li onclick="changeType(this)">Intro</li>
                <li onclick="changeType(this)">All</li>
            </ul>
            <input class="keyWords" type="text" placeholder="Find what you want !" id="searchInput" <?php if(isset($_GET['key']))echo 'value="'.$_GET['key'].'"'?>>
            <button class="searchBtn">Search</button>
        </div>
        <div class="container">
            <p id="sortType">
                Sort By :
                <label for="sortByPrice"><input id="sortByPrice" type="radio" name="sortBy" value="price" checked>Price</label>
                <label for="sortByHot"><input id="sortByHot" type="radio" name="sortBy" value="view">Popularity</label>
            </p>
            <a href="" class="item"><div class="resultBlock">
                    <img class="image" src="">
                    <p class="name"></p>
                    <p class="artist"></p>
                    <p class="hotPoint"><i class="fa fa-eye" ></i>&nbsp;<span class="viewed"></span><span class="price"></span></p>
                    <p class="description"></p>
                </div></a>
            <a href="" class="item"><div class="resultBlock">
                    <img class="image" src="">
                    <p class="name"></p>
                    <p class="artist"></p>
                    <p class="hotPoint"><i class="fa fa-eye" ></i>&nbsp;<span class="viewed"></span><span class="price"></span></p>
                    <p class="description"></p>
                </div></a>
            <a href="" class="item"><div class="resultBlock">
                    <img class="image" src="">
                    <p class="name"></p>
                    <p class="artist"></p>
                    <p class="hotPoint"><i class="fa fa-eye" ></i>&nbsp;<span class="viewed"></span><span class="price"></span></p>
                    <p class="description"></p>
                </div></a>
            <a href="" class="item"><div class="resultBlock">
                    <img class="image" src="">
                    <p class="name"></p>
                    <p class="artist"></p>
                    <p class="hotPoint"><i class="fa fa-eye" ></i>&nbsp;<span class="viewed"></span><span class="price"></span></p>
                    <p class="description"></p>
                </div></a>
            <a href="" class="item"><div class="resultBlock">
                    <img class="image" src="">
                    <p class="name"></p>
                    <p class="artist"></p>
                    <p class="hotPoint"><i class="fa fa-eye" ></i>&nbsp;<span class="viewed"></span><span class="price"></span></p>
                    <p class="description"></p>
                </div></a>
            <a href="" class="item"><div class="resultBlock">
                    <img class="image" src="">
                    <p class="name"></p>
                    <p class="artist"></p>
                    <p class="hotPoint"><i class="fa fa-eye" ></i>&nbsp;<span class="viewed"></span><span class="price"></span></p>
                    <p class="description"></p>
                </div></a>
        </div>

        <p id="paging">
            <button class="pageNum pageChosen" onclick="changePage(this)">1</button><button
                class="pageNum" onclick="changePage(this)">2</button><button
                class="pageNum" onclick="changePage(this)">3</button><button
                class="pageNum" onclick="changePage(this)">4</button><button
                class="pageNum" onclick="changePage(this)">5</button><button
                class="pageNum" onclick="changePage(this)">6</button><button
                class="pageNum" onclick="changePage(this)">7</button>
        </p>
    </div>

    <?php echo include "phpModule/Footer.php"; ?>
    <?php if(isset($_GET['choose']))echo '<script>var obj=document.getElementsByClassName("typeList")[0].getElementsByTagName("li")[2];changeType(obj)</script>'?>
</body>
</html>