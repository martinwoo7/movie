<!DOCTYPE html>
<?php
include("functions.php");

if (!isLoggedIn()) {
    $_SESSIONS['msg'] = "You must log in first";
    header('location: login.php');
}
$account_id = $_SESSION['user']['account_id'];
?>

<html>
    <head>
        <title>Account</title>
        <link type="text/css" rel="stylesheet" href="Resources/OMTS.css" />
        <meta charset="UTF-8">
    </head>
    <body>
        <div id="masthead">
            <h1>Online Movie Ticket Service Demo</h1>
        </div>
        
        <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        
        try {
            global $dbh;
            $query = $dbh->prepare("SELECT * FROM customer JOIN customer_phone ON customer.account_id = customer_phone.account_id WHERE customer.account_id=?;");
            $query -> execute([$account_id]);
            $account = $query->fetch();
        } catch (PDOEXCEPTION $e) {
            echo $e -> getMessage();
            die();
        }
        
        $first_name = $account['first_name'];
        $last_name = $account['last_name'];
        $street_number = $account['street_number'];
        $street_name = $account['street_name'];
        $city = $account['city'];
        $province = $account['province'];
        $postal_code = $account['postal_code'];
        $email = $account['email'];
        $cc_number = $account['cc_number'];
        $cc_expiry = $account['cc_expiry'];
        $phone_number = $account['phone_number'];
        
        ?>
        <form method="post" action="queryuser.php" enctype="multipart/form-data">
            <p>Account ID: <?php echo($account_id) ?></p>
            
            <div class='queries'>
                
                <label>Basic: </label>
                <input type="text" name="first_name" <?php echo(" placeholder='".$first_name."'") ?>>
                <input type="text" name="last_name" <?php echo(" placeholder='".$last_name."'") ?>>
                <input class="long" name="email" <?php echo(" placeholder='".$email."'") ?>>
                <input type="text" name="phone_number" <?php echo(" placeholder='".$phone_number."'") ?>>
                
                <br>
                <label>Address: </label>
                <input class="custom" name="street_number" <?php echo(" placeholder='".$street_number."'") ?>>
                <input type="text" name="street_name" <?php echo(" placeholder='".$street_name)."'" ?>>
                <input type="text" name="city" <?php echo(" placeholder='".$city."'") ?>>
                <input type="text" name="province" <?php echo(" placeholder='".$province."'") ?>>
                <input type="text" name="postal_code" <?php echo(" placeholder='".$postal_code."'") ?>>
                
                <br>
                <label>Payment: </label>
                <input type="text" name="cc_number" <?php echo(" placeholder='".$cc_number."'") ?>>
                <input type="text" name="cc_expiry" <?php echo(" placeholder='".$cc_expiry."'") ?>>
                
                <br>
                <label>Password: </label>
                <input type="password" name="password" placeholder="********">
                
                <br>
                <label><input type="checkbox" name="view_purchases">View my purchases</label>
            </div>
            
            <div id="spacing"></div>
            
            <div id="follow">
                <input type="submit" value="Execute" class="btn" id="signup">
                <input type="reset" class="btn" id="reset">
            </div>
        </form>
    </body>
</html>