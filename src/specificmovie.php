<?php 
include("functions.php");

if(!isLoggedIn()) {
	$_SESSIONS['msg'] = "You must log in first";
	header('location: login.php');	
}
?>

<html>
    <body>

    <?php
        $moviename = $_GET["moviename"];
        $movies = $dbh -> query("SELECT * from movie where title = '$moviename'");

        $movieArr = array();
        foreach($movies as $movRow) {
            foreach($movRow as $col) {
                $movieArr[] = $col;
            }
        }

        echo "<img src='Resources/img/".$moviename.".jpg' alt='Movie Preview' align='middle'<br>";
        echo "<br>";
        echo "Name: ".$movieArr[0];
        echo "<br>";
        echo "Running Time: ".$movieArr[1];
        echo "<br>";
        echo "rating: ".$movieArr[2];
        echo "<br>";
        echo "Plot_Synopsis: ".$movieArr[3];
        echo "<br>";
        echo "Director: " .$movieArr[4];
        echo "<br>";
        echo "Start_date: " .$movieArr[5];
        echo "<br>";
        echo "End_Date: " .$movieArr[6];
        echo "<form action='checkout.php' method='post'>";

        $query = "SELECT * FROM showing WHERE movie_title = '$movieArr[0]'";
        $moviedata = $dbh -> query($query);
        $count = 0;
        foreach($moviedata as $showing) {
            $count = $count + 1;

            if ($count % 5 == 0) {
                echo "<div class='row'>";
            }
            echo "<div class='box'>";
            echo "<p> $showing[1] </p>";
            echo "<p> $showing[3] </p>";
            echo "<input type='hidden' name='id' value='$showing[0]'> ";
            if ($showing[6] == 0) {
                echo "<input type='submit' value='Sold Out' disabled>";
            }
            else {
                echo "<input type='submit' value='Reserve Now'>";
            }
            echo "</div>";

            if ($count % 5 == 4) {
                echo "</div>";
            }

        echo "</form>";	
        }

        echo"</td>
            <td><form action='review.php'>
                <input type = 'hidden' name = 'moviename' value = ".$movieArr[0].">
                <input type = 'hidden' name = 'rating'    value = ".$movieArr[2].">
                <input type='submit' value='Review Movie'>
            </form>";
    ?>
    </body>
</html>