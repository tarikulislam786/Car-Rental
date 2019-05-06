<!doctype html>
<html lang="">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="404 Page not found - Propeller Admin Dashboard">
<meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
<title>404 Page Not Found | Propeller - Admin Dashboard</title>
<link rel="shortcut icon" type="image/x-icon" href="themes/images/favicon.ico">

<!-- Google icon -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Bootstrap css -->
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

<!-- Propeller css -->
<link rel="stylesheet" type="text/css" href="assets/css/propeller.min.css">

<!-- Propeller theme css-->
<link rel="stylesheet" type="text/css" href="themes/css/propeller-theme.css" />

<!-- Propeller admin theme css-->
<link rel="stylesheet" type="text/css" href="themes/css/propeller-admin.css">

</head>

<body class="body-custom body-404page">
    <div class="errorpage">
        <div class="wrapper">
            <div class="container">
                <header class="header-primary">
                    <a href="index.html" rel="home"><img src="themes/images/logo-icon.png" alt="logo" class="logo"></a>
                </header><!-- header-primary -->
            
                <div class="content-primary">
                    <h1 class="title">Page Not Found</h1>
                    <p class="description">The page you are looking for was moved, removed, <br>
                    renamed or might never existed.</p>
                    <div class="section-footer">
                        <a href="index.html" class="btn btn-primary">Back To Homepage</a>
                        <a href="mailto:name@mail.com" class="btn btn-secondary">Report Error</a>
                    </div>
                </div><!-- content-primary -->
            </div><!-- container -->
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

<!-- Scripts Ends -->

</body>
</html>