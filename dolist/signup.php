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
	<title>Todo Page | Signup</title>
	<!-- Material Design Bootstrap -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/css/mdb.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>   
</head>
<body class="signup">
<div class="signupBody">
	<div class="center">
		<form action="./includes/signup.inc.php" method="POST" style='max-width: 400px; margin: 0 auto;'>
	  <h1>Signup</h1>
	  <div class='form-group'>
			<input type="text" class="username form-control" name="user" placeholder="Username" required class=''>
	  </div>
	  <div class='form-group'>
			<input type="password" class="password form-control" name="password" placeholder="Password" required>
	  </div>
	  <div class='form-group'>
			<input type="password" class="password form-control" name="passwordconf" placeholder="Password Confirmation" required>
	  </div>
	  <div class='form-group'>
			<button type="submit" class='btn btn-sm btn-primary'>Sign Up</button>
	  </div>
	  <p>Already have an account? <a class="text-warning" href="login.php">Login here</a>.</p>
		</form>
	</div>
</div>

  <div class="modal fade" id="errModal">
	<div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title">
			Register
		  </h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
		  Please register to add todos.
		</div>
		<!-- Modal footer -->
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		
	  </div>
	</div>
  </div>


<script>
$(document).ready(function(){
	$("#errModal").modal();
});
</script>
</body>
</html>