<?php

session_start();

class Processor
{
	public $userId;
	public $conn;
// Create connection
	public function __construct()
	{
		$servername = "167.71.74.228";
		$username = "eugene";
		$password = "Exertion42Flak22sitters";
		$this->conn = new PDO("mysql:host=$servername;port=3306;dbname=2019BWebIntensive_eugene", $username, $password);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->userId = $_SESSION['UUID'];
	}
//to facilitate the catching of potential exceptions
	public function addTodo($post)
	{
		try {
			$date = date("Y-m-d H:i:s", time());
			$r = $this->conn->prepare("INSERT INTO `notes`(`authorUUID`, `title`, `completed`, `created`) VALUES (:authorUUID, :title, 0, :created)");
			$r->bindValue(':authorUUID', $this->userId);
			$r->bindValue(':title', $post['title']);
			$r->bindValue(':created', $date);
			$r->execute();

			$lastInsertId = $this->conn->lastInsertId();
			echo json_encode([
				'title' => $post['title'],
				'date' => $date,
				'id' => $lastInsertId
			]);
		}catch(PdoException $e) {
			echo $e->getMessage();
			exit;
		}
	}

	public function deleteTodo($post)
	{
		$r = $this->conn->prepare("DELETE FROM `notes` WHERE id = :id AND authorUUID = :authorUUID");
		$r->bindValue(':id', $post['id']);
		$r->bindValue(':authorUUID', $this->userId);
		$r->execute();
	}

	public function markTodo($post)
	{
		$r = $this->conn->prepare("UPDATE `notes` SET completed = 1 WHERE id = :id AND authorUUID = :authorUUID");
		$r->bindValue(':id', $post['id']);
		$r->bindValue(':authorUUID', $this->userId);
		$r->execute();
	}

}

$processor = new Processor();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_todo'])) {
	return $processor->addTodo($_POST);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_todo'])) {
	return $processor->deleteTodo($_POST);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mark_todo'])) {
	return $processor->markTodo($_POST);
}