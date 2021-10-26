<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
$_SESSION['logout']=1;
$url = 'login.php';
  header("location: ".$url); // for two folders
?>
