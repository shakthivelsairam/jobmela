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
    
    <title>Skill Portal</title>
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
.small-txt-box {
	padding-right: 5px!important;
	padding-left: 2px!important;
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
            <li><a class="active" href="admin.php">Family</a></li>
             <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
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
		    $devCount = "select rowid,link_skill_skill,level from skill_interested where link_family_family=?";
			$stmt = $conn->prepare($devCount);
			$ress = $stmt->execute([$edirow]);
			$rec="^^^^";
			$totRows=$stmt->rowCount();
			if ($totRows==0) $totRows=1;
			
		  ?>
		   </br> </br>
		  <h3>Educational Information</h3>
		 
		  <div class="row singleRow">
		  <?php for ($k=0;$k<$totRows;$k++) 
		  { 	
				$rec="^^^^^^^^^^^^^^^^^^^^^^^^^^^";
				$rec1 = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
				if ($rec1!="") $rec=$rec1[0]."^".$rec1[1]."^".$rec1[2];
				$p=explode("^",$rec);
				//print_r($p);
				?>
		  <span class="removeRow" id="removeRow" name="removeRow">
			<div class="col-xs-1 small-txt-box" style="width:0%">
			 <label for="inputCity"></label>
			<input type="hidden" name="pSno" id="pSno" class="form-control" placeholder="S.No"  value="<?php echo $k+1; ?>" />  
			</div>
			<div class="col-xs-2 small-txt-box">
			 <label for="inputCity">Skill title</label>
			<select id="pEduLevel" class="form-control" name="pEduLevel">
			<option value=0>--Select--</option>
			<?php
			 $devCoun1t = "select rowid,name from skill";
			$stmt23 = $conn->prepare($devCoun1t);
			$stmt23->execute();
			while ($rowx = $stmt23->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
			{
				?> <option value="<?php echo $rowx[0]; ?>" <?php if ($p[1]==$rowx[0]) echo " selected"; ?>><?php echo $rowx[1]; ?></option> <?php
			}
			?>
			</select>
			</div>
			<div class="col-xs-2 small-txt-box">
			<label for="inputCity">Level</label>
			<select id="pLevel" class="form-control" name="pLevel">
			<option value=0>--Select--</option>
			<option value=1 <?php if ($p[2]==1) echo "selected"; ?>>Entry</option>
			<option value=2 <?php if ($p[2]==2) echo "selected"; ?>>Intermediate</option>
			<option value=3 <?php if ($p[2]==3) echo "selected"; ?>>Expert</option>
			</select>
			</div>
			<div class="col-xs-1 small-txt-box purshingDiv" style="width:5%">
			<label for="inputCity"><br></br></br></label>
			<?php if ($k>0) echo '&nbsp;&nbsp;<img src="assets/img/delete_icon.png" onClick="fDelRow(this)" style="vertical-align: baseline;" heigth="20px" width="20px">'; ?>
			</div>
		  <?php if ($k!=($totRows-1)) echo "<br><br><br><br>"; ?>
			</span>
		  <?php } ?> 
		</div>
		<div class="form-row">
		<div class="col-xs-12 add-btn" style="border:0px solid red;float:right;width:55%">
		<i class='fa fa-plus fa-2x add-row' title='Add New Row' aria-hidden='true' style='color:green'></i>
		</div>

		</div>
		
		</br> </br>
		 <div class="form-row">
		  <div class="form-group">
			<button type="button" class="btn btn-next">Save</button>
			<button type="button" class="btn btn-cancel">Cancel</button>
			</div>
			
		  </div>
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
	var totRows="<?php echo $k; ?>";
	totRows=Number(totRows);
	var singRow = '<span class="removeRow" id="removeRow" name="removeRow"><br><br><br><br> <div class="col-xs-1 small-txt-box" style="width:0%">';
	singRow = singRow+'<label for="inputCity"></label><input type="hidden" name="pSno" id="pSno" class="form-control" placeholder="S.No"  value="" />  ';
	singRow = singRow+'</div><div class="col-xs-2 small-txt-box"><label for="inputCity">Skill title</label><select id="pEduLevel" class="form-control" name="pEduLevel">';
	singRow = singRow+'<option value=0>--Select--</option>';
	<?php
	 $devCoun1t = "select rowid,name from skill";
	$stmt23 = $conn->prepare($devCoun1t);
	$stmt23->execute();
	while ($rowx = $stmt23->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
	{
		?> 
		singRow = singRow+'<option value="<?php echo $rowx[0]; ?>"><?php echo $rowx[1]; ?></option>';
		<?php
	}
	?>
	singRow = singRow+'</select></div><div class="col-xs-2 small-txt-box"><label for="inputCity">Level</label>';
	singRow = singRow+'<select id="pLevel" class="form-control" name="pLevel"><option value=0>--Select--</option>';
	singRow = singRow+'<option value=1>Entry</option><option value=3>Intermediate</option><option value=3>Expert</option>';
	singRow = singRow+'</select></div>';
	
	singRow = singRow+'<div class="col-xs-1 small-txt-box purshingDiv" style="width:5%"><label for="inputCity"><br></br></br></label> &nbsp;&nbsp;<img src="assets/img/delete_icon.png" onClick="fDelRow(this)" style="vertical-align: baseline;" heigth="20px" width="20px"></div>';
	
	

	
	function fDelRow(obj)
	{
		//alert(5)
		//$(obj).parents('.removeRow').remove();
		// $('.obj').find(".removeRow").slice(rowid).remove();
		$(obj).closest(".removeRow").remove();
		//var oobj = document.getElementsByName("removeRow");
		//alert(obj.length);
		totRows=totRows-1;
		
	}
	function frowNum(rownum)
	{
		var isEmpty=0;
		var pSno = document.getElementsByName("pSno");
		var pEduLevel = document.getElementsByName("pEduLevel");
		var pLevel = document.getElementsByName("pLevel");
		pEduLevel[rownum].style.border="1px solid #ccc"; 
		pLevel[rownum].style.border="1px solid #ccc";
		// First make it black then check 
		pSno[rownum].style.border="1px solid #ccc";
		pEduLevel[rownum].style.border="1px solid #ccc"; 
		pLevel[rownum].style.border="1px solid #ccc";
		
		//if (pSno[rownum].value=="") { pSno[rownum].style.border="1px solid red"; isEmpty=1; }
		if (pEduLevel[rownum].value==0) { pEduLevel[rownum].style.border="1px solid red"; isEmpty=1; }
		if (pLevel[rownum].value==0) { pLevel[rownum].style.border="1px solid red"; isEmpty=1; }
		
		return isEmpty;
		
	}
  $(document).ready(function () {
	  
	  
    $('.registration-form fieldset:first-child').fadeIn('slow');

    $('.registration-form input[type="text"]').on('focus', function () {
        $(this).removeClass('input-error');
    });
	 $('.registration-form input[type="number"]').on('focus', function () {
        $(this).removeClass('input-error');
    });
	
	
	$('.add-row').on('click',function () {
		$('.singleRow').append(singRow);
		totRows=totRows+1;
		if (totRows==5)
		{
			$('.add-btn').css('display','none');
		}
	});
	

    // next step
    $('.btn-next').on('click', function () {
		var ferror=0;
		var pSno = document.getElementsByName("pSno");
		var pEduLevel = document.getElementsByName("pEduLevel");
		var pLevel = document.getElementsByName("pLevel");
		var totRecs = pSno.length;
		for (cnt=0;cnt<totRecs;cnt++)
		{
			if (frowNum(cnt)) ferror=1;
		}
		if ((ferror)||(cnt==0)) {
			var x = document.getElementById("snackbar");
			x.className = "show";
			$("#snackbar").html('Fill mandatory fields');
			$("#snackbar").css('background-color','#DF2909');
			$("#snackbar").css('color','#FFFFFF');
			setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
			return false;
		}
		pEduLeveltxt="";
		pLeveltxt="";

		for (cnt=0;cnt<totRecs;cnt++)
		{
			pEduLeveltxt=pEduLeveltxt+"|"+pEduLevel[cnt].value;
			pLeveltxt=pLeveltxt+"|"+pLevel[cnt].value;
		}
		updaterow=0;
		familyRow = "<?php echo $edirow; ?>";
		 $.ajax({
          url : 'login_ajax.php',
          type : 'POST',
          data : {
			'pEduLevel' : pEduLeveltxt,
			'pLevel' : pLeveltxt,
			'totalRows' : totRecs,
			'familyRow' : familyRow,
			'zproflag' : 90182612
          },
          dataType:'json',
          success : function(data) {
			  //alert(data['msg']);
			   window.location.href="admin.php";
				  return;
			  var x = document.getElementById("snackbar");
				x.className = "show";
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
              if (data['status']==0)
              {
				   $("#snackbar").html('Saved Successfully..!');
						$("#snackbar").css('background-color','#87C261');
						$("#snackbar").css('color','#FFFFFF');
              }
              else
              {
				 $("#snackbar").html('Failed to save..!');
				$("#snackbar").css('background-color','#DF2909');
				$("#snackbar").css('color','#FFFFFF');
    
              }
			  clearPrompts();
              // clearPrompts();
          },
          error : function(request,error)
          {
			   
             $("#snackbar").html('Failed to save..!');
			$("#snackbar").css('background-color','#DF2909');
			$("#snackbar").css('color','#FFFFFF');
			clearPrompts()
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
  function clearPrompts()
{
	$('.singleRow').html(singRow);
		totRows=0;
		document.getElementsByName("pEduLevel")[0].value="0";
	document.getElementsByName("pFieldStudy")[0].value="";
	document.getElementsByName("pCollege")[0].value="";
	document.getElementsByName("pDistrict")[0].value="";
	document.getElementsByName("pFromDate")[0].value="";
	document.getElementsByName("pToDate")[0].value="";
	document.getElementsByName("pMark")[0].value="";
}
</script>
  </body>
</html>
