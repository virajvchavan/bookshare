<?php
ob_start();
session_start();
session_unset();
session_destroy();
$original_page = $_SERVER['HTTP_REFERER'];
echo "$original_page";
if(stristr($original_page, "profile.php?id") == FALSE)
	header("Location: index.php");
else
	header("Location: $original_page");

?>