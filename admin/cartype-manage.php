<?php 
error_reporting(1);
include('../dbconnect.php');
include('header.php');
?>
<?php 
$email =$_SESSION["email"];//print_r($email);
 $query = "SELECT fname, lname, role from users where email="."'$email'";//print_r($query);

$result= $conn->query($query);//print_r($result);
//exit(mysql_error());
$result->setFetchMode(PDO::FETCH_ASSOC);
$countmach =$result->rowCount();
//echo $countmach;
if($countmach ==1) {//print_r("login successful");exit;
    $row = $result->fetch();//print_r($row);exit;
    $role = $row['role'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    //print_r($role);
}
?>

<?php
//pagination
if(isset($_GET["page"])){
    $page = $_GET["page"];

    if($page== "" || $page=="1"){
$page1=0;
}else{
    $page1=($page*10)-10;
}
}
?>
                 
<!--content area start-->
<div id="content" class="pmd-content inner-page">
    <!--tab start-->
    <div class="container-fluid full-width-container blank">
        <!-- Title -->
        <h1 class="section-title" id="services">
            <span>Car Type</span>
        </h1><!-- End Title -->
    
        <!--breadcrum start-->
        <ol class="breadcrumb text-left">
          <li><a href="index.html">Dashboard</a></li>
          <li class="active">Car Type</li>
        </ol><!--breadcrum end-->

        <?php 
        if(isset($_GET["page"])) {
        ?>
        <!-- Table -->
        <?php
    $data = '<div class="table-responsive pmd-card pmd-z-depth">
            <table class="table table-mc-red pmd-table">
                <thead>
                    <tr>
                        <th>Car type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
$query = "SELECT cartype_id, name FROM cartypes ORDER BY name ASC LIMIT $page1, 10";
$result= $conn->query($query);
    //exit(mysql_error());
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $numrows =$result->rowCount();
    //print_r($numrows);

    //for pagination count page
    $queryCountRows = "SELECT * from cartypes";
    $queryCountResult = $conn->query($queryCountRows); 
    $queryCountResult->setFetchMode(PDO::FETCH_ASSOC);
    $countnumrows =$queryCountResult->rowCount(); 

      // if query results contains rows then featch those rows 
    if($numrows > 0)
    {
        $number = 0;
        if(isset($_GET["page"])){
            $pageNo = $_GET["page"];
            $number = 1;
            for($i=2;$i<=$pageNo;$i++){
                $number+=10;
            }
        }
        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            
            $data .= '<tr class="eachrow">
                
                
                <td data-title="Car Type">'.$row['name'].'</td>
                
                <td class="pmd-table-row-action">
                            <a href="cartype-edit.php?id='.$row['cartype_id'].'" class="btn pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-default btn-sm">
                                <i class="material-icons md-dark pmd-sm">edit</i>
                            </a>
                            <a onclick="DeleteCartypeDetails('.$row['cartype_id'].')" class="btn pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-default btn-sm">
                                <i class="material-icons md-dark pmd-sm">delete</i>
                            </a>                    
                        </td>
            </tr>';
        
            $number++;
        }
    }
    else
    {
        // records now found 
        $data .= '<tr class="eachrow"><td colspan="6">Records not found!</td></tr>';
    }
    $data .= '</tbody></table></div>';
   // pagination
                    
        $totalpage =$countnumrows/10;
        $totalpage =ceil($totalpage);
        $currentpage    = (isset($_GET['page']) ? $_GET['page'] : 1);
        $firstpage      = 1;
        $lastpage       = $totalpage;
        $loopcounter = ( ( ( $currentpage + 2 ) <= $lastpage ) ? ( $currentpage + 2 ) : $lastpage );
        $startCounter =  ( ( ( $currentpage - 2 ) >= 3 ) ? ( $currentpage - 2 ) : 1 );

        if($totalpage > 1)
        {
            $data .= '<div class="pagination-container wow zoomIn mar-b-1x" data-wow-duration="0.5s">';
            $data .= '<ul class="pagination">';
            $data .= '<li class="pagination-item--wide first"> <a class="pagination-link--wide first" href="barcode-manage.php?page=1">First</a> </li>';
            for($i = $startCounter; $i <= $loopcounter; $i++)
            {
                if($i== $_GET["page"]){
                    $data .= '<li class="pagination-item is-active"> <a class="pagination-link" href="barcode-manage.php?page='.$i.'">'.$i." ".'</a> </li>';
                }else{
                    $data .= '<li class="pagination-item"> <a class="pagination-link" href="barcode-manage.php?page='.$i.'">'.$i." ".'</a> </li>';
                }
            }

            $data .= '<li class="pagination-item--wide last"> <a class="pagination-link--wide last" href="barcode-manage.php?page='.$totalpage.'">Last</a> </li>';
            $data  .= '</ul>';
            $data .= '</div>';
        }
        echo $data ;
        ?>
            <?php } else{?>
            
    <div class="table-responsive pmd-card pmd-z-depth">
        <div class="records_content"></div>
    </div>
    <?php } ?>
    </div><!-- tab end -->
    
</div><!-- content area end -->
<?php 
include('footer.php');
?>