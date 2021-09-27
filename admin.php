<?php
require "session_user_utils.php";
$rid = 0;
if (isset($_SESSION['useridref']))
{
	$rid = $_SESSION['useridref'];
}
if ($rid==0)
{
	$url = './error-page.php';
    header("location: ".$url); // for two folders
}
$snackmsg="";
if (isset($_SESSION['snackbar']))
{
	$snackmsg=$_SESSION['snackbar'];
	$_SESSION['snackbar']="";
	unset($_SESSION['snackbar']);
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
    <title>User</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/3.4/dist/css/bootstrap.min.css" rel="stylesheet">

   
  </head>
<style>
.fa {
	cursor:pointer;
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
            <li><a href="#">Family Info Maintenance</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>

    </nav>
    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
	  <br/>
	  <span>
			
		  </span>
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
		  $totRec=0;
		   $devCount = "select rowid,name,link_relation_relation from family where link_master_master=?";
          $stmt2 = $conn->prepare($devCount);
          $stmt2->execute([$rid]);
		  $res1 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		  if (count($res1)==0)
		 {
			 echo "<center><br><br><br>Family members are not added, <a href='FamilyMember.php'> Click Here </a> to add</center>";
		 }
		 else
		 {
			echo "<span id='errormessage1'></span>";
			if (!(count($res1)>9))
			{ ?>
				
			<?php } ?>
		  		  
		  <br/>
		  
		  <table id="example" class="table table-striped table-bordered" style="width:100%">
		   <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Relation</th>
				<th>Edit</th>
				<th>Other details</th>
            </tr>
			</thead>
			 <tbody>
		  <?php
		 
			
         
		 
		  $cnt=0;
          foreach ($res1 as $key => $row2)
          {
			$cnt=$cnt+1;
			$rn = mt_rand(11111111,99999999).$rid.mt_rand(11111111,99999999);
			$rel = $row2['link_relation_relation'];
			/// 
			// Check if any education details are updated
				$ccode0=$ccode1=$ccode2=$ccode3=$ccode4=$ccode5=$ccode6="#CFD3C8";
				$edu=0;
				$odqry1 = "select rowid from education where link_family_family=?";
				$odstmt1 = $conn->prepare($odqry1);
				$odstmt1->execute([$row2['rowid']]);
				if ($odrow = $odstmt1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				{
					$edu=1;
				}
				if ($edu==1) $ccode0="#B7E954";
				$job=0;
				$odqry2 = "select rowid from jobexp where link_family_family=?";
				$odstmt2 = $conn->prepare($odqry2);
				$odstmt2->execute([$row2['rowid']]);
				if ($odrow = $odstmt2->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				{
					$job=1;
				}
				if ($job==1) $ccode1="#B7E954";
				$skill=0;
				$odqry2 = "select rowid from skill_interested where link_family_family=?";
				$odstmt2 = $conn->prepare($odqry2);
				$odstmt2->execute([$row2['rowid']]);
				if ($odrow = $odstmt2->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				{
					$skill=1;
				}
				if ($skill==1) $ccode2="#B7E954";
				$award=0;
				$odqry2 = "select rowid from awards_received where link_family_family=?";
				$odstmt2 = $conn->prepare($odqry2);
				$odstmt2->execute([$row2['rowid']]);
				if ($odrow = $odstmt2->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				{
					$award=1;
				}
				if ($award==1) $ccode3="#B7E954";
				$cert=0;
				$odqry2 = "select rowid from certifications_having where link_family_family=?";
				$odstmt2 = $conn->prepare($odqry2);
				$odstmt2->execute([$row2['rowid']]);
				if ($odrow = $odstmt2->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				{
					$cert=1;
				}
				if ($cert==1) $ccode4="#B7E954";
				$proj=0;
				$odqry2 = "select rowid from projects_presented where link_family_family=?";
				$odstmt2 = $conn->prepare($odqry2);
				$odstmt2->execute([$row2['rowid']]);
				if ($odrow = $odstmt2->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				{
					$proj=1;
				}
				if ($proj==1) $ccode5="#B7E954";
				$pat=0;
				$odqry2 = "select rowid from patent_presented where link_family_family=?";
				$odstmt2 = $conn->prepare($odqry2);
				$odstmt2->execute([$row2['rowid']]);
				if ($odrow = $odstmt2->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
				{
					$pat=1;
				}
				if ($pat==1) $ccode6="#B7E954";
			
			$desc="";
			$relti = "select name from relation where rowid=?";
			$stmt22 = $conn->prepare($relti);
			$stmt22->execute([$rel]);
			$res12 = $stmt22->fetchAll(PDO::FETCH_ASSOC);
            echo "<tr> <td class='col-md-1'>".$cnt."</td><td class='col-md-4'>".$row2['name']."</td><td class='col-md-2'>".$res12[0]['name']."</td>";
			echo "<td class='col-md-1'><center><a href='FamilyMember.php?sessionid=".$rn."'><i class='fa fa-pencil' title='Edit Basic details' aria-hidden='true'></i></a></center></td>";
			echo "<td class='col-md-4'><a href='eduDetails.php?sessionid=".$rn."'><i class='fa fa-graduation-cap fa-2x' title='Education details' aria-hidden='true' style='color:".$ccode0."'></i></a>&nbsp;&nbsp;&nbsp;";
			echo "<a href='jobExp.php?sessionid=".$rn."'><i class='fa fa-file-word-o fa-2x' title='Job Experience' aria-hidden='true' style='color:".$ccode1."'></i></a>&nbsp;&nbsp;&nbsp;";
			echo "<a href='skills.php?sessionid=".$rn."'><i class='fa fa-wikipedia-w fa-2x' title='Skill' aria-hidden='true' style='color:".$ccode2."'></i></a>&nbsp;&nbsp;&nbsp;";
			echo "<a href='awards.php?sessionid=".$rn."'><i class='fa fa-thumbs-up fa-2x' title='Awards' aria-hidden='true' style='color:".$ccode3."'></i></a>&nbsp;&nbsp;&nbsp;";
			echo "<a href='certification.php?sessionid=".$rn."'><i class='fa fa-certificate fa-2x' title='Certifications/Licenses' aria-hidden='true' style='color:".$ccode4."'></i></a>&nbsp;&nbsp;&nbsp;";
			echo "<a href='projects.php?sessionid=".$rn."'><i class='fa fa-leanpub fa-2x' title='Projects/Paper Presented' aria-hidden='true' style='color:".$ccode5."'></i></a>&nbsp;&nbsp;&nbsp;";
			echo "<a href='patent.php?sessionid=".$rn."'><i class='fa fa-copyright fa-2x' title='Patent' aria-hidden='true' style='color:".$ccode6."'></i></a></td></tr>";
          }
		 }
		  ?>
		</table>

		</div>
	<div id="snackbar"></div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/3.4/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://getbootstrap.com/docs/3.4/assets/js/ie10-viewport-bug-workaround.js"></script>
	<script>
	var snackbar = "<?php echo $snackmsg; ?>";
	if (snackbar!="")
	{
		 var x = document.getElementById("snackbar");
		x.className = "show";
		$("#snackbar").html(snackbar);
		$("#snackbar").css('background-color','#87C261');
		$("#snackbar").css('color','#FFFFFF');
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 4000);
	}
	$(document).ready(function() {
    $('#example').DataTable();
	} );
	$('.fa-graduation-cap').on('click', function (e) {
		window.location.href="eduDetails.php?"
	});
	</script>
  </body>
</html>
