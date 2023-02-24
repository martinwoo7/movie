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
        
        $sql = "";
        $values = array();
        
        $sql_rental = "";
        $rental = $_POST['history'];
        if ($rental != "") {
            $sql_rental = "SELECT movie_title, theatre_complex, theatre_number, purchase_date, num_tickets_reserved, child_tickets, regular_tickets, senior_tickets, cost FROM reservation JOIN showing ON reservation.showing_id = showing.showing_id WHERE reservation.account_id=?;";
        }
        
        $del_account = $_POST['del_account'];
        if ($del_account != "") {
            $sql .= "DELETE FROM customer WHERE account_id=?;";
            $values[] = $del_account;
        }
        
        $num_theatres = 0;
        $theatre_complex = $_POST['theatre_complex'];
        if ($theatre_complex != "") {
            
            $street_number = $_POST['street_number'];
            $street_name = $_POST['street_name'];
            $city = $_POST['city'];
            $province = $_POST['province'];
            $postal_code = $_POST['postal_code'];
            $phone_number = $_POST['phone_number'];
            
            try {
                global $dbh;
                
                $query = $dbh->prepare("SELECT theatre_name FROM theatrecomplex WHERE theatrecomplex.theatre_name=?;");
                $query -> execute([$theatre_complex]);
                $check = $query->fetch();
                
                if (!$check and $street_number != "" and $street_name != "" and $city != "" and $province != "" and $postal_code != "" and $phone_number != "") {
                    $query = $dbh->prepare("INSERT INTO theatrecomplex VALUES(?,0,?,?,?,?,?,?)");
                    $query -> execute([$theatre_complex, $street_number, $street_name, $city, $province, $postal_code, $phone_number]);
                    
                } else {
                    
                    if ($street_number != "") {
                        $sql .= "UPDATE theatrecomplex SET street_number=? WHERE theatre_name=?;";
                        $values[] = $street_number;
                        $values[] = $theatre_complex;
                    }
            
                    if ($street_name != "") {
                        $sql .= "UPDATE theatrecomplex SET street_name=? WHERE theatre_name=?;";
                        $values[] = $street_name;
                        $values[] = $theatre_complex;
                    }

                    if ($city != "") {
                        $sql .= "UPDATE theatrecomplex SET city=? WHERE theatre_name=?;";
                        $values[] = $city;
                        $values[] = $theatre_complex;
                    }

                    if ($province != "") {
                        $sql .= "UPDATE theatrecomplex SET province=? WHERE theatre_name=?;";
                        $values[] = province;
                        $values[] = $theatre_complex;
                    }

                    if ($postal_code != "") {
                        $sql .= "UPDATE theatrecomplex SET postal_code=? WHERE theatre_name=?;";
                        $values[] = postal_code;
                        $values[] = $theatre_complex;
                    }

                    if ($phone_number != "") {
                        $sql .= "UPDATE theatrecomplex SET phone_number=? WHERE theatre_name=?;";
                        $values[] = phone_number;
                        $values[] = $theatre_complex;
                    }
                }
                
                $query = $dbh->prepare("SELECT COUNT(theatre.theatre_number) as num_theatres FROM theatre JOIN theatrecomplex ON theatre.theatre_complex = theatrecomplex.theatre_name WHERE theatre.theatre_complex=?;");
                $query -> execute([$theatre_complex]);
                $result = $query->fetch();
                $num_theatres = $result['num_theatres'];
                
            } catch (PDOEXCEPTION $e) {
                echo $e -> getMessage();
                die();
            }
            
            $theatre_number = $_POST['theatre_number'];
            $max_seats = $_POST['max_seats'];
            $screen_size = $_POST['screen_size'];
            if ($theatre_number != "") {
                
                if ($max_seats != "") {
                    $sql .= "UPDATE theatrecomplex JOIN theatre ON theatrecomplex.theatre_name = theatre.theatre_complex AND theatre.theatre_complex=? AND theatre.theatre_number=? SET max_seats=?;";
                    $values[] = $theatre_complex;
                    $values[] = $theatre_number;
                    $values[] = $max_seats;
                    
                    $sql .= "UPDATE showing SET max_seats=? WHERE theatre_complex=? AND theatre_number=?;";
                    $values[] = $max_seats;
                    $values[] = $theatre_complex;
                    $values[] = $theatre_number;
                }
                
                if ($screen_size != "") {
                    $sql .= "UPDATE theatrecomplex JOIN theatre ON theatrecomplex.theatre_name = theatre.theatre_complex AND theatre.theatre_complex=? AND theatre.theatre_number=? SET screen_size=?;";
                    $values[] = $theatre_complex;
                    $values[] = $theatre_number;
                    $values[] = $screen_size;
                }
            }
            
            if (isset($_POST['add_theatre']) and $max_seats != "" and $screen_size != "") {
                $sql .= "INSERT INTO theatre VALUES(?,NULL,?,?);";
                $values[] = $theatre_complex;
                $values[] = $max_seats;
                $values[] = $screen_size;
                
                $num_theatres += 1;
                $sql .= "UPDATE theatrecomplex SET number_of_theatres=? WHERE theatre_name=?;";
                $values[] = $num_theatres;
                $values[] = $theatre_complex;
            }
        }
        
        $movie = $_POST['movie'];
        if ($movie != "") {
            
            try {
                global $dbh;

                $query = $dbh->prepare("SELECT title FROM movie WHERE title=?;");
                $query -> execute([$movie]);
                $check = $query->fetch();
                
            } catch (PDOEXCEPTION $e) {
                echo $e -> getMessage();
                die();
            }
            
            $director = $_POST['director'];
            $rating = $_POST['rating'];
            $running_time = "";
            $hours = $_POST['running_time_h'];
            $minutes = $_POST['running_time_m'];
            $seconds = $_POST['running_time_s'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $plot_synopsis = $_POST['plot_synopsis'];
            
            if ($hours != "" and $minutes != "" and $seconds != "") {
                $running_time = $hours.':'.$minutes.':'.$seconds;
                $running_time = date("H:i:s",strtotime($running_time));
            }

            if (!$check and $director != "" and $rating != "" and $running_time != "" and $start_date != "" and $end_date != "" and $plot_synopsis != "" and is_uploaded_file($_FILES['poster']['tmp_name'])) {

                $start_date = date("Y-m-d H:i:s",strtotime($start_date));
                $end_date = date("Y-m-d H:i:s",strtotime($end_date));

                $sql .= "INSERT INTO movie VALUES(?,?,?,?,?,?,?);";
                $values[] = $movie;
                $values[] = $running_time;
                $values[] = $rating;
                $values[] = $plot_synopsis;
                $values[] = $director;
                $values[] = $start_date;
                $values[] = $end_date;
                
                $poster = $_FILES['poster'];
                $ext = pathinfo($poster['name'], PATHINFO_EXTENSION); #image type
                $new_file_name = $movie.".".$ext; #image name is email
                $success = move_uploaded_file($poster['tmp_name'], "Resources/img/".$new_file_name);

            } else {

                if ($director != "") {
                    $sql .= "UPDATE movie SET director=? WHERE title=?;";
                    $values[] = $director;
                    $values[] = $movie;
                }

                if ($rating != "") {
                    $sql .= "UPDATE movie SET rating=? WHERE title=?;";
                    $values[] = $rating;
                    $values[] = $movie;
                }

                if ($running_time != "") {
                    $sql .= "UPDATE movie SET running_time=? WHERE title=?;";
                    $values[] = $running_time;
                    $values[] = $movie;
                }

                if ($start_date != "") {
                    $sql .= "UPDATE movie SET start_date=? WHERE title=?;";
                    $values[] = $start_date;
                    $values[] = $movie;
                }

                if ($end_date != "") {
                    $sql .= "UPDATE movie SET end_date=? WHERE title=?;";
                    $values[] = $end_date;
                    $values[] = $movie;
                }

                if ($plot_synopsis != "") {
                    $sql .= "UPDATE movie SET plot_synopsis=? WHERE title=?;";
                    $values[] = $plot_synopsis;
                    $values[] = $movie;
                }
            }
        }
        
        $popular_complex = "";
        if (isset($_POST['popular_complex'])) {
            $popular_complex = "SELECT showing.theatre_complex, SUM(num_tickets_reserved) as tickets_sold FROM reservation JOIN showing on reservation.showing_id = showing.showing_id GROUP BY showing.theatre_complex ORDER BY tickets_sold DESC LIMIT 1;";
        }
        
        $popular_movie = "";
        if (isset($_POST['popular_movie'])) {
            $popular_movie = "SELECT showing.movie_title, SUM(num_tickets_reserved) as tickets_sold FROM reservation JOIN showing on reservation.showing_id = showing.showing_id GROUP BY showing.showing_id ORDER BY tickets_sold DESC LIMIT 1;";
        }
        
        try {
            global $dbh;
            
            if ($sql != "") {
                $query = $dbh->prepare($sql);
                $query -> execute($values);
            }
            
            if ($sql_rental != "") {
                $query = $dbh->prepare($sql_rental);
                $query->execute([$rental]);
                $rental_rows = $query->fetchAll();
            }
            
            if ($popular_complex != "") {
                $query = $dbh->prepare($popular_complex);
                $query->execute();
                $complex = $query->fetch();
            }
            
            if ($popular_movie != "") {
                $query = $dbh->prepare($popular_movie);
                $query->execute();
                $movie = $query->fetch();
            }
            
        } catch (PDOEXCEPTION $e) {
            echo $e -> getMessage();
            die();
        }
        
        if (isset($rental_rows)) {
            $output = '<p>Rental history for user ID: '.$rental.'</p>';
            $output .= "<table><tr><th>Movie</th><th>Theatre Complex</th><th>Theatre #</th><th>Purchase Date</th><th>Total Tickets</th><th>Child</th><th>Regular</th><th>Senior</th><th>Cost ($)</th></tr>";
            foreach ($rental_rows as $row) {
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
        }
        
        if ($popular_complex != "") {
            echo('<p>The most popular theatre complex is '.$complex['theatre_complex'].' which sold '.$complex['tickets_sold'].' tickets</p>');
        }
        
        if ($popular_movie != "") {
            echo('<p>The most popular movie is '.$movie['movie_title'].' which sold '.$movie['tickets_sold'].' tickets</p>');
        }
        
        echo('<p>Execution completed</p>');
        
        ?>
    </body>
</html>