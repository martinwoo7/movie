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
        
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $street_number = $_POST['street_number'];
        $street_name = $_POST['street_name'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $postal_code = $_POST['postal_code'];
        $email = $_POST['email'];
        $cc_number = $_POST['cc_number'];
        $cc_expiry = $_POST['cc_expiry'];
        $phone_number = $_POST['phone_number'];
        $password = $_POST['password'];
        
        $sql = "";
        $values = array();
        
        if ($first_name != "") {
            $sql .= "UPDATE customer SET first_name=? WHERE account_id=?;";
            $values[] = $first_name;
            $values[] = $account_id;
        }
        
        if ($last_name != "") {
            $sql .= "UPDATE customer SET last_name=? WHERE account_id=?;";
            $values[] = $last_name;
            $values[] = $account_id;
        }
        
        if ($email != "") {
            $sql .= "UPDATE customer SET email=? WHERE account_id=?;";
            $values[] = $email;
            $values[] = $account_id;
        }
        
        if ($street_number != "") {
            $sql .= "UPDATE customer SET street_number=? WHERE account_id=?;";
            $values[] = $street_number;
            $values[] = $account_id;
        }
        
        if ($street_name != "") {
            $sql .= "UPDATE customer SET street_name=? WHERE account_id=?;";
            $values[] = $street_name;
            $values[] = $account_id;
        }
        
        if ($city != "") {
            $sql .= "UPDATE customer SET city=? WHERE account_id=?;";
            $values[] = $city;
            $values[] = $account_id;
        }
        
        if ($province != "") {
            $sql .= "UPDATE customer SET province=? WHERE account_id=?;";
            $values[] = $province;
            $values[] = $account_id;
        }
        
        if ($postal_code != "") {
            $sql .= "UPDATE customer SET postal_code=? WHERE account_id=?;";
            $values[] = $postal_code;
            $values[] = $account_id;
        }
        
        if ($cc_number != "") {
            $sql .= "UPDATE customer SET cc_number=? WHERE account_id=?;";
            $values[] = $cc_number;
            $values[] = $account_id;
        }
        
        if ($cc_expiry != "") {
            $sql .= "UPDATE customer SET cc_expiry=? WHERE account_id=?;";
            $values[] = $cc_expiry;
            $values[] = $account_id;
        }
        
        if ($phone_number != "") {
            $sql .= "UPDATE customer_phone SET phone_number=? WHERE account_id=?;";
            $values[] = $phone_number;
            $values[] = $account_id;
        }
        
        if ($password != "") {
            $password = md5($password);
            $sql .= "UPDATE customer SET password=? WHERE account_id=?;";
            $values[] = $password;
            $values[] = $account_id;
        }
        
        try {
            global $dbh;
            
            if ($sql != "") {
                $query = $dbh->prepare($sql);
                $query -> execute($values);
            }
            
            if (isset($_POST['view_purchases'])) {
                $purchases = "SELECT movie_title, theatre_complex, theatre_number, purchase_date, num_tickets_reserved, child_tickets, regular_tickets, senior_tickets, cost FROM reservation JOIN showing ON reservation.showing_id = showing.showing_id WHERE reservation.account_id=?;";
                $query = $dbh->prepare($purchases);
                $query -> execute([$account_id]);
                $purchase_rows = $query->fetchAll();
            }
            
        } catch (PDOEXCEPTION $e) {
            echo $e -> getMessage();
            die();
        }
        
        if (isset($_POST['view_purchases'])) {
            $output = '<p>Purchase History for: '.$account_id.'</p>';
            $output .= "<table><tr><th>Movie</th><th>Theatre Complex</th><th>Theatre #</th><th>Purchase Date</th><th>Total Tickets</th><th>Child</th><th>Regular</th><th>Senior</th><th>Cost ($)</th></tr>";
            foreach ($purchase_rows as $row) {
                $output .= "<tr><td>".$row['movie_title']."</td>";
                $output .= "<td>".$row['theatre_complex']."</td>";
                $output .= "<td>".$row['theatre_number']."</td>";
                $output .= "<td>".$row['purchase_date']."</td>";
                $output .= "<td>".$row['num_tickets_reserved']."</td>";
                $output .= "<td>".$row['child_tickets']."</td>";
                $output .= "<td>".$row['regular_tickets']."</td>";
                $output .= "<td>".$row['senior_tickets']."</td>";
                $output .= "<td>".$row['cost']."</td></tr>";
            }
            $output .= "</table><br>";
            echo($output);
        } else {
            header("Location: account.php");
            exit();
        }
        ?>
        <label><a href="account.php">Return</a></label>
    </body>
</html>