<?php include("include/header.php") ?>

<div class="container-fluid">
<div class="row">
	<div class="col-lg-4 col-md-offset-4">
      <form class="form-signin" form action="admin_check_login.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" id="userName" name="userName" class="form-control" placeholder="Email address" required="" autofocus="">
        <input type="password" id="userPassword" name="userPassword" class="form-control" placeholder="Password" required="">
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
       </div>
    </div>
</div>
    <?php include("include/footer.php") ?>
<?php 



?>