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
    
    <title>Job Experience</title>
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
            <li><a class="active" href="#">Family</a></li>
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
		    $devCount = "select rowid,link_family_family,link_job_job,link_city_city,link_company_company,description,from_period,to_period,persuing from jobexp where link_family_family=?";
			$stmt = $conn->prepare($devCount);
			$ress = $stmt->execute([$edirow]);
			$rec="^^^^^^^^^^^^^^^^^^^^^^^^^^^";
			$totRows=$stmt->rowCount();
			if ($totRows==0) $totRows=1;
			
		  ?>
		   </br> </br>
		  <h3>Professional Experience</h3>
		 
		  <div class="row singleRow">
		  <?php for ($k=0;$k<$totRows;$k++) 
		  { 	
				$rec="^^^^^^^^^^^^^^^^^^^^^^^^^^^";
				$rec1 = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
				if ($rec1!="") $rec=$rec1[0]."^".$rec1[1]."^".$rec1[2]."^".$rec1[3]."^".$rec1[4]."^".$rec1[5]."^".$rec1[6]."^".$rec1[7]."^".$rec1[8];
				$p=explode("^",$rec);
				///print_r($p);
				?>
		  <span class="removeRow" id="removeRow" name="removeRow">
			<div class="col-xs-1 small-txt-box" style="width:0%">
			 <label for="inputCity"></label>
			<input type="hidden" name="pSno" id="pSno" class="form-control" placeholder="S.No"  value="<?php echo $k+1; ?>" />  
			</div>
			<div class="col-xs-2 small-txt-box">
			 <label for="inputCity">Job Title</label>
			<input type="text" name="pEduLevel" id="pEduLevel" class="form-control" placeholder="Job Title"  value="<?php echo $p[2]; ?>" />  
			</div>
			<div class="col-xs-2 small-txt-box" style="width:17%">
			<label for="inputCity">Company</label>
			<input type="text" name="pFieldStudy" id="pFieldStudy" value="<?php echo $p[3]; ?>" class="form-control" placeholder="Company"  />                        
			</div>
			<div class="col-xs-2 small-txt-box" style="width:13%">
			<label for="inputCity">City/District</label>
			<input type="text" name="pCollege" id="pCollege" value="<?php echo $p[4]; ?>" class="form-control" placeholder="District"  />                        
			</div>
			<div class="col-xs-2 small-txt-box" style="width:18%">
			<label for="inputCity">Description</label>
			<input type="text" name="pDistrict" id="pDistrict" value="<?php echo $p[5]; ?>" class="form-control" placeholder="Description"  />                        
			</div>
			<div class="col-xs-2 small-txt-box" style="width:12.5%">
			<label for="inputCity">From date</label>
			<input type="date" name="pFromDate" id="pFromDate" value="<?php echo $p[6]; ?>" class="form-control" max="<?php echo date('Y-m-d'); ?>"  placeholder="From Date"  />                        
			</div>
			<div class="col-xs-2 small-txt-box" style="width:12.5%">
			<label for="inputCity">To date</label>
			<input type="date" name="pToDate" id="pToDate" value="<?php echo $p[7]; ?>" class="form-control" max="<?php echo date('Y-m-d'); ?>"  placeholder="To Date"  />                        
			</div>
			<div class="col-xs-1 small-txt-box purshingDiv" style="width:8%">
			<label for="inputCity">Working here</label>
			<input type="checkbox" name="pPurshing" id="pPurshing" <?php if ($p[8]==1) echo " checked"; ?> style="height:20px;margin-top:8px;width:40%" id="pPurshing"/>                        
			<?php if ($k>0) echo '&nbsp;&nbsp;<img src="assets/img/delete_icon.png" onClick="fDelRow(this)" style="vertical-align: baseline;" heigth="20px" width="20px">'; ?>
			</div>
		  <?php if ($k!=($totRows-1)) echo "<br><br><br><br>"; ?>
			</span>
		  <?php } ?> 
		</div>
		<div class="col-xs-12 add-btn" style="border:0px solid red;float:right;width:5%">
		<i class='fa fa-plus fa-2x add-row' title='Add New Row' aria-hidden='true' style='color:green'></i>
		</div>

		</div>
		</br>
		 <div class="form-row">
		  <div class="form-group">
			<button type="button" class="btn btn-next">Save</button>
			<button type="button" class="btn btn-cancel">Cancel</button>
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
	singRow = singRow+'</div><div class="col-xs-2 small-txt-box"><label for="inputCity">job Title</label><input type="text" name="pEduLevel" id="pEduLevel" class="form-control" placeholder="Job Title"  value="" /> ';
	singRow = singRow+'</div><div class="col-xs-2 small-txt-box" style="width:17%"><label for="inputCity">Company</label>';
	singRow = singRow+'<input type="text" name="pFieldStudy" id="pFieldStudy" value="" class="form-control" placeholder="Company"  />';                        
	singRow = singRow+'</div><div class="col-xs-2 small-txt-box" style="width:13%"><label for="inputCity">City/District</label>';
	singRow = singRow+'<input type="text" name="pCollege" id="pCollege" value="" class="form-control" placeholder="City/District"  /></div>';
	singRow = singRow+'<div class="col-xs-2 small-txt-box" style="width:18%">';
	singRow = singRow+'<label for="inputCity">Description</label>';
	singRow = singRow+'<input type="text" name="pDistrict" id="pDistrict" value="" class="form-control" placeholder="Description"  /></div>';
	singRow = singRow+'<div class="col-xs-2 small-txt-box" style="width:12.5%"><label for="inputCity">From date</label>';
	singRow = singRow+'<input type="date" name="pFromDate" id="pFromDate" value="" class="form-control" max="<?php echo date("Y-m-d"); ?>"  placeholder="Last Name"  /></div>';
	singRow = singRow+'<div class="col-xs-2 small-txt-box" style="width:12.5%"><label for="inputCity">To date</label>';
	singRow = singRow+'<input type="date" name="pToDate" id="pToDate" value="" class="form-control" max="<?php echo date("Y-m-d"); ?>"  placeholder="Last Name"  /></div>';
	singRow = singRow+'<div class="col-xs-1 small-txt-box purshingDiv" style="width:8%"><label for="inputCity">Working here</label>';
	singRow = singRow+'<input type="checkbox" name="pPurshing" id="pPurshing" style="height:20px;margin-top:8px;width:40%" id="pPurshing"/>';
	singRow = singRow+'&nbsp;&nbsp;&nbsp;<img src="assets/img/delete_icon.png" onClick="fDelRow(this)" style="vertical-align: baseline;" heigth="20px" width="20px"></div></span>';


	
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
		var pFieldStudy = document.getElementsByName("pFieldStudy");
		var pCollege = document.getElementsByName("pCollege");
		var pDistrict = document.getElementsByName("pDistrict");
		var pFromDate = document.getElementsByName("pFromDate");
		var pToDate = document.getElementsByName("pToDate");
		//var pMark = document.getElementsByName("pMark");
		var pPurshing = document.getElementsByName("pPurshing");
		// First make it black then check 
		pSno[rownum].style.border="1px solid #ccc";
		pEduLevel[rownum].style.border="1px solid #ccc"; 
		pFieldStudy[rownum].style.border="1px solid #ccc";
		pCollege[rownum].style.border="1px solid #ccc"; 
		pDistrict[rownum].style.border="1px solid #ccc";
		pFromDate[rownum].style.border="1px solid #ccc"; 
		pToDate[rownum].style.border="1px solid #ccc";
		//pMark[rownum].style.border="1px solid #ccc";
		
		
		
		// if (pSno[rownum].value=="") { pSno[rownum].style.border="1px solid red"; isEmpty=1; }
		if (pEduLevel[rownum].value=="") { pEduLevel[rownum].style.border="1px solid red"; isEmpty=1; }
		if (pFieldStudy[rownum].value=="") { pFieldStudy[rownum].style.border="1px solid red"; isEmpty=1; }
		if (pCollege[rownum].value=="") { pCollege[rownum].style.border="1px solid red"; isEmpty=1; }
		if (pDistrict[rownum].value=="") { pDistrict[rownum].style.border="1px solid red"; isEmpty=1; }
		if (pFromDate[rownum].value=="") { pFromDate[rownum].style.border="1px solid red"; isEmpty=1; }
		if (pToDate[rownum].value=="")  { 
			if (!(pPurshing[rownum].checked))
			{
			pToDate[rownum].style.border="1px solid red"; isEmpty=1; 
			}
		}
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
		var pFieldStudy = document.getElementsByName("pFieldStudy");
		var pCollege = document.getElementsByName("pCollege");
		var pDistrict = document.getElementsByName("pDistrict");
		var pFromDate = document.getElementsByName("pFromDate");
		var pToDate = document.getElementsByName("pToDate");
		//var pMark = document.getElementsByName("pMark");
		var pPurshing = document.getElementsByName("pPurshing");
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
		pFieldStudytxt="";
		pCollegetxt="";
		pDistricttxt="";
		pFromDatetxt="";
		pToDatetxt="";
		//pMarktxt="";
		pPurshingtxt="";
		for (cnt=0;cnt<totRecs;cnt++)
		{
			pEduLeveltxt=pEduLeveltxt+"|"+pEduLevel[cnt].value;
			pFieldStudytxt=pFieldStudytxt+"|"+pFieldStudy[cnt].value;
			pCollegetxt=pCollegetxt+"|"+pCollege[cnt].value;
			pDistricttxt=pDistricttxt+"|"+pDistrict[cnt].value;
			pFromDatetxt=pFromDatetxt+"|"+pFromDate[cnt].value;
			pToDatetxt=pToDatetxt+"|"+pToDate[cnt].value;
			//pMarktxt=pMarktxt+"|"+pMark[cnt].value;
			if (pPurshing[cnt].checked==true)
			{
				pPurshingtxt=pPurshingtxt+"|"+1;
			}
			else
			{
				pPurshingtxt=pPurshingtxt+"|"+0;
			}
				
		}
		updaterow=0;
		familyRow = "<?php echo $edirow; ?>";
		 $.ajax({
          url : 'login_ajax.php',
          type : 'POST',
          data : {
			'pEduLevel' : pEduLeveltxt,
			'pFieldStudy' : pFieldStudytxt,
			'pCollege' : pCollegetxt,
			'pDistrict' : pDistricttxt,
			'pFromDate' : pFromDatetxt,
			'pToDate' : pToDatetxt,
			'pPursing' : pPurshingtxt,
			'totalRows' : totRecs,
			'familyRow' : familyRow,
			'zproflag' : 901635121
          },
          dataType:'json',
          success : function(data) {
			  //alert(data['msg']);
			   window.location.href="admin.php";
				  return;
              if (data['status']==0)
              {
				  var x = document.getElementById("snackbar");
				x.className = "show";
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
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
		document.getElementsByName("pEduLevel")[0].value="";
	document.getElementsByName("pFieldStudy")[0].value="";
	document.getElementsByName("pCollege")[0].value="";
	document.getElementsByName("pDistrict")[0].value="";
	document.getElementsByName("pFromDate")[0].value="";
	document.getElementsByName("pToDate")[0].value="";
	//document.getElementsByName("pMark")[0].value="";
}
</script>
  </body>
</html>
