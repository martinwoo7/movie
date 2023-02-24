<!doctype html>
<?php include('functions.php') ?>
<html>
<head>
<meta charset="utf-8">
<title>Log in</title>
</head>

<body>
<div class="login">
	<form action="login.php" method="post">
		
		<?php echo display_error(); ?>
		
		<h1>Log In</h1>
		<p>Don't have an account? <a href="index.php">Sign Up</a></p>
		<h2>Movie Account</h2>
		
		<div class="input-group">
			<p>Account Number*</p>
			<input type="text" name="accountnum" placeholder="Enter Account Number*">		
			<br>
		</div>

		<div class="input-group">
			<p>Password*</p>
			<input type="password" name="loginpwd" placeholder="Enter Password*">
			<br>
			<a href="#">Forgot your password?</a>
			<br>
			<input type="checkbox" name="remember" value="Remember">Keep Me Logged In
		<br>
		<br>
		</div>

		<div class="input-group">
			<button type="submit" class="btn" name="login_btn">Log In</button>
		</div>
	</form>
</div>
</body>
</html>