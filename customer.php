<?php 
	session_start();
?>
<!--
Author		:	George Chacko
Date		:	14 November 2013
Project		: 	Phase I - workshop prototype
Customer registration Page - this page allows customer to enter basic information like
------------------------- - name, address, phone, email etc. as well as user id and password
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
	//---------------------------
	include_once("functions.php");	
	//---------------------------
	// Initializing customer array
	$customerInfo = array(	"CustFirstName"	=> "",
							"CustLastName" 	=> "",
							"CustAddress" 	=> "",
							"CustCity" 		=> "",
							"CustProv" 		=> "",
							"CustPostal" 	=> "",
							"CustCountry" 	=> "",
							"CustHomePhone" => "",
							"CustBusPhone" 	=> "",
							"CustEmail" 	=> "",
							"CustUid"		=> "",
							"CustPwd"		=> "",
							"CustConfmPwd"	=> ""
				);
	//---------------------------
	$isValidForm = true; // to determine if form is valid to insert into Data base
	//---------------------------
	if (isset($_POST["submit"]))
	{
		// looping form collection for each customer information field
		foreach (array_keys($_POST) as $name)
		{
			// populating associative array
			$customerInfo[$name] = $_POST[$name]; 
		} // for loop end
		//---------------------------
		//--- Page validation 
		
		if(empty($customerInfo['CustFirstName']))
		{
			print "<br>First Name is Mandatory.";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustLastName']))
		{
			print "<br>Last Name is Mandatory.";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustAddress']))
		{
			print "<br>Address is Mandatory.";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustCity']))
		{
			print "<br>City is Mandatory.";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustProv']))
		{
			print "<br>Province is Mandatory.";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustPostal']))
		{
			print "<br>Postal Code is Mandatory.";
			$isValidForm = false;
		}
		else // checking postal code format
		{
			if(filter_var($customerInfo['CustPostal'], FILTER_VALIDATE_REGEXP, 
					array("options"=>array("regexp"=>"/^[a-z][0-9][a-z]( )?[0-9][a-z][0-9]$/i"))) === false)
			{
				print "<br>Postal Code not in correct format.";
				$isValidForm = false;
			}
		
		}
		if(empty($customerInfo['CustBusPhone']))
		{
			print "<br>Bus Phone is Mandatory.";
			$isValidForm = false;
		}
		if(empty($customerInfo['CustEmail']))
		{
			print "<br>Email is Mandatory.";
			$isValidForm = false;
		}
		else  // Checking email format
		{
			if(!filter_var($customerInfo['CustEmail'], FILTER_VALIDATE_EMAIL))
			{
				$isValidForm = false;
				print("<br>Email is Invalid");
			}
		}
		if(empty($customerInfo['CustUid']))
		{
			print "<br>User Id is Mandatory.";
			$isValidForm = false;
		}
		// checking both password and re enter password text fields filled
		if(empty($customerInfo['CustPwd']) || empty($customerInfo['CustConfmPwd']))
		{
			print "<br>Password is Mandatory.";
			$isValidForm = false;
		}
		else  // checking both password and re enter password are same
		{
			if($customerInfo['CustPwd'] != $customerInfo['CustConfmPwd'])
			{
				print "<br>Re Enter Password.";
				$isValidForm = false;
			}
		}
		//-------- Page validation ends -----------
		//---------------------------
		// If customer data is valid insert into data base
		if($isValidForm)
		{
			// populate user id and password from array into variables
			// to insert into another table (users)
			$userId = $customerInfo['CustUid'];
			$pwd	= $customerInfo['CustPwd'];
			
			// removing data not related to customer from array
			unset($customerInfo['submit']);
			unset($customerInfo['CustUid']);
			unset($customerInfo['CustPwd']);
			unset($customerInfo['CustConfmPwd']);
			// Insert customer data
			if(insertData($customerInfo,'customers'))
			{
				// Initializing user info array
				$userInfo = array(	"user"	=> "",
							"password" 	=> "" );
				$userInfo['user'] 		= $userId;
				$userInfo['password'] 	= md5($pwd); // password is encrypted
				//--------------------
				// Inserting user id and password into users table
				if(insertData($userInfo,'users'))
				{
					// On successful customer registration - 
					// check if order is placed if so redirect to payment page otherwise to home page
					if(isset($_SESSION["order"]))
					{
						header("Location:payment.php");
					}
					else
					{
						header("Location:index.php");
					}
				}
				else
				{
					print "<b>User information could not be added!!!</b>";
				}
				//--------------------
			}
			else
			{
				print "<b>Customer information could not be added!!!</b>";
			}	
		}
		//---------------------------
	}
?>
<div id="content">
	<form id="frm" method="post" >
		<table align="center">
			<tr><td align="center"><h2>Customer Information</h2></td></tr>
			<tr>
				<td>
					<table>
						<tr>
							<td align="right">First Name:</td>
							<td><input type="text" name="CustFirstName" size="20" maxlength="25" 
									value="<?php echo $customerInfo['CustFirstName'];?>"></td>
						</tr>
						<tr>
							<td align="right">Last Name:</td>
							<td><input type="text" name="CustLastName" size="20" maxlength="25" 
									value="<?php echo $customerInfo['CustLastName'];?>"></td>
						</tr>
						<tr>
							<td align="right">Address:</td>
							<td><input type="text" name="CustAddress" size="30" maxlength="75" 
									value="<?php echo $customerInfo['CustAddress'];?>"></td>
						</tr>
						<tr>
							<td align="right">City:</td>
							<td><input type="text" name="CustCity" size="30" maxlength="50" 
									value="<?php echo $customerInfo['CustCity'];?>"></td>
						</tr>
						<tr>
							<td align="right">Province:</td>
							<td><input type="text" name="CustProv" size="2" maxlength="2" 
									value="<?php echo $customerInfo['CustProv'];?>"></td>
						</tr>
						<tr>
							<td align="right">Postal Code:</td>
							<td><input type="text" name="CustPostal" size="7" maxlength="7" 
									value="<?php echo $customerInfo['CustPostal'];?>"></td>
						</tr>
						<tr>
							<td align="right">Country:</td>
							<td><input type="text" name="CustCountry" size="25" maxlength="25" 
									value="<?php echo $customerInfo['CustCountry'];?>"></td>
						</tr>
						<tr>
							<td align="right">Home Phone:</td>
							<td><input type="text" name="CustHomePhone" size="20" maxlength="20" 
									value="<?php echo $customerInfo['CustHomePhone'];?>"></td>
						</tr>
						<tr>
							<td align="right">Bus Phone:</td>
							<td><input type="text" name="CustBusPhone" size="20" maxlength="20" 
									value="<?php echo $customerInfo['CustBusPhone'];?>"></td>
						</tr>
						<tr>
							<td align="right">Email:</td>
							<td><input type="text" name="CustEmail" size="20" maxlength="20" 
									value="<?php echo $customerInfo['CustEmail'];?>"></td>
						</tr>
						<tr>
							<td align="right">User Id:</td>
							<td><input type="text" name="CustUid" size="10" maxlength="10" 
									value="<?php echo $customerInfo['CustUid'];?>"></td>
						</tr>
						<tr>
							<td align="right">Password:</td>
							<td><input type="password" name="CustPwd" size="10" maxlength="10" 
									value="<?php echo $customerInfo['CustPwd'];?>"></td>
						</tr>
						<tr>
							<td align="right">Re-enter Password:</td>
							<td><input type="password" name="CustConfmPwd" size="10" maxlength="10"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="submit" value="REGISTER"  name="submit" ></input>
					<input type="button" value="CLEAR"  id="resetBtn" ></input>
				</td>
			</tr>
		</table>
	</form> 
	
	
</div>
<?php
	include_once("footer.php");
?>
		</div>
	</body>
</html>