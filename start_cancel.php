<?php
include_once("config.php");
date_default_timezone_set ("Asia/Calcutta");
$memberId = $_GET['memberId'];

//member exists or not
$isUserExistQuery = "select * from members where code ='".$memberId."'";
$isUSerExist = pg_query($isUserExistQuery);
if(pg_num_rows($isUSerExist) == 0){
    echo "E001";
    return;
}


// calculate total fine
$categoryQuery = "select category from members where code = '".$memberId."'  ";
$category = pg_query($categoryQuery);
$category_value = pg_fetch_row($category);
$c_val = (int)$category_value[0];

$allBooksOwnedQuery = "select code, a900, a001, rtndate from transactions where code = '".$memberId."' ";
$allBooksOwned = pg_query($allBooksOwnedQuery);

$totalFine = 0;
$totalBooks = 0;

while ($allBooksOwned_row = pg_fetch_row($allBooksOwned)) {
	 $documentTypeQuery = "select a060 from opac where a001 = '".$allBooksOwned_row[2]."'   ";
	 $documentType = pg_query($documentTypeQuery);
	 $documentType_value = pg_fetch_row($documentType);

	 $fineQuery = "select fineperday from doctype where membercategory = '".$c_val."'  and documenttype = '".$documentType_value[0]."' ";
	 $fine = pg_query($fineQuery);
	 $fine_value = pg_fetch_row($fine);

	 $curr_date = date("Y-m-d");
	 $returndate = $allBooksOwned_row[3];

	 $qry = "select '".$curr_date."'::date -  '".$returndate."'::date ";
	 $execute = pg_query($qry);
	 $answer = pg_fetch_row($execute);

	 if($answer[0] > 0){
		//fine
		$fine_in_rupees = $answer[0] * $fine_value[0];
		$totalFine = $totalFine + $fine_in_rupees;
	}
	 $totalBooks = $totalBooks + 1;
}

	$updateQuery = "update members set cancelled = 1 where code = '".$memberId."' ";
	$update = pg_query($updateQuery);
    $timestamp = date("Y-m-d h:i:s");
    $updateQuery = "update members set cancelleddate = '".$timestamp."' where code = '".$memberId."' ";
    $update = pg_query($updateQuery); 

echo "F001_".$totalFine."_".$totalBooks."";
return;


?>

