<!doctype html>
<?php include("functions.php");
if(!isLoggedIn()) {
	$_SESSIONS['msg'] = "You must log in first";
	header('location: login.php');
	
} 

	global $dbh;
	
	/*$title = $_POST['title'];
	$location = $_POST["location"];
	$showtime = $_POST["showtime"];
	$address = $_POST["address"];*/

	$total = $_POST["total"];
	$total2 = $_POST["total2"];
	$c = $_POST["c"];
	$s = $_POST["s"];
	$g = $_POST["g"];

	$id = $_POST["id"];
	$accnum = $_SESSION['user']['account_id'];

	$date = date("Y-m-d H:i:s",time());
	
	$testQuery = "SELECT * FROM reservation WHERE account_id='$accnum' AND showing_id='$id'";
	$result = $dbh -> query($testQuery);
	$count = $result -> rowCount();
	
	if ($count == 0) {
		$query = "INSERT INTO reservation VALUES('$accnum', '$id', '$date', '$total', '$c', '$g', '$s','$total2')";
	}
	else {
		$query = "UPDATE reservation SET num_tickets_reserved = num_tickets_reserved + $total, child_tickets = child_tickets + $c, regular_tickets = regular_tickets + $g, senior_tickets = senior_tickets + $s, cost = $total2";
	}
	$dbh -> query($query);
?>

<html>
<head>
<meta charset="utf-8">
<title>Receipt</title>
</head>

<body>
<h1>Thank you for your purchase!</h1>
</body>
</html>