<?php
$name = $_REQUEST['name'];
$img_details = getimagesize('uploads/'.$name);
if($img_details[0] > 1700){
	echo json_encode("b");
}
