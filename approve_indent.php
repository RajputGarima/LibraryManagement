<?php
include_once("config.php");

$indent = '';

    if(isset($_POST['submit']) && !empty($_POST['indent_number'])){
        $indent = $_POST['indent_number'];
        $i = (int)$indent;

        date_default_timezone_set ("Asia/Calcutta");
        $month = date("m");
        $year = date("Y");
        $date = date("d");
        $time = date("h:i:s");
        $subto = $year."-".$month."-".$date." ".$time;


        $qry = "select approved from indent where indentno = '".$i."'";
        $execute = pg_query($qry);
        $ans = pg_fetch_row($execute);
        if(pg_num_rows($execute)==0){
            echo "Not a valid indent !";
        }
        elseif ($ans[0] == 1) {
            echo "Already approved indent";
        }
        else {
        $qry = "update indent set approved = 1  where indentno = '".$i."' ";
        $execute = pg_query($qry);
        $qry = "update indent set subto = '".$subto."' where indentno = '".$i."' ";
        $execute = pg_query($qry);
        // //$a001Query = "select a001 from topac where indentno = '".$i."'";
        // $a001 = pg_query($a001Query);
        // $a001_val = pg_fetch_row($a001);
        // echo $a001_val[0];
        // $final_val = $a001_val[0] + 4346;
        // $qry = "update topac set a001 = '".$final_val."' where indentno = '".$i."' ";
        // $execute = pg_query($qry);
        $qry = "update topac set approved = 1 where indentno = '".$i."' " ;
        $execute = pg_query($qry);
        if($execute){
            echo "Approved";
        }
        else{
            echo "Not approved";
        }

        }

    }

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <meta charset="UTF-8">
    <body>
        <div class="users__container">
            <div class="users__header">Approving an indent</div>
            <div class="search_container">
            <div class="users__container-list"></div> <br>
            	<form action="", method="POST">
					<input type="text" name="indent_number" placeholder="Indent Number" /><br> <br>
					<input type="Submit" name = 'submit' value="Approve">
				</form>
			</div>	
        </div>

        </body>
</html>
