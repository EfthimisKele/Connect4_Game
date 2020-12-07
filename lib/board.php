
<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);


function show_board() {
	
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
	//show_board();
}
?>