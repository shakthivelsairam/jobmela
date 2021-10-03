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
		  
		    $devCount = "select rowid,c2,c4,c16,c25,c26,c40,c34 from formr";
			$stmt = $conn->prepare($devCount);
			$ress = $stmt->execute();
			$rec="^^^^^^^";
			$totRows=$stmt->rowCount();
			if ($totRows==0) $totRows=1;
			
		  ?>
		   </br> </br>
		  
		 
		  <div class="row singleRow">
		 
		 
		  
		  <table id="userTable">
        <thead>
            <th>First Name</th>
            <th>Mobile</th>
            <th>Education</th>
			<th></th>
			<th>Marks/GPA</th>
			<th>Resume</th>
			<th>Remarks</th>
			<th>Selected</th>
        </thead>
        <tbody>
				 <?php 
					
					while($rec1 = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				 { ?>
					
					  <tr>
                        <td><?php echo $rec1[1]; ?></td>
                        <td><?php echo $rec1[2]; ?></td>
                        <td><?php echo $rec1[5]; ?></td>
						<td><?php echo $rec1[3]." ".$rec1[7]; ?></td>
						<td><?php echo $rec1[6]; ?></td>
						<?php
						$flg=0;
						$remarks="";
						$logchek = "select rowid,selectedflg,remarks from sortlistdata where companyid=? and candidateid=?";
						$stm4t = $conn->prepare($logchek);
						$stm4t->execute([$userid,$rec1[0]]);
						if ($rokw = $stm4t->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) 
						{	
							$flg=$rokw[1];
							$remarks=$rokw[2];
						}
						?>
						<td><a href="<?php echo $rec1[4]; ?>" target="_blank">Click Here </a></td>
						<td><textarea id="txtarea<?php echo $rec1[0]; ?>" onBlur="fCaptureRemarks(<?php echo $rec1[0]; ?>)"><?php echo $remarks; ?></textarea></td>
						
						<td><input type="checkbox" <?php if ($flg==1) echo "checked"; ?> onClick="fUpdate(<?php echo $rec1[0]; ?>)" id="chk<?php echo $rec1[0]; ?>"></td>
                    </tr>
				 <?php } ?>
             
        </tbody>
    </table>
    
	<div id="snackbar"></div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
		
	
    <script>
	function fCaptureRemarks(rowid)
	{
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
			  
              if (data['status']==0)
              {
				  /*
				var x = document.getElementById("snackbar");
				 x.className = "show";
				$("#snackbar").html(data['msg']);
				$("#snackbar").css('background-color','green');
				$("#snackbar").css('color','#FFFFFF');
				setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
				*/
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
				"targets": [3],
				"visible": false,
				"searchable": true
			}
		],
		
	});
	
    </script>
		</div>

    </div> <!-- /container -->


  </body>
</html>
