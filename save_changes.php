<?php
include_once("config.php");
$memberId = $_POST['memberId'];
$name = $_POST['name'];
$desig = $_POST['desig'];
$enrollDate = $_POST['enrollDate'];
$validupto = $_POST['validupto'];
$address = $_POST['address'];
$lab = $_POST['lab'];



$qry = "select code from category where description = '".$desig."' ";
$execute = pg_query($qry);
$result = pg_fetch_row($execute);
$category = (int)$result[0];

$qry = "update members set name = '".$name."'  where code = '".$memberId."' ";
$execute1 = pg_query($qry);

$qry = "update members set designation = '".$desig."'  where code = '".$memberId."' ";
$execute2 = pg_query($qry);

$qry = "update members set category = '".$category."'  where code = '".$memberId."' ";
$execute3 = pg_query($qry);

$qry = "update members set localaddress = '".$address."'  where code = '".$memberId."' ";
$execute4 = pg_query($qry);

$qry = "update members set lab = '".$lab."'  where code = '".$memberId."' ";
$execute5 = pg_query($qry);

if($execute1 && $execute2 && $execute3 && $execute4 && $execute5){
	echo "OK001";
	return;
}

?>