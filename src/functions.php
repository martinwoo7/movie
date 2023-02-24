<?php
session_start();

$dbh = new PDO('mysql:host=localhost;dbname=moviedb',"root", "");
$dbh -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$errors = array();
date_default_timezone_set('Canada/Pacific');
if (isset($_POST['register_btn'])) {
	register();
}

function register() {
	
	global $dbh, $errors, $accnum, $email;
	
	
	$accnum = mt_rand(100000, 999999);
	$password_1 = $_POST['pwd'];
	$password_2 = $_POST['pwd2'];
	$member_type = "member";
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$street_number = $_POST['streetnum'];
	$street_name = $_POST['streetname'];
	$city = $_POST['city'];
	$province = $_POST['province'];
	$postal_code = $_POST['postal'];
	$email = $_POST['email'];
	$cc_number = $_POST['ccnum'];
	$cc_exp1 = $_POST['ccex1'];
	$cc_exp2 = $_POST['ccex2'];
	$cc_exp = $cc_exp1 . "/" . $cc_exp2;
	$phone = $_POST['phone'];
	
	
	
	/*if (empty($accname)) {
		array_push($errors, "Username is required");
	}*/
	
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	
	if ($password_1 != $password_2) {
		array_push($errors, "Passwords do not match");
	}
	
	if (count($errors) == 0) {
		$password = md5($password_1);
		
		if (isset($_POST['member_type'])) {
			$member_type = e($_POST['member_type']);
			$query = "INSERT INTO customer (account_id, password, member_type, first_name, last_name, street_number, street_name, city, province, postal_code, email, cc_number, cc_expiry) VALUES('$accnum', '$password', '$member_type', '$firstname', '$lastname', '$street_number', '$street_name', '$city', '$province', '$postal_code', '$email', '$cc_number', '$cc_exp')";
			$dbh -> query($query);
			$dph -> query("INSERT INTO customer_phone VALUES('$accnum', '$phone')");
			$_SESSION['success'] = "New User successfully created!";
			header('location: user.php');
		}
		else {
			//(account_id, password, member_type, first_name, last_name, street_number, street_name, city, province, postal_code, email, cc_number, cc_expiry)
			$query = "INSERT INTO customer (account_id, password, member_type, first_name, last_name, street_number, street_name, city, province, postal_code, email, cc_number, cc_expiry) VALUES('$accnum', '$password', 'member', '$firstname', '$lastname', '$street_number', '$street_name', '$city', '$province', '$postal_code', '$email', '$cc_number', '$cc_exp')";
			$dbh -> query($query);
			$dbh -> query("INSERT INTO customer_phone VALUES('$accnum', '$phone')");
				
			$_SESSION['user'] = getUserById($accnum);
			$_SESSION['success'] = "You are now logged in";
			header('location: main.php');
		}
	}
}

function getUserById($id) {
	global $dbh;
	$query = "SELECT * FROM customer WHERE account_id=" . $id;
	$result = $dbh -> query($query);
	$user = $result -> fetch(PDO::FETCH_ASSOC);
	return $user;
}


function display_error() {
	global $errors;
	if (count($errors) > 0) {
		echo '<div class="error>';
		foreach($errors as $error) {
			echo $error .'<br>';
		}
		echo '</div>';
	}
}

function isLoggedIn() {
	if (isset($_SESSION['user'])) {
		return true;
	}
	else {
		return false;
	}
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

if (isset($_POST['login_btn'])) {
	login();
}

function login() {
	global $dbh, $accnum, $errors;
	
	$accnum = $_POST['accountnum'];
	$password = $_POST['loginpwd'];
	
	if (empty($accnum)) {
		array_push($errors, "Account number is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}
	
	if (count($errors) == 0) {
		$password = md5($password);
		
		$query = "SELECT * FROM customer WHERE account_id='$accnum' AND password='$password' LIMIT 1";
		$result = $dbh -> query($query);
		$rows = $result -> rowCount();
		
		if ($rows == 1) {
			$logged_in_user = $result -> fetch(PDO::FETCH_ASSOC);
			
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['success'] = "You are now logged in";
			
			if ($_SESSION['user']['member_type'] == "admin"){
				header("location: admin.html");
			}
			else {
				header("location: main.php");
			}
		}	
	}
	
	else {
		array_push($errors, "Wrong account number/password combination");
	}
	
	
}

?>