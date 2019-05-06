
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
if(isset($_GET["id"])){
    $id = $_GET["id"];
    
    if (!empty($id)) {
       
        $stmt = $conn->prepare("SELECT cars.car_id, cars.cartype_id, cars.carname, cars.identityNo, cars.photo,cars.description, cars.costPerday, cartypes.cartype_id, cartypes.name FROM cars INNER JOIN cartypes ON cars.cartype_id=cartypes.cartype_id WHERE cars.car_id=".$id); print_r($stmt);
        $stmt->execute();
        $row = $stmt->fetch();
        $cartype_id = $row['cartype_id'];
        $carname = $row['carname'];
        $identityNo = $row['identityNo'];
        $photo = $row['photo']; print_r($photo);
        $description = $row['description'];
        $costPerday = $row['costPerday'];
    
        if(!empty($row['cartype_id'])) // referred to as 
        {
            $cartype_id = $row['cartype_id']; 
        }
        
        if(!empty($row['carname']))
        {
            $carname = $row['carname'];
        }
        if(!empty($row['identityNo']))
        {
            $identityNo = $row['identityNo'];
        }
        if(!empty($row['photo']))
        {
            $photo = $row['photo'];
        }
        if(!empty($row['description']))
        {
            $description = $row['description'];
        }
        if(!empty($row['costPerday']))
        {
            $costPerday = $row['costPerday'];
        }

    }

}
?>

 <?php 
if(count($_POST)>0 || count($_FILES)>0)  {
if(isset($_POST) || isset($_FILES)){
        $cartype = $_POST['cartype'];
        $identity_no = $_POST['identity_no'];
        $name = $_POST['name'];
        $rental_cost = $_POST['rental_cost'];
        $description = str_replace("'", "\'", $_POST['description']); 
        $image= $_FILES['fileField']['name'];//print_r("Image name ".$image);exit;
        $newname= $_FILES['fileField']['name'];
        
    //$curr_timestamp = date('Y-m-d H:i:s'); //print_r($curr_timestamp);exit();
   // $my_date = strtotime($curr_timestamp);
    
    if(!empty($_POST) && !empty($_FILES)) {
        unlink("../uploads/".$photo); // if new image uploaded delete the previous one
        $UpdateQueryUser = "Update cars set cartype_id='$cartype', carname='$name', identityNo='$identity_no', photo='$image', description='$description', costPerday='$rental_cost' WHERE car_id=" . $id;//print_r($UpdateQueryUser);exit;
    }   
    
    if(!empty($_POST))    
    $UpdateQueryUser = "Update cars set cartype_id='$cartype', carname='$name', identityNo='$identity_no', description='$description', costPerday='$rental_cost' WHERE car_id=" . $id;//print_r($UpdateQueryUser);exit;
    $result = $conn->query($UpdateQueryUser);
     
     if(!empty($_FILES))  {
        if (($_FILES["fileField"]["type"] == "image/gif")
        || ($_FILES["fileField"]["type"] == "image/jpeg")
        || ($_FILES["fileField"]["type"] == "image/png" ))
        {
            $UpdateQueryUser = "Update cars set photo='$image' WHERE car_id=" . $id;//print_r($UpdateQueryUser);exit();
            $result = $conn->query($UpdateQueryUser);

            echo 'Updated Successful.';
            unlink("../uploads/".$photo); // if new image uploaded delete the previous one

            $target = $_SERVER['DOCUMENT_ROOT'] . '/carrental/uploads/';//print_r($target);exit;
            move_uploaded_file($_FILES['fileField']['tmp_name'], $target.$newname);//exit();
            //unset($_POST);
        }
        else
        {
            echo "Sorry, Files must be either JPEG, GIF, or PNG and less than 10,000 kb";
        }
    }

    if (!empty($result)) {
        echo 'Updated Successful.';
                    //unset($_POST);
    } else {
            echo 'Problem in updating.!';
    }  
        
       // header("Location:guesthouse-manage.php?success=1");
    echo "<script type='text/javascript'>window.location.href = 'car-manage.php?success=1';</script>";
    
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
                                <select class="select-simple form-control pmd-select2" name="cartype" required>
                                    <?php foreach ($dataCartype as $row): ?>
                                        <option value="<?=$row["cartype_id"]?>"<?=$cartype_id == $row["cartype_id"] ? ' selected="selected"' : '';?>><?=$row["name"]?></option>
                                    <?php endforeach ?>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                              <label class="control-label">Identity No</label>
                              <input value="<?php echo $identityNo;?>" type="text" id="regular1" class="form-control" name="identity_no">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                              <label class="control-label">Name</label>
                              <input value="<?php echo $carname;?>" type="text" id="regular1" class="form-control" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                              <label class="control-label">Rental Cost Per Day</label>
                              <input value="<?php echo $costPerday;?>" required type="number" id="regular1" class="form-control" name="rental_cost">
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                              <label class="control-label">Description</label>
                              <textarea class="form-control" name="description" rows="2" cols="10"><?php echo $description; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="group-fields clearfix row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">       
                                <!-- <label>Photo</label> -->
                                <span class="imagearea" style="width:100px;height:100px;background:yellow;margin:0px auto;">
            <?php 
                $strPath ='http://localhost/carrental/uploads/';?>
                <img src="<?php  echo $strPath.= $photo; ?>" 

            </span>
           <input type="file" name="fileField" id="fileField" />
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