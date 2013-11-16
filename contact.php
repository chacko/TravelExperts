<!--
contact.php
-->
<!DOCTYPE html>

<html>
<head>
	<title>Online Travel Booking and Management System</title>
	<link href="./css/bk.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrap">
<?php
	include_once("header.php");
	
?>
<div id="content">
<?php
	//connect to database
	$conn=mysql_connect("localhost","root","");
	$db=mysql_select_db('travelexperts') or die("Could not connect");
	
	//$sql="SELECT * FROM agencies, agent WHERE agencies.AgencyId=agents.AgencyId GROUP by";
	$sql_agency="SELECT * FROM agencies;";
	$result=mysql_query($sql_agency) or die(mysql_error());
	
	if (mysql_num_rows($result) > 0) {
		while ($row=mysql_fetch_assoc($result)) {
			
			echo "<table width='100%'>";
			echo "<tr><td>".$row['AgncyAddress'].",".$row['AgncyCity'].",".$row['AgncyProv']."</td><td>".$row['AgncyPostal']."</td></tr>";
			echo "<tr><td>Phone: ".$row['AgncyPhone']."</td><td>Fax: ".$row['AgncyFax']."</td></tr>";				
			echo "</table>";
			
			$agencyid=$row['AgencyId'];
			$sql_agent="SELECT * from agents where AgencyId='".$agencyid."';";
			
			$sql_result=mysql_query($sql_agent) or die(mysql_error());
			if (mysql_num_rows($sql_result) > 0) {					
				//echo "<tr>";
				echo "<table width='100%'>";
				while($row_agent=mysql_fetch_assoc($sql_result)) {
					echo "<tr><td>".$row_agent['AgtFirstName']." ".$row_agent['AgtLastName']."</td>";
					echo "<td>Phone: ".$row_agent['AgtBusPhone']."</td><td>Email: ".$row_agent['AgtEmail']."</td></tr>";
				}
				echo "</table>";
				//echo "</tr>";
			}
			else {
				echo "There is no agent available in this location";
			}
		}
		
	}
	else {
		echo "There is no agency available";
	}
	mysql_close($conn);
?>
</div>

<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>