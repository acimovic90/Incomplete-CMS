<?php
function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        ?>
        <div class="container" style="padding-top: 40px">
            <div class="alert alert-danger" role="alert" align="center">
                <p>Invalid Email!</p>
            </div>
        </div>
        <?php
        return false;
    }
    return $email;
}
function validate_username($user) {
    $trim_user = trim($user);
    $userName = filter_var($trim_user, FILTER_SANITIZE_STRING);
    $aValid = array('-', '_', '!', '.');

    if(!ctype_alnum(str_replace($aValid, '', $userName))) {
        ?>
        <div class="container" style="padding-top: 40px">
            <div class="alert alert-danger" role="alert" align="center">
                <p>Your username is not properly formatted.</p>
            </div>
        </div>
        <?php
        return false;
    }

    if(strlen($userName) < 4 || strlen($userName) > 15) {
        //Format okay, check length
        ?>
        <div class="container" style="padding-top: 40px">
            <div class="alert alert-danger" role="alert" align="center">
                <p>Username needs to be between 4 & 15 characters!</p>
            </div>
        </div>
        <?php
        return false;
    }
    return $userName;
}
function validate_password($pass) {
    $error = NULL;
    //Password validate
    $userPassword = trim($pass);
    if(strlen($userPassword) < 8 ) {$error .= "<p>Password too short!</p>";}
    if(strlen($userPassword) > 20 ) {$error .= "<p>Password too long!</p>";}
    if(!preg_match("#[0-9]+#", $userPassword) ) {$error .= "<p>Password must include at least one number!</p>";}
    if(!preg_match("#[a-z]+#", $userPassword) ) {$error .= "<p>Password must include at least one letter!</p>";}
    if(!preg_match("#[A-Z]+#", $userPassword) ) {$error .= "<p>Password must include at least one CAPS!</p>";}
    //if( !preg_match("#\W+#", $userPassword) ) {$error .= "<p>Password must include at least one symbol!</p>";}
    if($error){
        ?>
        <div class="container" style="padding-top: 40px">
            <div class="alert alert-danger" role="alert" align="center">
                <p>Password validation failure(your choice is weak):</p>
                <?php echo $error; ?>
            </div>
        </div>
        <?php
        return false;
    } else {
        return $userPassword;
    }
}

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