<?php
include_once("config.php");

$memberId = $_GET['memberId'];
$bookId = $_GET['bookId'];



$flag = $bookId;
//book exists or not
$checkBookDetails = "select * from opac where a900='".$bookId."'";
$bookDetailsResults = pg_query($checkBookDetails);
if(pg_num_rows($bookDetailsResults)==0){
	if($flag == 'THQ704' || $flag = 'hq846' || $flag = 'THQ390'  || $flag = 'THQ2529' || $flag = 'THQ1651' ||
		$flag == 'THQ2060' || $flag = 'thq496' || $flag = 'THQ1885' || $flag = 'hq859' || $flag = 'HQ768' || 
		$flag == 'hq725' || $flag = 'HQ 616' || $flag = 'THQ2033'  || $flag = 'HQ485' || $flag = 'THQ1101' ||
		$flag == 'THQ1189' || $flag = 'THQ1983' || $flag = 'HQ820' || $flag = 'THQ2126' || $flag = 'THQ1835' ||
		$flag == 'THQ2169' || $flag = 'THQ1054' || $flag = 'THQ2124' || $flag = 'THQ2125' || $flag = 'THQ807'  
	 ){
	}
	else{
    echo "NB001";
    return;
	}
}

//member exists or not
$isUserExistQuery = "select * from members where code ='".$memberId."'";
$isUSerExist = pg_query($isUserExistQuery);
if(pg_num_rows($isUSerExist) == 0){
    echo "ERROR001";
    return;
}

//book issued to the same member or not
$a001qry = "select a001 from transactions where code = '".$memberId."' and a900 = '".$bookId."'  ";
$execute = pg_query($a001qry);
if(pg_num_rows($execute) == 0){
	echo "E001";
	return;
}

$categoryQuery = "select category from members where code = '".$memberId."'  ";
$category = pg_query($categoryQuery);
$category_value = pg_fetch_row($category);
$c_val = (int)$category_value[0];

$a001_value = pg_fetch_row($execute);

 $documentTypeQuery = "select a060 from opac where a001 = '".$a001_value[0]."'   ";
 $documentType = pg_query($documentTypeQuery);
 $documentType_value = pg_fetch_row($documentType);

 $fineQuery = "select fineperday from doctype where membercategory = '".$c_val."'  and documenttype = '".$documentType_value[0]."' ";
 $fine = pg_query($fineQuery);
 if(pg_num_rows($fine)){
 	$fine_value = 1;
 }
 else{
 	$fine_value_arr = pg_fetch_row($fine);
 	$fine_value = $fine_value_arr[0];
}

 date_default_timezone_set ("Asia/Calcutta");
 $curr_date = date("Y-m-d");

 $retdatequery = "select rtndate from transactions where a900 = '".$bookId."' ";
 $retdate = pg_query($retdatequery);
 $retdate_value = pg_fetch_row($retdate);

$qry = "select '".$curr_date."'::date -  '".$retdate_value[0]."'::date ";
$execute = pg_query($qry);
$answer = pg_fetch_row($execute);

$deletefromTransactionQuery = "delete from transactions where a900 = '".$bookId."' ";
$deletefromTransaction = pg_query($deletefromTransactionQuery);


if($answer[0] > 0){
	//fine
	$fine_in_rupees = $answer[0] * $fine_value;
	echo "F001_".$fine_in_rupees."";
	return;
}
else{
	//no fine
	echo "OK001";
	return;
}



?>