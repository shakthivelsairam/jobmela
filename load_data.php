<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require "connection.php";
try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Unable to process your request, contact admin";
  return;
}
try {
	$familyreg = "drop table formr";
	$stmt = $conn->prepare($familyreg);
	$er = $stmt->execute();
} catch(PDOException $e) {
	$qry = "CREATE TABLE formr (";
	for ($x = 1; $x <= 300; $x+=1) 
	{
		$qry.= "c".$x.' text,'; 
	} 
	$qry .="rowid int auto_increment," ;
	$qry .="primary key (rowid)" ;
	$qry .=")"; 
	$stmt = $conn->prepare($qry);
	$er = $stmt->execute();
}

if(isset($_POST["submit_file"]))
{
	$familyreg = "delete from formr";
	$stmt = $conn->prepare($familyreg);
	$er = $stmt->execute();
		
 $file = $_FILES["file"]["tmp_name"];
 $file_open = fopen($file,"r");
 while(($c = fgetcsv($file_open, 10000000, ",")) !== false)
 {
	
	for ($i=0;$i<301;$i++)
	{
		if (!(isset(($c[$i])))) $c[$i]="";
	}		
			$f = "insert into formr (
				c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11,c12,c13,c14,c15,c16,c17,c18,c19,c20,c21,c22,c23,c24,c25,c26,c27,c28,c29,c30,c31,c32,c33,c34,c35,c36,c37,c38,c39,c40,c41,c42,c43,c44,c45,c46,c47,c48,c49,c50,c51,c52,c53,c54,c55,c56,c57,c58,c59,c60,c61,c62,c63,c64,c65,c66,c67,c68,c69,c70,c71,c72,c73,c74,c75,c76,c77,c78,c79,c80,c81,c82,c83,c84,c85,c86,c87,c88,c89,c90,c91,c92,c93,c94,c95,c96,c97,c98,c99,c100,c101,c102,c103,c104,c105,c106,c107,c108,c109,c110,c111,c112,c113,c114,c115,c116,c117,c118,c119,c120,c121,c122,c123,c124,c125,c126,c127,c128,c129,c130,c131,c132,c133,c134,c135,c136,c137,c138,c139,c140,c141,c142,c143,c144,c145,c146,c147,c148,c149,c150,c151,c152,c153,c154,c155,c156,c157,c158,c159,c160,c161,c162,c163,c164,c165,c166,c167,c168,c169,c170,c171,c172,c173,c174,c175,c176,c177,c178,c179,c180,c181,c182,c183,c184,c185,c186,c187,c188,c189,c190,c191,c192,c193,c194,c195,c196,c197,c198,c199,c200,c201,c202,c203,c204,c205,c206,c207,c208,c209,c210,c211,c212,c213,c214,c215,c216,c217,c218,c219,c220,c221,c222,c223,c224,c225,c226,c227,c228,c229,c230,c231,c232,c233,c234,c235,c236,c237,c238,c239,c240,c241,c242,c243,c244,c245,c246,c247,c248,c249,c250,c251,c252,c253,c254,c255,c256,c257,c258,c259,c260,c261,c262,c263,c264,c265,c266,c267,c268,c269,c270,c271,c272,c273,c274,c275,c276,c277,c278,c279,c280,c281,c282,c283,c284,c285,c286,c287,c288,c289,c290,c291,c292,c293,c294,c295,c296,c297,c298,c299,c300) 
				values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$stmt = $conn->prepare($f);
				$stmt->execute([$c[1],$c[2],$c[3],$c[4],$c[5],$c[6],$c[7],$c[8],$c[9],$c[10],$c[11],$c[12],$c[13],$c[14],$c[15],$c[16],$c[17],$c[18],$c[19],$c[20],$c[21],$c[22],$c[23],$c[24],$c[25],$c[26],$c[27],$c[28],$c[29],$c[30],$c[31],$c[32],$c[33],$c[34],$c[35],$c[36],$c[37],$c[38],$c[39],$c[40],$c[41],$c[42],$c[43],$c[44],$c[45],$c[46],$c[47],$c[48],$c[49],$c[50],$c[51],$c[52],$c[53],$c[54],$c[55],$c[56],$c[57],$c[58],$c[59],$c[60],$c[61],$c[62],$c[63],$c[64],$c[65],$c[66],$c[67],$c[68],$c[69],$c[70],$c[71],$c[72],$c[73],$c[74],$c[75],$c[76],$c[77],$c[78],$c[79],$c[80],$c[81],$c[82],$c[83],$c[84],$c[85],$c[86],$c[87],$c[88],$c[89],$c[90],$c[91],$c[92],$c[93],$c[94],$c[95],$c[96],$c[97],$c[98],$c[99],$c[100],$c[101],$c[102],$c[103],$c[104],$c[105],$c[106],$c[107],$c[108],$c[109],$c[110],$c[111],$c[112],$c[113],$c[114],$c[115],$c[116],$c[117],$c[118],$c[119],$c[120],$c[121],$c[122],$c[123],$c[124],$c[125],$c[126],$c[127],$c[128],$c[129],$c[130],$c[131],$c[132],$c[133],$c[134],$c[135],$c[136],$c[137],$c[138],$c[139],$c[140],$c[141],$c[142],$c[143],$c[144],$c[145],$c[146],$c[147],$c[148],$c[149],$c[150],$c[151],$c[152],$c[153],$c[154],$c[155],$c[156],$c[157],$c[158],$c[159],$c[160],$c[161],$c[162],$c[163],$c[164],$c[165],$c[166],$c[167],$c[168],$c[169],$c[170],$c[171],$c[172],$c[173],$c[174],$c[175],$c[176],$c[177],$c[178],$c[179],$c[180],$c[181],$c[182],$c[183],$c[184],$c[185],$c[186],$c[187],$c[188],$c[189],$c[190],$c[191],$c[192],$c[193],$c[194],$c[195],$c[196],$c[197],$c[198],$c[199],$c[200],$c[201],$c[202],$c[203],$c[204],$c[205],$c[206],$c[207],$c[208],$c[209],$c[210],$c[211],$c[212],$c[213],$c[214],$c[215],$c[216],$c[217],$c[218],$c[219],$c[220],$c[221],$c[222],$c[223],$c[224],$c[225],$c[226],$c[227],$c[228],$c[229],$c[230],$c[231],$c[232],$c[233],$c[234],$c[235],$c[236],$c[237],$c[238],$c[239],$c[240],$c[241],$c[242],$c[243],$c[244],$c[245],$c[246],$c[247],$c[248],$c[249],$c[250],$c[251],$c[252],$c[253],$c[254],$c[255],$c[256],$c[257],$c[258],$c[259],$c[260],$c[261],$c[262],$c[263],$c[264],$c[265],$c[266],$c[267],$c[268],$c[269],$c[270],$c[271],$c[272],$c[273],$c[274],$c[275],$c[276],$c[277],$c[278],$c[279],$c[280],$c[281],$c[282],$c[283],$c[284],$c[285],$c[286],$c[287],$c[288],$c[289],$c[290],$c[291],$c[292],$c[293],$c[294],$c[295],$c[296],$c[297],$c[298],$c[299],$c[300]]);
 }
}
?>
<html>
<body>
<div id="wrapper">
 <form method="post" action="load_data.php" enctype="multipart/form-data">
  <input type="file" name="file"/>
  <input type="submit" name="submit_file" value="Submit"/>
 </form>
</div>
</body>
</html>
