
 <!-- A PHP session stores data on the server rather than user's computer-->
<?php
session_start();
if (isset($_SESSION['UUID']) and isset($_SESSION['username'])) {
	$_SESSION['err'] = "You're Already Logged in!";
	return header('Location: ./index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todo Page | Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<!--add the login form code.-->
<body class="login">
 <!-- login body -->
<div class="loginBody">
	<div class="center">
		<form action="./includes/login.inc.php" method="POST" style='max-width: 400px;margin: 0 auto;'>
			<h1>Login</h1>
			<div class='form-group'>
				<input type="text" class="username form-control" name="user" placeholder="Username" required>
			</div>
			<div class='form-group'>
				<input type="password" class="password form-control" name="password" placeholder="Password" required>
			</div>
			<div class='form-group'>
				<button type="submit" class='btn btn-primary btn-sm'>Login</button>
			</div>
			<p>Don't have an account? <a class="text-warning" href="signup.php">Sign up now</a>.</p>
		</form>
	</div>
</div>
 <!-- Modal logged out -->
  <div class="modal fade" id="errModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
		  	Logged out
		  </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
			You have been logged out. Please log in to add todos.
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

 <!--  method will run once the page DOM is ready to execute JavaScript code -->
<script>
$(document).ready(function(){
	$("#errModal").modal();
});
</script>
</body>
</html>