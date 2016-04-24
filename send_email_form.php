<?php
if(!empty($_POST["email"])){
  $email = $_POST["email"];

  $EmailAdgrego = "adgregoapp@adgrego.dk";
  $EmailUser = $email;
  $SubjectAdgrego = "User has signed up for the News Letter";
  $SubjectUser = "Welcome To Adgrego";
// prepare email body text

  $Body .= "Email: ";
  $Body .= $email;
  $Body .= "\n";

  $msg .= "Welcome ";
  $msg .= "Dear member ";
  $msg .= " To Adgrego! We look forward to have you to inform you about the newest events around our app.";
// send email
  mail($EmailAdgrego, $SubjectAdgrego, $Body, "From:".$email);
  mail($EmailUser, $SubjectUser, $msg, "From:".$EmailAdgrego);
  echo "success";

}else{
  echo "invalid";
}

?>