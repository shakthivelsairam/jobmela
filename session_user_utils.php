<?php
// Clear all the session detailse
function url()
{
  return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?"https" : "http") . "://" . $_SERVER['HTTP_HOST']."/";
}
function rootDir()
{
  return $_SERVER['SERVER_NAME'];
}
function curUrl()
{
	$protocol = 'http'.(!empty($_SERVER['HTTPS']) ? 's' : '');
	return $protocol.'://'.$_SERVER['SERVER_NAME'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
}
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!(isset($_SESSION["isLogin"])))
{
  $url = './error-page.php';
  header("location: ".$url); // for two folders
}
?>
