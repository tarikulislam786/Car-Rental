
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
        $stmt = $conn->prepare("SELECT cartype_id, name FROM cartypes WHERE cartype_id=".$id); //print_r($stmt);
        $stmt->execute();
        $row = $stmt->fetch();
        $guesthouse = $row['name'];
       
        if(!empty($row['name'])) // referred to as 
        {
            $cartype = $row['name'];
        }
    }
}
?>

<?php 
/* if(isset($_POST['guesthouse'])){//print_r($_FILES);
    $guesthouse = $_POST['guesthouse'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $curr_timestamp = date('Y-m-d H:i:s'); //print_r($curr_timestamp);exit();
    $my_date = strtotime($curr_timestamp);
    //mysql_set_charset('utf8');
    $sql = "INSERT INTO `guesthouses` (`name`, `street`, `city`, `state`,`zip`, `created_at`, `updated_at`)VALUES('$guesthouse', '$street','$city','$state','$zip', '$my_date', '$my_date')";//print_r($sql);exit;
        $count = $conn->exec($sql);//print_r($count);exit;
        mysql_set_charset('utf8');
       // $conn->query("SET NAMES 'utf8'");
        echo 'Added Successful.';
    
       // header("Location:guesthouse-manage.php?success=1");
    echo "<script type='text/javascript'>window.location.href = 'guesthouse-manage.php';</script>";
    
} */
 ?>
  <?php 
if(count($_POST)>0) {
if(isset($_POST)){//print_r($_FILES);
        $cartype = $_POST['cartype'];
        
   // $curr_timestamp = date('Y-m-d H:i:s'); //print_r($curr_timestamp);exit();
  //  $my_date = strtotime($curr_timestamp);

    
    $UpdateQueryUser = "Update cartypes set name='$cartype' WHERE cartype_id=" . $id;//print_r($UpdateQueryUser);exit;
    $result = $conn->query($UpdateQueryUser);
    if (!empty($result)) {
        echo 'Updated Successful.';
                    //unset($_POST);
    } else {
            echo 'Problem in updating.!';
    }
        
       // header("Location:guesthouse-manage.php?success=1");
    echo "<script type='text/javascript'>window.location.href = 'cartype-manage.php?success=1';</script>";
    
    //header("location:inventory_list.php");
    //exit();
}
}
 ?>

 <link rel="stylesheet" href="uploadify/style_common.css" /><!--image show display inline block-->
<!-- script for uploadify is added to footer.php file -->
<!--content area start-->
<div id="content" class="pmd-content inner-page">
    <!--tab start-->
    <div class="container-fluid full-width-container blank">
        <!-- Title -->
        <h1 class="section-title" id="services">
            <span>Edit</span>
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
                        <form id="validationForm" action="cartype-edit.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
                            <div class="pmd-card pmd-z-depth">
                                <div class="pmd-card-body">
                                    <div class="group-fields clearfix row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                                <label for="regular1" class="control-label">
                                                    Name*
                                                </label>
                                                <input type="text" value="<?php echo $cartype;?>" id="regular1" class="form-control" name="cartype">
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