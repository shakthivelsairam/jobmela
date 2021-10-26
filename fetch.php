<?php
if(isset($_POST["limit"], $_POST["start"]))
{
	
	require "connection.php";
	if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	// Create connection
	try {
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "Unable to process your request, contact admin";
		return;
	}
	$filter="";
	if (isset($_POST['sltFilter'])) $filter=$_POST['sltFilter'];
	$compayid = $_SESSION['useridref'];
	if ($filter=="")
	{
		
	  $devCount = "select fa.rowid,fa.name,fa.dob,fa.mobile,fa.city,fa.district,fa.preferredLoc,fa.prefferedInd,ed.edu_level,ed.field_study,fi.name,lv.name from family fa,education ed,field fi,level lv where fa.rowid=ed.link_family_family and fi.rowid=ed.field_study and lv.rowid=ed.edu_level ORDER BY fa.rowid LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
	  $devTotCnt = "select count(*) from family fa,education ed,field fi,level lv where fa.rowid=ed.link_family_family and fi.rowid=ed.field_study and lv.rowid=ed.edu_level";
	  //echo $devTotCnt;
	}
	else
	{
		$EDU = array();
		$STR = array();
		$FOS = array();
		$IND = array();
		$WLOC = array();
		
		for ($i=0;$i<count($filter);$i++)
		{
			$rec = $filter[$i];
			$dta = explode("-",$rec);
			if ($dta[0]=="EDU") array_push($EDU,$dta[1]);
			if ($dta[0]=="STR") array_push($STR,$dta[1]);
			if ($dta[0]=="FOS") array_push($FOS,$dta[1]);
			if ($dta[0]=="IND") array_push($IND,$dta[1]);
			if ($dta[0]=="WLOC") array_push($WLOC,$dta[1]);
		}
		/*
		if (count($WLOC)>0) $WLOC=implode(",",$WLOC);
		if (count($EDU)>0) $EDU=implode(",",$EDU);
		if (count($STR)>0) $STR=implode(",",$STR);
		if (count($FOS)>0) $FOS=implode(",",$FOS);
		if (count($IND)>0) $IND=implode(",",$IND);
		*/
		// $devCount = "select rowid,name,fathersname,dob,mobile,city,district,preferredLoc,prefferedInd from family ORDER BY rowid LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
		$devCount = "select fa.rowid,fa.name,fa.dob,fa.mobile,fa.city,fa.district,fa.preferredLoc,fa.prefferedInd,ed.edu_level,ed.field_study,fi.name,lv.name from family fa,education ed,field fi,level lv where";
		$whereCond="";
		$andFlg=0;
		if (count($WLOC)>0) 
		{
			$WLOC=implode(",",$WLOC); 
			$whereCond =" fa.preferredLoc in (".$WLOC.")"; 
			$andFlg=1;
		}
		if (count($IND)>0) 
		{
			$IND=implode(",",$IND);
			if ($andFlg==1) $whereCond .= " and";
			$whereCond .= " fa.prefferedInd in (".$IND.")"; 
			$andFlg=1;
		}
		if (count($FOS)>0) 
		{
			$FOS=implode(",",$FOS);
			if ($andFlg==1) $whereCond .= " and";
			$whereCond .= " ed.field_study in (".$FOS.")"; 
			$andFlg=1;
		}
		// if ($STR!="") $devCount .= ($andFlg?: " and")." fa.prefferedInd in (".$STR.")",$andFlg=1;
		if (count($EDU)>0) 
		{
			$EDU=implode(",",$EDU);
			if ($andFlg==1) $whereCond .= " and";
			$whereCond .= " ed.edu_level in (".$EDU.")"; 
			$andFlg=1;
		}
		
		$devCount = $devCount.$whereCond." and fa.rowid=ed.link_family_family and fi.rowid=ed.field_study and lv.rowid=ed.edu_level ORDER BY fa.rowid LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
		$devTotCnt = "select count(*) from family fa,education ed,field fi,level lv where".$whereCond." and fa.rowid=ed.link_family_family and fi.rowid=ed.field_study and lv.rowid=ed.edu_level";
	}
		//print_r($devCount);
		//print_r($devTotCnt);
		// Count the total records
		$stmtTot = $conn->prepare($devTotCnt);
		$stmtTot->execute();
		$rowRecrs = $stmtTot->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
		$totRows = $rowRecrs[0];	
		
		
			$stmt = $conn->prepare($devCount);
			$ress = $stmt->execute();
			
		while($rec1 = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
		{
			$flg=" ";
						$remarks="";
						$logchek = "select rowid,selectedflg,remarks from sortlistdata where companyid=? and candidateid=?";
						$stm4t = $conn->prepare($logchek);
						$stm4t->execute([$compayid,$rec1[0]]);
						if ($rokw = $stm4t->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
						{	
							if ($rokw[1]==1) $flg=" checked ";
							$remarks=$rokw[2];
						}
		  echo '
		  <tr><td>'.$rec1[1].'</td><td>'.$rec1[2].'</td><td>'.$rec1[3].'</td><td>'.$rec1[11].'</td><td>'.$rec1[10].'</td>
		  <td><center><a href="javascript:void"><i class="fa fa-download" aria-hidden="true" onClick="fDownloadResume('.$rec1[0].')"></i></a></center></td>
		  <td><textarea id="txtarea'.$rec1[0].'" onBlur="fCaptureRemarks('.$rec1[0].')">'.$remarks.'</textarea></td>
		  <td><center><input type="checkbox"'.$flg.'onClick="fUpdate('.$rec1[0].')" id="chk'.$rec1[0].'"></center></td>
		  </tr>';
		}
		$Rtotl = (int)$_POST["start"]+(int)$_POST["limit"];
		if ($Rtotl>$totRows) $Rtotl=$totRows;
		echo "<tr><td colspan=10 align='center'><font color='red'>Displaying ".$Rtotl." records out of ".$totRows."</font></td><tr>";

}
?>