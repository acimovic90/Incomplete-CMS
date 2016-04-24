<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
	//MySQLi Object-oriented
	// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); //the i stands for improved
	// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error); //if anything above is wrong the connection doesn't get established
} 

?>