<?php
session_start();

if (!isset($_SESSION['UUID']) && !isset($_SESSION['username'])) {
	return header('Location: ./login.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<script>
		var authUUID = "";
		var idsToTitle = {};
	</script>
	<!--GET variable is used to collect values from a form -->
	<?php
	$UUID = $_SESSION['UUID'];
	include('./includes/db.inc.php');
	$us = $_SESSION['username'];
	// $sort = $_GET['sortBy'] ?? '';
	if (isset($_GET['sortBy'])) {
		$sort = $_GET['sortBy'];
	}else{
		$sort = '';
	}
	switch ($sort){
		case "newOld":
		$r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `created` DESC");        
		break;
		case "oldNew":
		$r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `created` ASC");
		break;
		case "az":
		$r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `title` ASC");        
		break;
		case "za":
		$r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid ORDER BY `title` DESC");        
		break;
		default:
		$r = $conn->prepare("SELECT * FROM `notes` WHERE authorUUID = :uuid");
	}
	$r->bindValue(':uuid',$UUID);
	$r->execute();
	$results = $r->fetchAll();
	?>
</head>
<body class="mainBody c-s-loaded p-5">
	<div class='main card'>
		<div class='card-header'>
			Todo list
		</div>
		<div class="card-body">
			<div class='form-group-container d-flex'>
				<form class='form-group mr-5 d-flex todo-form'>
					<input type='text' id='myInput' class='form-control todo mr-5' name='title' placeholder="Eat Lunch...." required>
					<input type='hidden' name='add_todo'>
					<button class='btn btn-primary'>
						Add
					</button>
				</form>
				<!--drop down for new , old  and alphabetic-->
				<div class='form-group'>
					<select class="changeSort form-control" id="changeSort">
						<option value="newOld" <?php if ($sort == "newOld"){echo "selected";} ?> >Newest - Oldest</option>
						<option value="oldNew" <?php if ($sort == "oldNew"){echo "selected";} ?> >Oldest - Newest</option>
						<option value="az" <?php if ($sort == "az"){echo "selected";} ?> >A - Z</option>
						<option value="za" <?php if ($sort == "za"){echo "selected";} ?> >Z - A</option>
					</select>
				</div>
			</div>
			<hr>
			<ul class='list-group todo-list-group'>
				<?php foreach($results as $item): ?>
					<li class='list-group-item d-flex'>
						<div class='mr-5 mr-md-auto'>
							<h6>Title</h6>
							<small><?php echo $item['title']; ?></small>
						</div>
						<div class='mr-5 mr-md-auto'>
							<h6>Date created</h6>
							<small><?php echo $item['created']; ?></small>
						</div>
						<div class='mr-5 mr-md-auto'>
							<h6>Completed</h6>
							<?php if($item['completed'] == 1): ?>
								<span class='badge badge-md badge-success badge-pill d-block todo-status'>
									Yes
								</span>
							<?php else: ?>
								<span class='badge badge-danger badge-pill d-block todo-status'>
									No
								</span>
							<?php endif; ?>
						</div>
						<div>
							<h6>Actions</h6>
							<div>
								<button class='btn bt-sm btn-success markTodo' id='<?php echo $item["id"]; ?>'>
									Mark
								</button>
								<button class='btn bt-sm btn-danger deleteTodo' id='<?php echo $item["id"]; ?>'>
									Delete
								</button>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<!--log out. sign out-->
		<p class='p-3'>
			<a href="logout.php" class="btn btn-danger">SIGN OUT</a>
		</p>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type='text/javascript' src='includes/js/todo.js'></script>
</body>
</html>
