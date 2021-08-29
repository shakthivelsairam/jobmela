<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
$_SESSION['logout']=1;
$url = 'index.php';
  header("location: ".$url); // for two folders
?>
