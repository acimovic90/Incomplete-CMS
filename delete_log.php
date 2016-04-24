<?php
require "include/security.php";
if(!isset($_SESSION['adminRole'])) {
    header('Location:index.php');
}

if(!empty($_GET['id'])){
    $id = trim(strip_tags($_GET['id']));
    try {
        require "include/db_connect.php";

        // prepare sql and bind parameters
        $stmt = $conn->prepare("DELETE FROM log WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header("location: activity_log.php");

    } //ERROR
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} 
    elseif(empty($_GET['id'])) {
        $stmt = $conn->prepare("DELETE FROM log");
        $stmt->execute();
        header("location: activity_log.php");
} else{
     echo "Error!";
}