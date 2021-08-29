<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if(session_status() !== PHP_SESSION_ACTIVE) session_start();
require "connection.php";
// Create connection
try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Unable to process your request, contact admin";
  return;
}

if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==710))
{
  try
  {
	unset($_SESSION["isLogin"]);
	  $qryResult = array();
      $qryResult['status'] = 1;
      $qryResult['msg'] = "Invalid login credentials";
    $userid = $_REQUEST['username'];
	$pwd = $_REQUEST['password'];
      $loginchk = "select rowid,usertype from users where userid=? and password=?";
    $stmt = $conn->prepare($loginchk);
    $stmt->execute([$userid,$pwd]);
    if ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
	{
			if ($row[1]=="Admin") 
			{
				$qryResult['status'] = 99;
				$_SESSION["isLogin"]=1;
				$_SESSION["isAdmin"]=1;
			}
			else
			{
				$loginchk1 = "select rowid from master where gpfno=?";
				$stmt1 = $conn->prepare($loginchk1);
				$stmt1->execute([$userid]);
				if ($row1 = $stmt1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				{
					$qryResult['msg'] = "Login Success";
					$qryResult['status'] = 0;
					$_SESSION["isLogin"]=1;
					$_SESSION["useridref"]=$row1[0];
				}
			}
	}
     echo json_encode($qryResult);
      return;
  }
  catch(PDOException $e) {
    $qryResult = array();
    $qryResult['status'] = 1;
    $qryResult['msg'] = "Unable to save, please contact admin".$e;
    echo json_encode($qryResult);
    return;
  }
}

if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==77665))
{
  try
  {  
	  $qryResult = array();
      $qryResult['status'] = 1;
      $qryResult['msg'] = "Failed to save!";
	  $grfno=$_REQUEST['gpfNo'];
	  $pName=$_REQUEST['pName'];
	  $sltRank=$_REQUEST['sltRank'];
	  $adharNo=$_REQUEST['adharNo'];
	  $sltStation=$_REQUEST['sltStation'];
	  $dob=$_REQUEST['dob'];
	  $doj=$_REQUEST['doj'];
	  $doe=$_REQUEST['doe'];
	  $sltDept=$_REQUEST['sltDept'];
	  $rowid = $_REQUEST['userrow'];
	  if ($rowid>0)
	  {
		$loginchk = "update master set department_department_link=?,name=?,rank_rank_link=?,aadharno=?,station_presentstation_link=?,dob=?,doj=?,doe=? where rowid=?";
		$stmt = $conn->prepare($loginchk);
		$stmt->execute([$sltDept,$pName,$sltRank,$adharNo,$sltStation,$dob,$doj,$doe,$rowid]);
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Successfully Updated";
		
	  }
	  else
	  {
		 $stmt = $conn->prepare("select rowid from master where gpfno=:inpgpfo");
		$stmt->bindValue(':inpgpfo', $grfno);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($res)>0)
		{
			$qryResult['msg'] = "GPF Number already present";
		}
		else
		{
			$loginchk = "insert into master (gpfno,department_department_link,name,rank_rank_link,aadharno,station_presentstation_link,dob,doj,doe) values (?,?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($loginchk);
			$stmt->execute([$grfno,$sltDept,$pName,$sltRank,$adharNo,$sltStation,$dob,$doj,$doe]);
			$qryResult['status'] = 0;
			$qryResult['msg'] = "Saved Successfully".$loginchk;
		}
	  }
	  echo json_encode($qryResult);
		return;
  }
  catch(PDOException $e) {
    $qryResult = array();
    $qryResult['status'] = 1;
    $qryResult['msg'] = "Unable to save, please contact admin".$e;
    echo json_encode($qryResult);
    return;
  }
}
$conn = null;
?>

