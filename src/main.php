<!doctype html>
<?php include('functions.php');

if(!isLoggedIn()) {
	$_SESSIONS['msg'] = "You must log in first";
	header('location: login.php');
	
} ?>

<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="Resources/main.css">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<title>Home</title>
</head>

<body>

	<div class="nav">
		<div class="col">
			<h1>TITLE</h1>
		</div>
		<div class="col">
			<ul class="navTool">
				<li><a href="#">Showtimes</a></li>
				<li><a href="#">Theaters</a></li>
				<li><a href="#">Trailers</a></li>
				<?php  if (isset($_SESSION['user'])) : ?>
					<li><?php echo $_SESSION['user']['first_name']; ?></li>
					<small>
						<i>(<?php echo ucfirst($_SESSION['user']['member_type']); ?>)</i>
						<br>
						<a href="account.php">Account</a>
						<a href="index.php?logout='1'">logout</a>
					</small>
				<?php  endif ?>
			</ul>
		</div>
	</div>

	<div class="content">
		<?php if (isset($_SESSIONS['success'])) : ?>
			<div class="error success">
				<h3>
					<?php echo $_SESSION['success'];
						unset($_SESSION['sucess']); 
					?>
				</h3>
			</div>
		<?php endif ?>
	</div>

	<div class="banner">
		<div class="hero">
			
		</div>
	</div>

	<?php 
		$movies = $dbh -> query("SELECT title from movie");
		
        $movieNameArr = array();
		foreach($movies as $movRow) {
    		$movieNameArr[] = $movRow[0];
		}
		$movieNameArrLen = count($movieNameArr);
        
        echo('<div id="posters">');
		for($i = 0; $i < $movieNameArrLen; $i++) {
            echo('<div class="poster">');
            echo('<a href="specificmovie.php?moviename=');
            echo($movieNameArr[$i].'">');
            echo('<img src="Resources/img/');
            echo($movieNameArr[$i].'.jpg">');
            echo('<p>'.$movieNameArr[$i].'</p></a></div>');
		}
        echo('</div>');
	?>
    
    <div id=clear></div>
	<div class="footer">
		<ul class="footerStuff">
			<li><a href="#">About Us</a></li>
			<li><a href="#">Contact Us</a></li>
			<li><a href="#">Random Link</a></li>
			<li><a href="#">Random Link</a></li>
		</ul>
	</div>

</body>
</html>
