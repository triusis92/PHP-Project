<?php
	$hostname = "localhost";
	$username = "root";
	$password = "";
// connect and select MYySQL pizza database
	 $DBConnection = mysqli_connect($hostname,$username,$password);
	 
	 if($DBConnection===FALSE)
	 {
		 $error = "<p>Unable to connect to databse server</p>\n";
		 echo $error;
		 exit;
	 }
	 else
	 {
		 $DBName = "pizza";
		 if(!mysqli_select_db($DBConnection,$DBName))
		 {
			 $error = "<p>Unable to select $DBName database</p>\n";
			 echo $error;
			 exit;
		 }
	 }
	 
?>