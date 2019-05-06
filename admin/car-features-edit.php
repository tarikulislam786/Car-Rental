
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
if(isset($_GET["id"])){
    $id = $_GET["id"];
    
    if (!empty($id)) {
       // $query = "SELECT id, barcode, subject, formula, category,  warningMark FROM barcodeDetails WHERE id=".$id;
        $stmt = $conn->prepare("SELECT carfeatures.car_id, capacity, aircondition, kmpl, carname, is_automatic_transmission, is_manual_transmission, is_fuel_petrol, is_fuel_diesel FROM carfeatures INNER JOIN cars ON carfeatures.car_id = cars.car_id WHERE carfeatures_id=".$id); //print_r($stmt);
        $stmt->execute();
        $row = $stmt->fetch();
        $car_id = $row['car_id'];
        $carname = $row['carname'];
        $capacity = $row['capacity'];
        $aircondition = $row['aircondition'];
        $kmpl = $row['kmpl'];
        $is_automatic_transmission = $row['is_automatic_transmission'];
        $is_manual_transmission = $row['is_manual_transmission'];
        $is_fuel_petrol = $row['is_fuel_petrol'];
        $is_fuel_diesel = $row['is_fuel_diesel'];
        
        if(!empty($row['carname'])) // referred to as 
        {
            $carname = $row['carname'];
        }
        if(!empty($row['capacity']))  // referred to as 
        {
            $capacity = $row['capacity'];
        }
        if(!empty($row['aircondition']))
        {
            $aircondition = $row['aircondition'];
        }
        if(!empty($row['kmpl']))
        {
            $kmpl = $row['kmpl'];
        }

        if(!empty($row['is_automatic_transmission'])){
            $is_automatic_transmission = $row['is_automatic_transmission'];
        }

        if(!empty($row['is_manual_transmission'])){
            $is_manual_transmission = $row['is_manual_transmission'];
        }
        if(!empty($row['is_fuel_petrol'])){
            $is_fuel_petrol = $row['is_fuel_petrol'];
        }
        if(!empty($row['is_fuel_diesel'])){
            $is_fuel_diesel = $row['is_fuel_diesel'];
        }
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
if(count($_POST)>0) {
if(isset($_POST)){//print_r($_FILES);
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

    
    $UpdateQueryUser = "Update carfeatures set car_id='$car', capacity='$capacity', kmpl='$kmpl', aircondition='$aircondition', is_automatic_transmission='$auto_transmission', is_manual_transmission='$manual_transmission', is_fuel_petrol='$petrol', is_fuel_diesel='$diesel' WHERE carfeatures_id=" . $id;//print_r($UpdateQueryUser);exit();
    $result = $conn->query($UpdateQueryUser);
    if (!empty($result)) {
        echo 'Updated Successful.';
                    //unset($_POST);
    } else {
            echo 'Problem in updating.!';
    }
        
       // header("Location:guesthouse-manage.php?success=1");
    echo "<script type='text/javascript'>window.location.href = 'car-features-manage.php?success=1';</script>";
    
    //header("location:inventory_list.php");
    //exit();
}
}
 ?>
<!--content area start-->
<div id="content" class="pmd-content inner-page">
    <!--tab start-->
    <div class="container-fluid full-width-container blank">
        <!-- Title -->
        <h1 class="section-title" id="services">
            <span>Update</span>
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
                                        <option <?=$car_id == $row["car_id"] ? ' selected="selected"' : '';?> value="<?=$row["car_id"]?>"><?=$row["carname"]?></option>
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
                                <input type="number"  value="<?php echo $capacity;?>" required id="regular1" class="form-control" name="capacity">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="regular1" class="control-label">
                                    Kilometer/Litre*
                                </label>
                                <input type="number" value="<?php echo $kmpl;?>" min="0" step="0.01" required id="regular1" class="form-control" name="kmpl">
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
                                        <option <?=$aircondition == "Dual Zone" ? ' selected="selected"' : '';?> value="Dual Zone">Dual Zone</option>
                                        <option <?=$aircondition == "Three Zone" ? ' selected="selected"' : '';?> value="Three Zone">Three Zone</option>
                                        <option <?=$aircondition == "Four Zone" ? ' selected="selected"' : '';?> value="Four Zone">Four Zone</option>
                                </select>
                            </div>
                            <div class="checkbox pull-left custom" style="margin-bottom: 20px;display: block"></div>
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    <input <?php if($is_automatic_transmission== 1) echo "checked ";?>type="checkbox" name="auto_transmission" value="1" class="pm-ini"><span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Automatic Transmission</span>
                                </label>
                            </div>
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    <input <?php if($is_manual_transmission== 1) echo "checked ";?>type="checkbox" name="manual_transmission" value="1" class="pm-ini"><span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Manual Transmission</span>
                                </label>
                            </div>
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    <input <?php if($is_fuel_petrol== 1) echo "checked ";?>type="checkbox" name="petrol" value="1" class="pm-ini"><span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Fuel Petrol</span>
                                </label>
                            </div>
                            <div class="checkbox pull-left custom">
                                <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                    <input <?php if($is_fuel_diesel== 1) echo "checked ";?>type="checkbox" name="diesel" value="1" class="pm-ini"><span class="pmd-checkbox-label">&nbsp;</span>
                                    <span class="pmd-checkbox"> Fuel Diesel</span>
                                </label>
                            </div>
                            
                        
                            </div>
                        </div>
                    </div>
                </div>      
                <div class="pmd-card-actions">
                    <button  type="submit" class="btn btn-primary next">Submit</button>
                    <a href="car-features-manage.php" class="btn btn-default">Cancel</a>
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