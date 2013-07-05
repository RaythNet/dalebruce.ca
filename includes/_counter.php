<?php
header("Content-type: image/png");
$db = mysqli_connect("localhost", "dalebruce", "rrW9c6BKyS8xTwdL");
mysqli_select_db($db, "dalebruce") or die("Unable to select database.");
$Query = "SELECT * FROM user_tracking";
$TotalHits = mysqli_num_rows(mysqli_query($db,$Query));
$str = strval($TotalHits);
$str = str_pad($str, 8, "0", STR_PAD_LEFT);

$img_handle = ImageCreate (71, 13) or die ("Cannot Create image");
//Image size (x,y)
$back_color = ImageColorAllocate($img_handle, 0, 0, 0);
imagecolortransparent($img_handle, $back_color);
//Background color RBG
$txt_color = ImageColorAllocate($img_handle, 255,215,0);
//Text Color RBG
ImageString($img_handle, 31, 0, 0, $str, $txt_color);
Imagepng($img_handle);
?> 