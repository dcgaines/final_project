<?php
	session_start();
	if(!isset($_SESSION["login"])) {
		header("Location:index.php");
	}

	try {
		$config = parse_ini_file("db.ini");
		$dbh = new PDO($config['dsn'], $config['username'], $config['password']);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$exam_name = $_POST['exam_name'];
		$p = "select q_number, points from Question where exam_name='".$exam_name."'";
		$a = "select q_number, identifier from CorrectAnswer where exam_name='".$exam_name."'";		
		$total_score = 0;
		foreach($dbh->query($p) as $question) {
			$row = $dbh->query($p);
			$question_num = $question[0];

			$answer = $_POST[$question_num];
			foreach($dbh->query($a) as $corr_ans) {
				if(strcmp($corr_ans[0], $question_num) == 0 && strcmp($corr_ans[1], $answer) == 0) {
					$points = (int)$question[1];
					break;
				} else {
					$points = 0;
				}
			}
			$total_score = $total_score + $points;
			$insert = $dbh->prepare("insert into Answered values(:id, :exam, :ques, :ans, :pts)");
			$insert->execute(array(':id' => $_SESSION['id'], ':exam' => $exam_name, ':ques' => (int)$question_num, ':ans' => $answer, ':pts' => (int)$points));			
		}
		$takes = $dbh->prepare("insert into Takes values(:id, :exam, :score)");
		$takes->execute(array(':id' => $_SESSION['id'], ':exam' => $exam_name, ':score' => $total_score));
	} catch (PDOException $e) {
		print "Error!".$e->getMessage()."<br/>";
		die();
	}
	header("Location:home.php");
?>
