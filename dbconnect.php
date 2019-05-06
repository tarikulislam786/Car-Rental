<?php
// The class.messages.php has been added only for account/besittercomplete.php file to show message after updating & redirecting to the page.
// PHP Successful update message is not working after redirecting so message been displayed from connect.php
//------------------------------------------------------------------------------
// A session is required for the messages to work
//------------------------------------------------------------------------------
if( !session_id() ) session_start();
//------------------------------------------------------------------------------
// Include the Messages class and instantiate it
//------------------------------------------------------------------------------
require_once('admin/class.messages.php');
$msg = new Messages();

?>
<?php 
$hostdb = 'localhost';
$namedb = 'carrental';
$userdb = 'root';
$passdb = '';
//$row_limit = 5;
// Connect and create the PDO object
$conn = new PDO("mysql:host=$hostdb; dbname=$namedb", $userdb, $passdb);

$conn->exec("set names utf8");// Sets encoding UTF-8
// added for Specifying the specific error
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set Errorhandling to Exception 
//$item_per_page 		= 3; //item to display per page

// PHP Successful update mesage triggered for account/besitterComplete.php file
if ( isset($_GET['success']) == 1 )
{
    $msg->add('s', 'Data Saved Successfully.');
}elseif ( isset($_GET['success-update']) == 1 )
{
    $msg->add('s', 'Data Updated Successfully.');
}elseif( isset($_GET['credential-error']) == 1 )
{
    $msg->add('e', 'username or password is incorrect.');
}elseif( isset($_GET['unauthorized-access']) == 1 )
{
    $msg->add('e', 'Unauthorized Access.');
}elseif( isset($_GET['book-success']) == 1 )
{
    $msg->add('s', 'Rent A Car Successful');
}elseif( isset($_GET['book-failed']) == 1 )
{
    $msg->add('e', 'Car Has Already Been Booked');
}
// for pagination

?>


