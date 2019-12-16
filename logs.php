<?php
include_once("config.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <meta charset="UTF-8">
    <body>
        <div class="users__container">
            <div class="users__header">Transactions</div>
            <div class="search_container">
            	<form action="", method="GET">
					<select name="previous_transac">
                    <option value=''>--Logs--</option>
                    <option value = '10'> Last 10 transactions </option>
                    <option value = '50'> Last 50 transactions </option> 
                    <option value = '100'> Last 100 transactions </option> 
                    <option value = '200'> Last 200 transactions </option> 
                    <option value = '300'> Last 300 transactions </option> 
                    <option value = '400'> Last 400 transactions </option> 
                    <option value = '500'> Last 500 transactions </option> 
                    <option value = 'x'> All transactions </option> 
                    </select>
                    <input type="Submit", name='submit' value = "SUBMIT">
                    <br> <br>
				</form>



<?php
$limit = '';

	if( !empty($_GET['previous_transac']) && $_GET['previous_transac']!= '' && isset($_GET['submit'])){

		$limit = $_GET['previous_transac'];
		$limit_int = (int)$limit;

		if($limit == 'x'){
			$qry = "select * from issues order by issuedate desc ";		
		}
		else{
			$qry = "select * from issues order by issuedate desc limit '".$limit_int."' ";	
		}
		$execute = pg_query($qry); ?>

		
		<div class="users__container-list">
			<?php
            while( $result = pg_fetch_row($execute)) {          
            ?>
            	<div class="profile__container">

            	<div>
                    <label class="propertyTitle">Member Id: </label>
                    <label class="propertyValue"><?php echo $result[0]; ?></label>
                </div>

                <div>
                    <label class="propertyTitle">Transaction type:</label>
                    <label class="propertyValue"><?php echo ($result[8] == 'I') ? "Issue" : "Return"; ?></label>
                </div>

                <div>
                    <label class="propertyTitle">Book Id: </label>
                    <label class="propertyValue"><?php echo $result[4]; ?></label>
                </div>

                <div>
                    <label class="propertyTitle">Issue Date:</label>
                    <label class="propertyValue"><?php echo $result[5]; ?></label>
                </div>

                <div>
                    <label class="propertyTitle">Return Date:</label>
                    <label class="propertyValue"><?php echo $result[7]; ?></label>
                </div>

            	</div>
            <?php }  ?>
	</div>

<?php
	}

?>






			</div>	
        </div>

        </body>

</html>