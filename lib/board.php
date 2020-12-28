
<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);


function show_piece($x,$y) {
	global $conn;
	$conn = dbconnect();
	$sql = 'select * from board where x=? and y=?';
	$st = $conn->prepare($sql);
	$st->bind_param('ii',$x,$y);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function move_piece($x,$y,$token) {
	
	if($token==null || $token=='') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"token is not set."]);
		exit;
	}
	
	$color = current_color($token);
	if($color==null ) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"You are not a player of this game."]);
		exit;
	}

	$status = read_status();
	if($status['status']!='started') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Game isn't ready yet!"]);
		exit;
	}

	if($status['p_turn']!=$color) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"It's not your turn!"]);
		exit;
	}

	//έλεγχος αμα έχει δωθεί αριθμός εκτός ορίων
	if($x > 6 || $y > 7){
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"You gave wrong number!"]);
		exit;
	}

/*	ελεγχος χρωμα θεσης */
	$c = check_color($x, $y);
	$key = "color";
	$value = $c[$key];

	//ελεγχος αμα έχει χρώμα η θέση ή χρώμα η από κάτω θέση
	if ($value == null){
		if($x==6){
			do_move($x,$y);
		}
		else if($x < 6){
			$k = $x+1;
			$c2 = check_color($k,$y);
	     	$value2 = $c2[$key];

		 	if($value2 !== null){
				do_move($x,$y);	
		 	}
		 	else{
			 	header("HTTP/1.1 400 Bad Request");
			 	print json_encode(['errormesg'=>"You can't do this move!"]);
			 	exit;
		 	}
		}
		else{
			header("HTTP/1.1 400 Bad Request");
			print json_encode(['errormesg'=>"You can't do this move!"]);
			exit;
		}				
	}else{	
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Wrong move, has already a color!"]);
		exit;
	}

	$orig_board=read_board();
	//$color
	$color3 = $status['p_turn'];
	$win = false;
	$win = checkVertical($color3);
	if($win !== true){
		$win = checkHorizontal($color3);
	}
	if($win !== true){
		$win = checkDiagonalUp($color3);
	}
	if($win !== true){
		$win = checkDiagonalDown($color3);
	}
		

	if($win !== true){
	}
	else{
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Gg we have a winner!"]);
		print $color3;
		game_over($color3);
		exit;
	}


    //ελεγχος αμα εχει γεμισει ο πινακάς και συνεπώς δεν έχω κανέναν νικητή
	$res = check_result();
	if($res < 42){		
	}else{	
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Game is over, no one is winner!"]);
		game_over2();
		exit;
	}
}

function show_board($input) {
	global $conn;
	$conn = dbconnect();	
	$sql = 'select * from board';
	$st = $conn->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function reset_board() {
	global $conn;
	$conn = dbconnect();
	$sql = 'call clean_board()';
	$conn->query($sql);
}

//check if table is full, if yes and no winners then it is a tie
function check_result(){
	global $conn;
	$conn = dbconnect();
	$sql = "SELECT COUNT(color) from board where color = 'Y' OR color = 'R' ";
	$st = $conn->prepare($sql);
	$st->execute();
	$count = $st->get_result()->fetch_row()[0];
	return($count);
}

//call when we have a winner
function game_over($color){
	global $conn;
	$conn = dbconnect();
	$sql =$conn->prepare( "UPDATE `game_status` SET `status`='ended',`result`=?,p_turn=null");
	$sql->bind_param("s", $color);	
	$sql->execute();
}

//call when the game is over and tie
function game_over2(){
	global $conn;
	$conn = dbconnect();
	$sql =$conn->prepare( "UPDATE `game_status` SET `status`='ended',`result`=?,p_turn=null");
	$sql->bind_param("s", "");	
	$sql->execute();
}

function check_color($x, $y) {
	global $conn;
	$conn = dbconnect();
	$sql= $conn->prepare('select color from board where x=? and y=?');
	$sql->bind_param("ii", $x, $y);	
	$sql->execute();
	$res =$sql->get_result();
	$row = $res->fetch_all(MYSQLI_ASSOC);
	$yolo= array_values($row);
	$color = array_shift($yolo);
	$sql->close();
	return($color);
}

function checkVertical($color){
	$win = false;
	for($col=1; $col<8; $col++){  	 	 	  	//go through every column
		for ($row=1; $row<=3; $row++){ 	 		//include rows 1,2,3
			$c = check_color($row, $col);
			$c1 = check_color($row+1, $col);
			$c2 = check_color($row+2, $col);
			$c3 = check_color($row+3, $col);
		  	$key = "color";
			$value = $c[$key];
			$value1 = $c1[$key];
			$value2 = $c2[$key];
			$value3 = $c3[$key];
			if ($value == $color AND $value1 == $color AND $value2 == $color AND $value3 == $color){
				$win = true;
			}
		}
	}
return($win); 
}

function checkHorizontal($color){
	$win = false;
	for($row=1; $row<7; $row++){  	 	 	 	//go through every row
		for ($col=1; $col<=4; $col++){  	   //must include column 1,2,3,4
			$c = check_color($row, $col);
			$c1 = check_color($row, $col+1);
			$c2 = check_color($row, $col+2);
			$c3 = check_color($row, $col+3);
		  	$key = "color";
			$value = $c[$key];
			$value1 = $c1[$key];
			$value2 = $c2[$key];
			$value3 = $c3[$key];
			if ($value == $color AND $value1 == $color AND $value2 == $color AND $value3 == $color){
				$win = true;
			}
		}
	}
return($win); 
}

function checkDiagonalDown($color){
	$win = false;
	for($row=1; $row<=3; $row++){  	 	 	 	//must include rows 1,2,3
		for ($col=1; $col<=4; $col++){  	   //must include columns 1,2,3,4
			$c = check_color($row, $col);
			$c1 = check_color($row+1, $col+1);
			$c2 = check_color($row+2, $col+2);
			$c3 = check_color($row+3, $col+3);
		  	$key = "color";
			$value = $c[$key];
			$value1 = $c1[$key];
			$value2 = $c2[$key];
			$value3 = $c3[$key];
			if ($value == $color AND $value1 == $color AND $value2 == $color AND $value3 == $color){
				$win = true;
			}
		}
	}
return($win); 
}

function checkDiagonalUp($color){
	$win = false;
	for($row=1; $row<=3; $row++){  	 	 	 	//must include rows 1,2,3
		for ($col=4; $col<=7; $col++){  	   //must include columns 4,5,6,7
			$c = check_color($row, $col);
			$c1 = check_color($row+1, $col-1);
			$c2 = check_color($row+2, $col-2);
			$c3 = check_color($row+3, $col-3);
		  	$key = "color";
			$value = $c[$key];
			$value1 = $c1[$key];
			$value2 = $c2[$key];
			$value3 = $c3[$key];
			if ($value == $color AND $value1 == $color AND $value2 == $color AND $value3 == $color){
				$win = true;
			}
		}
	}
return($win); 
}

function read_board() {
	global $conn;
	$conn = dbconnect();
	$sql = 'select * from board';
	$st = $conn->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	return($res->fetch_all(MYSQLI_ASSOC));
}

// move piece
function do_move($x,$y) {
	global $conn;
	$conn = dbconnect();
	$sql = 'call `move_piece`(?,?);';
	$st = $conn->prepare($sql);
	$st->bind_param('ii',$x,$y );
	$st->execute();
	header('Content-type: application/json');
	print json_encode(read_board(), JSON_PRETTY_PRINT);
}
?>