<?php
require "include/security.php";
    if(!isset($_SESSION['userName'])){
        header("Location:index.php");
    }
?>
<html lang="en" hola_ext_inject="disabled"><head>
    <?php
    include("include/admin-header.php")
    ?>
</head>

<body id="profile">

<?php
include_once("include/nav-bar.php");
require "include/db_connect.php";

$records = $conn->prepare('SELECT id,username,role,email,lastlogin,activated,picture,bio FROM users WHERE username = :username');
$records->bindParam(':username', $_SESSION['userName']);
$records->execute();
$result = $records->fetch(PDO::FETCH_ASSOC);
?>

    <div class="container" style="padding-top: 60px">
        <div class="row">
            <div class="container" >

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo $result['username']; ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center">
                                <img alt="User Pic" src="<?php echo $result['picture']; ?>" style="width: 150px; height: 150px;" class="img-circle img-thumbnail"></div>

                            <div class=" col-md-9 col-lg-9 ">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Name</td>
                                        <td><?php echo $result['username']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Email</td>
                                        <td><?php echo $result['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="glyphicon glyphicon-education" aria-hidden="true"></span> Role</td>
                                        <td><?php
											if ($result['role'] == -1) {
                                                echo '<span class="label label-default">Deactivated</span>';
                                            }
                                            if($result['role'] == 0 && $result['activated'] == 1){
                                                echo '<span class="label label-danger">Banned</span>';
                                            }
                                            if($result['role'] == 0 && $result['activated'] == 0){
                                                echo '<span class="label label-default">Pending</span>';
                                            }
                                            if($result['role'] == 1){
                                                echo '<span class="label label-default">User</span>';
                                            }
                                            if($result['role'] == 5){
                                                echo '<span class="label label-info">Administrator</span>';
                                            }
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Last login</td>
                                        <td><?php echo $result['lastlogin']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Bio</td>
                                        <td><i>
                                                <?php
                                                if ($result['bio']) {
                                                    echo $result['bio'];
                                                } 
                                                ?>
                                            </i></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a href="edit_user.php"><i class="glyphicon glyphicon-camera"></i> Change picture</a>
                        <span class="pull-right">
                            <a href="edit_user.php"><i class="glyphicon glyphicon-cog"></i> Edit profile</a>
                        </span>
                    </div>

                </div>
            </div>
        </div>
  
    </div>

<?php
include_once("include/footer.php");
?>

