<?php
$no_visible_elements = true;
ob_start(); // redirect issue
error_reporting(1);
//include('admin/header.php'); 
include('dbconnect.php');
?>



<?php
$query = "SELECT car_id, carname FROM cars WHERE cartype_id='".$_GET[cartypeid]."'";//print_r($query);exit();
$result= $conn->query($query); //var_dump($result);
    //exit(mysql_error());
$result->setFetchMode(PDO::FETCH_ASSOC);
 $numrows =$result->rowCount();
if($numrows > 0)
{
 $data = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {

        $data[] = array('car_id' => $row["car_id"], 'carname' => $row["carname"]);
    }
    header("Content-type: application/json");
    echo json_encode($data);
}
?>
