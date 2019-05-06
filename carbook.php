   <?php
$no_visible_elements = true;
ob_start(); // redirect issue
error_reporting(1);
//include('admin/header.php'); 
include('dbconnect.php');
?>



<?php
$query = "SELECT cars.car_id, cars.cartype_id, cars.carname, cars.identityNo, cars.photo, cars.costPerday,cars.description, cartypes.cartype_id, cartypes.name, carfeatures.carfeatures_id, carfeatures.car_id, carfeatures.capacity,carfeatures.aircondition, carfeatures.is_automatic_transmission,carfeatures.is_manual_transmission, carfeatures.kmpl, carfeatures.is_fuel_petrol, carfeatures.is_fuel_diesel  FROM cars INNER JOIN cartypes ON cars.cartype_id=cartypes.cartype_id INNER JOIN carfeatures ON cars.car_id= carfeatures.car_id  ORDER BY carname ASC";//print_r($query);exit();
$result= $conn->query($query); //var_dump($result);
    //exit(mysql_error());
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $numrows =$result->rowCount();
    //print_r($numrows);

    //for pagination count page
    $queryCountRows = "SELECT * from cars";
    $queryCountResult = $conn->query($queryCountRows); 
    $queryCountResult->setFetchMode(PDO::FETCH_ASSOC);
    $countnumrows =$queryCountResult->rowCount(); 

?>
<?php 
// dropdown select populating
$smt = $conn->prepare('select cartype_id,name From cartypes');
$smt->execute();
$dataCartype = $smt->fetchAll();
?>
<?php 
if(isset($_GET["carid"])){
    $carid = $_GET["carid"];
    
    if (!empty($carid)) {
       // $query = "SELECT id, barcode, subject, formula, category,  warningMark FROM barcodeDetails WHERE id=".$id;
        $stmt = $conn->prepare("SELECT cars.car_id, cars.cartype_id, cars.carname, cartypes.cartype_id, cartypes.name FROM cars INNER JOIN cartypes ON cars.cartype_id = cartypes.cartype_id WHERE cars.car_id=".$carid); //print_r($stmt);
        $stmt->execute();
        $row = $stmt->fetch();
        $cartype_id = $row['cartype_id'];
        $car_id = $row['car_id'];
        if(!empty($row['cartype_id'])) // referred to as 
        {
            $cartype_id = $row['cartype_id'];
        }if(!empty($row['car_id'])) // referred to as 
        {
            $car_id = $row['car_id'];
        }
    }
}
?>
 
<?php 
//if(isset($_FILES['fileField']['name']) && isset($_POST['caption'])){//print_r($_FILES);
if(isset($_POST['email'])){
    $email = $_POST['email'];
    $cartype = $_POST['cartype'];
    $car_id = $_POST['car'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
   // $no_of_guest = 
    $checkindate = $_POST['checkin'];
    $checkoutdate = $_POST['checkout'];
   // $curr_timestamp = date('Y-m-d H:i:s'); //print_r($curr_timestamp);exit();
   // $my_date = strtotime($curr_timestamp);
    //mysql_set_charset('utf8');

    // check whether room is booked or not


    $queryIsBook = "SELECT car_id,book_start_date, book_end_date
        FROM bookedcar
        WHERE book_start_date <= '$checkoutdate' AND book_end_date >= '$checkindate' AND car_id='$car_id'";//print_r($queryIsBook);exit();
        $resultIsBooked = $conn->query($queryIsBook);

        //exit(mysql_error());
        $resultIsBooked->setFetchMode(PDO::FETCH_ASSOC);
        $row = $resultIsBooked->fetch(PDO::FETCH_ASSOC);
        
        $numrows =$resultIsBooked->rowCount();
        if ($numrows > 0) { //print_r("Car is already booked.");exit();
       // header('locaton:wrong.php');
        echo "<script type='text/javascript'>window.location.href = 'index.php?book-failed=1';</script>";
        } else {
             $sql = "INSERT INTO `bookedcar` (`car_id`, `name`, `email`, `phone`, `book_start_date`, `book_end_date`)VALUES('$car_id', '$name', '$email', '$phone','$checkindate','$checkoutdate')";//print_r($sql);exit;
            $count = $conn->exec($sql);//print_r($count);exit;
            $lastInsertId = $conn->lastInsertId();
           // mysql_set_charset('utf8');
           // $conn->query("SET NAMES 'utf8'");
           // echo 'Added Successful.';

    // sending mail

    $from = 'From: abna mattar';
    $subject = 'Renting Car';
   // $body = $_POST['message'];
   // $body = wordwrap($body, 70);           // makes the body no longer than 70 characters long
    $body='<html>
    <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
    <body>
    <table width="90%" border="1">
    <thead>
        <tr>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">Rental Car Details</th>
    </tr>
    </thead>
        <tbody>
        <tr>
        <td>';
     $body.=   $name;
        $body.='</td><td>'.$email.'</td><td>'.$phone.'</td><td>';
        
$query = "SELECT bookedcar.bookedcar_id, bookedcar.book_start_date, bookedcar.book_end_date, cars.carname, cars.identityNo, cars.costPerday, cartypes.name FROM bookedcar INNER JOIN cars ON bookedcar.car_id=cars.car_id INNER JOIN cartypes ON cars.cartype_id=cartypes.cartype_id   WHERE bookedcar_id=".$lastInsertId;
$result= $conn->query($query);
    //exit(mysql_error());
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $numrows =$result->rowCount();
    //print_r($numrows);

      // if query results contains rows then featch those rows 
    
        while($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            
            $body .= 'Car: '.$row['carname'].'<br />Car Type: '.$row['name'].'<br />Car Registration No: '.$row['identityNo'].'<br />Cost Per Day: '.$row['costPerday'].'<br />Book Start Date: '.$row['book_start_date'].'<br />Book End Date: '.$row['book_end_date'];
            $body .= '</td></tr></tbody></table></body></html>';    
        }
         
    // set headers (From, Encoding utf-8 and Reply-to)
    $headers = $from."\r\n";
    $headers .= 'Content-Type: text/html; charset=utf-8';
    $headers .= "Reply-To: ". $_POST['email'];

     
    $headers .= "CC: md.tarikulislam786@yahoo.com\r\n";
    $headers .= "BCC: md.tarikulislam786@yahoo.com\r\n";

    $to = $email; 
    // send the email
    if (mail($to, $subject, $body, $headers)) echo 'Thank you for using our mail form';
    else echo 'Error, the message can not be sent';
    // end send email
       // header("Location:guesthouse-manage.php?success=1");
    echo "<script type='text/javascript'>window.location.href = 'index.php?book-success=1';</script>";
           
    }
}
    // results not found 
 ?>

    <!DOCTYPE html>
    <html lang="zxx" class="no-js">
    <head>
        <!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon-->
        <link rel="shortcut icon" href="img/fav.png">
        <!-- Author Meta -->
        <meta name="author" content="codepixer">
        <!-- Meta Description -->
        <meta name="description" content="">
        <!-- Meta Keyword -->
        <meta name="keywords" content="">
        <!-- meta character set -->
        <meta charset="UTF-8">
        <!-- Site Title -->
        <title>Car Rentals</title>

        <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
            <!--
            CSS
            ============================================= -->
            <link rel="stylesheet" type="text/css" href="css/message.css" media="all" />
            <link rel="stylesheet" href="css/linearicons.css">
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <link rel="stylesheet" href="css/bootstrap.css">
            <link rel="stylesheet" href="css/magnific-popup.css">
            <link rel="stylesheet" href="css/nice-select.css">                  
            <link rel="stylesheet" href="css/animate.min.css">
            <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">          
            <link rel="stylesheet" href="css/owl.carousel.css">
            <link rel="stylesheet" href="css/main.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        </head>
        <body>

              <header id="header" id="home">
                <div class="container">
                    <div class="row align-items-center justify-content-between d-flex">
                      <div id="logo">
                        <a href="index.html"><img src="img/logo.png" alt="" title="" /></a>
                      </div>
                      <nav id="nav-menu-container">
                        <ul class="nav-menu">
                          <li class="menu-active"><a href="index.php">Home</a></li>
                          <li><a href="about.html">About</a></li>
                          <li><a href="cars.php">Cars</a></li>
                          <li><a href="service.html">Service</a></li>
                          <li><a href="team.html">Team</a></li> 
                          <li><a href="blog-home.html">Blog</a></li>    
                          <li><a href="contact.html">Contact</a></li>   
                          <li class="menu-has-children"><a href="">Pages</a>
                            <ul>
                              <li><a href="blog-single.html">Blog Single</a></li>
                              <li><a href="elements.html">Elements</a></li>
                            </ul>
                          </li>                   
                        </ul>
                      </nav><!-- #nav-menu-container -->                    
                    </div>
                </div>
              </header><!-- #header -->


            <!-- start banner Area -->
            <section class="banner-area relative" id="home">
                <div class="overlay overlay-bg"></div>  
                <div class="container">
                    
                    <div class="row fullscreen d-flex align-items-center justify-content-center">
                        <div class="banner-content col-lg-7 col-md-6 ">
                            <h6 class="text-white ">the Royal Essence of Journey</h6>
                            <h1 class="text-white text-uppercase">
                                Relaxed Journey Ever                
                            </h1>
                            <p class="pt-20 pb-20 text-white">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <a href="#" class="primary-btn text-uppercase">Rent Car Now</a>
                        </div>
                        <div class="col-lg-5  col-md-6 header-right" style="top:70px;">
                            <?php echo $msg->display();?>
                            <h4 class="text-white pb-30">Book Your Car Today!</h4>
                            <form class="form" method="post" action="">
                                <div class="form-group">
                                    <div class="defaul" id="defaul">
                                        <select name="cartype" id="cartypeddl" class="form-control">
                                            <option value="" disabled selected hidden>Select Car Type</option>
                                            $<?php foreach ($dataCartype as $row): ?>
                                            <option <?=$cartype_id == $row["cartype_id"] ? ' selected="selected"' : '';?> value="<?=$row["cartype_id"]?>"><?=$row["name"]?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="doappend" id="">
                                        <select name="car" required id="carddl" class="form-control">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- <div class='input-group date' id='datetimepicker6'>
                                        <input type='text' class="form-control" placeholder="Start Date" />
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div> -->
                                    <div class="input-wrap">
                                      <input type="text" id="dp1" required name="checkin" placeholder="Start Date" class="form-control" data-language='en'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-wrap">
                                      <input type="text" id="dp2" required name="checkout" placeholder="End Date" class="form-control" data-language='en'>
                                    </div>
                                </div>
                                
                                <div class="from-group">
                                    <input class="form-control txt-field" required type="text" name="name" placeholder="Your name">
                                    <input class="form-control txt-field" required type="email" name="email" placeholder="Email address">
                                    <input class="form-control txt-field" required type="tel" name="phone" placeholder="Phone number">
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <!-- <button type="reset" class="btn btn-default btn-lg btn-block text-center text-uppercase">Confirm Car Booking</button> -->
                                        <input type="submit" class="btn btn-default btn-lg btn-block text-center text-uppercase" value="Confirm Car Booking" />
                                    </div>
                                </div>
                            </form>
                        </div>                                          
                    </div>
                </div>                  
            </section>
            <!-- End banner Area -->        

               

            <!-- Start model Area -->
            <section class="model-area section-gap" id="cars">
                <div class="container">
                    <div class="row d-flex justify-content-center pb-40">
                        <div class="col-md-8 pb-40 header-text">
                            <h1 class="text-center pb-10">Choose your Desired Car Model</h1>
                            <p class="text-center">
                                Who are in extremely love with eco friendly system.
                            </p>
                        </div>
                    </div>              
                    
                    <div class="active-model-carusel">
                        <?php 
                        // if query results contains rows then featch those rows 
                        if($numrows > 0)
                        {
                            $number = 0;
                            while($row = $result->fetch(PDO::FETCH_ASSOC))
                            {
                        ?>        
                        <div class="row align-items-center single-model item">
                            <div class="col-lg-6 model-left">
                                <div class="title justify-content-between d-flex">
                                    <h4 class="mt-20"><?php echo $row["carname"];?></h4>
                                    <h2>OMR <?php echo $row["costPerday"];?><span>/day</span></h2>
                                </div>
                                <p>
                                    <?php echo $row["description"];?>
                                </p>
                                <p>
                                    Car Type         : <?php echo $row["name"];?> <br>
                                    Kilometer/Hour   : <?php echo $row["kmpl"];?> <br>
                                    Registration No  : <?php echo $row["identityNo"];?> <br>
                                    Fuel             : <?php if(!empty($row["is_fuel_petrol"]))echo "Petrol";if(!empty($row["is_fuel_petrol"]) && !empty($row["is_fuel_diesel"])) echo " ,";if(!empty($row["is_fuel_diesel"]))echo " Diesel";?><br>
                                    Capacity         : <?php echo $row["capacity"];?> Person <br>
                                    Air Condition    : <?php echo $row["aircondition"];?> <br>
                                    Transmission     : <?php if(!empty($row["is_automatic_transmission"]))echo "Automatic";if(!empty($row["is_automatic_transmission"]) && !empty($row["is_manual_transmission"])) echo " ,";if(!empty($row["is_manual_transmission"]))echo " Manual"." ";?>
                                
                                </p>
                                <a class="text-uppercase primary-btn" href="carbook.php?carid=<?php echo $row['car_id'];?>">Book This Car Now</a>
                            </div>
                            <div class="col-lg-6 model-right">
                                <img class="img-fluid" src="uploads/<?php echo $row["photo"];?>" alt="">
                            </div>
                        </div>
                            <?php
                                $number++;
                            }
                        }
                        else
                        {
                            // records now found 
                            $data .= '<tr class="eachrow"><td colspan="6">Records not found!</td></tr>';
                        }
                        ?>
                                                                      
                    </div>
                </div>  
            </section>
            <!-- End model Area -->


            <!-- start footer Area -->      
            <footer class="footer-area section-gap">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6">
                            <div class="single-footer-widget">
                                <h6>Quick links</h6>
                                <ul>
                                    <li><a href="#">Jobs</a></li>
                                    <li><a href="#">Brand Assets</a></li>
                                    <li><a href="#">Investor Relations</a></li>
                                    <li><a href="#">Terms of Service</a></li>
                                </ul>                               
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6">
                            <div class="single-footer-widget">
                                <h6>Features</h6>
                                <ul>
                                    <li><a href="#">Jobs</a></li>
                                    <li><a href="#">Brand Assets</a></li>
                                    <li><a href="#">Investor Relations</a></li>
                                    <li><a href="#">Terms of Service</a></li>
                                </ul>                               
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6">
                            <div class="single-footer-widget">
                                <h6>Resources</h6>
                                <ul>
                                    <li><a href="#">Jobs</a></li>
                                    <li><a href="#">Brand Assets</a></li>
                                    <li><a href="#">Investor Relations</a></li>
                                    <li><a href="#">Terms of Service</a></li>
                                </ul>                               
                            </div>
                        </div>                                              
                        <div class="col-lg-2 col-md-6 col-sm-6 social-widget">
                            <div class="single-footer-widget">
                                <h6>Follow Us</h6>
                                <p>Let us be social</p>
                                <div class="footer-social d-flex align-items-center">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-dribbble"></i></a>
                                    <a href="#"><i class="fa fa-behance"></i></a>
                                </div>
                            </div>
                        </div>                          
                        <div class="col-lg-4  col-md-6 col-sm-6">
                            <div class="single-footer-widget">
                                <h6>Newsletter</h6>
                                <p>Stay update with our latest</p>
                                <div class="" id="mc_embed_signup">
                                    <form novalidate="true" action="" method="post" class="form-inline">
                                        <input class="form-control" name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '" required="" type="email">
                                            <button class="click-btn btn btn-default"><span class="lnr lnr-arrow-right"></span></button>
                                            <div style="position: absolute; left: -5000px;">
                                                <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                                            </div>

                                        <div class="info"></div>
                                    </form>
                                </div>
                            </div>
                        </div>  
                        <p class="mt-50 mx-auto footer-text col-lg-12">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>                                            
                    </div>
                </div>
            </footer>   
            <!-- End footer Area -->        

            <script src="js/vendor/jquery-2.2.4.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="js/vendor/bootstrap.min.js"></script>          
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>          
            <script src="js/easing.min.js"></script>            
            <script src="js/hoverIntent.js"></script>
            <script src="js/superfish.min.js"></script> 
            <script src="js/jquery.ajaxchimp.min.js"></script>
            <script src="js/jquery.magnific-popup.min.js"></script> 
            <script src="js/owl.carousel.min.js"></script>          
            <script src="js/jquery.sticky.js"></script>
            <script src="js/jquery.nice-select.min.js"></script>    
            <script src="js/waypoints.min.js"></script>
            <script src="js/jquery.counterup.min.js"></script>                  
            <script src="js/parallax.min.js"></script>      
            <script src="js/mail-script.js"></script>   
            <script src="js/main.js"></script>  
        
<script type="text/javascript">

            function Cars(cartypeid){ //alert("called");

                $("#carddl").empty();

               // $("#carddl").append("<option>Loading.....</option>");
                $.ajax({
                    type: "POST",
                    url: "cardropdown.php?cartypeid="+cartypeid,
                    contentType: "application/json; charset= UTF-8",
                    dataType: "json",
                    success: function(data){
                        $(".default-select.doappend").empty();
                        $("#carddl").append("<option value='0'>--- Select Car ---</option>");
                        $.each(data, function(i, item){
                            var car_id = "<?php echo $car_id; ?>";
                            if(car_id== data[i].car_id){
                                var selected="selected";
                            }else{
                                var selected="";
                            } 
                           // $("#carddl").append("<option "((car_id = data[i].car_id) ? +"selected" : +""); value='"+data[i].car_id+"'>"+data[i].carname+"</option>");
                        $("#carddl").append("<option "+selected+" value='"+data[i].car_id+"'>"+data[i].carname+"</option>");
                        });
                    },
                    complete: function(){

                    }

                });
            }
                $( document ).ready(function() {
                    //Cars();
                    $("#cartypeddl").change(function(){ 
                        var ctypeid = $("#cartypeddl").val();//alert(cartypeid);
                        Cars(ctypeid);
                    });
                    // load cars in dropdown after getting php variable ctypeid
                    var ctypeid = "<?php echo $cartype_id; ?>";
                        Cars(ctypeid);

                });

            </script>
            <script>
                     
  // $(function() {
  //   $('#datetimepicker6').datetimepicker();
  //   $('#datetimepicker7').datetimepicker({
  //     useCurrent: false //Important! See issue #1075
  //   });
  //   $("#datetimepicker6").on("dp.change", function(e) {
  //     $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
  //   });
  //   $("#datetimepicker7").on("dp.change", function(e) {
  //     $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
  //   });
  // });
   $(function() {
      
    $input = $('#dp1,#dp2'),
    dp = $input.datepicker( { dateFormat: 'yy-mm-dd'}).data('datepicker');
   $("#dp1").on("dp.change", function (e) {
            $('#dp2').data("datepicker").minDate(e.date);
        });
        $("#dp2").on("dp.change", function (e) {
            $('#dp1').data("datepicker").maxDate(e.date);
        });
});

</script>
        </body>
    </html>



