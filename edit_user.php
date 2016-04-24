<?php
require "include/security.php";
if(!isset($_SESSION['userName'])){
    header("Location:index.php");
}
?>
<html lang="en" hola_ext_inject="disabled">
<?php
include("include/admin-header.php");
include_once("include/nav-bar.php");

if(!empty($_SESSION['userName'])) {
    $user_request = filter_var($_SESSION['userName'], FILTER_SANITIZE_STRING);

    require "include/db_connect.php";
    $records = $conn->prepare('SELECT id,username,email,picture,bio FROM users WHERE username = :username');
    $records->bindParam(':username', $user_request);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $_SESSION['id']	= $results['id'];

    
    ?>
    <div id="page-wrapper">

        <div class="container">
            <h1 class="page-header">Edit Profile</h1>

            <div class="row">
                <!-- left column -->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="text-center">
                        <img src="<?php echo $results['picture']; ?>" class="img-circle img-thumbnail" style="height: 200px; width: 200px">
                        <h6>Upload a different photo...</h6>
                        <!--insert form for img upload -->

                        <form action="uploadp.php" style="padding-bottom: 30px;" method="post" class="text-center center-block well well-sm" enctype="multipart/form-data">
                            <div class="pull-left"><input type="file" name="fileToUpload" id="fileToUpload"></div>
                            <div class="pull-right"><input type="submit" class='btn btn-xs btn-primary' value="Upload" name="submit"></div>
                        </form>

                    </div>
                </div>
                <!-- edit form column -->
                <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                    <h3>Personal info</h3>

                    <form class="form-horizontal" role="form" method="post" action="user_edit_details.php">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Username:</label>

                            <div class="col-lg-8">
                                <input class="form-control" name="username" disabled="disabled" value="<?php echo $results['username']; ?>" type="text">
                                <input hidden="hidden" name="inputUsername" value="<?php echo $results['username']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>

                            <div class="col-lg-8">
                                <input class="form-control" name="inputEmail" value="<?php echo $results['email']; ?>" type="email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Bio:</label>

                            <div class="col-lg-8">
                                <textarea rows="5" class="form-control" name="inputBio"><?php echo $results['bio']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>

                            <div class="col-md-8">
                                <input class="btn btn-primary" value="Save Changes" type="submit">
                            </div>
                        </div>
                    </form>
                    <br/>

                    <form class="form-horizontal" role="form" method="post" action="user_new_password.php">
                        <h3>Change Password</h3>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Old Password</label>

                            <div class="col-md-8">
                                <input class="form-control" name="oldPassword" type="password">
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Password:</label>

                            <div class="col-md-8">
                                <input class="form-control" name="newPassword" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirm password:</label>

                            <div class="col-md-8">
                                <input class="form-control" name="confirmPassword" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>

                            <div class="col-md-8">
                                <input class="btn btn-primary" value="Change Password" type="submit">
                                <span></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
else {
    ?>
    <div class="container">
        <div style="padding-top: 40px">
            <div class='alert alert-warning' role='alert'>
                <a href='#' class='alert-link'>User not found!</a>
            </div>
        </div>
    </div>
    <?php
}
include_once("footer.php");
?>

