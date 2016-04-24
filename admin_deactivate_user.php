<?php
require "include/security.php";
if(!empty($_GET['id'])){
    $id = trim(strip_tags($_GET['id']));
    try {
        require "include/db_connect.php";

        // prepare sql and bind parameters
        $stmt = $conn->prepare("UPDATE users SET role='0', session_id='' WHERE id=:id AND role='1'");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

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
                    $user_name = $_SESSION['username'];
                    $location = "Banned a user";

                    // prepare sql and bind parameters
                    $stmt1 = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
                    VALUES (:ipaddress, :username, :location, NOW())");
                    $stmt1->bindParam(':ipaddress', $user_ip);
                    $stmt1->bindParam(':username', $user_name);
                    $stmt1->bindParam(':location', $location);
                    $stmt1->execute();

        header("location: admin_list_users.php");

    } //ERROR
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    echo "Error!";
}