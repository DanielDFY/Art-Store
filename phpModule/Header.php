<?php
if(!isset($_SESSION['footPrint']))
    $_SESSION['footPrint'] =  array();

?>
<div id="header">
    <nav>
        <div class="background">
            <div class="background_mask"></div>
            <div class="background_filter"></div>
        </div>
        <i><a href="Index.php" class="logo">&nbsp;Art Store</a></i>
        <i class="slogan">&nbsp;Where you find GENIUS and EXTRAORDINARY</i>
        <ul class="unsigned">
            <li>
                <a onclick="signOrRegister()"><i class="fa fa-user-times" ></i>&nbsp;Sign in / Register</a>
            </li>
        </ul>
        <ul class="signed">
            <li>
                <a href="MyAccount.php"><i class="fa fa-user-circle" ></i>&nbsp;<span id="Usrn">Unsigned</span></a>
                <ul>
                    <li><a href="MyAccount.php"><i class="fa fa-file" ></i>&nbsp;My Profile</a></li>
                    <li><a href="#"><i class="fa fa-star" ></i>&nbsp;Favorites</a></li>
                    <li><a onclick="confirmSignOut()"><i class="fa fa-sign-out" ></i>&nbsp;Sign out</a></li>
                </ul>
            </li>

            <li><a id="message" href="#"><i class="fa fa-comment"></i>&nbsp;Message</a></li>
            <li><a href="ShoppingCart.php"><i class="fa fa-shopping-cart" ></i>&nbsp;Shopping Cart&nbsp;</a></li>
        </ul>
    </nav>

    <div id="sign">
        <div class="container">
            <ul class="switcher">
                <li><a href="#" id="switcher_1" class="selected" onclick="switchSelect(true)">Sign in</a></li>
                <li><a href="#" id="switcher_2" class="unselected" onclick="switchSelect(false)">Register</a></li>
            </ul>

            <div id="signIn">
                <form class="signForm signIn" method="post">
                    <p class="signName">
                        Name :
                        <span class="check exist">*&nbsp;Unregistered Username</span>
                        <span class="check empty">*&nbsp;Username can't be empty</span>
                    </p>
                    <input type="text" id="signUsrn" name="signUsrn" maxlength="12" " autocomplete="off"><br />
                    <p class="signPass">
                        Password :
                        <span class="check correct">*&nbsp;Wrong Password</span>
                        <span class="check empty">*&nbsp;Password can't be empty</span>
                    </p>
                    <input type="password" name="signPass" maxlength="16" autocomplete="off"><br />
                    <input class="cancel formButton" type="button" value="Cancel" onclick="signOrRegisterCancel()">
                    <input class="submit formButton" type="button" value="Submit" onclick="signIn()">
                </form>
            </div>
            <div id="register">
                <form class="signForm register" method="post">
                    <p class="registerName">
                        Name :
                        <span class="check exist">*&nbsp;Used Username</span>
                        <span class="check empty">*&nbsp;Username can't be empty</span>
                        <span class="check length">*&nbsp;6 characters at least</span>
                        <span class="check content">*&nbsp;Username must be mixed with numbers and letters</span>
                    </p>
                    <input type="text"  id="registerUsrn" name="registerUsrn" maxlength="12" onchange="checkRegisterUsrn()" autocomplete="off"><br />
                    <p class="registerPass">
                        Password :
                        <span class="check empty">*&nbsp;Password can't be empty</span>
                        <span class="check length">*&nbsp;6 characters at least</span>
                    </p>
                    <input type="password" name="registerPass" maxlength="16" onchange="checkRegisterPass()" autocomplete="off"><br />
                    <p class="registerPassAgain">
                        Confirm your password :
                        <span class="check same">*&nbsp;Different passwords are entered</span>
                    </p>
                    <input type="password" name="registerPassAgain" onchange="checkPassAgain()" autocomplete="off"><br />
                    <p class="registerEmail">
                        E-mail :
                        <span class="check email">*&nbsp;Format: xxx@xxx.xxx</span>
                        <span class="check empty">*&nbsp;E-mail can't be empty</span>
                    </p>
                    <input type="email" name="registerEmail" onchange="checkRegisterEmail()" autocomplete="off"><br />
                    <p class="registerTel">
                        Tel :
                        <span class="check tel">*&nbsp;0/86/17951 + 13/15/17/18 + 8 numbers </span>
                        <span class="check empty">*&nbsp;Tel number can't be empty</span>
                    </p>
                    <input type="tel" name="registerTel" onchange="checkRegisterTel()" autocomplete="off"><br />
                    <p class="registerAdr">
                        Address :
                        <span class="check empty">*&nbsp;Address can't be empty</span>
                    </p>
                    <input type="text" name="registerAdr" onchange="checkRegisterAdr()" autocomplete="off"><br />
                    <input class="cancel formButton" type="button" value="Cancel" onclick="signOrRegisterCancel()">
                    <input class="submit formButton" type="button" value="Submit" onclick="register()">
                </form>
            </div>
        </div>
    </div>

    <div id="alert">
        <div class="container">
            <p class="alertText"></p>
            <button class="alertBtn ok" onclick="ok()">OK</button>
            <button class="alertBtn cancel" onclick="ok()">No</button>
            <button class="alertBtn confirm">Yes</button>
        </div>
    </div>

</div>

<?php return ?>