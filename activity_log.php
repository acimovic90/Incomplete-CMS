<?php
//checks for admin rights
session_start();
if(!isset($_SESSION['adminRole'])) {
    header('location: index.php');
}
require "include/db_connect.php";
?>
<html lang="en" hola_ext_inject="disabled"><head>
    <?php
    include("include/header.php")
    ?>
    <style>
        .table tbody tr td:first-child {
            font-size: 0.875em;
        }

    </style>
</head>

<body id="Administration">

<?php

?>

<div class="container">
    <h1 class="page-header">Activity Log</h1>
<div class="panel panel-primary">
    <div class="panel-heading">Activity <a class="delete-log-right btn btn-primary btn-xs" type="button" href="delete_log.php">Delete All Logs</a></div>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th>ID</th>
            <th>IP Address</th>
            <th>Username</th>
            <th>Activity</th>
            <th>Timestamp</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
    <?php
    //Getting the page number
    if (isset($_GET["page"])) {
        $page  = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT);
    } else {
        $page=1;
    };
    $numOfResults = 40;
    $start_from = ($page-1) * $numOfResults;
    $result = $conn->prepare("SELECT * FROM log ORDER BY id DESC LIMIT $start_from, $numOfResults");
    $result->execute();
    foreach($result as $row){
                echo "<tr><td class='col-md-1'>";
                echo $row['id'];
                echo "</td><td class='col-md-2'>";
                echo $row['ipaddress'];
                echo "</td><td class='col-md-1'>";
                echo "<strong><a href=profile.php?p=".$row['username'].">".$row['username']."</a></strong>";
                echo "</td><td class='col-md-2'>";
                echo $row['location'];
                echo "</td><td class='col-md-2'>";
                echo $row['ts'];
                echo "</td><td class='col-md-1'>";
                echo "<a href=delete_log.php?id=".$row['id']."><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
                echo "</td></tr>";
    }
    ?>
    </tbody>
</table>

    <div id="pagination">
        <?php
        $result = $conn->prepare("SELECT COUNT(id) FROM log");
        $result->execute();
        $row = $result->fetch();
        $total_records = $row[0];
        $total_pages = ceil($total_records / $numOfResults);
        echo "<div align='center'>";
        for ($i=1; $i<=$total_pages; $i++) {

            echo "<a href='activity_log.php?page=".$i."'";
            if($page==$i){
                echo "class=active";
            }
            echo "class='btn btn-sm btn-primary' role='button'>";
            echo "".$i."</a> ";

        };
        echo "</div>";
        ?>
    </div>
</div>
</div><!-- /.container -->

   
<?php include 'include/footer.php'; ?>