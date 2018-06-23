<?php
session_start();
if($_POST['signOut']=="signOut"){
    unset($_SESSION['user']);
    echo "Sign out!";
}
else
    echo $_POST['signOut'];
