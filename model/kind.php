<?php
session_start();
if($_POST['kind']=="setsex"){
    $_SESSION['sex']=1;
}
else{
    $_SESSION['kind']=$_POST['kind'];
}
?>
