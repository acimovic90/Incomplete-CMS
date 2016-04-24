<html lang="en" hola_ext_inject="disabled">
<head>
	<?php
	include("include/header.php")
	?>
</head>

<body>
	<?php
	require "include/functions.php";

	if(!empty($_POST["userName"]) && !empty($_POST["userEmail"]) && !empty($_POST["userPassword"])) {

		if(validate_username($_POST["userName"]) && validate_password($_POST["userPassword"]) && validate_email($_POST["userEmail"])) {
			$userName = validate_username($_POST["userName"]);
			$userEmail = validate_email($_POST["userEmail"]);
			$userPassword = validate_password($_POST["userPassword"]);

        //Activation key
			$activation_key = sha1(mt_rand(10000, 99999) . time() . $userEmail);

        //Password_hash
			$hash_userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

			try {
				require "include/db_connect.php";

            // prepare sql and bind parameters
				$stmt = $conn->prepare("INSERT INTO users (username, password, email, activationkey, keytimeout)
					VALUES (:username, :password, :email, :activationkey, NOW())");
				$stmt->bindParam(':username', $userName);
				$stmt->bindParam(':password', $hash_userPassword);
				$stmt->bindParam(':email', $userEmail);
				$stmt->bindParam(':activationkey', $activation_key);
				$stmt->execute();

            $user_ip = getUserIP(); // Output IP address [Ex: 177.87.193.134]
            $location = "User was created (need activation)";

            // prepare sql and bind parameters
            $stmt2 = $conn->prepare("INSERT INTO newsLetter (email)
            	VALUES (:email)");
            $stmt2->bindParam(':email', $userEmail);
            $stmt2->execute();


            // prepare sql and bind parameters
            $stmt3 = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
            	VALUES (:ipaddress, :username, :location, NOW()+INTERVAL 1 DAY)");
            $stmt3->bindParam(':ipaddress', $user_ip);
            $stmt3->bindParam(':username', $userEmail);
            $stmt3->bindParam(':location', $location);
            $stmt3->execute();

            //ACCEPTED
            $sMessage = "Hi, $userName. To activate your account please click here: http://adgrego.dk/activate_user.php?e=$userEmail&k=$activation_key";
            //activate_user needs to be designed
            $sSendMessage= rawurlencode($sMessage);
            mail($userEmail ,"Activate your account",rawurldecode($sSendMessage));
            ?>

            <div class="container" style="padding-top: 40px">
            	<div class="alert alert-success" role="alert" align="center">
            		<p>Your account was successfully created!</p>
            		<p>Consult your email <strong><?php echo $userEmail; ?></strong> to activate it</p>
            	</div>
            </div>
            <?php

        } //ERROR
        catch (PDOException $e) {
        	echo "Error: " . $e->getMessage();
        }
        $conn = null;
    }
} else {
	?>
	<div class="container" style="padding-top: 40px">
		<div class="alert alert-danger" role="alert" align="center">
			<p>Please fill in the fields!</p>
		</div>
	</div>
	<?php
	header("refresh:2;url=index.php");
	exit;
}


?>
<?php include 'include/footer.php'; ?>