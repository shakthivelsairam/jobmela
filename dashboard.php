<?php
require "session_user_utils.php";
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!(isset($_SESSION["isAdmin"])))
{
  $url = './error-page.php';
  header("location: ".$url); // for two folders
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
            // echo "Unable to process your request, contact admin";
            // return;
          }
		  ?>
		  <br/>
		  <div id="printbar" style="float:right"><a href="addEditUser.php"><button type="button" class="btn btn-primary ">Add</button></a></div>
		  <table id="example" class="table table-striped table-bordered" style="width:100%">
		   <thead>
            <tr>
                <th>GPF Number</th>
                <th>Name</th>
				<th>Department</th>
                <th>Rank</th>
                <th>Aadhar No</th>
                <th>Station</th>
                <th>Date of Birth</th>
				<th>Date of Joining</th>
				<th>Date of Enroll</th>
				<th>Action</th>
            </tr>
			</thead>
			 <tbody>
		  <?php
          $devCount = "select rowid,department_department_link,gpfno,name,rank_rank_link,aadharno,station_presentstation_link,dob,doj,doe from master";
          $stmt2 = $conn->prepare($devCount);
          $stmt2->execute();
		  $res1 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		  
          foreach ($res1 as $key => $row2)
          {
			$rn = mt_rand(111111111111111111,999999999999999999).$row2['rowid'];
            echo "<tr><td>".$row2['gpfno']."</td><td>".$row2['name']."</td><td>".$row2['department_department_link']."</td><td>".$row2['rank_rank_link']."</td><td>".$row2['aadharno']."</td><td>".$row2['station_presentstation_link']."</td><td>".$row2['dob']."</td><td>".$row2['doj']."</td><td>".$row2['doe']."</td><td><center><a href='addEditUser.php?sessionid=".$rn."'><i class='fa fa-pencil' aria-hidden='true'></i></a></center></td></tr>";
          }
		  ?>
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
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap.min.js"></script>
	
	<script>
	$(document).ready(function() {
    $('#example').DataTable();
	} );
	</script>
  </body>
</html>
