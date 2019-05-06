<?php
$no_visible_elements = true;
ob_start(); // redirect issue
error_reporting(1);
//include('admin/header.php'); 
include('dbconnect.php');
?>
<?php

//session_start(); // session started from connect.php
if(isset($_SESSION["email"])){
    header("location:index.php");
    exit();
}
?>

<?php
try {
    //global $countmach;
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];//print_r($email);
        $password = md5($_POST['password']);
        $sql = 'SELECT user_id FROM users where email="'.$email.'" and password ="'.$password.'" limit 1';//print_r($sql);exit;
        //print_r($sql);exit();
        $q = $conn->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $countmach =$q->rowCount();
        //echo $countmach;
        if($countmach ==1){//print_r("login successful");exit;
            while($row = $q->fetch()){//print_r($row);exit;
                $user_id = $row['user_id'];
            }
            $_SESSION['user_id']=$user_id;
            $_SESSION['email']=$email;
            //$_SESSION['name']=$name;
            $_SESSION['password']=$password;
            //print_r($name);
            header("location:admin/index.php");
            exit();
        } else {
            $countmach = 2;//print_r($countmach);exit(); // If incorrect login details are given?
            //echo 'that information is incorrect,try again <a href="login.php">click here</a>';
            //exit();
            //header("Location:login.php?credential-error=1");
            $Message = urlencode("Login credential error");
            $msg->add('e', 'The email or password you entered was incorrect. Please try again.');
            header("Location:login.php?Message=".$Message);
            exit();
        }
        // Define an insert query
        //header("Location:login.php");
    }
    $conn = null;        // Disconnect
}
catch(PDOException $e) {
    echo $e->getMessage();
}
?>


<!doctype html>
<html lang="">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Login | Propeller - Admin Dashboard">
<meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
<title>Login | Propeller - Admin Dashboard</title>
<link rel="shortcut icon" type="image/x-icon" href="admin/themes/images/favicon.ico">

<!-- Google icon -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Bootstrap css -->
<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.min.css">

<!-- Propeller css -->
<link rel="stylesheet" type="text/css" href="admin/assets/css/propeller.min.css">

<!-- Propeller theme css-->
<link rel="stylesheet" type="text/css" href="admin/themes/css/propeller-theme.css" />

<!-- Propeller admin theme css-->
<link rel="stylesheet" type="text/css" href="admin/themes/css/propeller-admin.css">

<!-- Message theme css-->
<link rel="stylesheet" type="text/css" href="css/message.css" media="all" />

</head>

<body class="body-custom">
<div class="logincard">
    <?php echo $msg->display();?>
    <div class="pmd-card card-default pmd-z-depth">
        <div class="login-card">
            
            <form action="login.php" method="post">  
                <div class="pmd-card-title card-header-border text-center">
                    <div class="loginlogo">
                        <a href="javascript:void(0);"><img src="admin/themes/images/logo-icon.png" alt="Logo"></a>
                    </div>
                    <h3>Sign In <span>with <strong>PROPELLER</strong></span></h3>
                </div>
                
                <div class="pmd-card-body">
                    <div class="alert alert-success" role="alert"> Oh snap! Change a few things up and try submitting again. </div>
                    <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label for="inputError1" class="control-label pmd-input-group-label">Username</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons md-dark pmd-sm">perm_identity</i></div>
                            <input type="text" class="form-control" id="exampleInputAmount" name="email">
                        </div>
                    </div>
                    
                    <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label for="inputError1" class="control-label pmd-input-group-label">Password</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons md-dark pmd-sm">lock_outline</i></div>
                            <input type="text" class="form-control" id="exampleInputAmount" name="password">
                        </div>
                    </div>
                </div>
                <div class="pmd-card-footer card-footer-no-border card-footer-p16 text-center">
                    <div class="form-group clearfix">
                        <div class="checkbox pull-left">
                            <label class="pmd-checkbox checkbox-pmd-ripple-effect">
                                <input type="checkbox" checked="" value="">
                                <span class="pmd-checkbox"> Remember me</span>
                            </label>
                        </div>
                        <span class="pull-right forgot-password">
                            <a href="javascript:void(0);">Forgot password?</a>
                        </span>
                    </div>
                    <button type="submit" type="button" class="btn pmd-ripple-effect btn-primary btn-block">Login</button>
                    
                    <p class="redirection-link">Don't have an account? <a href="javascript:void(0);" class="login-register">Sign Up</a>. </p>
                    
                </div>
                
            </form>
        </div>
        
        <div class="register-card">
            <div class="pmd-card-title card-header-border text-center">
                <div class="loginlogo">
                    <a href="javascript:void(0);"><img src="admin/themes/images/logo-icon.png" alt="Logo"></a>
                </div>
                <h3>Sign Up <span>with <strong>PROPELLER</strong></span></h3>
            </div>
            <form>  
              <div class="pmd-card-body">
              
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label for="inputError1" class="control-label pmd-input-group-label">Username</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons md-dark pmd-sm">perm_identity</i></div>
                            <input type="text" class="form-control" id="exampleInputAmount">
                        </div>
                    </div>
                    
                    <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label for="inputError1" class="control-label pmd-input-group-label">Email address</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons md-dark pmd-sm">email</i></div>
                            <input type="text" class="form-control" id="exampleInputAmount">
                        </div>
                    </div>
                    
                    <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label for="inputError1" class="control-label pmd-input-group-label">Password</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons md-dark pmd-sm">lock_outline</i></div>
                            <input type="text" class="form-control" id="exampleInputAmount">
                        </div>
                    </div>
              </div>
              
              <div class="pmd-card-footer card-footer-no-border card-footer-p16 text-center">
                <a href="index.html" type="button" class="btn pmd-ripple-effect btn-primary btn-block">Sign Up</a>
                <p class="redirection-link">Already have an account? <a href="javascript:void(0);" class="register-login">Sign In</a>. </p>
              </div>
            </form>
        </div>
        
        <div class="forgot-password-card">
            <form>  
              <div class="pmd-card-title card-header-border text-center">
                <div class="loginlogo">
                    <a href="javascript:void(0);"><img src="themes/images/logo-icon.png" alt="Logo"></a>
                </div>
                <h3>Forgot password?<br><span>Submit your email address and we'll send you a link to reset your password.</span></h3>
            </div>
              <div class="pmd-card-body">
                    <div class="form-group pmd-textfield pmd-textfield-floating-label">
                        <label for="inputError1" class="control-label pmd-input-group-label">Email address</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="material-icons md-dark pmd-sm">email</i></div>
                            <input type="text" class="form-control" id="exampleInputAmount">
                        </div>
                    </div>
                </div>
              <div class="pmd-card-footer card-footer-no-border card-footer-p16 text-center">
                <a type="button" class="btn pmd-ripple-effect btn-primary btn-block">Submit</a>
                <p class="redirection-link">Already registered? <a href="javascript:void(0);" class="register-login">Sign In</a></p>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts Starts -->
<script src="assets/js/jquery-1.12.2.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/propeller.min.js"></script>
<script>
    $(document).ready(function() {
        var sPath=window.location.pathname;
        var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
        $(".pmd-sidebar-nav").each(function(){
            $(this).find("a[href='"+sPage+"']").parents(".dropdown").addClass("open");
            $(this).find("a[href='"+sPage+"']").parents(".dropdown").find('.dropdown-menu').css("display", "block");
            $(this).find("a[href='"+sPage+"']").parents(".dropdown").find('a.dropdown-toggle').addClass("active");
            $(this).find("a[href='"+sPage+"']").addClass("active");
        });
    });
</script>
<!-- login page sections show hide -->
<script type="text/javascript">
    $(document).ready(function(){
     $('.app-list-icon li a').addClass("active");
        $(".login-for").click(function(){
            $('.login-card').hide()
            $('.forgot-password-card').show();
        });
        $(".signin").click(function(){
            $('.login-card').show()
            $('.forgot-password-card').hide();
        });
    });
</script>
<script type="text/javascript">
$(document).ready(function(){
        $(".login-register").click(function(){
            $('.login-card').hide()
            $('.forgot-password-card').hide();
            $('.register-card').show();
        });
        
        $(".register-login").click(function(){
            $('.register-card').hide()
            $('.forgot-password-card').hide();
            $('.login-card').show();
        });
        $(".forgot-password").click(function(){
            $('.login-card').hide()
            $('.register-card').hide()
            $('.forgot-password-card').show();
        }); 
});
</script> 

<!-- Scripts Ends -->

</body>
</html>