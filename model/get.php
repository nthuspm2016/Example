<?php
session_start();
if($_POST['id']=='kind'){
    if(isset($_SESSION['kind']))
        echo $_SESSION['kind'];
    else
        echo 'all';
}
else{
    if(isset($_SESSION['mode']))
        echo $_SESSION['mode'];
    else
        echo 'hot';
}
?>
