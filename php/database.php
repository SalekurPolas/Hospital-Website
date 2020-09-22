<?php
	session_start();
	$conn = mysqli_connect('localhost', 'root', '');
	$db = mysqli_select_db($conn, 'test');

	$check = mysqli_query($conn, 'select 1 from `users`');

	if($check == FALSE){
		$create = "CREATE TABLE users (
			id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(30) NOT NULL,
			email VARCHAR(50) NOT NULL,
			bdate VARCHAR(20) NOT NULL,
			occupation VARCHAR(30) NOT NULL,
			phone VARCHAR(20) NOT NULL,
			password VARCHAR(30) NOT NULL
		)";

		if (!mysqli_query($conn, $create)) {
			echo "Error found! Please try again later. <br>";
		}
	}
?>