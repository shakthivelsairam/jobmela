<?php
if((isset($_FILES['img']))||(isset($_FILES['res'])))
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
		$existsFlag=0;
		$imgName="";
		$resName="";
		$img_chke_qry = "select rowid,image_name,resume from profile_image where family_rowid=?";
		$stmtx = $conn->prepare($img_chke_qry);
		$stmtx->execute([$_SESSION['savedRow']]);
		if ($rowX = $stmtx->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
		{
			$existsFlag=1;
			$imgName = $rowX[1];
			$resName = $rowX[2];
		}
	   if ((!empty($_FILES['img']['name'])))
	   {
		  $target_folder = 'profile_images/';
		  $filename = "photo_".date('dmY')."_".$_FILES['img']['name'];
		  $upload_image = $target_folder.$filename;
		  if((move_uploaded_file($_FILES['img']['tmp_name'],$upload_image)))
		  {
			$imgName = $filename;
		  }
	   }
	   if ((!empty($_FILES['res']['name'])))
	   {
		   $resume_folder = 'resumes/';
		   $resume_filename = "resume_".date('dmY')."_".$_FILES['res']['name'];
		   $upload_resume = $resume_folder.$resume_filename;
		  if((move_uploaded_file($_FILES['res']['tmp_name'],$upload_resume)))
		  {
			$resName = $resume_filename;
		  }
	   }
		  if ($existsFlag==1)
		  {
			  $profile_photo = "update profile_image set image_name=?,resume=? where family_rowid=?";
		  }
		  else
		  {
			  $profile_photo = "insert into profile_image (image_name,resume,family_rowid) values (?,?,?)";
		  }
	
		  try {
			   $stmt = $conn->prepare($profile_photo);
			   $stmt->execute([$imgName,$resName,$_SESSION['savedRow']]);
			   return true;
		  }
		  catch(PDOException $e) {
				echo "Unable to process your request, contact admin";
				return false;
		  }

}
?>