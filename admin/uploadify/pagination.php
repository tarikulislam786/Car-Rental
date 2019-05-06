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
            $images[]=$file;
        }
    }
}
sort($images);
$id = $_REQUEST['id'];
$mod = $_REQUEST['mod'];
$lastPage = $_REQUEST['lastPage'];
$lastPageStart = ($lastPage*33)-33;
if($id == $lastPageStart && $mod != 0){
    $inc = $mod;
}else{
    $inc = 33;
}
for($i=$id;$i<$id+$inc;$i++){
    $pass[] = $images[$i];
}
echo json_encode($pass);