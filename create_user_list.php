<?php
	if(!empty($_POST["email"])){
		require 'include/db_connect.php';

		$userEmail = $_POST["email"];
		$stmt1 = $conn->prepare("SELECT * FROM newsLetter WHERE email = $userEmail");
		$stmt1->execute();

	if(mysqli_num_rows($stmt1)==0){ //if there isn't any with that $userMail
	$stmt2 = $conn->prepare ("INSERT INTO newsLetter (email) 
	VALUES (:email)");	
	$stmt2->bindParam(':email', $userEmail);
	$stmt2->execute();
	echo "success";
	}
	}else{
		echo "invalid";
	}




//'$secret_key'

?>