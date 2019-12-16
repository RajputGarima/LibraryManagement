<?php
// echo "<pre>";
// print_r($_GET);
include_once("config.php");

$bookId = $_GET['bookId'];
$userId = $_GET['userId'];
$issueDate = $_GET['issueDate'];
$returnDate = $_GET['returnDate'];




$sql = "select * from opac where a900='".$bookId."'";
$result = pg_query($sql);

$row=pg_fetch_array($result);

$bookName = $row['a200'];
$code = $row['a001'];
$author = $row['authors'];
//$loc = $row['loc'];
//echo $bookName
$insertTranscationsQuery = "INSERT INTO transactions (code, a001, title, authors,a900, issuedate, rtndate) VALUES
('".$userId."','".$code."','".$bookName."','".$author."','".$bookId."','".$issueDate."','".$returnDate."')";
//echo $insertTranscationsQuery;
//echo $test = pg_query($insertTranscationsQuery);

if(pg_query($insertTranscationsQuery)){
    $insertIssuesTable = "INSERT INTO issues (code, a001, title, authors, a900, issuedate, rtnstatus, rtndate, ttype) VALUES
    ('".$userId."', '".$code."', '".$bookName."', '".$author."', '".$bookId."', '".$issueDate."', '2', '".$returnDate."', 'I')";
    //echo $insertIssuesTable;
    if(pg_query($insertIssuesTable)){
        echo "OK001";
        return;        
    }else{
        echo "ERRO2";
        return;
    }
}else{
    echo "ERRO1";
    return;
}

?>