<?php
//THQ530
//echo "test";
include_once("config.php");
$bookId = $_GET['bookId'];
$userId = $_GET['userId'];
//book already issued or not
$sql = "select * from opac as O inner join  transactions as T on O.a001 = T.a001 where O.a900= '".$bookId."' "  ;
//echo $sql;
$result = pg_query($sql);
if(pg_num_rows($result) > 0){
    echo "E001";
    return;
}

//book exists or not
$checkBookDetails = "select * from opac where a900='".$bookId."'";
$bookDetailsResults = pg_query($checkBookDetails);
if(pg_num_rows($bookDetailsResults)==0){
    echo "NB001";
    return;
}

//member exists or not
$isUserExistQuery = "select * from members where code ='".$userId."'";
$isUSerExist = pg_query($isUserExistQuery);
if(pg_num_rows($isUSerExist) == 0){
    echo "ERROR001";
    return;
}


// membership period valid or not

$isUserValid = "select validupto from members where code = '".$userId."' ";
$execute = pg_query($isUserValid);
$ans = pg_fetch_row($execute);
date_default_timezone_set ("Asia/Calcutta");
$curr_date = date("Y-m-d");
$qry = "select '".$curr_date."'::date -  '".$ans[0]."'::date ";
$execute = pg_query($qry);
$answer = pg_fetch_row($execute);
//echo $answer[0];
if($answer[0] >= 0){
    echo "ERROR002";
    $updateQuery = "update members set cancelled = 1 where code = '".$userId."' ";
    $update = pg_query($updateQuery);
    $timestamp = date("Y-m-d h:i:s");
    $updateQuery = "update members set cancelleddate = '".$timestamp."' where code = '".$userId."' ";
    $update = pg_query($updateQuery);
    return;
}


//checking if book limit exceeds or not

$isIssueAllowedQuery = "select CODE, COUNT(a001)  from transactions where code =  '".$userId."' GROUP BY CODE";
$isIssueAllowed = pg_query($isIssueAllowedQuery);
if(pg_num_rows($isIssueAllowed) > 0){
    $categoryQuery = "select category from members where code = '".$userId."'  ";
    $category = pg_query($categoryQuery);
    $category_value = pg_fetch_row($category);
    $category_value_int = (int)$category_value[0];
    $booksallowedQuery = "select booksallowed from category where code = '".$category_value_int."' ";
    $booksallowed = pg_query($booksallowedQuery);
    $booksallowed_value = pg_fetch_row($booksallowed);
    $isIssueAllowed_value = pg_fetch_row($isIssueAllowed);
    if($booksallowed_value[0] <= $isIssueAllowed_value[1] ){
        echo "B001";
        return;
    }
}



?>
<?php
while($row = pg_fetch_array($bookDetailsResults)) {           
?>
<div class="form-group">
    <label for="Book Id">Title :- </label>
    <label for="Book Id"><?php echo $row["a200"];; ?></label>
</div>
<div class="form-group">
    <label for="Book Id">Author :-</label>
    <label for="Book Id"><?php echo  $row["authors"]; ?></label>
</div>
<div class="form-group">
    <label for="Book Id">Publishers:- </label>
    <label for="Book Id"><?php echo $row["a300"]; ?></label>
</div>
<!--<div class="form-group">
    <label for="Book Id">Labs:- </label>
    <label for="Book Id"><?php //echo $row['a020'] ?></label>
</div>-->

<div class="form-group">
            <label for="Book Id">Issue Date</label>
        <?php date_default_timezone_set ("Asia/Calcutta"); 
            $month = date("m");
            $year = date("Y");
            $date = date("d");
            $time = date("h:i:s");
            $issuedate = $year."-".$month."-".$date." ".$time; 
        ?>
            <input type="text" value= "<?php echo $issuedate; ?>" disabled="true" class="form-control" id="issueDate">
</div>
<div class="form-group">
            <label for="Book Id">Return Date</label>
            <?php
                $userId = $_GET['userId'];
                $qry1 = "select a060 from opac where a900 = '".$bookId."' ";
                $qry2 = "select category from members where code =  '".$userId."' ";
                $execute1 = pg_query($qry1);
                $execute2 = pg_query($qry2);
                $ans1 = pg_fetch_row($execute1);
                $ans2 = pg_fetch_row($execute2);
                $ans2_int = (int)$ans2[0];
                $qry3 = "select period from doctype where membercategory= '".$ans2_int."' and documenttype = '".$ans1[0]."' ";
                $execute3 = pg_query($qry3);
                if(pg_num_rows($execute3) == 0){
                    $answer = 30;
                }
                else {
                    $ans3 = pg_fetch_row($execute3);
                    $answer = $ans3[0];
                }
                $curr_date = date('Y-m-d');
                $retdate = date('Y-m-d', strtotime($curr_date. ' + '.$answer.' days'));
                $returndate = $retdate." ".$time; 
            ?>
            <input type="text" value= "<?php echo $returndate; ?>" disabled="true" class="form-control" id="returnDate">
        </div>
<?php }  ?>    
