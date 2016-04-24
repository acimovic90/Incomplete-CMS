<?php
require "include/security.php";

if(!isset($_SESSION['adminRole'])) {
    header('location: index.php');
}
?>
<html lang="en" hola_ext_inject="disabled">
<?php
include("include/admin-header.php");
include_once("include/nav-bar.php");

?>

<div id="wrapper">
    <?php
    require( "include/db_connect.php");
    ?>
    <!-- Navigation -->

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dashboard <small>Statistics Overview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">26</div>
                                    <div>New Users Created!</div>
                                </div>
                            </div>
                        </div>
                        <a href="admin_list_users.php">
                            <div class="panel-footer">
                                <span class="pull-left"><b>Manage Users</b></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-archive fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">10</div>
                                    <div>New Logs Created!</div>
                                </div>
                            </div>
                        </div>
                        <a href="activity_log.php">
                            <div class="panel-footer">
                                <span class="pull-left"><b>Activity Logs</b></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-envelope fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">124</div>
                                    <div>Mails In Your Inbox!</div>
                                </div>
                            </div>
                        </div>
                        <a data-toggle="modal" data-target="#chooseEmail">
                            <div class="panel-footer">
                                <span class="pull-left"><b>Send Mail</b></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-cloud-upload fa-5x pull-left"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">10</div>
                                    <div>New Uploads Made!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left"><b>Manage Uploads</b></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

           <!-- <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> System management</h3>
                        </div>
                        <div class="panel-body">
                          
                                      </div>
                                  </div>
                              </div>
                          </div> -->
                          <!-- /.row -->
                          <div class="modal fade" id="chooseEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-body">
                                         <?php
                                         $sql = "SELECT * FROM users";
                                         $query = $conn->prepare($sql);
                                         $query->execute();
                                         $chooseEmail = $query->fetchAll( PDO::FETCH_ASSOC );

                                         ?>
                                         <form class="form-signin" method="post" action="admin_send_email.php">
                                          <div class="dropdown">               
                                              Email to...:
                                              <select class="btn btn-default btn-block dropdown-toggle"name="selectedEmail">
                                                <?php 
                                                foreach( $chooseEmail as $row ){
                                                 ?>

                                                 <option class="form-control" value="<?php echo $row['email'] ?>"> <?php echo $row['username']." - ". $row['email']; }?></option>            
                                             </select>

                                         </br></br>
                                         Message:</br>
                                         <textarea class="form-control" rows="4" name="textMessage"></textarea>

                                     </br></br>
                                     <button class="btn btn-sm btn-primary" id="submit" type="submit">Send Email</button>


                                 </div>
                             </form>


                         </div>
                     </div>
                 </div>
             </div>

             <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Donut Chart</h3>
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                            <div class="text-right">
                                <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Tasks Panel</h3>
                        </div>
                        <?php 
                        $records = $conn->prepare("SELECT lastlogin FROM users WHERE username = :admin");
                        $records->bindParam(':username', 'admin');
                        $records->execute();
                        $results = $records->fetch(PDO::FETCH_ASSOC);
                        foreach( $results as $row ){ ?>
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <span class="badge">just now</span>
                                    <i class="fa fa-fw fa-calendar"></i> Calendar updated
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="badge">4 minutes ago</span>
                                    <i class="fa fa-fw fa-comment"></i> Commented on a post
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="badge">23 minutes ago</span>
                                    <i class="fa fa-fw fa-truck"></i> Order 392 shipped
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="badge">46 minutes ago</span>
                                    <i class="fa fa-fw fa-money"></i> Invoice 653 has been paid
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="badge"><?php echo $row['lastlogin']; ?></span>
                                    <i class="fa fa-fw fa-user"></i> Your last login
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="badge">2 hours ago</span>
                                    <i class="fa fa-fw fa-check"></i> Completed task: "pick up dry cleaning"
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="badge">yesterday</span>
                                    <i class="fa fa-fw fa-globe"></i> Saved the world
                                </a>
                                <a href="#" class="list-group-item">
                                    <span class="badge">two days ago</span>
                                    <i class="fa fa-fw fa-check"></i> Completed task: "fix error on sales page"
                                </a>
                            </div>
                            <div class="text-right">
                                <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Transactions Panel</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Order Date</th>
                                            <th>Order Time</th>
                                            <th>Amount (USD)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>3326</td>
                                            <td>10/21/2013</td>
                                            <td>3:29 PM</td>
                                            <td>$321.33</td>
                                        </tr>
                                        <tr>
                                            <td>3325</td>
                                            <td>10/21/2013</td>
                                            <td>3:20 PM</td>
                                            <td>$234.34</td>
                                        </tr>
                                        <tr>
                                            <td>3324</td>
                                            <td>10/21/2013</td>
                                            <td>3:03 PM</td>
                                            <td>$724.17</td>
                                        </tr>
                                        <tr>
                                            <td>3323</td>
                                            <td>10/21/2013</td>
                                            <td>3:00 PM</td>
                                            <td>$23.71</td>
                                        </tr>
                                        <tr>
                                            <td>3322</td>
                                            <td>10/21/2013</td>
                                            <td>2:49 PM</td>
                                            <td>$8345.23</td>
                                        </tr>
                                        <tr>
                                            <td>3321</td>
                                            <td>10/21/2013</td>
                                            <td>2:23 PM</td>
                                            <td>$245.12</td>
                                        </tr>
                                        <tr>
                                            <td>3320</td>
                                            <td>10/21/2013</td>
                                            <td>2:15 PM</td>
                                            <td>$5663.54</td>
                                        </tr>
                                        <tr>
                                            <td>3319</td>
                                            <td>10/21/2013</td>
                                            <td>2:13 PM</td>
                                            <td>$943.45</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>

<?php include("include/footer.php"); ?>