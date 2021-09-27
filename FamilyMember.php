<?php
require "session_user_utils.php";
$edirow=0;
if (isset($_REQUEST['sessionid']))
{
	$edirow=substr($_REQUEST['sessionid'],8);
	$slen=strlen($edirow);
	$slen = $slen-8;
	$edirow=substr($edirow,0,$slen);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    
    <title>Job Portal</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/3.4/dist/css/bootstrap.min.css" rel="stylesheet">

   
  </head>
<style>
h3 {
	text-align:center;
}
body {
	background-color: #f8f9fa;
}
button.btn {
    height: 40px;
    padding: 0 20px;
    vertical-align: middle;
    background: #26A69A;
    
    border: 0;
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 40px;
    color: #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    text-shadow: none;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}

button.btn:hover {
    opacity: 0.6;
    color: #fff;
}

button.btn:active {
    outline: 0;
    opacity: 0.6;
    color: #fff;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
}

button.btn:focus {
    outline: 0;
    opacity: 0.6;
    background: #26A69A;
    color: #fff;
}

button.btn:active:focus,
button.btn.active:focus {
    outline: 0;
    opacity: 0.6;
    background: #26A69A;
    color: #fff;
}
.registration-form fieldset {
    display: none;
}
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  top: 50px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 3.5s;
  animation: fadein 0.5s, fadeout 0.5s 3.5s;
}

@-webkit-keyframes fadein {
  from {top: 0; opacity: 0;} 
  to {top: 50px; opacity: 1;}
}

@keyframes fadein {
  from {top: 0; opacity: 0;}
  to {top: 50px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {top: 50px; opacity: 1;} 
  to {top: 0; opacity: 0;}
}

@keyframes fadeout {
  from {top: 50px; opacity: 1;}
  to {top: 0; opacity: 0;}
}

</style>
  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
		  <?php if (isset($_REQUEST['isAdmin'])) { ?>
            <li><a href="#">Master</a></li>
		  <?php } ?>
            <li><a class="active" href="#">Family</a></li>
             <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<form runat="server" id="basic-form">
    <div class="container" style="width:95%">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="registration-form">
			<?php
			
			 require "connection.php";
          // Create connection
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
            echo "Unable to process your request, contact admin";
            return;
          }
		    $devCount = "select rowid,link_master_master,name,link_relation_relation,fathersname,dob,mobile,doorno,addline1,addline2,addline3,city,state,pincode,aaadhar,language,height,preferredLoc,prefferedInd,gpfno,rank,gradeno,station,fathermobile,link_district_district from family where rowid=?";
			$stmt = $conn->prepare($devCount);
			$stmt->execute([$edirow]);
			$rec="^^^^^^^^^^^^^^^^^^^^^^^^^^^";
			$profile_img="default.png";
			$profile_pdf="";
			if ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
				$rec=$row[0]."^".$row[1]."^".$row[2]."^".$row[3]."^".$row[4]."^".$row[5]."^".$row[6]."^".$row[7]."^".$row[8]."^".$row[9]."^".$row[10]."^".$row[11]."^".$row[12]."^".$row[13]."^".$row[14]."^".$row[15]."^".$row[16]."^".$row[17]."^".$row[18]."^".$row[19]."^".$row[20]."^".$row[21]."^".$row[22]."^".$row[23]."^".$row[24];
				$profImage = "select image_name,resume from profile_image where family_rowid=? order by rowid desc";
				$stmtimg = $conn->prepare($profImage);
				$stmtimg->execute([$row[0]]);
				if ($rowimg = $stmtimg->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))  { $profile_img=$rowimg[0]; $profile_pdf=$rowimg[1]; }
			}
			$pieces = explode("^", $rec);
		  ?>
		  <br/>
		
		  <fieldset style="display:block" class="afterSave">
		  </br>
		  <h3>Basic Information</h3>
		  <div class="form-row">
			<div class="form-group col-md-3">
			  <label for="inputCity">Name</label>
			  <input type="text" class="form-control" required id="pName" value="<?php echo $pieces[2]; ?>">
			</div>
			<div class="form-group col-md-3">
			  <label for="inputState">Father's Name</label>
				<input type="text" required class="form-control" id="pFName" value="<?php echo $pieces[4]; ?>">
			</div>
			<div class="form-group col-md-3">
			 <label for="inputState">DOB</label>
				<input type="date" required class="form-control" id="pDOB" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $pieces[5]; ?>">
			</div>
			<div class="form-group col-md-3">
			 <label for="inputState">Moblie Number</label>
				<input type="number" maxlength="10" size="10" max="10" required class="form-control" id="pMobile" value="<?php echo $pieces[6]; ?>">
			</div>
		  </div>
			
			<div class="form-row">
			<div class="form-group col-md-3">
			  <label for="inputCity">Door No</label>
			  <input type="text" class="form-control" id="pDoorNo" value="<?php echo $pieces[7]; ?>">
			</div>
			<div class="form-group col-md-3">
			  <label for="inputState">Address Line 1</label>
				<input type="text" class="form-control" id="pAddLine1" value="<?php echo $pieces[8]; ?>">
			</div>
			<div class="form-group col-md-3">
			 <label for="inputState">Address Line 2</label>
				<input type="text" class="form-control" id="pAddLine2" value="<?php echo $pieces[9]; ?>">
			</div>
			<div class="form-group col-md-3">
			 <label for="inputState">Address Line 3</label>
				<input type="text" class="form-control" id="pAddLine3" value="<?php echo $pieces[10]; ?>">
			</div>
		  </div>


			<div class="form-row">
			<div class="form-group col-md-3">
			 <label for="inputState">Pin Code</label>
				<input type="number" class="form-control" id="pPinCode" value="<?php echo $pieces[13]; ?>">
			</div>
			<div class="form-group col-md-3">
			  <label for="inputCity">City</label>
			  <input type="text" class="form-control" id="pCity" value="<?php echo $pieces[11]; ?>">
			</div>
			<div class="form-group col-md-3">
			  <label for="inputState">State</label>
				<input type="text" class="form-control" id="pState" value="<?php echo $pieces[12]; ?>">
			</div>
			
			<div class="form-group col-md-3">
			 <label for="inputState">AADHAR Number</label>
				<input type="number" class="form-control" id="pAadhar" value="<?php echo $pieces[14]; ?>">
			</div>
		  </div>
				
		<div class="form-row">
			<div class="form-group col-md-3">
			  <label for="inputCity">Languages Known</label>
			  <input type="text" class="form-control" id="pLanguage" value="<?php echo $pieces[15]; ?>">
			</div>
			<div class="form-group col-md-3">
			  <label for="inputState">Height (In Metres)</label>
				<input type="number" class="form-control" id="pHeight" value="<?php echo $pieces[16]; ?>">
			</div>
			<div class="form-group col-md-3">
			  <label for="inputCity">Relation</label>
			  <select class="form-control" id="pRelation">
			  <option value=0>--Select--</option>
			  <option value=1 <?php if ($pieces[3]==1) echo "selected"; ?>>Son</option>
			  <option value=2 <?php if ($pieces[3]==2) echo "selected"; ?>>Daughter</option>
			  <option value=3 <?php if ($pieces[3]==3) echo "selected"; ?>>Spouse</option>
			  </select>
			</div>
			  <div class="form-group col-md-3">
			 <label for="inputState">District</label>
				<select id="pDistrict" class="form-control" name="pDistrict">
				<option value=0>--Select--</option>
				<?php
				 $devCoun1t = "select rowid,name from district";
				$stmt23 = $conn->prepare($devCoun1t);
				$stmt23->execute();
				while ($rowx = $stmt23->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
				{
					?> <option value="<?php echo $rowx[0]; ?>" <?php if ($rowx[0]==$pieces[24]) echo "selected"; ?>><?php echo $rowx[1]; ?></option> <?php
				}
				?>
				</select>
			</div>
		  </div>
		  <div class="form-row">
	
			<div class="form-group col-md-3">
			  <label for="inputCity">Preferred Industry</label> <br/>
			  <span id="pIndustryAll" class="pIndustryAll">
			  <input type="checkbox" value="1" <?php if (strpos($pieces[18],"1")>0) echo "checked"; ?> name="pIndustry" id="pIndustry">&nbsp; Information Technology</br>
			  <input type="checkbox" value="2" <?php if (strpos($pieces[18],"2")>0) echo "checked"; ?> name="pIndustry" id="pIndustry">&nbsp; Hardware</br>
			  <input type="checkbox" value="3" <?php if (strpos($pieces[18],"3")>0) echo "checked"; ?> name="pIndustry" id="pIndustry">&nbsp; Legal</br>
			  <input type="checkbox" value="4" <?php if (strpos($pieces[18],"4")>0) echo "checked"; ?> name="pIndustry" id="pIndustry">&nbsp; Pharmaceutical</br>
			  <input type="checkbox" value="5" <?php if (strpos($pieces[18],"5")>0) echo "checked"; ?> name="pIndustry" id="pIndustry">&nbsp; Sales</br>
			  <input type="checkbox" value="6" <?php if (strpos($pieces[18],"6")>0) echo "checked"; ?> name="pIndustry" id="pIndustry">&nbsp; Marketing</br>
			  <input type="checkbox" value="7" <?php if (strpos($pieces[18],"7")>0) echo "checked"; ?> name="pIndustry" id="pIndustry">&nbsp; Finance
			  </span>
			</div>
			<div class="form-group col-md-3">
			 <label for="inputState">Preferred Work Location 1</label> <br/>
			 <select id="pWorkLoc1" class="form-control" name="pWorkLoc1">
				<option value=0>--Select--</option>
			 <?php
				if ($pieces[17]=="") $pieces[17]="||";
				$wl=explode("|",$pieces[17]);
				$stmt23->execute();
				while ($rowx = $stmt23->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
				{
					?> <option value="<?php echo $rowx[0]; ?>" <?php if ($wl[0]==$rowx[0]) echo "selected"; ?>><?php echo $rowx[1]; ?></option> <?php
				}
			 ?>
			 </select>
			  <br/>
			 <label for="inputState">Preferred Work Location 2</label> <br/>
			 <select id="pWorkLoc2" class="form-control" name="pWorkLoc2">
				<option value=0>--Select--</option>
			 <?php
				$stmt23->execute();
				while ($rowx = $stmt23->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
				{
					?> <option value="<?php echo $rowx[0]; ?>" <?php if ($wl[1]==$rowx[0]) echo "selected"; ?>><?php echo $rowx[1]; ?></option> <?php
				}
			 ?>
			 </select>
			  <br/>
			 <label for="inputState">Preferred Work Location 3</label> <br/>
			 <select id="pWorkLoc3" class="form-control" name="pWorkLoc3">
				<option value=0>--Select--</option>
			 <?php
				$stmt23->execute();
				while ($rowx = $stmt23->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
				{
					?> <option value="<?php echo $rowx[0]; ?>" <?php if ($wl[2]==$rowx[0]) echo "selected"; ?>><?php echo $rowx[1]; ?></option> <?php
				}
			 ?>
			 </select>
			</div>
			<div class="form-group col-md-3">
			   <label for="inputState">Father's GPF Number</label>
				<input type="number" class="form-control" id="pFatherGPFNo" value="<?php echo $pieces[19]; ?>">
				<br/>
				<label for="inputState">Father's Grade Number</label>
				<input type="text" class="form-control" id="pFatherGradeNo" value="<?php echo $pieces[21]; ?>">
				<br/>
				 <label for="inputState">Father's Mobile Number</label>
				<input type="number" class="form-control" id="pFatherMobile" value="<?php echo $pieces[23]; ?>">
			</div>
			<div class="form-group col-md-3">
				 <label for="inputCity">Father's Rank</label>
			  <input type="text" class="form-control" id="pFatherRank" value="<?php echo $pieces[20]; ?>">
			  <br/>
			   <label for="inputState">Father's Station</label>
				<input type="text" class="form-control" id="pFatherStation" value="<?php echo $pieces[22]; ?>">
			</div>
		  </div>
			
		<div class="form-row">
			<div class="form-group col-md-3">
			 <label for="inputState">Resume [Max size: 2MB]</label>
			  <input type="file" name="pResume" accept="application/pdf" class="form-control" id="pResume">
			  
			</div>
		  </div>
		<div class="form-row">
			<div class="form-group col-md-3">
			</div>
			<div class="form-group col-md-3">
			 <label for="inputState">Photo [Max size: 1MB]</label>
			<input type="file" name="imgInp" accept="image/*" class="form-control" id="imgInp" value="<?php echo $pieces[1]; ?>">
			</div>
			<div class="form-group col-md-3">
				<span id="profImage"><img id="blah" width="150px" height="130px" src="profile_images/<?php echo $profile_img; ?>" ></span>
			</div>
			<div class="form-group col-md-3">
			 <label for="inputState"><br/><br/><br/></label> 
				 <button type="button" class="btn btn-next">Save</button>
				<button type="button" class="btn btn-cancel">Cancel</button>
			</div>
			<div class="form-group col-md-3">
			   <label><span id="uploadResume"><?php echo $profile_pdf; ?></span></label>
			</div>
		  </div>
		  
		  <div class="form-row">
		  <div class="form-group col-md-8">
			
			</div>
			
		  </div>
		  <div class="form-row">
		
			
		  </div>
		 </fieldset>

		

		</div>
	<div id="snackbar"></div>
    </div> <!-- /container -->
	</form>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    
    <script src="https://getbootstrap.com/docs/3.4/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://getbootstrap.com/docs/3.4/assets/js/ie10-viewport-bug-workaround.js"></script>
	
	<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap.min.js"></script>
	
	<script>
	imgInp.onchange = evt => {
		$('#profImage').css('display', 'block');
	  const [file] = imgInp.files
	  if (file) {
		blah.src = URL.createObjectURL(file)
	  }
	}
		
	
  $(document).ready(function () {
	  
	  
    $('.registration-form fieldset:first-child').fadeIn('slow');

    $('.registration-form input[type="text"]').on('focus', function () {
        $(this).removeClass('input-error');
    });
	 $('.registration-form input[type="number"]').on('focus', function () {
        $(this).removeClass('input-error');
    });

    // next step
    $('.registration-form .btn-next').on('click', function () {
		var ferror=0;
		var updaterow = "<?php echo $pieces[0]; ?>";
	$('#pName').css("border", "1px solid black");
	$('#pFName').css("border", "1px solid black");
	$('#pDOB').css("border", "1px solid black");
	$('#pMobile').css("border", "1px solid black");
	$('#pDoorNo').css("border", "1px solid black");
	$('#pAddLine1').css("border", "1px solid black");
	$('#pAddLine2').css("border", "1px solid black");
	$('#pAddLine3').css("border", "1px solid black");
	$('#pCity').css("border", "1px solid black");
	$('#pState').css("border", "1px solid black");
	$('#pPinCode').css("border", "1px solid black");
	$('#pAadhar').css("border", "1px solid black");
	$('#pLanguage').css("border", "1px solid black");
	$('#pHeight').css("border", "1px solid black");
	$('#pRelation').css("border", "1px solid black");
	$('#imgInp').css("border", "1px solid black");
	$('#pIndustryAll').css("border", "0px solid black");
	$('#pWorkLoc1').css("border", "0px solid black");
	$('#pWorkLoc2').css("border", "0px solid black");
	$('#pWorkLoc3').css("border", "0px solid black");
	// New fields
	$('#pResume').css("border", "0px solid black");
	$('#pFatherGPFNo').css("border", "1px solid black");
	$('#pFatherRank').css("border", "1px solid black");
	$('#pFatherGradeNo').css("border", "1px solid black");
	$('#pFatherStation').css("border", "1px solid black");
	$('#pFatherMobile').css("border", "1px solid black");
	$('#pDistrict').css("border", "1px solid black");
	
	
	// fetch value
	
	pName=$('#pName').val();
	pFName=$('#pFName').val();
	pDOB=$('#pDOB').val();
	pMobile=$('#pMobile').val();
	pDoorNo=$('#pDoorNo').val();
	pAddLine1=$('#pAddLine1').val();
	pAddLine2=$('#pAddLine2').val();
	pAddLine3=$('#pAddLine3').val();
	pCity=$('#pCity').val();
	pState=$('#pState').val();
	pPinCode=$('#pPinCode').val();
	pAadhar=$('#pAadhar').val();
	pLanguage=$('#pLanguage').val();
	pHeight=$('#pHeight').val();
	pRelation=$('#pRelation').val();
	// pIndustry = $('#pIndustry').val(); 
	// pWorkLoc = $('#pWorkLoc').val(); 
	var pIndustry="";
	$.each($("input[name='pIndustry']:checked"), function(){
		pIndustry = pIndustry+"|"+$(this).val();
	});
	
	var pWorkLoc=$('#pWorkLoc1').val()+"|"+$('#pWorkLoc2').val()+"|"+$('#pWorkLoc3').val();
	pFatherGPFNo=$('#pFatherGPFNo').val();
	pFatherRank=$('#pFatherRank').val();
	pFatherGradeNo=$('#pFatherGradeNo').val();
	pFatherStation=$('#pFatherStation').val();
	pFatherMobile=$('#pFatherMobile').val();
	pDistrict=$('#pDistrict').val();
	
	if (pName=="") {  $('#pName').css("border", "1px solid red"); ferror=1}
	if (pFName=="") {  $('#pFName').css("border", "1px solid red"); ferror=1}
	if (pDOB=="") {  $('#pDOB').css("border", "1px solid red"); ferror=1}
	if (pMobile=="") {  $('#pMobile').css("border", "1px solid red"); ferror=1}
	if (pMobile.length!=10) {  $('#pMobile').css("border", "1px solid red"); ferror=1}
	if (pDoorNo=="") {  $('#pDoorNo').css("border", "1px solid red"); ferror=1}
	if (pAddLine1=="") {  $('#pAddLine1').css("border", "1px solid red"); ferror=1}
	if (pAddLine2=="") {  $('#pAddLine2').css("border", "1px solid red"); ferror=1}
	if (pCity=="") {  $('#pCity').css("border", "1px solid red"); ferror=1}
	if (pState=="") {  $('#pState').css("border", "1px solid red"); ferror=1}
	if (pPinCode=="") {  $('#pPinCode').css("border", "1px solid red"); ferror=1}
	if (pAadhar=="") {  $('#pAadhar').css("border", "1px solid red"); ferror=1}
	if (pLanguage=="") {  $('#pLanguage').css("border", "1px solid red"); ferror=1}
	if (pHeight=="") {  $('#pHeight').css("border", "1px solid red"); ferror=1}
	if (pRelation==0) {  $('#pRelation').css("border", "1px solid red"); ferror=1}
	if (updaterow=="")
	{
		if ($('#imgInp')[0].files.length==0) {  $('#imgInp').css("border", "1px solid red"); ferror=1}
		//if ($('#pResume')[0].files.length==0) {  $('#pResume').css("border", "1px solid red"); ferror=1}
	}
	if (($('#pWorkLoc1').val()==0)&&($('#pWorkLoc2').val()==0)&&($('#pWorkLoc3').val()==0)) {  $('#pWorkLoc1').css("border", "1px solid red"); ferror=1; }
	if (pIndustry=="") {  $('#pIndustryAll').css("border", "1px solid red"); ferror=1; }
	
	if (pFatherGPFNo=="") {  $('#pFatherGPFNo').css("border", "1px solid red"); ferror=1; }
	if (pFatherRank=="") {  $('#pFatherRank').css("border", "1px solid red"); ferror=1; }
	if (pFatherGradeNo=="") {  $('#pFatherGradeNo').css("border", "1px solid red"); ferror=1; }
	if (pFatherStation=="") {  $('#pFatherStation').css("border", "1px solid red"); ferror=1; }
	if (pFatherMobile=="") {  $('#pFatherMobile').css("border", "1px solid red"); ferror=1; }
	if (pFatherMobile.length!=10) {  $('#pFatherMobile').css("border", "1px solid red"); ferror=1; }
	if (pDistrict==0) {  $('#pDistrict').css("border", "1px solid red"); ferror=1; }
	
	
    if (ferror) {
		var x = document.getElementById("snackbar");
		x.className = "show";
		$("#snackbar").html('Fill mandatory fields');
		$("#snackbar").css('background-color','#DF2909');
		$("#snackbar").css('color','#FFFFFF');
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
		return false;
	}
	var x = document.getElementById("snackbar");
	x.className = "show";
	$("#snackbar").html('Please wait.....');
	$("#snackbar").css('background-color','#FAFD23');
	$("#snackbar").css('color','#161615');
	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
	
		 $.ajax({
          url : 'login_ajax.php',
          type : 'POST',
          data : {
			'pName' : pName,
			'pFName' : pFName,
			'pDOB' : pDOB,
			'pMobile' : pMobile,
			'pDoorNo' : pDoorNo,
			'pAddLine1' : pAddLine1,
			'pAddLine2' : pAddLine2,
			'pAddLine3' : pAddLine3,
			'pCity' : pCity,
			'pState' : pState,
			'pPinCode' : pPinCode,
			'pAadhar' : pAadhar,
			'pLanguage' : pLanguage,
			'pHeight' : pHeight,
			'pRelation' : pRelation,
			'pWorkLoc' : pWorkLoc,
			'pIndustry' : pIndustry,
			'pFatherGPFNo' : pFatherGPFNo,
			'pFatherRank' : pFatherRank,
			'pFatherGradeNo' : pFatherGradeNo,
			'pFatherStation' : pFatherStation,
			'pFatherMobile' : pFatherMobile,
			'pDistrict' : pDistrict,
			'updaterow' : updaterow,
			'zproflag' : 109091
          },
          dataType:'json',
          success : function(data) {
			  if (data['status']==0)
              {
				  // Upload image and then show save message
				  if (($('#imgInp')[0].files.length==0)&&($('#pResume')[0].files.length==0))
				  {
					    window.location.href="admin.php";
						return;
					    $("#snackbar").html('Saved Successfully..!');
						$("#snackbar").css('background-color','#87C261');
						$("#snackbar").css('color','#FFFFFF');
				  }
				  else
				  {
				 var property=$('#imgInp').prop('files')[0];
				 var resumeProp=$('#pResume').prop('files')[0];
				  var form_data = new FormData();
				  form_data.append("img",property); 
				  form_data.append("res",resumeProp); 
				  $.ajax({
					 url:"upload_image.php",
					 method:"POST",
					 data:form_data,
					 contentType:false,
					 cache:false,
					 processData:false,
					 success:function(data)
					 {
						 window.location.href="admin.php";
						 return;
						$("#snackbar").html('Saved Successfully..!');
						$("#snackbar").css('background-color','#87C261');
						$("#snackbar").css('color','#FFFFFF');
					 },
					error : function(request,error)
					{
						var x = document.getElementById("snackbar");
						x.className = "show";
						$("#snackbar").html('Failed to upload photo..!!');
						$("#snackbar").css('background-color','#DF2909');
						$("#snackbar").css('color','#FFFFFF');
						setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);

					}
				  });
				  }
				  
				  
				
              }
              else
              {
				$("#snackbar").html('Fill mandatory fields');
				$("#snackbar").css('background-color','#DF2909');
				$("#snackbar").css('color','#FFFFFF');
				}
				var x = document.getElementById("snackbar");
				  x.className = "show";
				  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
					clearPrompts();
			  
              
          },
          error : function(request,error)
          {
			   
            var x = document.getElementById("snackbar");
			x.className = "show";
			$("#snackbar").html('Failed to save data!!');
			$("#snackbar").css('background-color','#DF2909');
			$("#snackbar").css('color','#FFFFFF');
			setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
				
          }
      });
		
		
		
		
		/*
        var parent_fieldset = $(this).parents('fieldset');
        var next_step = true;

        parent_fieldset.find('input[type="text"],input[type="email"]').each(function () {
            if ($(this).val() == "") {
                $(this).addClass('input-error');
                next_step = false;
            } else {
                $(this).removeClass('input-error');
            }
        });
		var next_step = true;
        if (next_step) {
            parent_fieldset.fadeOut(500, function () {
                $(this).next().fadeIn(500);
            });
        }
		*/

    });

    // previous step
    $('.registration-form .btn-previous').on('click', function () {
        $(this).parents('fieldset').fadeOut(500, function () {
            $(this).prev().fadeIn(500);
        });
    });

    // submit
    $('.registration-form').on('submit', function (e) {

        $(this).find('input[type="text"],input[type="email"]').each(function () {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            } else {
                $(this).removeClass('input-error');
            }
        });

    });

   
});
  
	
	$('.btn-cancel').click(function() {
	window.location.replace("admin.php");
});

function clearPrompts()
{
	$('#pName').val('');
	$('#pFName').val('');
	$('#pDOB').val('');
	$('#pMobile').val('');
	$('#pDoorNo').val('');
	$('#pAddLine1').val('');
	$('#pAddLine2').val('');
	$('#pAddLine3').val('');
	$('#pCity').val('');
	$('#pState').val('');
	$('#pPinCode').val('');
	$('#pAadhar').val('');
	$('#pLanguage').val('');
	$('#pHeight').val('');
	$('#pRelation').val(0);
	$('#imgInp').val('');
	$('#profImage').css('display', 'none');
	$('#uploadResume').css('display', 'none');
	// New fields
	$('#pResume').val('');
	$('#pFatherGPFNo').val('');
	$('#pFatherRank').val('');
	$('#pFatherGradeNo').val('');
	$('#pFatherStation').val('');
	$('#pFatherMobile').val('');
	$('#pDistrict').val(0);
	$.each($("input[name='pIndustry']"), function(){
		$(this).attr('checked',false);
	});
	$.each($("input[name='pWorkLoc']"), function(){
		$(this).attr('checked',false);
	});
	
	
}
</script>
  </body>
</html>
