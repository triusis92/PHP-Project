<!DOCTYPE html>
<head>
	<title>Pizza Order Receipt</title>
	<meta charset="utf-8">
</head>

<body>
<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include "inc_DBConnect.php";
	$OrderID = $_SESSION['oid'];
	
	
	$SQLReceiptString = "SELECT * FROM orders WHERE order_id ='".$OrderID."'";
	
	
	$QueryResult = mysqli_query($DBConnection, $SQLReceiptString);
	if($QueryResult===FALSE)
	{
		echo "<p>There was a problem</p>";
	}
	else if(mysqli_num_rows($QueryResult)==0)
	{
		echo "<p>There are no orders</p>";
	}
	else
	{
		echo "<h1 align='center'>Invoice</h1>";
		echo "<table border='1' cellspacing='0'>\n";
		echo "<tr><th>Order ID</th>".
			 "<th>Student</th>".
			 "<th>First Name</th>".
			 "<th>Last Name</th>".
			 "<th>Email</th>".
			 "<th>Address</th>".
			 "<th>Phone No</th>".
			 "<th>Price</th>".
			 "<th>Size</th>".
			 "<th>Anchovies</th>".
			 "<th>Pineapple</th>".
			 "<th>Pepperoni</th>".
			 "<th>Peppers</th>".
			 "<th>Olives</th>".
			 "<th>Onions</th>".
			 "<th>&nbsp;</th></tr>\n";
			 
		while($order = mysqli_fetch_assoc($QueryResult))
		{
			echo "<tr><td>".$order['order_id']."</td>".
				 "<td>".$order['student']."</td>".
				 "<td>".$order['firstname']."</td>".
				 "<td>".$order['lastname']."</td>".
				 "<td>".$order['email']."</td>".
				 "<td>".$order['address']."</td>".
				 "<td>".$order['phone']."</td>".
				 "<td>".$order['price']."</td>".
				 "<td>".$order['size']."</td>".
				 "<td>".$order['anchovies']."</td>".
				 "<td>".$order['pineapple']."</td>".
				 "<td>".$order['pepperoni']."</td>".
				 "<td>".$order['peppers']."</td>".
				 "<td>".$order['olives']."</td>".
				 "<td>".$order['onion']."</td>".
				 "<td><a href=\"UpdateOrder.php?order_id=".
						$order['order_id']."\">Update</a></td>".
				"<td><a href=\"DeleteOrder.php?order_id=".
						$order['order_id']."\">Delete</a></td>".
				"</tr>\n";
		}
		echo "</table>\n";
	}
	
	
?>

</body>
</html>