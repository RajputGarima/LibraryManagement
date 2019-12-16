<?php
include_once("config.php");
if($_POST['user_name'] !== '' && $_POST['password'] != ''){
$username = $_POST['user_name'];
$password = $_POST['password'];

$isValidUserQuery = "select * from admins where username ='".$username."' and password='".$password."'";
$isValidUser = pg_query($isValidUserQuery);

if(pg_num_rows($isValidUser) > 0){
echo "OK01";
return;
}
echo "ERROR01";
return;

}else{
echo "Error";
return;
}

?>