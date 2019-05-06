<?php
// check request
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    // include Database connection file
    include("../../../dbconnect.php");

    // get user id
    $id = $_POST['id'];
        $stmt = $conn->prepare("SELECT name FROM cartypes WHERE cartype_id=".$id); //print_r($stmt);
        $stmt->execute();
        $row = $stmt->fetch();
        
    $query = "DELETE FROM cartypes WHERE cartype_id = '$id'";
    
    /*if (!$result = mysql_query($query)) {
        exit(mysql_error());
    }*/
    $conn->query($query);
}
?>