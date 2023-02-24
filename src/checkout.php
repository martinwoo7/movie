<!doctype html>
<?php include('functions.php');

if(!isLoggedIn()) {
	$_SESSIONS['msg'] = "You must log in first";
	header('location: login.php');
	
} 

	$showingID = $_POST['id'];
	$query = "SELECT * FROM showing WHERE showing_id='$showingID'";
	$result = $dbh -> query($query);

	$data = array();
	foreach ($result as $temp) {
		array_push($data, $temp[0], $temp[1], $temp[2], $temp[3], $temp[4], $temp[5], $temp[6], $temp[7]);
	}
	$result2 = $dbh -> query("SELECT * FROM theatrecomplex WHERE theatre_name='$data[1]'");

	$theaterdata = array();
	foreach ($result2 as $temp2) {
		array_push($theaterdata, $temp2[0], $temp2[1], $temp2[2], $temp2[3], $temp2[4], $temp2[5], $temp2[6], $temp2[7]);
	}

?>

<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="Resources/checkout.css">
<script defer src="Resources/JS/increment.js"></script>
<script defer src="Resources/JS/checkout.js"></script>
<title>Checkout</title>
</head>

<body>
<form action="receipt.php" id="regForm" method="post">
	<h1>Purchase:</h1>
	<h3><?php echo("$data[7]") ?></h3>
	<h3><?php echo("$data[3]") ?></h3>
	<h4><?php echo("$data[1]") ?></h4>
	<h4><?php echo("$theaterdata[2] $theaterdata[3], $theaterdata[4] $theaterdata[5]") ?></h4>
	<h4><?php echo("$theaterdata[7]") ?></h4>
	
	<input type="hidden" id="seats" value="<?php echo htmlspecialchars($data[6]); ?>">
	
	<!-- One tab for each step of the form: -->
	<div class="tab" id="optional">(OPTIONAL) Enter membership card:
		<p><input type="text" placeholder="Membership Card"></p>
	</div>
	
	<div class="tab">Ticket Order:
		<p>Children (3 - 13): <input type="number" name="child" id="child" value="0" disabled>
			<button type="button" id="incChild" onclick="change(this.id)">+</button><button type="button" id="decChild" onclick="change(this.id)" >-</button>
		</p>
		
		<p>Seniors (65+): <input type="number" name="senior" id="senior" value="0" disabled>
			<button type="button" id="incSen" onclick="change(this.id)">+</button><button type="button" id="decSen" onclick="change(this.id)">-</button>
		</p>
		
		<p>Adults (14 - 64): <input type="number" name="regular" id="adult" value="0" disabled>
			<button type="button" id="incAd" onclick="change(this.id)">+</button><button type="button" id="decAd" onclick="change(this.id)">-</button>
		</p>
		<p>Total number of tickets: <span id="totalticket">0</span></p>
		<p>Total Cost: <span id="totalcost">0</span></p>
	</div>
	
	<div class="tab">Confirm:
		<p>Total number of tickets to purchase: <span id="totalticket2">0</span></p>
		<p>Total cost of tickets: <span id="totalcost2">0</span></p>
	</div>
	
	<div style="overflow:auto;">
		<div style="float: right;">
			<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
			<button type="button" id="nextBtn" onclick="nextPrev(+1)">Next</button>
		</div>
	</div>
	
	<div style="text-align: center; margin-top: 3%;">
		<span class="step"></span>
		<span class="step"></span>
		<span class="step"></span>
	</div>
	<?php $address = "$theaterdata[2] . '' . $theaterdata[3] . ',' . $theaterdata[4] . '' . $theaterdata[5]'"; ?>
	<input type="hidden" name="title" value="<?php echo $data[7];?>">
	<input type="hidden" name="location" value="<?php echo $data[1];?>">
	<input type="hidden" name="address" value=" <?php echo $address?> ">
	<input type="hidden" name="showtime" value="<?php echo $theaterdata[3];?>">
	<input type="hidden" name="id" value="<?php echo $showingID?>">
	
	<form action="" method="POST">
		<input type="hidden" name="total" id="total" value="0">
		<input type="hidden" name="total2" id="total2" value="0">
		<input type="hidden" name="c"  id="c" value="0">
		<input type="hidden" name="s" id="s" value="0">
		<input type="hidden" name="g" id="g" value="0">
	</form>
</form>

</body>
</html>