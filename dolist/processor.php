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

{
	"particles": {
	  "number": {
		"value": 80,
		"density": {
		  "enable": true,
		  "value_area": 800
		}
	  },
	  "color": {
		"value": "#ffffff"
	  },
	  "shape": {
		"type": "circle",
		"stroke": {
		  "width": 0,
		  "color": "#000000"
		},
		"polygon": {
		  "nb_sides": 5
		},
		"image": {
		  "src": "img/github.svg",
		  "width": 100,
		  "height": 100
		}
	  },
	  "opacity": {
		"value": 0.5,
		"random": false,
		"anim": {
		  "enable": false,
		  "speed": 1,
		  "opacity_min": 0.1,
		  "sync": false
		}
	  },
	  "size": {
		"value": 3,
		"random": true,
		"anim": {
		  "enable": false,
		  "speed": 40,
		  "size_min": 0.1,
		  "sync": false
		}
	  },
	  "line_linked": {
		"enable": true,
		"distance": 150,
		"color": "#000000",
		"opacity": 0.4,
		"width": 1
	  },
	  "move": {
		"enable": true,
		"speed": 6,
		"direction": "none",
		"random": false,
		"straight": false,
		"out_mode": "out",
		"bounce": false,
		"attract": {
		  "enable": false,
		  "rotateX": 600,
		  "rotateY": 1200
		}
	  }
	},
	"interactivity": {
	  "detect_on": "canvas",
	  "events": {
		"onhover": {
		  "enable": true,
		  "mode": "repulse"
		},
		"onclick": {
		  "enable": true,
		  "mode": "push"
		},
		"resize": true
	  },
	  "modes": {
		"grab": {
		  "distance": 400,
		  "line_linked": {
			"opacity": 1
		  }
		},
		"bubble": {
		  "distance": 400,
		  "size": 40,
		  "duration": 2,
		  "opacity": 8,
		  "speed": 3
		},
		"repulse": {
		  "distance": 200,
		  "duration": 0.4
		},
		"push": {
		  "particles_nb": 4
		},
		"remove": {
		  "particles_nb": 2
		}
	  }
	},
	"retina_detect": true
  }