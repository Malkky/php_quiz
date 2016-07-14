<?php include 'database.php'; ?>
<?php session_start(); ?>
<?php
	//Check to see if score is set
	if(!isset($_SESSION['score'])){
		$_SESSION['score'] = 0;  //declare the global of score
	}

	if($_POST){  //making sure the answer is submitted
		$number = $_POST['number'];
		$selected_choice = $_POST['choice'];
		$next = $number+1;

		//Get total
		$query = "SELECT * FROM questions";
		//Get result
		$results = $mysqli->query($query) or die($mysqli->error.__LINE__);
		$total = $results->num_rows;

		//Get correct choice
		$query = "SELECT * FROM choices WHERE question_number = $number AND is_correct = 1";

		//Get result
		$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

		//Get row
		$row = $result->fetch_assoc();

		//Set correct choice
		$correct_choice = $row['id'];

		//Comparison
		if($correct_choice == $selected_choice){
			//Answer is correct
			$_SESSION['score'] += 1;
		}

		//Check if its last question
		if($number == $total){
			header("Location: final.php");//if its last redirect to last page
			exit();
		} else{
			header("Location: question.php?n=".$next);//if its not go to the next question by incrementing n
		}
	}