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


if (isset($_SESSION['logout']))
{
	unset($_SESSION['logout']);
	unset($_SESSION['isAdmin']);
	unset($_SESSION['isLogin']);
	session_destroy();
}


// Session timeout
if (!isset($_SESSION['timestamp'])) { $_SESSION['timestamp']=time();  }
$idletime=500;//after 60 seconds the user gets logged out

if (time()-$_SESSION['timestamp']>$idletime){
	if (strpos($_SERVER['HTTP_REFERER'],"index.php"))
	{
		$url = 'login.php';
	}
	else
	{
		session_destroy();
		session_unset();
		$url = './error-page.php';
	}
	header("location: ".$url); // for two folders
}else{
    $_SESSION['timestamp']=time();
}

//on session creation

?>
