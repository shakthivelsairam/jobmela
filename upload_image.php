<?php
if(isset($_FILES['img']))
{
   if(!empty($_FILES['img']['name']))
   {
	   if(session_status() !== PHP_SESSION_ACTIVE) session_start();
		require "connection.php";
		// Create connection
		try {
		  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
		  echo "Unable to process your request, contact admin";
		  return false;
		}
		
		if (!(isset($_SESSION['savedRow'])))
		{
			return false;
		}
      $target_folder = 'profile_images/';
      $filename = "profile_".date('dmY')."_".$_FILES['img']['name'];
      $upload_image = $target_folder.$filename;
      if(move_uploaded_file($_FILES['img']['tmp_name'],$upload_image))
      {
		  try {
		   $profile_photo = "insert into profile_image (family_rowid,image_name) values (?,?)";
		   $stmt = $conn->prepare($profile_photo);
		   $stmt->execute([$_SESSION['savedRow'],$filename]);
		   return true;
		  }
		   catch(PDOException $e) {
			echo "Unable to process your request, contact admin";
			return false;
		}
      }
   }
}
?>