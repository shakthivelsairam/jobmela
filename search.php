<?php
require "session_user_utils.php";
$userid="";
if (!(isset($_SESSION["isLogin"])))
{
  $url = './error-page.php';
  header("location: ".$url); // for two folders
}
$userid=$_SESSION['useridref'];
require "connection.php";
// Create connection
try {
$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
echo "Unable to process your request, contact admin";
return;
}
$devCount = "select rowid,userid,username from companyuser where rowid=?";
$stmt = $conn->prepare($devCount);
$stmt->execute([$userid]);
$rec="^^^^";
if ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
$rec=$row[0]."^".$row[1]."^".$row[2];
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
	
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
 <style>
body {
  margin: 0;
  padding: 0;
  background-color: #17a2b8;
  height: 100vh;
}
#login .container #login-row #login-column #login-box {
  margin-top: 120px;
  max-width: 600px;
  height: 320px;
  border: 1px solid #9C9C9C;
  background-color: #EAEAEA;
}
#login .container #login-row #login-column #login-box #login-form {
  padding: 20px;
}
#login .container #login-row #login-column #login-box #login-form #register-link {
  margin-top: -85px;
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
            <li class=""><a href="basicinfo.php">My Proflie</a></li>
			<li class="active"><a href="search.php" class="searchresume">Search Resumes</a></li>
		 </ul>
		 <ul class="nav navbar-nav" style="float:right">
			<li class="">
				<a href="#">Welcome <?php if ($row[2]=="") { echo "Guest"; } else { echo $row[1]; } ?> </a>
			</li>
             <li class="float:right"><a href="logout.php">Logout</a></li>
         
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
            // echo "Unable to process your request, contact admin";
            // return;
          }
		  // reginfo
		  
		   
			$totRows=1;
			
		  ?>
		   </br> 
		 
		    <div class="form-row">
				  <div class="form-group col-md-10">
					  <select data-placeholder="Select multiple items for filter" class="form-control" multiple style="border:1px solid red" name="sltPrefInd" id="sltPrefInd">
					  <option value="0">--Select--</option>
					  <optgroup label="Education">
					  <?php 
						$streams=array();
						$streamqry="select rowid,name,count(name) c from level group by name having c = 1";
						$stream1 = $conn->prepare($streamqry);
						$stream1->execute();
						while ($rowx = $stream1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
						{
							
							?> <option value="EDU-<?php echo $rowx[0]; ?>" data-stream="<?php echo $rowx[2]; ?>"><?php echo $rowx[1]; ?></option> <?php
						}
					  ?>
						</optgroup>
					   <optgroup label="Stream">
					  <?php 
						$streams=array();
						$streamqry="select rowid,name from stream";
						$stream1 = $conn->prepare($streamqry);
						$stream1->execute();
						while ($rowx = $stream1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
						{
							
							?> <option value="STR-<?php echo $rowx[0]; ?>" data-stream="<?php echo $rowx[2]; ?>"><?php echo $rowx[1]; ?></option> <?php
						}
					  ?>
						</optgroup>
						
						<optgroup label="Field of Study" style="color:red">
							<?php
								$devCoun1t = "select rowid,name from field";
							$stmt23 = $conn->prepare($devCoun1t);
							$stmt23->execute();
							while ($rowx = $stmt23->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
							{
								?> <option value="FOS-<?php echo $rowx[0]; ?>"><?php echo $rowx[1]; ?></option> <?php
							}
							?>
						</optgroup>
						<optgroup label="Preferred Industry">
							<?php 
							$prefind = "select rowid,description from prefferedind where active=1";
							$prefindstmt = $conn->prepare($prefind);
							$prefindstmt->execute();
							while ($rind = $prefindstmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
							{
								?> <option value="IND-<?php echo $rind[0]; ?>"><?php echo $rind[1]; ?></option> <?php
							}
							?>
						</optgroup>
						<optgroup label="Preferred Work Location">
							<?php 
							$prefind = "select rowid,name from district";
							$prefindstmt = $conn->prepare($prefind);
							$prefindstmt->execute();
							while ($rind = $prefindstmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
							{
								?> <option value="WLOC-<?php echo $rind[0]; ?>"><?php echo $rind[1]; ?></option> <?php
							}
							?>
						</optgroup>
					  </select>
				</div>
				 <div class="form-group col-md-1">
				 <input type="button" name="btnapplyfilter" value="Filter" onClick="fLoadmoredata()">
				 </div>
				 <div class="form-group col-md-1">
				 <i class="fa fa-bar-chart" aria-hidden="true"></i>
					</div>
		  </div>
		  
		  <div id="chartContainer" style="display:none">
		  
		  </div>
		  </br></br>
		  
		  
		  <div class="row singleRow" style="border:0px solid red">
		 <table class="table table-bordered table-striped" id="tblPDF">
        <thead>
            <th>First Name</th>
			<th>DOB</th>
            <th>Mobile</th>
            <th>Education</th>
			<th>Field of Study</th>
			<th>Resume</th>
			<th>Remarks</th>
			<th>Selected</th>
        </thead>
        <tbody id="load_data">
			
		</tbody>
		</table>
			<div id="load_data_message"></div>
		 </div>
		 </div>
		 </div>
		
<div id="snackbar"></div>

<?php
$dataPoints = array();
/*
	foreach ($dta as $key => $value) {
		$one=array("label"=>$key,"y"=>$value);
		array_push($dataPoints,$one);
	}
	*/
?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
	
    <script>
	
	
		 let sltFilter = $('#sltPrefInd').val(); 
		 if (sltFilter=="") sltFilter="";
		 //sltFilter = sltFilter.replace(",", "#");
		 let limit = 20;
		 let start = 0;
		 var action = 'inactive';
		 function load_country_data(limit, start,sltFilter)
		 {
			 //alert(start+" ; "+limit);
		  $.ajax({
		   url:"fetch.php",
		   method:"POST",
		    dataType: 'text',
		   data:{limit:limit, start:start,sltFilter:sltFilter},
		  
		   success:function(data)
		   {
			   //alert(data);
			//if (sltFilter!="") $('#load_data').html('');
			if ((data.length)>150) $('#load_data').append(data);
			if(data == '')
			{
			 $('#load_data_message').html("");
			 action = 'active';
			}
			else
			{
				if ((data.length)>150)
				{
					$('#load_data_message').html("<div class='btn btn-warning' onClick='fLoadmoredata()'>Click here to load more ...</div>");
					action = "inactive";
				}
				else
				{
						$('#load_data_message').html('No records found!!');
				}
			}
		   }
		  });
		 }

		 if(action == 'inactive')
		 {
			 sltFilter = $('#sltPrefInd').val(); 
			 if (sltFilter=="") sltFilter="";
			 //sltFilter = sltFilter.toString().replace(",", "#");
			action = 'active';
		  load_country_data(limit, start,sltFilter);
		 }
		     
		 function fLoadmoredata()
		{
			sltFilter = $('#sltPrefInd').val(); 
			//alert(sltFilter+" - "+limit+" - "+start);
			$('#load_data_message').html("<span class='btn btn-warning'>Please Wait....</span>");
			action = 'active';
			
			setTimeout(function(){
			load_country_data(limit, start,sltFilter);
			}, 1000);
			start = start + limit;
		};
		$("#sltPrefInd").change(function(){
			 		limit = 20;
					start = 0;
					$('#load_data').html('');
					$('#load_data_message').html('');
					//alert(" - "+limit+" - "+start);
		});
		
		
	
		//////// 
	
	
	      $("body").on("click", "#btnPdf", function () {
			
					
				  html2canvas($('#tblPDF'), {
					onrendered: function (canvas) {
						var data = canvas.toDataURL();
						var docDefinition = {
							content: [{
								image: data,
								width: 500
							}],
							orientation: 'landscape', //portrait
					pageSize: 'A4', //A3 , A5 , A6 , legal , letter
						};
						pdfMake.createPdf(docDefinition).download("cutomer-details.pdf");
					}
				});
			
	
        });
	
	
	
	
	function fCaptureRemarks(rowid)
	{
		//alert(44);
		var compayid = "<?php echo $userid; ?>";
		var bjValue =  $('#txtarea'+rowid).val();	//$('#txtarea'+rowid);
		$.ajax({
          url : 'login_ajax.php',
          type : 'POST',
          data : {
              'compayid' : compayid,
              'remarks' : bjValue,
			  'candiateid' : rowid,
              'zproflag' : 4400112
          },
          dataType:'json',
          success : function(data) {
			  //alert(data['msg']);
              if (data['status']==0)
              {
				  
				var x = document.getElementById("snackbar");
				 x.className = "show";
				$("#snackbar").html(data['msg']);
				$("#snackbar").css('background-color','green');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
				
              }
			 
              else
              {
               var x = document.getElementById("snackbar");
				x.className = "show";
				$("#snackbar").html(data['msg']);
				$("#snackbar").css('background-color','#DF2909');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
              }
              // clearPrompts();
          },
          error : function(request,error)
          {
            $("#errormessage1").css('display', 'block');
            $('#errormessage1').html("Failed to login, please contact admin"+error);
			$("#errormessage1").css('color', 'red');
            $('#errormessage1').delay(9000).fadeOut();
          }
      });
	}
	function fUpdate(rowid)
	{
		var compayid = "<?php echo $userid; ?>";
		var flag = $('#chk'+rowid);
		flag =($(flag).prop('checked'));
		flagValue=0;
		if (flag==true) flagValue=1;
		$.ajax({
          url : 'login_ajax.php',
          type : 'POST',
          data : {
              'compayid' : compayid,
              'checkedflag' : flagValue,
			  'candiateid' : rowid,
              'zproflag' : 5903
          },
          dataType:'json',
          success : function(data) {
			  
              if (data['status']==0)
              {
				                 var x = document.getElementById("snackbar");
				 x.className = "show";
				$("#snackbar").html(data['msg']);
				$("#snackbar").css('background-color','green');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
              }
			 
              else
              {
               var x = document.getElementById("snackbar");
				x.className = "show";
				$("#snackbar").html(data['msg']);
				$("#snackbar").css('background-color','#DF2909');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
              }
              // clearPrompts();
          },
          error : function(request,error)
          {
            $("#errormessage1").css('display', 'block');
            $('#errormessage1').html("Failed to login, please contact admin"+error);
			$("#errormessage1").css('color', 'red');
            $('#errormessage1').delay(9000).fadeOut();
          }
      });
	}
	function fDownloadResume(rowid)
	{
		$.ajax({
          url : 's.php',
          type : 'POST',
          data : {
              'rowid' : rowid,
          },
          dataType:'json',
          success : function(data) {
			  
              if (data['status']==0)
              {
				                 var x = document.getElementById("snackbar");
				 x.className = "show";
				$("#snackbar").html(data['msg']);
				$("#snackbar").css('background-color','green');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
              }
			 
              else
              {
               var x = document.getElementById("snackbar");
				x.className = "show";
				$("#snackbar").html(data['msg']);
				$("#snackbar").css('background-color','#DF2909');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
              }
              // clearPrompts();
          },
          error : function(request,error)
          {
            $("#errormessage1").css('display', 'block');
            $('#errormessage1').html("Failed to login, please contact admin"+error);
			$("#errormessage1").css('color', 'red');
            $('#errormessage1').delay(9000).fadeOut();
          }
      });
	}
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
	$('#userTable').dataTable({
		dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ],
		paging: false,
		 "columnDefs": [
			{
				"targets": [4],
				"visible": true,
				"searchable": true
			}
		],
		
	});
		
		

    </script>
		</div>

    </div> <!-- /container -->


  	<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
	<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
		<script>
	
		$("#sltPrefInd").chosen({
			no_results_text: "Oops, nothing found!"	,
			max_selected_options: 5
		})
		
			var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Department wise analysis"
	},
	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();


		</script>
  </body>
</html>
