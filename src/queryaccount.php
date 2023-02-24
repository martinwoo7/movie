<?php
    session_start();
    $account_id = $_SESSION['user']['account_id'];
?>

<html>
    <head>
        <title>OMTS</title>
        <link type="text/css" rel="stylesheet" href="OMTS.css" />
        <meta charset="UTF-8">
    </head>
    <body>
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
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql .= "UPDATE customer SET password=? WHERE account_id=?;";
            $values[] = $password;
            $values[] = $account_id;
        }
        
        try {
            $dbh = new PDO('mysql:host=localhost;dbname=OMTS','root','');
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if ($sql != "") {
                $query = $dbh->prepare($sql);
                $query -> execute($values);
            }
            
            $dbh = null;
        } catch (PDOEXCEPTION $e) {
            echo $e -> getMessage();
            die();
        }
        
        header("Location: account.php");
        exit();
        ?>
    </body>
</html>