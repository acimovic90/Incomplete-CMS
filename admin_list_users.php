<?php
//checks for admin rights
require "include/security.php";
if(!isset($_SESSION['adminRole'])) {
    header('location: index.php');
}
require "include/db_connect.php";

$sql     = "SELECT id,username,email,lastlogin,session_id,activated FROM users WHERE role='5'";
$query   = $conn->prepare($sql);
$query->execute();
$result5 = $query->fetchAll( PDO::FETCH_ASSOC );

$sql     = "SELECT id,username,email,lastlogin,session_id,activated FROM users WHERE role='1'";
$query   = $conn->prepare($sql);
$query->execute();
$result1 = $query->fetchAll( PDO::FETCH_ASSOC );

$sql     = "SELECT id,username,email,lastlogin,session_id,activated FROM users WHERE role='0'";
$query   = $conn->prepare($sql);
$query->execute();
$result0 = $query->fetchAll( PDO::FETCH_ASSOC );

?>
<html lang="en" hola_ext_inject="disabled"><head>
<?php
include("include/header.php")
?>
</head>

<body id="Administration">

    <div class="container">
        <h1 class="page-header">Manage users</h1>

        <?php if($result5){ ?>
        <!-- ADMINISTRATORS -->
        <div class="panel panel-primary">
            <div class="panel-heading">Administrators<a data-toggle="modal" data-target="#createModal"><span class="add-user-right glyphicon glyphicon-user" aria-hidden="true"></span> <span class="glyphicon-class"></span>
                <span class="add-user-right glyphicon glyphicon-plus" aria-hidden="true"></span> <span class="glyphicon-class"></span></a></div>

                <!-- Modal create -->
                <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form class="form-signin" action="create_user.php" method="post">
                                    <h2 class="form-signin-heading">Create user</h2>
                                    <input class="form-control" type="text" name="userName" placeholder="Username">
                                    <input class="form-control" type="email" name="userEmail" placeholder="Email">
                                    <input class="form-control" type="password" name="userPassword" placeholder="Password">
                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                

                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Last Login</th>
                            <th>Session id</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $result5 as $row ){
                            echo "<tr><td class='col-md-1'>";
                            ?>
                            <a href="admin_to_user.php?id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
                            <a href='session_logout.php?id=<?php echo $row['id']; ?>'><span class='glyphicon glyphicon-off' aria-hidden='true'></span></a>
                            <?php
                            echo "</td><td class='col-md-1'>";
                            echo $row['id'];
                            echo "</td><td class='col-md-2'>";
                            echo $row['username'];
                            echo "</td><td class='col-md-3'>";
                            echo $row['email'];
                            echo "</td><td class='col-md-2'>";
                            echo $row['lastlogin'];
                            echo "</td><td class='col-md-2'>";
                            echo $row['session_id'];
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        if($result1){ ?>
        <!-- ACTIVE -->
        <div class="panel panel-primary">
            <div class="panel-heading">Active</div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Actions</th>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Last Login</th>
                        <th>Session id</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $result1 as $row ){
                        echo "<tr><td class='col-md-1'>";
                        ?>
                        <a href="promote_user.php?id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                        <a href='admin_deactivate_user.php?id=<?php echo $row['id']; ?>'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a>
                        <a href='session_logout.php?id=<?php echo $row['id']; ?>'><span class='glyphicon glyphicon-off' aria-hidden='true'></span></a>
                        <?php
                        echo "</td><td class='col-md-1'>";
                        echo $row['id'];
                        echo "</td><td class='col-md-2'>";
                        echo $row['username'];
                        echo "</td><td class='col-md-3'>";
                        echo $row['email'];
                        echo "</td><td class='col-md-2'>";
                        echo $row['lastlogin'];
                        echo "</td><td class='col-md-2'>";
                        echo $row['session_id'];
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
    }

    if($result0){ ?>
    <!-- Pending / banned -->
    <div class="panel panel-primary">
        <div class="panel-heading">Pending / Banned</div>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $result0 as $row ){
                    echo "<tr><td class='col-md-1'>";
                    ?>
                    <a href='approve_user.php?id=<?php echo $row['id']; ?>'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a>
                    <a href='delete_banned.php?id=<?php echo $row['id']; ?>'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>
                    <?php
                    echo "</td><td class='col-md-1'>";
                    echo $row['id'];
                    echo "</td><td class='col-md-2'>";
                    echo $row['username'];
                    echo "</td><td class='col-md-4'>";
                    echo $row['email'];
                    echo "</td><td class='col-md-2'>";
                    if($row['activated']==1){
                        echo '<span class="label label-danger">Banned</span>';
                    } else {
                        echo '<span class="label label-default">Pending</span>';
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>


</div><!-- /.container -->


<?php include 'include/footer.php'; ?>



