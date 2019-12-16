<?php
include_once("config.php");

    $name = '';
    $desig = '';
    $addr = '';
    $lab = '';

    if(isset($_POST['submit']) && !empty($_POST['submit']) && !empty($_POST['your_name'])  &&  !empty($_POST['your_desig']) &&  !empty($_POST['your_address']) && !empty($_POST['your_lab']) && $_POST['your_lab']!= '' && $_POST['your_desig']!= ''){

        $name = $_POST['your_name'];
        $desig = $_POST['your_desig'];
        $addr = $_POST['your_address'];
        $lab = $_POST['your_lab'];
        date_default_timezone_set ("Asia/Calcutta");

        $qry = "select code from category where description = '".$desig."' ";
        $execute = pg_query($qry);
        $result = pg_fetch_row($execute);
        $category = (int)$result[0];

        $qry = "select max(code) from members";
        $execute = pg_query($qry);
        $result = pg_fetch_row($execute);
        $temp = $result[0];
        $num = '';
        $i = 4;
        $j = 0;
        while($i <  strlen($temp)){
        	$num[$j] = $temp[$i];
        	$j++;
        	$i++;
        }
        $code = "TIRC".($num + 1);

        $month = date("m");
        $year = date("Y");
        $date = date("d");
        $time = date("h:i:s");
        $enrolementdate = $year."-".$month."-".$date." ".$time;
        $validupto = ($year + 10)."-".$month."-".$date." ".$time;


            $query = "insert into members(code, name, designation, category, enrolementdate, validupto, localaddress, cancelled,cancelleddate, lab) values('".$code."' ,'".$name."', '".$desig."' , '".$category."' ,'".$enrolementdate."','".$validupto."',  '".$addr."', 0, null,   '".$lab."') ";
            $run = pg_query($query);
                if($run){
                    echo "Member added!! Your member id is '".$code."' .";  
                }
                else{
                    echo "Could not add member";
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
            <div class="users__header">Adding a new member</div>
            <div class="search_container">
            <div class="users__container-list"></div> <br>
            	<form action="" method="POST">
					<input type="text" name="your_name" placeholder="Name" /> <br> <br>
                    <select name="your_desig">
                    <option value=''>--Designation--</option>
                    <?php
                        $qry = "select description from category";
                        $execute = pg_query($qry);
                        while($ans = pg_fetch_row($execute)){ 
                             ?>
                            <option value= "<?php  echo $ans[0]; ?>" >  <?php echo $ans[0]; ?> </option>
                    <?php   } ?>         
                    </select><br><br>
					<input type="text" name="your_address" placeholder="Local Address"/><br> <br>
                    <select name="your_lab">
                    <option value=''>--Lab--</option>
                    <?php
                        $qry = "select code from lab";
                        $execute = pg_query($qry);
                        while($ans = pg_fetch_row($execute)){ 
                             ?>
                            <option value= <?php  echo $ans[0]; ?> >  <?php echo $ans[0]; ?> </option>
                    <?php   } ?>         
                    </select><br><br><br>                 
					<input type="Submit", name='submit' value = "Add Member">
				</form>
			</div>	
        </div>

        </body>
</html>
