<?php

$db = pg_connect("host = localhost port = 5432 dbname = project1 user = postgres password = Garima@007  ");
if(!$db){
	echo "can't connect to database";
}
else{
	//echo "\nconnected ";
}


?>