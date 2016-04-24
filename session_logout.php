<?php
require "include/security.php";
if(!empty($_GET['id'])){
    $id = trim(strip_tags($_GET['id']));
    try {
        require "include/db_connect.php";

        // prepare sql and bind parameters
        $stmt = $conn->prepare("UPDATE users SET session_id='' WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header("location: admin_list_users.php");

    } //ERROR
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    echo "Error!";
}