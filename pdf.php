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
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Convert or Export HTML Table to PDF file using jQuery | Tutorialswebsite</title>
     <style type="text/css">
        body
        {
            font-family: Arial;
            font-size: 10pt;
        }
        table
        {
            border: 1px solid #;
            border-collapse: collapse;
        }
        table th
        {
            background-color: #F7F7F7;
            color: #333;
            font-weight: bold;
        }
        table th, table td
        {
            padding: 5px;
            border: 1px solid #ccc;
        }
		
		tr.noBorder td {
		  border: 0;
		}
    </style>
</head>
<body>
     
		<?php 
		$devCount = "select c2,c3,c4,c5,c6,c7,c8,c9,c10,c12,c26,c27,c28,c29,c30,c31,c32,c34,c35,c36,c37,c38,c39,c40,c58,c59,c60,c61,c62,c63,c64,c65,c66,c67,c68,c69,c70,c71,c72,c73,c74,c75,c76,c77,c78,c79 from formr where rowid <4 ";
		$stmt = $conn->prepare($devCount);
		$ress = $stmt->execute();
		$totRows=$stmt->rowCount();
		$cnt=0;
		while($rec1 = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
		{
			echo "<table id='tblCandidateInfo".$cnt."'><tr><th colspan=4 align='center'>Candiate Information</th></tr>";
			echo "<tr><td colspan=2>Candiate Name </td><td colspan=2>".$rec1[0]."</td></tr>";
			echo "<tr><td colspan=2>Date Of birth</td> <td colspan=2>".$rec1[1]."</td></tr>";
			echo "<tr><td colspan=2>Mobile Number</td> <td colspan=2>".$rec1[2]."</td></tr>";
			echo "<tr><td colspan=2>Address Line 1</td><td colspan=2>".$rec1[3]."</td></tr>";
			echo "<tr><td colspan=2>Address Line 2</td><td colspan=2>".$rec1[4]."</td></tr>";
			if ($rec1[5]!="") echo "<tr><td colspan=2>Address Line 3</td><td colspan=2>".$rec1[5]."</td></tr>";
			echo "<tr><td colspan=2>City</td><td colspan=2>".$rec1[6]."</td></tr>";
			echo "<tr><td colspan=2>State</td><td colspan=2>".$rec1[7]."</td></tr>";
			echo "<tr><td colspan=2>Pincode</td><td colspan=2>".$rec1[8]."</td></tr>";
			echo "<tr><td colspan=2>Languages known</td><td colspan=2>".$rec1[9]."</td></tr>";
			echo "<tr class='noBorder'><td><br/></td></tr>";
			echo "<tr><th colspan=10>Education details</th></tr>";
			// c26,c27,c28,c29,c30,c31,c32
			echo "<tr><th>S.No</th><th>Education</th><th>Field of study</th><th>College/University</th><th>City</th><th>Duriation</th><th>Percentage</th>";
			echo "<tr><td>1</td><td>".$rec1[10]."</td><td>".$rec1[11]."</td><td>".$rec1[12]."</td><td>".$rec1[13]."</td><td>".$rec1[14]." - ".$rec1[15]."</td><td>".$rec1[16]."</td></tr>";
			if ($rec1[16]!="") echo "<tr><td>2</td><td>".$rec1[17]."</td><td>".$rec1[18]."</td><td>".$rec1[19]."</td><td>".$rec1[20]."</td><td>".$rec1[21]." - ".$rec1[22]."</td><td>".$rec1[23]."</td></tr>";
			
			if ($rec1[24]!="")
			{
				echo "<tr class='noBorder'><td><br/></td></tr>";
				echo "<tr><th colspan=10>Work Experience</th></tr>";
				// c26,c27,c28,c29,c30,c31,c32
				echo "<tr><th>S.No</th><th>Job title</th><th>Company Name</th><th>City/District</th><th>Job Nature</th><th>Duriation</th><th>Working Here ?</th>";
				echo "<tr><td>1</td><td>".$rec1[24]."</td><td>".$rec1[25]."</td><td>".$rec1[26]."</td><td>".$rec1[27]."</td><td>".$rec1[28]." - ".$rec1[29]."</td><td>".$rec1[30]."</td></tr>";
				if ($rec1[31]!="") echo "<tr><td>2</td><td>".$rec1[31]."</td><td>".$rec1[32]."</td><td>".$rec1[33]."</td><td>".$rec1[34]."</td><td>".$rec1[35]." - ".$rec1[36]."</td><td>".$rec1[37]."</td></tr>";
				if ($rec1[38]!="") echo "<tr><td>3</td><td>".$rec1[38]."</td><td>".$rec1[39]."</td><td>".$rec1[40]."</td><td>".$rec1[41]."</td><td>".$rec1[42]." - ".$rec1[43]."</td><td>".$rec1[44]."</td></tr>";
			}
			echo "</table>";
			echo "<br><br>";
			$cnt=$cnt+1;
		}
		?>
	
    <br />
    <input type="button" id="btnExport" value="Export" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
		var totalRows = "<?php echo $totRows; ?>";
        $("body").on("click", "#btnExport", function () {
			
					
			
			for (ik=0;ik<totalRows;ik++)
			{
					var tblName="tblCandidateInfo"+ik;
				  html2canvas($('#'+tblName)[0], {
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
			}
	
        });
    </script>
</body>
</html>