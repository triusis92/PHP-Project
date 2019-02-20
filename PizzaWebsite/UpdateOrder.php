<html>
<head>  
	<meta charset = "utf-8">
	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Update Order</title>
	<script type="text/javascript">
	function redraw()
	{

		var pizzaPrice = 0;


		// default to large
		pizzaImageSize = 250;
		pizzaBasePrice = 12;
		pricePerTopping = 1;
		

	if (document.getElementById('small').checked==true)
		{

		pizzaImageSize = 100;
		pizzaBasePrice = 6;
		pricePerTopping = .5;
		}

	if (document.getElementById('medium').checked==true)
		{
		
		pizzaImageSize = 180;
		pizzaBasePrice = 10;
		pricePerTopping = 1;
		}
		
		
	document.getElementById('image1').height=pizzaImageSize;
	document.getElementById('image1').width=pizzaImageSize;
	document.getElementById('image2').height=pizzaImageSize;
	document.getElementById('image2').width=pizzaImageSize;
	document.getElementById('image3').height=pizzaImageSize;
	document.getElementById('image3').width=pizzaImageSize;
	document.getElementById('image4').height=pizzaImageSize;
	document.getElementById('image4').width=pizzaImageSize;
	document.getElementById('image5').height=pizzaImageSize;
	document.getElementById('image5').width=pizzaImageSize;
	document.getElementById('image6').height=pizzaImageSize;
	document.getElementById('image6').width=pizzaImageSize;
	document.getElementById('image7').height=pizzaImageSize;
	document.getElementById('image7').width=pizzaImageSize;

	// do the toppings
	howManyToppings = 0;

	if (document.getElementById('anchovies').checked==true)
		{
		document.getElementById('image2').style.visibility = "visible";
		howManyToppings = howManyToppings + 1;
		}
	else
		{
		document.getElementById('image2').style.visibility = "hidden";
		}
		
		
		
	if (document.getElementById('pineapple').checked==true)
		{
		document.getElementById('image3').style.visibility = "visible";
		howManyToppings = howManyToppings + 1;
		}
	else
		{
		document.getElementById('image3').style.visibility = "hidden";
		}
		
		
		
		
		
	if (document.getElementById('pepperoni').checked==true)
		{
		document.getElementById('image4').style.visibility = "visible";
		howManyToppings = howManyToppings + 1;
		}
	else
		{
		document.getElementById('image4').style.visibility = "hidden";
		}
		
		

		
		
		
	if (document.getElementById('olives').checked==true)
		{
		document.getElementById('image5').style.visibility = "visible";
		howManyToppings = howManyToppings + 1;
		}
	else
		{
		document.getElementById('image5').style.visibility = "hidden";
		}
		
		

		
		
		
	if (document.getElementById('onion').checked==true)
		{
		document.getElementById('image6').style.visibility = "visible";
		howManyToppings = howManyToppings + 1;
		}
	else
		{
		document.getElementById('image6').style.visibility = "hidden";
		}
		
		

		
		
		
	if (document.getElementById('peppers').checked==true)
		{
		document.getElementById('image7').style.visibility = "visible";
		howManyToppings = howManyToppings + 1;
		}
	else
		{
		document.getElementById('image7').style.visibility = "hidden";
		}
		
		

		
	// calculate price
	pizzaPrice = pizzaBasePrice + pricePerTopping * howManyToppings;
	document.getElementById('pricetext').innerHTML = pizzaPrice;
	document.getElementById('totalPrice').value = pizzaPrice; // MOC for submission to server
	}

	function validateInput ()
	{
	var valid  = new Boolean(true);

	if (document.getElementById("cname").value == "")
		{
		valid = false;
		document.getElementById("cname").style.backgroundColor = "#ff0000";
		}
		else
		{
		document.getElementById("cname").style.backgroundColor = "#99ff99";
		}

	if (document.getElementById("caddress").value == "")
		{
		valid = false;
		document.getElementById("caddress").style.backgroundColor = "#ff0000";
		}
		else
		{
		document.getElementById("caddress").style.backgroundColor = "#99ff99";
		}


	return valid;
	}


	</script>
</head> 

<body onload="redraw()"> 
<?php
$ShowForm = FALSE;//set show form boolean to false
$inputs = array('firstName', 'lastName', 'emailAddress', 'address', 'phoneNo', 'totalPrice','pizzaSize');//array for manadatory inputs
$checkBoxes = array('student','addAnchovies','addPineapple','addPepperoni','addOlives','addOnion','addPeppers');//arrau for optional inputs
$order = array();//hold the order, main inputs
$extra = array();//hold checkbox inputs

include "inc_DBConnect.php";
				
				if(isset($_POST['submit']))
				{
					session_start();//start session
					$OrderID = $_SESSION['oid'];//set session Order id
					foreach($inputs as $input)
					{
						$order[$input] = "";//initialize each element of order to empty string	
					}				
					foreach($inputs as $input)
					{
						//validate user entered data				
						if((!isset($_POST[$input])) || (strlen(trim(($_POST[$input])))==0))
						{
								echo "<p>'$input' is a required field.</p>\n";
								$ShowForm = TRUE;//need to redisplay form so user can correct errors
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
							$extra[$box] ='Y';
						}
					}
					if($ShowForm===FALSE)//if form is not displayed
					{					
						//sanitise data
						$OrderID = mysqli_real_escape_string($DBConnection, $OrderID);
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
						//update the order
						$SQLString = "UPDATE orders
									 SET
									 student = '$student',firstname = '$firstname', lastname = '$lastname',
									 email = '$email', address = '$address', phone = '$phone', price = '$price',
									 size = '$size', anchovies = '$anchovies', pineapple = '$pineapple', pepperoni = '$pepperoni',
									 peppers = '$peppers', olives = '$olives', onion = '$onion'
									 WHERE order_id ='".$OrderID."'";
									 									 
						// execute query
						$QueryResult = mysqli_query($DBConnection, $SQLString);				
						if($QueryResult === FALSE)//check if query was executed
						{
							//ONLY display error number at debug time
							echo "<p>There was an error updating the recored.<br />\n" .
										"The error was " .
										(mysqli_error($DBConnection)) .
										".<br />\nThe query was '" .
										($SQLString) . "'</p>\n";
						}
						else
						{
							include "Receipt.html.php";//display updated reciept
						}						
					}
				}
				else
				{
					$OrderID = $_GET['order_id'];//get order id from reciept
					session_start();//start session again
					$_SESSION['oid'] = $OrderID;//initailise session order id
					$SQLString="SELECT * FROM orders WHERE order_id='$OrderID'";//get specified order
						
					$QueryResult=mysqli_query($DBConnection,$SQLString);
					if($QueryResult===FALSE)
					{
						echo "<p>There was an error retrieving the record.<br/>\n". 
						"The error was " . 
						(mysqli_error[$DBConnection]) . "<br>\nThe Query was '" . ($SQLString) ."'</p>\n";					
					}	
						
					$row = mysqli_fetch_assoc($QueryResult);//fetch a row with specified id as array
					
					$student = $row['student'];
					if($student == "Y")//if student checkbox is ticked
					{
						$student = "checked";//set student variable to checked
					}
					else
					{
						$student = null;//checkbox is not ticked
					}
					//assign input variables to specified index in row		
					$firstname = $row['firstname'];
					$lastname = $row['lastname'];
					$email = $row['email'];
					$address = $row['address'];
					$phone = $row['phone'];
					$price = $row['price'];
							
					$small = null;
					$medium = null;
					$large  = null;
								
					if($row['size'] == "large")//check which radio buttons are selected
					{
						$large = "checked";
					}
					else if($row['size'] == "medium")
					{
						$medium = "checked";
					}
					else
					{
						$small = "checked";
					}
					//check	if if any toppings are selected	
					$anchovies = $row['anchovies'];
					if($anchovies == "Y")
					{
						$anchovies = "checked";
					}
					else
					{
						$anchovies = null;
					}
							
					$pineapple = $row['pineapple'];
					if($pineapple == "Y")
					{
						$pineapple = "checked";
					}
					else
					{
						$pineapple = null;
					}
							
					$pepperoni = $row['pepperoni'];
					if($pepperoni == "Y")
					{
						$pepperoni = "checked";
					}
					else
					{
						$pepperoni = null;
					}
							
					$peppers = $row['peppers'];
					if($peppers == "Y")
					{
						$peppers = "checked";
					}
					else
					{
						$peppers = null;
					}
							
					$olives = $row['olives'];
					if($olives == "Y")
					{
						$olives = "checked";
					}
					else
					{
						$olives = null;
					}
							
					$onion = $row['onion'];
					if($onion == "Y")
					{
						$onion = "checked";
					}
					else
					{
						$onion = null;
					}

					$ShowForm=TRUE;//redisplay the sticky form					
				}

				if($ShowForm===TRUE)
				{
				?>
						<form  id="pizza-form"  action="UpdateOrder.php" onSubmit="return validateInput();" name="orderPizza" method="post" >
					  <h3>What Size of Pizza Would You Like? </h3>
					 
						Small
						<input id="small" type="radio" name="pizzaSize" value="small" onChange="redraw()" <?php echo $small; ?>/>
						Medium
						<input id="medium" type="radio" name="pizzaSize" value="medium" onChange="redraw()" <?php echo $medium; ?> />
						Large
						<input id="large" type="radio" name="pizzaSize" value="large" onChange="redraw()" <?php echo $large; ?> />
				   
					  <div id="pizzaImages">
						<img id="image1" src="images/base.png" width="250" height="250"/>
						<img id="image2" src="images/anchois.png" width="250" height="250"/>
						<img id="image3" src="images/pineapple.png" width="250" height="250"/>
						<img id="image4" src="images/pepperoni.png" width="250" height="250"/>
						<img id="image5" src="images/olives.png" width="250" height="250" />
						<img id="image6" src="images/onion.png" width="250" height="250" />
						<img id="image7" src="images/pepper.png" width="250" height="250"/>
					  </div>
					  <br>
					  <h3>Add Extra Toppings</h3>
					
						Anchovies
					   <input id="anchovies" type="checkbox" name="addAnchovies" value="y" onChange="redraw()" <?php echo $anchovies; ?>/>
					   
						Pineapple
					  <input id="pineapple" type="checkbox" name="addPineapple" value="y" onChange="redraw()" <?php echo $pineapple; ?>/>
					  
						Pepperoni
					   <input id="pepperoni" type="checkbox" name="addPepperoni" value="y" onChange="redraw()" <?php echo $pepperoni; ?>/>
					   
						Olives
						<input id="olives" type="checkbox" name="addOlives" value="y" onChange="redraw()" <?php echo $olives; ?>/>
						
						Onion
						<input id="onion" type="checkbox" name="addOnion" value="y" onChange="redraw()" <?php echo $onion; ?>/>
						
						Peppers
						<input id="peppers" type="checkbox" name="addPeppers" value="y" onChange="redraw()" <?php echo $peppers; ?>/>
				   
				   
				   
				   
				   
					 <h3>Total Price is: €<span id="pricetext">18</span></h3>
					 <input name="totalPrice" id="totalPrice" type="hidden" value = "<?php echo $order['totalPrice'];?>" />
					 
					  
						<h3>Enter your  details</h3>
						First Name:
						<input name="firstName" id="cname" type="text" value = "<?php echo $firstname; ?>" required />
						<br/>
						<br/>
						Last Name:
						<input name="lastName" id="cname" type="text" value = "<?php echo $lastname; ?>" required />
						<br/>
						<br/>
						Address:
						<textarea name="address" id = "caddress" type="text" rows="5" cols="30" required><?php echo $address; ?></textarea>
						<br/>
						<br/>
						Email Address:
						<input name="emailAddress" type="email" value = "<?php echo $email; ?>" required />
						<br/>
						<br/>
					   
						<br/>
						Phone Number:
						<input name="phoneNo" id="phoneNumber" type="text" value = "<?php echo $phone; ?>" required/>
						 <br/>
						 <br/>
						Tick here if you are student:
						<input type="checkbox" id="studentdiscount" name="student" onChange="redraw()" <?php echo $student; ?>/>
					   				  
					  <br/>
					  <button type="submit" name = "submit" value="submit" >Submit order</button>
					</form>
				<?php
				}
?>     
		
</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                          