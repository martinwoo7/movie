<?php
include("functions.php");

if(!isLoggedIn()) {
    $_SESSIONS['msg'] = "You must log in first";
    header('location: login.php');
}
$account_id = $_SESSION['user']['account_id'];
?>

<html>
    <head>
        <title>OMTS</title>
        <link type="text/css" rel="stylesheet" href="Resources/OMTS.css" />
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        $sql = "SELECT customer.account_id, first_name, last_name, phone_number, street_number, street_name, city, province, postal_code, email, cc_number, cc_expiry FROM customer JOIN customer_phone ON customer.account_id = customer_phone.account_id WHERE member_type = 'member'";
        
        try {
            global $dbh;
            $rows = $dbh -> query($sql);
        } catch (PDOEXCEPTION $e) {
            echo $e -> getMessage();
            die();
        }
        
        $output = "<table><tr><th>Acc. ID</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Street #</th><th>Street Name</th><th>City</th><th>Province</th><th>Postal Code</th><th>email</th><th>CC Number</th><th>CC Expiry</th></tr>";
        foreach ($rows as $row) {
            $output .= "<tr><td>".$row['account_id']."</td>";
            $output .= "<td>".$row['first_name']."</td>";
            $output .= "<td>".$row['last_name']."</td>";
            $output .= "<td>".$row['phone_number']."</td>";
            $output .= "<td>".$row['street_number']."</td>";
            $output .= "<td>".$row['street_name']."</td>";
            $output .= "<td>".$row['city']."</td>";
            $output .= "<td>".$row['province']."</td>";
            $output .= "<td>".$row['postal_code']."</td>";
            $output .= "<td>".$row['email']."</td>";
            $output .= "<td>".$row['cc_number']."</td>";
            $output .= "<td>".$row['cc_expiry']."</td></tr>";
        }
        $output .= "</table><br>";
        echo($output);
        ?>
    </body>
</html>