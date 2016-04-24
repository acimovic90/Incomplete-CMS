<?php
require "include/security.php";
require "include/functions.php";
if(!empty($_GET['id'])){
    $id = trim(strip_tags($_GET['id']));
    try {
        require "include/db_connect.php";

        // prepare sql and bind parameters
        $stmt = $conn->prepare("UPDATE users SET role='1', session_id=''  WHERE id=:id AND role='5'");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

                    $user_ip = getUserIP(); // Output IP address [Ex: 177.87.193.134]
                    $user_name = $_SESSION['username'];
                    $location = "Downgraded admin to user";

                    // prepare sql and bind parameters
                    $stmt1 = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
                    VALUES (:ipaddress, :username, :location, NOW())");
                    $stmt1->bindParam(':ipaddress', $user_ip);
                    $stmt1->bindParam(':username', $user_name);
                    $stmt1->bindParam(':location', $logaction);
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