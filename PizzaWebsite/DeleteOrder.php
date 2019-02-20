<html>
	<head>
	<title>Delete Order</title>
	<meta charset ="utf-8" />
</head>

<body>
    
<?php
		session_start();
		$OrderID = $_SESSION['oid'];
		if(isset($_GET['confirm']))
		{
			include "inc_DBConnect.php";
			$SQLDeleteString = "DELETE FROM orders WHERE order_id ='".$OrderID."'";
			$QueryResult = mysqli_query($DBConnection, $SQLDeleteString);
			if($QueryResult===FALSE)
			{
				echo "<p>There was a problem with query</p>";
			}
			else
			{
				 echo "Order deleted successfully.";
			}
		}
		else
		{
			echo "<p>Are you sure?</p>";
			echo "<a href=\"DeleteOrder.php?order_id=$OrderID&confirm=true\">Yes</a><br>";
			echo "<a href=\"Receipt.html.php?order_id=$OrderID\">No</a><br>";
		}
?>
<a href="OrderPizza.html">Make another order!</a>
</body>
</html>