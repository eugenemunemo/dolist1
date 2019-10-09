<?php
session_start();
if (isset($_SESSION['UUID']) and isset($_SESSION['username'])) {
	$_SESSION['err'] = "You're Already Logged in!";
    header('Location: ./index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Todo Page | Signup</title>
	<link rel="stylesheet" type="text/css" href="./includes/css/main.css">
	<!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/css/mdb.min.css" rel="stylesheet">
    <link href="css/styles.min.css" rel="stylesheet">
   
</head>
<body class="signup">
<div class="signupBody">
	<div class="center">
		<h1>Signup</h1>
		<h4>Todo List</h4>
		<form action="./includes/signup.inc.php" method="POST">
			<input type="text" class="username" name="user" placeholder="Username" required><br>
			<input type="password" class="password" name="password" placeholder="Password" required><br>
			<input type="password" class="password" name="passwordconf" placeholder="Password Confirmation" required><br>
			<button type="submit">Sign Up</button>
		</form>
		
	</div>
	<p>Already have an account? <a class="text-warning" href="login.php">Login here</a>.</p>
</div>

<?php
$temp = $_SESSION['temp'];
$tempT = $_SESSION['tempT'];
$_SESSION['temp'] = null;
$_SESSION['tempT'] = null;
if ($tempT !== null){
echo'
  <div class="modal fade" id="errModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">'.$tempT.'</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	'.$temp.'  
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
';
}
?>
</body>
</html>