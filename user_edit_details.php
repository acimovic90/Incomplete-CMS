<?php
require "include/security.php";
require "include/functions.php";

//Checks the fields
if(!empty($_POST["inputEmail"]) && !empty($_POST["inputBio"]) && $_SESSION['userName']) {
    $inputUsername = filter_var($_POST['inputUsername'], FILTER_SANITIZE_STRING);
    $inputEmail = filter_var($_POST['inputEmail'], FILTER_SANITIZE_EMAIL);
    $inputBio = filter_var($_POST['inputBio'], FILTER_SANITIZE_STRING);

        require "include/db_connect.php";

        //Checks the password against the database
        $records = $conn->prepare("SELECT username, email, bio FROM users WHERE username = :username");
        $records->bindParam(':username', $_SESSION['userName']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        if(count($results) > 0 && $inputUsername && validate_email($inputEmail)){

            //Password = True
            if($results['username'] == $_SESSION['userName'] && $_SESSION['profileCount'] < 10){

                //username & session matched
                $stmt = $conn->prepare("UPDATE users SET email=:email, bio=:bio WHERE username=:username");
                $stmt->bindParam(':username', $inputUsername);
                $stmt->bindParam(':email', $inputEmail);
                $stmt->bindParam(':bio', $inputBio);
                $stmt->execute();

                //Limit user profile update to 10 times pr. session
                $_SESSION['profileCount'] += 1;

                    $user_ip = getUserIP(); // Output IP address [Ex: 177.87.193.134]
                    $user_name = $_SESSION['userName'];
                    $location = "Updated user profile";

                    // prepare sql and bind parameters
                    $stmt1 = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
                    VALUES (:ipaddress, :username, :location, NOW())");
                    $stmt1->bindParam(':ipaddress', $user_ip);
                    $stmt1->bindParam(':username', $user_name);
                    $stmt1->bindParam(':location', $location);
                    $stmt1->execute();

                header("location: my_profile.php");
            } else {
                //Blocked from updating account, limit of 10 times exceeded
                header("location: my_profile.php");
            }
        }
} else {
    include "include/header.php";
?>
<div class="container">
    <div style="padding-top: 40px">
        <div class='alert alert-warning' role='alert'>
            <a href='' class='alert-link'>Error!</a>
        </div>
    </div>
</div>
<?php
}