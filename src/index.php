<!doctype html>
<?php include('functions.php') ?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="Resources/index.css">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<script defer src="Resources/JS/fontawesome-all.js"></script>
<title>Register</title>
</head>

<body>
	<form id="form" action="index.php" method="post">
		<?php echo display_error(); ?>
		
		<h1>Register Now!</h1>
		<div class="input-group row">
			<div class="col">
				<p>First Name*</p>
				<input type="text" name="firstname" placeholder="First Name*">
			</div>
			<div class="col">
				<p>Last Name*</p>
				<input type="text" name="lastname" placeholder="Last Name*">
			</div>
		</div>
		
		<div class="input-group row">
			<div class="col">
				<p>Password*</p>
				<input type="password" name="pwd" placeholder="Enter a Password*">
			</div>
			<div class="col">
				<p>Confirm your password*</p>
				<input type="password" name="pwd2" placeholder="Confirm your Password*">
			</div>
		</div>
		
		<div class="input-group">
			<p>Email*</p>
			<input type="email" name="email" placeholder="Enter your Email*">
		</div>
		<div class="input-group row">
			<div class="col">
				<p>Street Number*</p>
				<input type="text" name="streetnum" placeholder="Enter your street number*">
			</div>
			<div class="col">
				<p>Street Name*</p>
				<input type="text" name="streetname" placeholder="Enter your street name*">
			</div>
		</div>
		<div class="input-group row">
			<div class="col">
				<p>City*</p>
				<input type="text" name="city" placeholder="Enter your city*">
			</div>
			<div class="col">
				<p>Province*</p>
				<select name="province">
					<option value="BC">British Columbia</option>
					<option value="AB">Alberta</option>
					<option value="SK">Saskatchewan</option>
					<option value="MB">Manitoba</option>
					<option value="ON">Ontario</option>
					<option value="QC">Quebec</option>
					<option value="NB">New Brunswik</option>
					<option value="NS">Nova Scotia</option>
					<option value="PE">Prince Edward Island</option>
					<option value="NL">Newfoundland and Labrador</option>
					<option value="NT">Northwest Territories</option>
					<option value="YT">Yukon</option>
					<option value="NU">Nunavut</option>
				</select>
			 </div>
		</div>
		<div class="input-group row">
			<div class="col">
				<p>Postal Code*</p>
				<input type="text" name="postal" placeholder="Enter your postal code*">
			</div>
			<div class="col">
				<p>Phone Number*</p>
				<input type="text" name="phone" placeholder="0000000000*">
			</div>
		</div>
		<div class="input-group row">
			<div class="col">
				<p>Card Number*</p>
				<input type="text" name="ccnum" placeholder="0000000000">
			</div>
			<div class="col">
			<p>Expiration Date*</p>
				<div class="cc">
					<select name="ccex1">
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
				</div>
				<div class="cc">
					<select name="ccex2">
						<option value="18">2018</option>
						<option value="19">2019</option>
						<option value="20">2020</option>
						<option value="21">2021</option>
						<option value="22">2022</option>
						<option value="23">2023</option>
						<option value="24">2024</option>
					</select>
				</div>
			</div>
		</div>
		<div class="input-group icons">
			<i class="fab fa-cc-visa fa-2x"></i>
			<i class="fab fa-cc-mastercard fa-2x"></i>
			<i class="fab fa-cc-amex fa-2x"></i>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn">Register</button>
		</div>
		<p>
			Already a member? <a href="login.php">Sign in</a>
		</p>
	</form>
</body>
</html>