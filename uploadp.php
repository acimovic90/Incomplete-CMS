<?php
require "include/security.php";
$target_dir = "p_upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 2097152) {
    echo "Sorry, your file is too large. Limit is 2M";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
//Removing semicolon from filename
if (strpos($target_file, ';') !== FALSE) {
    echo 'Semicolons in the filename are not allowed';
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    exit;
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        
    } else {
        echo "Sorry, there was an error uploading your file to ".$target_file;
    }
	
}

require "include/db_connect.php";

$id = $_SESSION['id'];
//echo "user id = ".$id;

$records = $conn->prepare('Update users set picture= :picture where id = :id');
$records->bindParam(':picture', $target_file);
$records->bindParam(':id', $id);
$records->execute();

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
    $logaction = "Uploaded new profile picture";

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO log (ipaddress, username, location, ts)
    VALUES (:ipaddress, :username, :location, NOW())");
    $stmt->bindParam(':ipaddress', $user_ip);
    $stmt->bindParam(':username', $user_name);
    $stmt->bindParam(':location', $location);
    $stmt->execute();
                    
header("Location:edit_user.php");
?>