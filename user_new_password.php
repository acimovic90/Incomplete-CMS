<html lang="en" hola_ext_inject="disabled"><head>
<?php
include("include/admin-header.php")
?>
</head>

<body>
    <?php
    include "include/nav-bar.php";
    require "include/security.php";
    require "include/functions.php";

//Checks the fields
    if(!empty($_POST["oldPassword"]) && !empty($_POST["newPassword"]) && !empty($_POST["confirmPassword"]))
    {
        $oldPassword = filter_var($_POST['oldPassword'], FILTER_SANITIZE_STRING);
        $newPassword = filter_var($_POST['newPassword'], FILTER_SANITIZE_STRING);
        $confirmPassword = filter_var($_POST['confirmPassword'], FILTER_SANITIZE_STRING);

        // Validating & Checks if Passwords are matching
        if(validate_password($newPassword) && $newPassword == $confirmPassword) {
            require "include/db_connect.php";

            //Checks the password against the database
            $records = $conn->prepare("SELECT username, password FROM users WHERE username = :username");
            $records->bindParam(':username', $_SESSION['userName']);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);

            if(count($results) > 0 && password_verify($oldPassword, $results['password'])){

                //Password = True
                if($results['username'] == $_SESSION['userName']){

                    $hash_userPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    //username & session matched
                    $stmt = $conn->prepare("UPDATE users SET password=:newPassword WHERE username=:username AND password=:oldPassword");
                    $stmt->bindParam(':username', $results['username']);
                    $stmt->bindParam(':oldPassword', $results['password']);
                    $stmt->bindParam(':newPassword', $hash_userPassword);
                    $stmt->execute();

                        $user_ip = getUserIP(); // Output IP address [Ex: 177.87.193.134]
                        $user_name = $_SESSION['userName'];
                        $location = "Updated password";

                        // prepare sql and bind parameters
                        $stmt1 = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
                            VALUES (:ipaddress, :username, :location, NOW())");
                        $stmt1->bindParam(':ipaddress', $user_ip);
                        $stmt1->bindParam(':username', $user_name);
                        $stmt1->bindParam(':location', $location);
                        $stmt1->execute();
                        ?>
                        <div class="container" style="padding-top: 40px">
                            <div class="alert alert-success" role="alert" align="center">
                                <p>Password was changed successfully!</p>
                                <p>Please login with your new password</p>
                            </div>
                        </div>
                        <script>
                            setTimeout(function(){location.href="logout.php"} , 2000);
                        </script>
                        <?php
                    } else {
                        ?>
                        <div class="container" style="padding-top: 40px">
                            <div class="alert alert-danger" role="alert" align="center">
                                <p>Something went Wrong! Please try again</p>
                            </div>
                        </div>
                        <script>
                            setTimeout(function(){location.href="edit_user.php"} , 4000);
                        </script>
                        <?php
                    }

                }
                else {
                //Password = False
                    ?>
                    <div class="container" style="padding-top: 40px">
                        <div class="alert alert-danger" role="alert" align="center">
                            <p>Wrong password!</p>
                        </div>
                    </div>
                    <script>
                        setTimeout(function(){location.href="edit_user.php"} , 4000);
                    </script>
                    <?php
                }
            }
            else
            {
            //Passwords are not matching
                ?>
                <div class="container" style="padding-top: 40px">
                    <div class="alert alert-danger" role="alert" align="center">
                        <p>Passwords did not match!</p>
                    </div>
                </div>
                <script>
                    setTimeout(function(){location.href="edit_user.php"} , 4000);
                </script>
                <?php
            }
        }
        else
        {
            ?>
            <div class="container" style="padding-top: 40px">
                <div class="alert alert-danger" role="alert" align="center">
                    <p>Please fill in the fields!</p>
                </div>
            </div>
            <script>
                setTimeout(function(){location.href="edit_user.php"} , 4000);
            </script>
            <?php
        }
        echo "</body></html>";