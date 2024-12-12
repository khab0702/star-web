<?php

    $name= $_POST['name'];
	$num = $_POST['num'];
	$od = $_POST['od '];

	// Database connection
	$conn = mysqli_connect('localhost','root','','food');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} 
	else {
	echo "Registration successfully...";
    }
    ?>