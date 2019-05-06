
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
$smt = $conn->prepare('select cartype_id,name From cartypes');
$smt->execute();
$dataCartype = $smt->fetchAll();
?>

<?php 
//if(isset($_FILES['fileField']['name']) && isset($_POST['caption'])){//print_r($_FILES);
if(isset($_POST['cartype'])){//print_r($_FILES);
    $cartype = $_POST['cartype'];
    $name = $_POST['name'];
    $identity_no = $_POST['identity_no'];
    $rental_cost = $_POST['rental_cost'];
    $image= $_FILES['fileField']['name'];//print_r($image);exit;
    $newname= $_FILES['fileField']['name'];
    $description = str_replace("'", "\'", $_POST['description']); 
   // $curr_timestamp = date('Y-m-d H:i:s'); //print_r($curr_timestamp);exit();
    //$my_date = strtotime($curr_timestamp);
    //mysql_set_charset('utf8');
    $sql = "INSERT INTO `cars`(`cartype_id`, `carname`, `identityNo`, `photo`, `description`, `costPerday`)VALUES('$cartype', '$name', '$identity_no', '$image', '$description', '$rental_cost')";//print_r($sql);exit;
        $count = $conn->exec($sql);//print_r($count);exit;
       
       // $conn->query("SET NAMES 'utf8'");
        echo 'Added Successful.';
    if (($_FILES["fileField"]["type"] == "image/gif")
        || ($_FILES["fileField"]["type"] == "image/jpeg")
        || ($_FILES["fileField"]["type"] == "image/png" ))
    {

        $target = $_SERVER['DOCUMENT_ROOT'] . '/carrental/uploads/';//print_r($target);exit;
        move_uploaded_file($_FILES['fileField']['tmp_name'], $target.$newname);//exit();
       // header("Location:barcode-manage.php?success=1");
    }
    else
    {
        echo "Sorry, Files must be either JPEG, GIF, or PNG and less than 10,000 kb";
    }
       // header("Location:guesthouse-manage.php?success=1");
    echo "<script type='text/javascript'>window.location.href = 'car-manage.php';</script>";
    
}
 ?>
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
          <li class="active">Car</li>
        </ol><!--breadcrum end-->
    
        <div class="no-table-blank-state row">
                <!--no table found blank state-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="holder">
                        <form id="validationForm" action="" method="post" enctype="multipart/form-data">
            <div class="pmd-card pmd-z-depth">
                <div class="pmd-card-body">
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="regular1" class="control-label">
                                    Car Type*
                                </label>
                                <select required class="select-simple form-control pmd-select2" name="cartype">
                                    <?php foreach ($dataCartype as $row): ?>
                                        <option value="<?=$row["cartype_id"]?>"><?=$row["name"]?></option>
                                    <?php endforeach ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                              <label class="control-label">Identity No</label>
                              <input type="text" id="regular1" class="form-control" name="identity_no">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                              <label class="control-label">Name</label>
                              <input type="text" id="regular1" class="form-control" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                              <label class="control-label">Rental Cost Per Day</label>
                              <input required type="number" id="regular1" class="form-control" name="rental_cost">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                              <label class="control-label">Description</label>
                              <textarea class="form-control" name="description" rows="2" cols="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">       
                                <!-- <label>Photo</label> -->
                                <input type="file" style="float: right;" name="fileField" id="fileField" />
                            </div>
                        </div>
                        
                    </div>
                </div>      
                <div class="pmd-card-actions">
                    <button  type="submit" class="btn btn-primary next">Submit</button>
                    <a href="car-manage.php" class="btn btn-default">Cancel</a>
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