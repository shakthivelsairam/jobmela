<?php
require "session_user_utils.php";
$userid="";
if (!(isset($_SESSION["isLogin"])))
{
  $url = './error-page.php';
  header("location: ".$url); // for two folders
}
$userid=$_SESSION['useridref'];
// echo "<br><br><br><br>".$userid;
$edirow=0;
if (isset($_REQUEST['sessionid']))
{
	$edirow=substr($_REQUEST['sessionid'],18);
}
require "connection.php";
// Create connection
try {
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
echo "Unable to process your request, contact admin";
return;
}
$devCount = "select rowid,userid,username,companyname,email,mobile,remarks,description,designation from companyuser where rowid=?";
$stmt = $conn->prepare($devCount);
$stmt->execute([$userid]);
$rec="^^^^^^^^^^^^^^";
if ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
$rec=$row[0]."^".$row[1]."^".$row[2]."^".$row[3]."^".$row[4]."^".$row[5]."^".$row[6]."^".$row[7]."^".$row[8];
}
$pieces = explode("^", $rec);
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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <title>Portal</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/3.4/dist/css/bootstrap.min.css" rel="stylesheet">
	 <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://getbootstrap.com/docs/3.4/dist/js/bootstrap.min.js"></script>
  <style>
  label {
  color:#fff;
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
  </head>

  <body style="background-color:#75754F">

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
            <li class="active"><a href="#">My Proflie</a></li>
			<li class=""><a href="<?php if ($row[2]!="") echo 'search.php'; else echo '#'; ?>" class="searchresume">Search Resumes</a></li>
		 </ul>
		 <ul class="nav navbar-nav" style="float:right">
			<li class="">
				<a href="#">Welcome <?php if ($row[2]=="") { echo "Guest"; } else { echo $row[1]; } ?> </a>
			</li>
             <li class="float:right"><a href="logout.php">Logout</a></li>
         
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<br/><br/>
	
    <div class="container mt-5 mb-5">
	<center><h3><label>Basic Information</label></h3></center>
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-3">
				<label>Your Full Name</label>
				<input type="text" class="form-control" id="pName" placeholder="Your Full Name" value="<?php echo $pieces[2]; ?>"> 
		</div>
		<div class="col-md-3">
				<label>Your Designation</label>
				<input type="text" class="form-control" id="pJobTitle" placeholder="Your Designation" value="<?php echo $pieces[8]; ?>">  
		</div>
		 <div class="col-md-2">
				<label>Company Name</label>
				<input type="text" class="form-control" id="pOrgName" placeholder="Company Name" value="<?php echo $pieces[3]; ?>"> 
		</div>
		 <div class="col-md-2">
				<label>Email</label>
				<input type="text" class="form-control" id="pEmail" placeholder="Email address" value="<?php echo $pieces[4]; ?>"> 
		</div>
		 <div class="col-md-2">
				<label>Your Mobile Number</label>
				<input type="text" class="form-control" id="pMobile" placeholder="10 Digit mobile number" value="<?php echo $pieces[5]; ?>">  
		</div>
    </div>
	<br/>
	 <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-6">
				<label>Description</label>
				<textarea class="form-control" id="pDesc" rows="5" placeholder="What kind of resources you are looking for ?"><?php echo $pieces[7]; ?> </textarea>
 
		</div>
		 <div class="col-md-6">
				<label>Remarks</label>
				<textarea class="form-control" id="pRemarks" rows="5" placeholder="Any comments ?"> <?php echo $pieces[6]; ?></textarea>

		</div>
		
    </div>
	<br/>
	 <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-8">
				<button type="button" class="btn btn-primary saveUpdate"><?php if ($pieces[0]=="") echo "Save"; else echo "Update"; ?></button>
					<button type="button" class="btn btn-primary btnCancel">Clear</button>

		</div>
		
    </div>
	   <div id="snackbar"></div>
</div>


<script>
$('.btnCancel').click(function() {
	window.location.replace("basicinfo.php");
});
$('.saveUpdate').click(function() {
    var ferror = 0;
	// gpfNo,pName,sltRank,adharNo,sltStation,dob,doj,doe
    $('#pName').css("border", "1px solid black");
	$('#pJobTitle').css("border", "1px solid black");
	$('#pOrgName').css("border", "1px solid black");
	$('#pEmail').css("border", "1px solid black");
	$('#pMobile').css("border", "1px solid black");
	
	$('#pDesc').css("border", "1px solid black");
	$('#pRemarks').css("border", "1px solid black");
	
	
	var pName = $('#pName').val();
	var pJobTitle = $('#pJobTitle').val();
    var pOrgName = $('#pOrgName').val();
	var pEmail = $('#pEmail').val();
	var pMobile = $('#pMobile').val();
	var pDesc = $('#pDesc').val();
	var pRemarks = $('#pRemarks').val();
	
	
    if (pName === '') {  $('#pName').css("border", "1px solid red"); ferror=1}
	if (pJobTitle === '') {  $('#pJobTitle').css("border", "1px solid red"); ferror=1}
    if (pOrgName == '') {  $('#pName').css("border", "1px solid red"); ferror=1}
	if (pEmail == '') {  $('#sltRank').css("border", "1px solid red"); ferror=1}
	if (pMobile == '') {  $('#pMobile').css("border", "1px solid red"); ferror=1}
	if (pDesc == '') {  $('#pDesc').css("border", "1px solid red"); ferror=1}
	if (pRemarks == '') {  $('#pRemarks').css("border", "1px solid red"); ferror=1}
    
	 if (ferror) {
		var x = document.getElementById("snackbar");
		x.className = "show";
		$("#snackbar").html("Please fill mandatory fields");
		$("#snackbar").css('background-color','#DF2909');
		$("#snackbar").css('color','#FFFFFF');
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
		return false;
	}
	
	
	userrow = '<?php echo $pieces[0] ;?>';
	
    //
    // save the user details and trigger email
    $.ajax({
          url : 'login_ajax.php',
          type : 'POST',
          data : {
              'pName' : pName,
			  'pJobTitle' : pJobTitle,
              'pOrgName' : pOrgName,
			  'pEmail' : pEmail,
			  'pMobile' : pMobile,
			  'pDesc' : pDesc,
			  'pRemarks' : pRemarks,
			  'userrow' : userrow,
              'zproflag' : 77665
          },
          dataType:'json',
          success : function(data) {
              if (data['status']==0)
              {
				  $('.searchresume').attr("href", "search.php");
				var x = document.getElementById("snackbar");
				x.className = "show";
				$("#snackbar").html("Details updated successfully");
				$("#snackbar").css('background-color','green');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
              }
              else
              {
                $("#errormessage1").css('display', 'block');
				$("#errormessage1").css('color', 'red');
                $('#errormessage1').html(data['msg']);
                $('#errormessage1').delay(6000).fadeOut();
              }
              // clearPrompts();
          },
          error : function(request,error)
          {
			   
            $("#errormessage1").css('display', 'block');
			$("#errormessage1").css('color', 'red');
            $('#errormessage1').html("Failed to save, please contact admin");
            $('#errormessage1').delay(6000).fadeOut();
          }
      });
    //
    return false;
  });
</script>
  </body>
</html>
