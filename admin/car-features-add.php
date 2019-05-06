
<?php
error_reporting(1);
ob_start(); // redirecting problem solved
 include('../dbconnect.php');
 include('header.php');
 ?>
 <?php 
 session_start();//print_r($_SESSION);exit;
if(!isset($_SESSION["email"]))
{
    header("location:../login.php?unauthorized-access=1");
    exit();
}
 ?>
<?php
$email=$_SESSION["email"];

$query = "SELECT role from users where email="."'$email'";//print_r($query);

$result= $conn->query($query);//print_r($result);
//exit(mysql_error());
$result->setFetchMode(PDO::FETCH_ASSOC);
$countmach =$result->rowCount();
//echo $countmach;
if($countmach ==1) {//print_r("login successful");exit;
    $row = $result->fetch();//print_r($row);exit;
    $role = $row['role'];//print_r($role);
    if($role>1) // if student/ teacher
    {
        //echo "Un authorized access.";
        header('Location:error.php');
    }
}
?>
<?php 
// dropdown select populating
$smt = $conn->prepare('select car_id, carname From cars');
$smt->execute();
$dataCar = $smt->fetchAll();
?>
<?php 
//if(isset($_FILES['fileField']['name']) && isset($_POST['caption'])){//print_r($_FILES);
if(isset($_POST['car'])){//print_r($_FILES);
    $capacity = $_POST['capacity'];
    $car = $_POST['car'];
    $kmpl = $_POST['kmpl']; //print_r($kmpl);exit();
    $aircondition = $_POST['aircondition'];
    $auto_transmission = $_POST['auto_transmission'];
    $manual_transmission = $_POST['manual_transmission'];
    $petrol = $_POST['petrol'];
    $diesel = $_POST['diesel'];
    
   // $curr_timestamp = date('Y-m-d H:i:s'); //print_r($curr_timestamp);exit();
   // $my_date = strtotime($curr_timestamp);
    //mysql_set_charset('utf8');
    $sql = "INSERT INTO `carfeatures` (`car_id`, `capacity`, `aircondition`, `is_automatic_transmission`, `is_manual_transmission`, `kmpl`, `is_fuel_petrol`, `is_fuel_diesel`)VALUES('$car', '$capacity','$aircondition','$auto_transmission', '$manual_transmission', '$kmpl', '$petrol', '$diesel')";//print_r($sql);exit;
        $count = $conn->exec($sql);//print_r($count);exit;
        mysql_set_charset('utf8');
       // $conn->query("SET NAMES 'utf8'");
        echo 'Added Successful.';
    
       // header("Location:guesthouse-manage.php?success=1");
    echo "<script type='text/javascript'>window.location.href = 'car-features-manage.php';</script>";
    
}
 ?>
 <style type="text/css">
.pull-left.custom{float:none!important; display: inline;}
 </style>
<!--content area start-->
<div id="content" class="pmd-content inner-page">
    <!--tab start-->
    <div class="container-fluid full-width-container blank">
        <!-- Title -->
        <h1 class="section-title" id="services">
            <span>ADD</span>
        </h1><!-- End Title -->
    
        <!--breadcrum start-->
        <ol class="breadcrumb text-left">
          <li><a href="index.html">Dashboard</a></li>
          <li class="active">Car Features</li>
        </ol><!--breadcrum end-->
    
        <div class="no-table-blank-state row">
                <!--no table found blank state-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="holder">
                        <form id="validationForm" action="" method="post">
            <div class="pmd-card pmd-z-depth">
                <div class="pmd-card-body">
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="regular1" class="control-label">
                                    Car*
                                </label>
                                <select required class="select-simple form-control pmd-select2" name="car">
                                    <?php foreach ($dataCar as $row): ?>
                                        <option value="<?=$row["car_id"]?>"><?=$row["carname"]?></option>
                                    <?php endforeach ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="regular1" class="control-label">
                                    Max Capacity*
                                </label>
                                <input type="number"  required id="regular1" class="form-control" name="capacity">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="regular1" class="control-label">
                                    Kilometer/Litre*
                                </label>
                                <input type="number" min="0" step="0.01" required id="regular1" class="form-control" name="kmpl">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group clearfix">
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    
                                    <span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Air condition</span>
                                </label>
                                <select required class="select-simple form-control pmd-select2" name="aircondition">
                                        <option value="Dual Zone">Dual Zone</option>
                                        <option value="Three Zone">Three Zone</option>
                                        <option value="Four Zone">Four Zone</option>
                                </select>
                            </div>
                            <div class="checkbox pull-left custom" style="margin-bottom: 20px;display: block"></div>
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    <input type="checkbox" name="auto_transmission" value="1" class="pm-ini"><span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Automatic Transmission</span>
                                </label>
                            </div>
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    <input type="checkbox" name="manual_transmission" value="1" class="pm-ini"><span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Manual Transmission</span>
                                </label>
                            </div>
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    <input type="checkbox" name="petrol" value="1" class="pm-ini"><span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Fuel Petrol</span>
                                </label>
                            </div>
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    <input type="checkbox" name="diesel" value="1" class="pm-ini"><span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Fuel Diesel</span>
                                </label>
                            </div>
                            
                        
                            </div>
                        </div>
                    </div>
                </div>      
                <div class="pmd-card-actions">
                    <button  type="submit" class="btn btn-primary next">Submit</button>
                    <a href="roomtype-manage.php" class="btn btn-default">Cancel</a>
                </div>
            </div> <!-- section content end -->  
            </form>
                    </div>
                </div><!-- end no table found blank state-->
            </div>
    </div><!-- tab end -->
    
</div><!-- content area end -->


<?php 
    include('footer.php');

?>