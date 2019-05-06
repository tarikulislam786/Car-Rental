
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
//if(isset($_FILES['fileField']['name']) && isset($_POST['caption'])){//print_r($_FILES);
if(isset($_POST['cartype'])){//print_r($_FILES);
    $cartype = $_POST['cartype'];
    
    //$curr_timestamp = date('Y-m-d H:i:s'); //print_r($curr_timestamp);exit();
   // $my_date = strtotime($curr_timestamp);
    //mysql_set_charset('utf8');
    $sql = "INSERT INTO `cartypes` (`name`)VALUES('$cartype')";//print_r($sql);exit;
        $count = $conn->exec($sql);//print_r($count);exit;
        mysql_set_charset('utf8');
       // $conn->query("SET NAMES 'utf8'");
        echo 'Added Successful.';
    
       // header("Location:guesthouse-manage.php?success=1");
    echo "<script type='text/javascript'>window.location.href = 'cartype-manage.php';</script>";
    
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
          <li class="active">Car Type</li>
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
                                    Name*
                                </label>
                                <input type="text" required id="regular1" class="form-control" name="cartype">
                            </div>
                        </div>
                    </div>
                    
                </div>      
                <div class="pmd-card-actions">
                    <button  type="submit" class="btn btn-primary next">Submit</button>
                    <a href="cartype-manage.php" class="btn btn-default">Cancel</a>
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