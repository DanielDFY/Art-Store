<footer>
    <div id="followMe">
        <p class="logos">
            <a href="#"><span class="logo1 fa fa-weibo"></span></a>
            <a href="#"><span class="logo2 fa fa-facebook-official"></span></a>
            <a href="#"><span class="logo3 fa fa-twitter"></span></a>
            <a href="#"><span class="logo4 fa fa-wechat"></span></a>
        </p>
    </div>
    <div id="aboutMe">
        <p>Copyright &copy; 2018-<?php echo date("Y")?> ART STORE by Ding Fanyu</p>
    </div>
</footer>

<?php

if(!isset($_SESSION["view"])){
    $_SESSION["view"] = 1;
} else{
    $_SESSION["view"]++;
}
return
?>
