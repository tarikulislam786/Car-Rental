<?php
// check request
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    // include Database connection file
    include("../../../dbconnect.php");

    // get user id
    $id = $_POST['id'];
        $stmt = $conn->prepare("SELECT car_id, photo FROM cars WHERE car_id=".$id); //print_r($stmt);
        $stmt->execute();
        $row = $stmt->fetch();
        $photo = $row['photo']; //print_r($photo);
    $query = "DELETE FROM cars WHERE car_id = '$id'";
    
    /*if (!$result = mysql_query($query)) {
        exit(mysql_error());
    }*/
    $conn->query($query);
    unlink("../../../uploads/".$photo); // if new image uploaded delete the previous one
}
?>