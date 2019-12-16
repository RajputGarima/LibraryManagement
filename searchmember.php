<?php
include_once("config.php");

$memberId = $_GET['memberId'];
//member exists or not
$checkmemberQuery = "select * from members where code = '".$memberId."' ";
$checkmember = pg_query($checkmemberQuery);
if(pg_num_rows($checkmember) == 0){
	echo "E001";
	return;
}

$detailsQuery = "select * from members where code = '".$memberId."' ";
$details = pg_query($detailsQuery);
$details_values = pg_fetch_row($details);

?>

<div class="form-group">
    <label for="Member Id">MemberID </label>
    <input type="text" value = "<?php  echo $details_values[0]; ?>" class="form-control" disabled="true">
</div>
<div class="form-group">
    <label for="Member Id">Name </label>
    <input type="text" value = "<?php  echo $details_values[1]; ?>" class="form-control" id="name">
</div>

<div class="form-group" >
    <label for="Member Id">Designation</label><br>
    <select name="your_desig" id = "your_desig">
                    <option value= "<?php  echo $details_values[2]; ?>" > <?php echo $details_values[2]; ?> </option>
                    <?php
                        $qry = "select description from category";
                        $execute = pg_query($qry);
                        while($ans = pg_fetch_row($execute)){ 
                             ?>
                            <option value= "<?php  echo $ans[0]; ?>" >  <?php echo $ans[0]; ?> </option>
                    <?php   } ?>         
                    </select>  
</div>

<div class="form-group">
    <label for="Member Id">Enrollment Date </label>
    <input type="text" value = "<?php  echo $details_values[4]; ?>" class="form-control" id="enroll_date" disabled="true">
</div>

<div class="form-group">
    <label for="Member Id">Valid upto </label>
    <input type="text" value = "<?php  echo $details_values[5]; ?>" class="form-control" id="valid_date" disabled="true">
</div>

<div class="form-group">
    <label for="Member Id">Local Address</label>
    <input type="text" value = "<?php  echo $details_values[6]; ?>" class="form-control" id="address">
</div>

<div class="form-group">
    <label for="Member Id">Lab</label><br>
    <select name="your_lab" id="your_lab">
                    <option value="<?php  echo $details_values[9]; ?>"> <?php echo $details_values[9]; ?> </option>
                    <?php
                        $qry = "select code from lab";
                        $execute = pg_query($qry);
                        while($ans = pg_fetch_row($execute)){ 
                             ?>
                            <option value= "<?php  echo $ans[0]; ?>" >  <?php echo $ans[0]; ?> </option>
                    <?php   } ?>         
                    </select>
</div>

