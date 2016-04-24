<?php
session_start();
$session_user = $_SESSION['userName'];
$session_id = session_id();

//Checks for user activity
if(time() - $_SESSION['last_activity'] > 600) { // 10 minutes
    header("Location:logout.php");
}

require "include/db_connect.php";
$records = $conn->prepare("SELECT username, session_id FROM users WHERE username = :username AND session_id = :session_id");
$records->bindParam(':username', $session_user);
$records->bindParam(':session_id', $session_id);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

if($results['session_id'] == $session_id && $results['username'] == $session_user){
    //user approved
} else {
    //user denied
    header("Location:logout.php");
}

$blacklisted = array(); //94.18.243.144
if (in_array ($_SERVER['REMOTE_ADDR'], $blacklisted)) {
    echo "You are blocked";
    exit;
}

?>