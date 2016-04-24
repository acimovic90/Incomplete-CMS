<html lang="en" hola_ext_inject="disabled">
<head>
    <?php include("include/header.php"); ?>
</head>

<body>
    <?php 
    require "include/functions.php";
?>

<div class="container">

                <?php
                //GET's from email
                $userEmail = strip_tags(trim($_GET['e']));
                $secretKey = strip_tags(trim($_GET['k']));

                //Checks the password against the database
                require "include/db_connect.php";
                $records = $conn->prepare("SELECT email, activationkey, activated, username FROM users WHERE email=:email");
                $records->bindParam(':email', $userEmail);
                $records->execute();
                $results = $records->fetch(PDO::FETCH_ASSOC);

                if(count($results) > 0 && $results['activated'] == 0 && $results['email'] == $userEmail && $results['activationkey'] == $secretKey) {

                    try {
                        // prepare sql and bind parameters
                        // User is only allowed to use key once, hence the activated
                        $stmt = $conn->prepare("UPDATE users SET role = '1', activated='1' WHERE email=:email AND activationkey=:secretkey AND activated='0'");
                        $stmt->bindParam(':email', $userEmail);
                        $stmt->bindParam(':secretkey', $secretKey);
                        $stmt->execute();

                        $user_ip = getUserIP(); // Output IP address [Ex: 177.87.193.134]
                        $location = "User Activated ";

                        // prepare sql and bind parameters
                        $stmt1 = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
                        VALUES (:ipaddress, :username, :location, NOW())");
                        $stmt1->bindParam(':ipaddress', $user_ip);
                        $stmt1->bindParam(':username', $results['username']);
                        $stmt1->bindParam(':location', $location);
                        $stmt1->execute();

                        header("refresh:3;url=index.php");
                        ?>
                        <div style="padding-top: 40px">
                            <div class='alert alert-success' role='alert'>
                                <a href='#' class='alert-link'>Your profile was successfully activated</a>
                            </div>
                        </div>
                    <?php
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                } else {
                ?>
                <div style="padding-top: 40px">
                    <div class='alert alert-danger' role='alert'>
                        <p align="center">Something did not match!</p>
                        <p align="center">Are you sure you clicked the right link?</p>
                    </div>
                </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>
            </div> <!-- /container -->

<?php include 'include/footer.php'; ?>