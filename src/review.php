<?php
include("functions.php");

if(!isLoggedIn()) {
    $_SESSIONS['msg'] = "You must log in first";
    header('location: login.php');
}
$account_id = $_SESSION['user']['account_id'];
?>

<html>
    <body>
    <?php
    $moviename = $_GET["moviename"];
    $rating = $_GET["rating"];
    $review = $_GET["review"];
    $id = $_GET["id"];
    $reviews = $dbh->query("SELECT * from review where movie_title = '$moviename'");

    echo "<h3>Make a review for ".$moviename."</h3>";
    echo "<form action='review.php'>
    REVIEW:<br>
    <input type='hidden' name='moviename' value = '$moviename'>
    <input type='hidden' name='rating' value = '$rating'>
    <input type='textbox' name='review' value=''><br>
    <input type='hidden' name='id' value='$id'>
    <input type='submit' value='Submit'>
    <input type='reset'>
  </form>";
  if($review != NULL) {
    $result = $dbh ->query("INSERT INTO Review
    VALUES('$moviename', '$id', '$review')");
    if(!$result) {
        echo "failure to make review.";
    }
}
    echo "<h3>These are the reviews for ".$moviename."</h3>";
    $id = array();
    $review = array();
    foreach($reviews as $revRow) {
        array_push($id,$revRow[1]);
        array_push($review,$revRow[2]);
    }
    $idLen = count($id);
    for($i = 0; $i < $idLen; $i++) {
        echo "User : " .$id[$i] ." says ";
        echo $review[$i];
        echo "<br>";
    }
    ?>
    </body>
</html>