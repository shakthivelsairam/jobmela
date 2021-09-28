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
      $loginchk = "select rowid,dob,email from family where email=? and dob=?";
    $stmt = $conn->prepare($loginchk);
    $stmt->execute([$userid,$pwd]);
    if ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
	{	

			$qryResult['msg'] = "Login Success";
			$qryResult['status'] = 0;
			$_SESSION["isLogin"]=1;
			$_SESSION["useridref"]=$row[0];
			
			/* below stuffs are for common
			if ($row[1]==1) 
			{
				$qryResult['status'] = 99;
				$_SESSION["isLogin"]=1;
				$_SESSION["isAdmin"]=1;
				$qryResult['msg'] = "Login Success";
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
			*/
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

if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==109091))
{
  try
  {
	  $qryResult = array();
      $qryResult['status'] = 1;
      $qryResult['msg'] = "Failed to save!";
	  $pName=$_REQUEST['pName'];
	  $pFName=$_REQUEST['pFName'];
	  $pDOB=$_REQUEST['pDOB'];
	  $pMobile=$_REQUEST['pMobile'];
	  $pDoorNo=$_REQUEST['pDoorNo'];
	  $pAddLine1=$_REQUEST['pAddLine1'];
	  $pAddLine2=$_REQUEST['pAddLine2'];
	  $pAddLine3=$_REQUEST['pAddLine3'];
	  $pCity=$_REQUEST['pCity'];
	  $pState = $_REQUEST['pState'];
	  $pPinCode = $_REQUEST['pPinCode'];
	  $pAadhar = $_REQUEST['pAadhar'];
	  $pLanguage = $_REQUEST['pLanguage'];
	  $pHeight = $_REQUEST['pHeight'];
	  $pRelation = $_REQUEST['pRelation'];
	  $pIndustry = $_REQUEST['pIndustry'];
	  $pWorkLoc = $_REQUEST['pWorkLoc'];
	  
	  $pFatherGPFNo = $_REQUEST['pFatherGPFNo'];
	  $pFatherRank = $_REQUEST['pFatherRank'];
	  $pFatherGradeNo = $_REQUEST['pFatherGradeNo'];
	  $pFatherStation = $_REQUEST['pFatherStation'];
	  $pFatherMobile = $_REQUEST['pFatherMobile'];
	  $pDistrict = $_REQUEST['pDistrict'];

	  $masterrowid = $_SESSION["useridref"];
	  //$pName = $_FILES["image"]["name"];
	   $updaterow=$_REQUEST['updaterow'];
	   if ($updaterow>0)
	   {
		   // preferredLoc
		   // prefferedInd
		   $familyreg = "update family set name=?,link_relation_relation=?,fathersname=?,dob=?,mobile=?,doorno=?,addline1=?,addline2=?,addline3=?,city=?,state=?,pincode=?,aaadhar=?,language=?,height=?,preferredLoc=?,prefferedInd=?,gpfno=?,frank=?,gradeno=?,station=?,fathermobile=?,link_district_district=? where rowid=?";
		$stmt = $conn->prepare($familyreg);
		$er = $stmt->execute([$pName,$pRelation,$pFName,$pDOB,$pMobile,$pDoorNo,$pAddLine1,$pAddLine2,$pAddLine3,$pCity,$pState,$pPinCode,$pAadhar,$pLanguage,$pHeight,$pWorkLoc,$pIndustry,$pFatherGPFNo,$pFatherRank,$pFatherGradeNo,$pFatherStation,$pFatherMobile,$pDistrict,$updaterow]);
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Updated Successfully";
		$_SESSION["savedRow"]=$updaterow;
		$_SESSION["snackbar"]="Details Altered Successfully";
	   }
	   else
	   {
		$familyreg = "insert into family (
		link_master_master,name,link_relation_relation,fathersname,dob,mobile,doorno,addline1,addline2,addline3,city,state,pincode,aaadhar,language,height,preferredLoc,prefferedInd,gpfno,frank,gradeno,station,fathermobile,link_district_district) 
		values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = $conn->prepare($familyreg);
		$stmt->execute([$masterrowid,$pName,$pRelation,$pFName,$pDOB,$pMobile,$pDoorNo,$pAddLine1,$pAddLine2,$pAddLine3,$pCity,$pState,$pPinCode,$pAadhar,$pLanguage,$pHeight,$pWorkLoc,$pIndustry,$pFatherGPFNo,$pFatherRank,$pFatherGradeNo,$pFatherStation,$pFatherMobile,$pDistrict]);
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Saved Successfully";
		$_SESSION["savedRow"]=$conn->lastInsertId();
		$_SESSION["snackbar"]="Details Added Successfully";
		// mov pPhoto
	   }
		echo json_encode($qryResult);
  }
	
	catch(PDOException $e) {
	$qryResult = array();
	$qryResult['status'] = 1;
	$qryResult['msg'] = "Unable to save, please contact admin".$e;
	echo json_encode($qryResult);
	return;
  }
} 


 /// Educational details
 
if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==901635121))
{
	try {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Failed to save!";
		$pEduLevel=$_REQUEST['pEduLevel'];
		$pFieldStudy=$_REQUEST['pFieldStudy'];
		$pCollege=$_REQUEST['pCollege'];
		$pDistrict=$_REQUEST['pDistrict'];
		$pFromDate=$_REQUEST['pFromDate'];
		$pToDate=$_REQUEST['pToDate'];
		$pPursing=$_REQUEST['pPursing'];
		$totRecs=$_REQUEST['totalRows'];
		$masterrowid = $_REQUEST["familyRow"];
		$familyreg = "delete from jobexp where link_family_family=?";
		$stmt = $conn->prepare($familyreg);
		$er = $stmt->execute([$masterrowid]);
		for ($ij=0;$ij<$totRecs;$ij++)
		{
			
			$rec1 = explode("|",$pEduLevel)[$ij+1];
			$rec2 = explode("|",$pFieldStudy)[$ij+1];
			$rec3 = explode("|",$pCollege)[$ij+1];
			$rec4 = explode("|",$pDistrict)[$ij+1];
			$rec5 = explode("|",$pFromDate)[$ij+1];
			$rec6 = explode("|",$pToDate)[$ij+1];
			$rec7 = explode("|",$pPursing)[$ij+1];
			$familyreg = "insert into jobexp (
			link_family_family,link_job_job,link_city_city,link_company_company,description,from_period,to_period,persuing) 
			values (?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($familyreg);
			$err=$stmt->execute([$masterrowid,$rec1,$rec2,$rec3,$rec4,$rec5,$rec6,$rec7]);
		}
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Saved Successfully";
		$_SESSION["snackbar"]="Details Altered Successfully";
		echo json_encode($qryResult);
		return;
		
	}
	catch(PDOException $e) {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Unable to save, please contact admin";
		$_SESSION["snackbar"]="Unable to save, please contact admin";
		echo json_encode($qryResult);
		return;
  }
}
// Job Experiance details
if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==70941))
{
	try {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Failed to save!";
		$pEduLevel=$_REQUEST['pEduLevel'];
		$pFieldStudy=$_REQUEST['pFieldStudy'];
		$pCollege=$_REQUEST['pCollege'];
		$pDistrict=$_REQUEST['pDistrict'];
		$pFromDate=$_REQUEST['pFromDate'];
		$pToDate=$_REQUEST['pToDate'];
		$pMark = $_REQUEST['pMark'];
		$pPursing=$_REQUEST['pPursing'];
		$totRecs=$_REQUEST['totalRows'];
		$masterrowid = $_REQUEST["familyRow"];
		$familyreg = "delete from education where link_family_family=?";
		$stmt = $conn->prepare($familyreg);
		$er = $stmt->execute([$masterrowid]);
		for ($ij=0;$ij<$totRecs;$ij++)
		{
			
			$rec1 = explode("|",$pEduLevel)[$ij+1];
			$rec2 = explode("|",$pFieldStudy)[$ij+1];
			$rec3 = explode("|",$pCollege)[$ij+1];
			$rec4 = explode("|",$pDistrict)[$ij+1];
			$rec5 = explode("|",$pFromDate)[$ij+1];
			$rec6 = explode("|",$pToDate)[$ij+1];
			$rec7 = explode("|",$pPursing)[$ij+1];
			$rec8 = explode("|",$pMark)[$ij+1];
			$familyreg = "insert into education (
			link_family_family,edu_level,field_study,college_univer,district,from_period,to_period,pursing,percentage) 
			values (?,?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($familyreg);
			$err=$stmt->execute([$masterrowid,$rec1,$rec2,$rec3,$rec4,$rec5,$rec6,$rec7,$rec8]);
		}
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Saved Successfully";
		$_SESSION["snackbar"]="Details Altered Successfully";
		echo json_encode($qryResult);
		return;
		
	}
	catch(PDOException $e) {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Unable to save, please contact admin";
		$_SESSION["snackbar"]="Unable to save, please contact admin";
		echo json_encode($qryResult);
		return;
  }
}
// Skills details
if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==90182612))
{
	try {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Failed to save!";
		$pEduLevel=$_REQUEST['pEduLevel'];
		$pLevel=$_REQUEST['pLevel'];
		$totRecs=$_REQUEST['totalRows'];
		$masterrowid = $_REQUEST["familyRow"];
		$familyreg = "delete from skill_interested where link_family_family=?";
		$stmt = $conn->prepare($familyreg);
		$er = $stmt->execute([$masterrowid]);
		for ($ij=0;$ij<$totRecs;$ij++)
		{
			
			$rec1 = explode("|",$pEduLevel)[$ij+1];
			$rec2 = explode("|",$pLevel)[$ij+1];
			$familyreg = "insert into skill_interested (
			link_family_family,link_skill_skill,level) 
			values (?,?,?)";
			$stmt = $conn->prepare($familyreg);
			$err=$stmt->execute([$masterrowid,$rec1,$rec2]);
		}
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Saved Successfully";
		$_SESSION["snackbar"]="Details Altered Successfully";
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
// Award portal
if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==67675102))
{
	try {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Failed to save!";
		$pTitle=$_REQUEST['pTitle'];
		$pAward=$_REQUEST['pAwardDte'];
		$pDesc=$_REQUEST['pDesc'];
		$totRecs=$_REQUEST['totalRows'];
		$masterrowid = $_REQUEST["familyRow"];
		$familyreg = "delete from awards_received where link_family_family=?";
		$stmt = $conn->prepare($familyreg);
		$er = $stmt->execute([$masterrowid]);
		for ($ij=0;$ij<$totRecs;$ij++)
		{
			$rec1 = explode("|",$pTitle)[$ij+1];
			$rec2 = explode("|",$pAward)[$ij+1];
			$rec3 = explode("|",$pDesc)[$ij+1];
			$familyreg = "insert into awards_received (
			link_family_family,link_award_award,dateofaward,description) 
			values (?,?,?,?)";
			$stmt = $conn->prepare($familyreg);
			$err=$stmt->execute([$masterrowid,$rec1,$rec2,$rec3]);
		}
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Saved Successfully";
		$_SESSION["snackbar"]="Details Altered Successfully";
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

// Certifications portal
if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==444000012))
{
	try {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Failed to save!";
		$pTitle=$_REQUEST['pTitle'];
		$pAwardedDate=$_REQUEST['pAwardedDate'];
		$pExpiryDate=$_REQUEST['pExpiryDate'];
		$pNeverExpiry=$_REQUEST['pNeverExpiry'];
		$totRecs=$_REQUEST['totalRows'];
		$masterrowid = $_REQUEST["familyRow"];
		$familyreg = "delete from certifications_having where link_family_family=?";
		$stmt = $conn->prepare($familyreg);
		$er = $stmt->execute([$masterrowid]);
		for ($ij=0;$ij<$totRecs;$ij++)
		{
			$rec1 = explode("|",$pTitle)[$ij+1];
			$rec2 = explode("|",$pAwardedDate)[$ij+1];
			$rec3 = explode("|",$pExpiryDate)[$ij+1];
			$rec4 = explode("|",$pNeverExpiry)[$ij+1];
			$familyreg = "insert into certifications_having (
			link_family_family,link_certification_certification,dateofcertification,dateofexpiry,neverexpiry) 
			values (?,?,?,?,?)";
			$stmt = $conn->prepare($familyreg);
			$err=$stmt->execute([$masterrowid,$rec1,$rec2,$rec3,$rec4]);
		}
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Saved Successfully";
		$_SESSION["snackbar"]="Details Altered Successfully";
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

// Papers portal
if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==66990090))
{
	try {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Failed to save!";
		$pTitle=$_REQUEST['pTitle'];
		$pURL=$_REQUEST['pURL'];
		$pPublish=$_REQUEST['pPublish'];
		$pDesc=$_REQUEST['pDesc'];
		$totRecs=$_REQUEST['totalRows'];
		$masterrowid = $_REQUEST["familyRow"];
		$familyreg = "delete from projects_presented where link_family_family=?";
		$stmt = $conn->prepare($familyreg);
		$er = $stmt->execute([$masterrowid]);
		for ($ij=0;$ij<$totRecs;$ij++)
		{
			$rec1 = explode("|",$pTitle)[$ij+1];
			$rec2 = explode("|",$pURL)[$ij+1];
			$rec3 = explode("|",$pPublish)[$ij+1];
			$rec4 = explode("|",$pDesc)[$ij+1];
			$familyreg = "insert into projects_presented (
			link_family_family,title,url,dateofpublished,description) 
			values (?,?,?,?,?)";
			$stmt = $conn->prepare($familyreg);
			$err=$stmt->execute([$masterrowid,$rec1,$rec2,$rec3,$rec4]);
		}
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Saved Successfully";
		$_SESSION["snackbar"]="Details Altered Successfully";
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


/// Patnent
if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==110991212))
{
	try {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Failed to save!";
		$pTitle=$_REQUEST['pTitle'];
		$pURL=$_REQUEST['pURL'];
		$pPublish=$_REQUEST['pPublish'];
		$pPatent=$_REQUEST['pPatent'];
		$pDesc=$_REQUEST['pDesc'];
		$totRecs=$_REQUEST['totalRows'];
		$masterrowid = $_REQUEST["familyRow"];
		$familyreg = "delete from patent_presented where link_family_family=?";
		$stmt = $conn->prepare($familyreg);
		$er = $stmt->execute([$masterrowid]);
		for ($ij=0;$ij<$totRecs;$ij++)
		{
			$rec1 = explode("|",$pTitle)[$ij+1];
			$rec2 = explode("|",$pURL)[$ij+1];
			$rec3 = explode("|",$pPublish)[$ij+1];
			$rec4 = explode("|",$pDesc)[$ij+1];
			$rec5 = explode("|",$pDesc)[$ij+1];
			$familyreg = "insert into patent_presented (
			link_family_family,title,url,dateofpublished,pattern_number,description) 
			values (?,?,?,?,?,?)";
			$stmt = $conn->prepare($familyreg);
			$err=$stmt->execute([$masterrowid,$rec1,$rec2,$rec3,$rec4,$rec5]);
		}
		$qryResult['status'] = 0;
		$qryResult['msg'] = "Saved Successfully";
		$_SESSION["snackbar"]="Details Altered Successfully";
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
			$qryResult['msg'] = "Saved Successfully";
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

if ((isset($_REQUEST['zproflag']))&&($_REQUEST['zproflag']==893641))
{
	try {
		$qryResult = array();
		$qryResult['status'] = 1;
		$qryResult['msg'] = "Failed to save!";
		$qryResult['data']="";
		$levelid=$_REQUEST['levelid'];
		$loginchk = "select stream_stream_link from level where rowid=?";
		$stmt = $conn->prepare($loginchk);
		$stmt->execute([$levelid]);
		$steamid=0;
		if ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
		{	
			$steamid=$row[0];
		}
		$streams=array();
		$streamqry="select rowid,name from field where stream_stream_link=?";
		$stream1 = $conn->prepare($streamqry);
		$stream1->execute([$steamid]);
		while ($rowe = $stream1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
		{
			$streams[]=$rowe;
		}
		$qryResult['data']=$streams;
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

