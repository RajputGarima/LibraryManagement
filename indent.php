<?php
include_once("config.php");

$title = '';
$type = '';
$edition = '';
$publisher = '';
$author = '';
$copies = '';
$price = '';
$indentlab = '';
$budgetlab = '';
$mailinglab = '';


    if(isset($_POST['submit']) && !empty($_POST['book_title']) && !empty($_POST['book_edition']) && !empty($_POST['book_publisher']) && !empty($_POST['book_author']) && !empty($_POST['book_copies']) &&  !empty($_POST['book_price']) && $_POST['book_type']!='' && $_POST['indent_lab']!='' && $_POST['mailing_lab']!='' && $_POST['budget_lab']!=''){


        $title = $_POST['book_title'];
        $type = $_POST['book_type'];
        $edition = $_POST['book_edition'];
        $publisher = $_POST['book_publisher'];
        $author = $_POST['book_author'];
        $copies = $_POST['book_copies'];
        $price = $_POST['book_price'];
        $indentlab = $_POST['indent_lab'];
        $mailinglab = $_POST['mailing_lab'];
        $budgetlab = $_POST['budget_lab'];

        $qry = "select max(indentno) from indent";
        $execute = pg_query($qry);
        $result = pg_fetch_row($execute);
        $temp = $result[0];
        $indentno = (int)($temp + 1);

        date_default_timezone_set ("Asia/Calcutta"); 
        $month = date("m");
        $year = date("Y");
        $date = date("d");
        $time = date("h:i:s");
        $from = $year."-".$month."-".$date." ".$time;

        $qry = "insert into indent(mailinglab, indentno, indentlab, budgetlab, subfrom, subto, copies, inrprice, approved) values('".$mailinglab."', '".$indentno."' ,  '".$indentlab."' , '".$budgetlab."', '".$from."', null,  '".$copies."',   '".$price."',  0)";
        $execute = pg_query($qry);
        if($execute){
            echo "Indent Added.. Indent number is '".$indentno."'";
        }
        else{
            echo "not added";
        }

        $qry = "select code from typeofmaterial where name = '".$type."' ";
        $execute = pg_query($qry);
        $result = pg_fetch_row($execute);
        $a060 = $result[0];

        $a001Query = "select max(a001) from opac";
        $a001 = pg_query($a001Query);
        $a001_val = pg_fetch_row($a001);
        $newa001 = $a001_val[0] + 1;
        $newa001_int = (int)$newa001;
        
        $qry = "insert into topac(a060, a100, a200, a260, a300, a400, a440, indentno, approved, a001) values( '".$a060."' , null, '".$title."',  '".$edition."' , '".$author."' , '".$publisher."', null,  '".$indentno."' , 0,'".$newa001_int."'   )"; 
        $execute = pg_query($qry);
        if($execute){
            //echo "topac Added";
        }
        else{
            echo "not added";
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
            <div class="users__header">Adding a new indent</div>
            <div class="search_container">
            <div class="users__container-list"></div> <br>
            	<form action="" method="POST">
					<input type="text" name="book_title" placeholder="Title" /> <br> <br>

                    <select name="book_type">
                    <option value=''>--Book type--</option>
                    <?php
                        $qry = "select name from typeofmaterial";
                        $execute = pg_query($qry);
                        while($ans = pg_fetch_row($execute)){ 
                             ?>
                            <option value= "<?php  echo $ans[0]; ?>" >  <?php echo $ans[0]; ?> </option>
                    <?php   } ?>         
                    </select><br><br>

					<input type="text" name="book_edition" placeholder="Edition"/><br> <br>
                    <input type="text" name="book_publisher" placeholder="Publishers"/><br> <br>
                    <input type="text" name="book_author" placeholder="Author"/><br> <br>
                    <input type="text" name="book_copies" placeholder="Copies"/><br> <br>
                    <input type="text" name="book_price" placeholder="Price"/><br> <br>

                    <select name="indent_lab">
                    <option value=''>--Indent lab--</option>
                    <?php
                        $qry = "select code from lab";
                        $execute = pg_query($qry);
                        while($ans = pg_fetch_row($execute)){ 
                             ?>
                            <option value= <?php  echo $ans[0]; ?> >  <?php echo $ans[0]; ?> </option>
                    <?php   } ?>         
                    </select><br><br> 

                    <select name="budget_lab">
                    <option value=''>--Budget lab--</option>
                    <?php
                        $qry = "select code from lab";
                        $execute = pg_query($qry);
                        while($ans = pg_fetch_row($execute)){ 
                             ?>
                            <option value= <?php  echo $ans[0]; ?> >  <?php echo $ans[0]; ?> </option>
                    <?php   } ?>         
                    </select><br><br> 

                    <select name="mailing_lab">
                    <option value=''>--Mailing lab--</option>
                    <?php
                        $qry = "select code from lab";
                        $execute = pg_query($qry);
                        while($ans = pg_fetch_row($execute)){ 
                             ?>
                            <option value= <?php  echo $ans[0]; ?> >  <?php echo $ans[0]; ?> </option>
                    <?php   } ?>         
                    </select><br><br> <br> <br>

                    <input type="Submit", name='submit' value = "Indent book">
				</form>
			</div>	
        </div>

        </body>
</html>
