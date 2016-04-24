<html lang="en" hola_ext_inject="disabled">
<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<?php include("include/header.php") ?>



<?php


if(!empty($_POST["userName"]) && !empty($_POST["userPassword"])) {

    //Logging the login try
    $_SESSION['login_try'] += 1;


    $userName = strip_tags(trim($_POST['userName']));
    $userPassword = strip_tags(trim($_POST['userPassword']));

    //Blocking the user after 20 tries (brute force check)
    if($_SESSION['login_try'] >= 20){ 
        //Sets the time of the block
        $_SESSION['blocked_time'] = time();
        //Saving info to the session - save to db later
        $_SESSION['failed_name'][] = $userName;
        //Ip log
        $_SESSION['failed_ip'] = $_SERVER['REMOTE_ADDR'];
        //Proxy log
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $_SESSION['failed_for'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        ?>
        <div class="container" style="padding-top: 40px">
            <div class="alert alert-danger" role="alert" align="center">
                <p>You have been logged out of the system</p>
                <p>The maximum amount of login attempts has been exceeded!</p>
            </div>
        </div>
        <?php
        exit;
    } 

    require "include/db_connect.php";
    $records = $conn->prepare('SELECT id,username,password,email,role, activated FROM users WHERE username = :username');
    $records->bindParam(':username', $userName);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if(count($results) > 0 && password_verify($userPassword, $results['password'])){ //start here
        echo "<body>";
        if($results['role'] > 0) {
                //Resets the login try to 0
            $_SESSION['login_try'] = 0;
                //Regenerates new session id
            session_regenerate_id();
            $_SESSION['userName'] = $results['username'];

                //Setting activity
            $_SESSION['last_activity'] = time();

                //Logged in time + add new session id
            $update = $conn->prepare("UPDATE users SET lastlogin=NOW(), session_id=:session_id WHERE id=:id");
            $update->bindParam(':id', $results['id']);
            $update->bindParam(':session_id', session_id());
            $update->execute();

            function getUserIP()
            {
                $client  = @$_SERVER['HTTP_CLIENT_IP'];
                $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
                $remote  = $_SERVER['REMOTE_ADDR'];

                if(filter_var($client, FILTER_VALIDATE_IP))
                {
                    $ip = $client;
                }
                elseif(filter_var($forward, FILTER_VALIDATE_IP))
                {
                    $ip = $forward;
                }
                else
                {
                    $ip = $remote;
                }
                return $ip;
            }
                    $user_ip = getUserIP(); // Output IP address [Ex: 177.87.193.134]
                    $user_name = $_SESSION['userName'];
                    $location = "User signed in";

                    // prepare sql and bind parameters
                    $stmt = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
                        VALUES (:ipaddress, :username, :location, NOW())");
                    $stmt->bindParam(':ipaddress', $user_ip);
                    $stmt->bindParam(':username', $user_name);
                    $stmt->bindParam(':location', $location);
                    $stmt->execute();

                    ?>
                    <?php
                    if($results['role'] == 5){
                        $_SESSION['adminRole'] = 1;
                        ?>
                        <script type="text/javascript">
                            window.location = "/administration.php"
                        </script>
                        <?php
                    }                    
                }
                else {
                  if ($results['activated'] == 0){
                    ?>
                    <div class="container" style="padding-top: 40px">
                        <div class="alert alert-danger" role="alert" align="center">
                            <p>Your account is not yet activated</p>
                            <p>Please check your email for the activation link</p>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="container" style="padding-top: 40px">
                        <div class="alert alert-danger" role="alert" align="center">
                            <p>You have been banned</p>
                        </div>
                    </div>
                    <?php
                }
            }
        /*end here*/   } else {
            ?>
            <body onLoad="$('#loginModal').modal('show');">
                <div class="container" style="padding-top: 40px">
                    <div class="alert alert-danger" role="alert" align="center">
                        <p>Username and Password did not match!</p>
                    </div>
                </div>
                <?php
            }

        } else {
            ?>
            <div class="container" style="padding-top: 40px">
                <div class="alert alert-danger" role="alert" align="center">
                    <p>Please fill in the fields!</p>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
      // include_once("includes/scripts.php");
        ?>
    </body></html>