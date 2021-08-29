<?php
require "session_user_utils.php";
if (!(isset($_SESSION["isAdmin"])))
{
  $url = './error-page.php';
  header("location: ".$url); // for two folders
}
$edirow=0;
if (isset($_REQUEST['sessionid']))
{
	$edirow=substr($_REQUEST['sessionid'],18);
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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <title>Portal</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/3.4/dist/css/bootstrap.min.css" rel="stylesheet">

   
  </head>

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
            <li class="active"><a href="#">Master</a></li>
            <li><a href="#">Family</a></li>
             <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
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
		    $devCount = "select gpfno,name,rank_rank_link,aadharno,station_presentstation_link,dob,doj,doe,department_department_link from master where rowid=?";
			$stmt = $conn->prepare($devCount);
			$stmt->execute([$edirow]);
			$rec="^^^^^^^^^^^^^^";
			if ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
				$rec=$row[0]."^".$row[1]."^".$row[2]."^".$row[3]."^".$row[4]."^".$row[5]."^".$row[6]."^".$row[7]."^".$row[8];
				
			}
			$pieces = explode("^", $rec);
		  
		  ?>
		  <br/>
		
		 
		  <div class="form-row">
			<div class="form-group col-md-4">
			  <label for="inputCity">GPF Number</label>
			  <input type="text" class="form-control" <?php if ($pieces[0]!="") echo "disabled"; ?> id="gpfNo" value="<?php echo $pieces[0]; ?>">
			</div>
			<div class="form-group col-md-4">
			  <label for="inputState">Name</label>
				<input type="text" class="form-control" id="pName" value="<?php echo $pieces[1]; ?>">
			</div>
			<div class="form-group col-md-4">
			  <label for="inputState">Rank</label>
				<select id="sltRank" class="form-control">
					<option value=0>Choose...</option>
					<?php 
					 $ranks = "select rowid,name from rank";
					$rankstmt = $conn->prepare($ranks);
					$rankstmt->execute();
					while ($rnks = $rankstmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
						$slt="";
						if ($rnks[0]==$pieces[2]) $slt="selected";	
						echo "<option value=".$rnks[0]." ".$slt.">".$rnks[1]."</option>";
					}
					?>
				 </select>
			</div>
		  </div>

		<div class="form-row">
			<div class="form-group col-md-4">
			  <label for="inputCity">Aadhar Number</label>
			  <input type="text" class="form-control" id="adharNo" value="<?php echo $pieces[3]; ?>">
			</div>
			<div class="form-group col-md-4">
			  <label for="inputState">Station</label>
				<select id="sltStation" class="form-control">
					<option value=0>Choose...</option>
					<?php 
					 $ranks = "select rowid,name from station";
					$rankstmt = $conn->prepare($ranks);
					$rankstmt->execute();
					while ($rnks = $rankstmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
						$slt="";
						if ($rnks[0]==$pieces[4]) $slt="selected";	
						echo "<option value=".$rnks[0]." ".$slt.">".$rnks[1]."</option>";
					}
					?>
				 </select>
			</div>
			<div class="form-group col-md-4">
			  <label for="inputZip">Date of Birth</label>
			   <input type="date" class="form-control" id="dob" name="date" value="<?php echo $pieces[5]; ?>"/>
			</div>
		  </div>
		  
		<div class="form-row">
			<div class="form-group col-md-4">
			  <label for="inputCity">Date of Joining</label>
			  <input type="date" class="form-control" name="date" id="doj" value="<?php echo $pieces[6]; ?>"/>
			</div>
			<div class="form-group col-md-4">
			  <label for="inputState">Date of Enrollment</label>
				<input type="date" class="form-control" name="date" id="doe" value="<?php echo $pieces[7]; ?>"/>
			</div>
			<div class="form-group col-md-4">
			  <label for="inputState">Department</label>
				<select id="sltDept" class="form-control">
					<option value=0>Choose...</option>
					<?php 
					 $ranks = "select rowid,name from department";
					$rankstmt = $conn->prepare($ranks);
					$rankstmt->execute();
					while ($rnks = $rankstmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
						$slt="";
						if ($rnks[0]==$pieces[8]) $slt="selected";	
						echo "<option value=".$rnks[0]." ".$slt.">".$rnks[1]."</option>";
					}
					?>
				 </select>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4"></div>
				<div class="form-group col-md-5">
					<button type="button" class="btn btn-primary saveUpdate"><?php if ($pieces[0]=="") echo "Save"; else echo "Update"; ?></button>
					<button type="button" class="btn btn-primary btnCancel">Cancel</button>
				</div>
				<div class="form-group col-md-3"></div>
			</div>
			<br/><br/>
				<div class="form-row">
				<div class="form-group col-md-4"></div>
				<div class="form-group col-md-6" id="errormessage1">
				</div>
			</div>
		  </div>
	
		  <table class="table table-striped table-bordered" style="width:100%">
		  
				</table>

		</div>

    </div> <!-- /container -->


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
	$(document).ready(function() {
    $('#example').DataTable();
	} );
	</script>
<script>
$('.btnCancel').click(function() {
	window.location.replace("dashboard.php");
});
$('.saveUpdate').click(function() {
    var ferror = 0;
	// gpfNo,pName,sltRank,adharNo,sltStation,dob,doj,doe
    $('#gpfNo').css("border", "1px solid black");
	$('#pName').css("border", "1px solid black");
	$('#sltRank').css("border", "1px solid black");
	$('#adharNo').css("border", "1px solid black");
	$('#sltStation').css("border", "1px solid black");
	$('#dob').css("border", "1px solid black");
	$('#doj').css("border", "1px solid black");
	$('#doe').css("border", "1px solid black");
	$('#sltDept').css("border", "1px solid black");
	
	var gpfNo = $('#gpfNo').val();
    var pName = $('#pName').val();
	var sltRank = $('#sltRank').val();
	var adharNo = $('#adharNo').val();
	var sltStation = $('#sltStation').val();
	var dob = $('#dob').val();
	var doj = $('#doj').val();
	var doe = $('#doe').val();
	var sltDept = $('#sltDept').val();
    if (gpfNo === '') {  $('#gpfNo').css("border", "1px solid red"); ferror=1}
    if (pName === '') {  $('#pName').css("border", "1px solid red"); ferror=1}
	if (sltRank == 0) {  $('#sltRank').css("border", "1px solid red"); ferror=1}
	if (adharNo === '') {  $('#adharNo').css("border", "1px solid red"); ferror=1}
	if (sltStation == 0) {  $('#sltStation').css("border", "1px solid red"); ferror=1}
	if (dob === '') {  $('#dob').css("border", "1px solid red"); ferror=1}
	if (doj === '') {  $('#doj').css("border", "1px solid red"); ferror=1}
	if (doe === '') {  $('#doe').css("border", "1px solid red"); ferror=1}
	if (sltDept === '') {  $('#sltDept').css("border", "1px solid red"); ferror=1}
    if (ferror) return false;
	
	userrow = '<?php echo $edirow ;?>';
	
    //
    // save the user details and trigger email
    $.ajax({
          url : 'login_ajax.php',
          type : 'POST',
          data : {
              'gpfNo' : gpfNo,
              'pName' : pName,
			  'sltRank' : sltRank,
			  'adharNo' : adharNo,
			  'sltStation' : sltStation,
			  'dob' : dob,
			  'doj' : doj,
			  'doe' : doe,
			  'sltDept' : sltDept,
			  'userrow' : userrow,
              'zproflag' : 77665
          },
          dataType:'json',
          success : function(data) {
              if (data['status']==0)
              {
				$("#errormessage1").css('display', 'block');
				$("#errormessage1").css('color', 'green');
                $('#errormessage1').html(data['msg']);
                $('#errormessage1').delay(6000).fadeOut();
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
