/* 
Author		:	George Chacko
Date		:	14 November 2013

*/   

//---------------------------------------
function customerValidate()
{
	alert("Customer page");
	documet.forms[0].action = "customer.php";
	documet.forms[0].submit();

}
//-------------------------------------------
// Submitting the page
function validate()
{
	
	if(checkForMandatory_Fields())
	{
		var subPage = confirm("Are You Sure about submitting this page?");
	
		if(subPage)
		{
			document.forms[0].action ="bouncer.php";
			document.forms[0].submit();
		}
	}
}
//---------------------------------------			
// Reset page
function resetPage()
{
	var resetPage = confirm("Are You Sure about clearing the form?");
	
	if(resetPage)
	{
		document.forms[0].reset();
	}
}
//---------------------------------------			
// validate mandatory fields -----------
function checkForMandatory_Fields()
{
	var frm = document.getElementById("frm");
	
	for (var i=0; i<frm.length; i++)
	{
		// check for text fields 
		if(frm.elements[i].type == "text")
		{
			if(frm.elements[i].value == "")
			{
				alert(frm.elements[i].name + " is Empty");
				frm.elements[i].focus();
				return false;
			}
			
			// check for Postal format 
			if(frm.elements[i].name == "Postal-code")
			{
				if(!validate_Zip(frm.elements[i].value))
				{
					alert(frm.elements[i].name + " format is not correct");
					frm.elements[i].focus();
					return false;
				}
			}
		}
		// ------------------------------------------
		
	}
	// Check for gender
	if(!validate_Gender())
	{
		alert("Kindly select Gender");
		document.forms[0].getElementById("gender").focus();
		return false;
	}
	return true;
}
//---------------------------------------			
//---------ZIP code validation
function validate_Zip(zip)
{
	 var regPostalcode = new RegExp("^[a-z][0-9][a-z]( )?[0-9][a-z][0-9]$","i");
	 if (regPostalcode.test(zip))
	 {
		return true;
	 }
	 else
	 {
		return false;
	 }
}
//---------------------------------------
// ------------ Radio button validation
function validate_Gender()
{
	var frm = document.getElementById("frm");
	
	for (var i=0; i<frm.length; i++)
	{
		if(frm.elements[i].type == "radio" && frm.elements[i].checked)
		{
			return true;
		}
	}
	return false;
}

//----------------------------------