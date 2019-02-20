<!DOCTYPE html>
<head>  
    <meta charset = "utf-8">
        <title>View Order</title>
</head> 
<body> 
<?php

// if ($_SERVER['REQUEST_METHOD'] == POST) form has been submitted by POST method
//include "inc_DBConnect.php";
session_start();
$ShowForm = FALSE;
$orderID = uniqid();
$_SESSION['oid'] = $orderID;
$inputs = array('firstName', 'lastName', 'emailAddress', 'address', 'phoneNo', 'totalPrice','pizzaSize');
$checkBoxes = array('student','addAnchovies','addPineapple','addPepperoni','addOlives','addOnion','addPeppers');
$order = array();
$extra = array();


foreach($inputs as $input)
		{
			$order[$input] = "";//initialize each element of order to empty string	
		}
		
		if(isset($_POST['submit']))//if submit buttun is clicked on form
		{
			//TODO put into validation function
			foreach($inputs as $input)
			{
				//validate user entered data
				
				if((!isset($_POST[$input])) || (strlen(trim(($_POST[$input])))==0))
				{
					echo "<p>'$input' is a required field.</p>\n";
					//$ShowForm = TRUE;//need to redisplay form so user can correct errors
				}
				else
				{
					//user entered data is valid so remove empty spaces amd store in order
					$order[$input]=trim($_POST[$input]);
				}
			}//end foreach
			foreach($checkBoxes as $box)
			{
				//validate user entered data
				
				if(!isset($_POST[$box]))
				{
					$extra[$box] ='N';
				}
				else
				{
					//user entered data is valid so remove empty spaces amd store in order
					$extra[$box] ='Y';
				}
			}//end f
			if($ShowForm===FALSE)
			{
				//data is valid amd form does NOT need to be didplayed
				//connect to database
				include "inc_DBConnect.php";
				
				//sanitize data entered by user TODO put into sanitize function
				$orderID = mysqli_real_escape_string($DBConnection, $orderID);
				$size = mysqli_real_escape_string($DBConnection, $order['pizzaSize']);
				$price = mysqli_real_escape_string($DBConnection, $order['totalPrice']);
				$firstname = mysqli_real_escape_string($DBConnection, $order['firstName']);
				$lastname = mysqli_real_escape_string($DBConnection, $order['lastName']);
				$address = mysqli_real_escape_string($DBConnection, $order['address']);
				$email = mysqli_real_escape_string($DBConnection, $order['emailAddress']);
				$phone = mysqli_real_escape_string($DBConnection, $order['phoneNo']);
				$student = mysqli_real_escape_string($DBConnection, $extra['student']);
				$anchovies = mysqli_real_escape_string($DBConnection, $extra['addAnchovies']);
				$pineapple = mysqli_real_escape_string($DBConnection, $extra['addPineapple']);
				$pepperoni = mysqli_real_escape_string($DBConnection, $extra['addPepperoni']);
				$olives = mysqli_real_escape_string($DBConnection, $extra['addOlives']);
				$onion = mysqli_real_escape_string($DBConnection, $extra['addOnion']);
				$peppers = mysqli_real_escape_string($DBConnection, $extra['addPeppers']);
				
				//build SQL INSERT command string
				$SQLString = "INSERT INTO orders(order_id,student,firstname,lastname,email,address,phone,price,size,anchovies,pineapple,pepperoni,peppers,olives,onion)
							 VALUES ('$orderID', '$student', '$firstname', '$lastname', '$email', '$address', '$phone', '$price', '$size', '$anchovies', '$pineapple', '$pepperoni', '$olives', '$onion', '$peppers')";
							 
				
				// execute query
				$QueryResult = mysqli_query($DBConnection, $SQLString);
				
				if($QueryResult === FALSE)
				{
					//ONLY display error number at debug time
					echo "<p>There was an error saving the recored.<br />\n" .
										"The error was " .
										(mysqli_error($DBConnection)) .
										".<br />\nThe query was '" .
										($SQLString) . "'</p>\n";
				}
				else
				{
					include "Receipt.html.php";
				}
				
				
			}//end if $showForm is FALSE
			
		}
?>
</body>
</html>
