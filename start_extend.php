<?php
include_once("config.php");


$memberId = $_GET['memberId'];


//member exists or not
$isUserExistQuery = "select * from members where code = '".$memberId."' ";
$isUSerExist = pg_query($isUserExistQuery);
if(pg_num_rows($isUSerExist) == 0){
    echo "E001";
    return;
}

//extend validupto
date_default_timezone_set ("Asia/Calcutta");
$month = date("m");
$year = date("Y");
$date = date("d");
$time = date("h:i:s");
$validupto = ($year + 10)."-".$month."-".$date." ".$time;

$qry = "update members set validupto = '".$validupto."' where code = '".$memberId."'";
$execute = pg_query($qry);
if($execute){
	echo "OK001";
	return;
}

?>