<?php 
/* 
Author		:	George Chacko
Date		:	15 November 2013
-- Functions file  ----- functions used in web site 
*/
// Adding Data to DB-------------------
function insertData($dataArray,$table)
{
	// variable to hold sql statement
	$insertStmt = "INSERT INTO $table (";
	
	// Initializing variables to hold column names and values
	$cols = "";  //columns
	$vals = "";  // fields
	
	// getting keys from array passed as parameter
	$keys = array_keys($dataArray);
	// --- looping through array
	foreach ($keys as $key)
	{
		$cols .= $key . ",";
		$vals .= "'" . $dataArray[$key] . "'," ;
	}
	
	// -- removing extra comma 
	$cols = rtrim($cols, ",");
	$vals = rtrim($vals, ",");
	
	$insertStmt .= $cols . ") VALUES (" . $vals . ")";
	
	// Data base connection
	$con=mysql_connect("localhost","root","");
	
	//providing which data base to be used
	mysql_select_db('TravelExperts') or die('Could not connect');
	
	// executes DB operation
	$results = mysql_query($insertStmt);
	
	if($results)
	{
		mysql_close();
		return true;
	}
	else
	{
		mysql_close();
		return false;
	}
}
//--------------------------------
?>