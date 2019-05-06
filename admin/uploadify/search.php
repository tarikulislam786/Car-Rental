<?php
/**
 * Created by PhpStorm.
 * User: AR
 * Date: 3/31/14
 * Time: 6:42 PM
 */

$dir = "uploads/";
if ($opendir = opendir($dir))
{
    $images=array();
    while (($file = readdir($opendir)) !==FALSE)
    {
        if($file != "." && $file != ".." && $file !="thumbs")
        {
            $images[]=($file);
        }
    }
}
sort($images);



$lenght = sizeof($images);
$search_field_value = strtolower(trim($_REQUEST['search_field_value']));
for($i=0;$i<$lenght;$i++){

	if($search_field_value=="" || strpos(strtolower($images[$i]),$search_field_value) !== false){
		$pass[] = $images[$i];
		//echo $images[$i];
	}
    
}

echo json_encode($pass);