<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require "include/security.php"; //all in the folder include!!
require "include/functions.php";
require "include/db_connect.php";

if(!$_SESSION['userName'] == '' || !$_SESSION['userName'] == NULL) {

    $user_ip = getUserIP(); // Output IP address [Ex: 177.87.193.134]
    $username = $_SESSION['userName'];
    $location = "User logged out";

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
    VALUES (:ipaddress, :username, :location, NOW())");
    $stmt->bindParam(':ipaddress', $user_ip);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':location', $location);
    $stmt->execute();

    session_destroy();
}
header('location: admin-login.php');
?>