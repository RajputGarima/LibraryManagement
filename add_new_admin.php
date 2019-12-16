<?php
include_once("config.php");
    $name = '';
    $pass = '';

    if(!empty($_POST['your_name'])  &&  !empty($_POST['your_pass']) ){
        $name = $_POST['your_name'];
        $pass = $_POST['your_pass'];
            $query = "insert into admins(username, password) values( '".$name."', '".$pass."') ";
            $run = pg_query($query);
                if($run){
                    echo "Admin added successfully";  
                    }
                else{
                    echo "Could not add admin";
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
            <div class="users__header">Adding a new admin</div>
            <div class="search_container">
            <div class="users__container-list"></div> <br>
            	<form action="" method="POST">
					<input type="text" name="your_name" placeholder="Username" /> <br> <br>
					<input type="password" name="your_pass" placeholder="Password"/><br> <br>
					<input type="Submit", name='submit' value = "ADD">
				</form>
			</div>	
        </div>

        </body>
</html>
