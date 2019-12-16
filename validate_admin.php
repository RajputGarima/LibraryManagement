
<!DOCTYPE html>
<html>
    <head>
        <link rel= "stylesheet" type="text/css" href="css/style.css">
        <script>
         if(sessionStorage){
             if(!(sessionStorage.getItem("session_key") == "lib_admin") && !sessionStorage.getItem("session_key") != null){
                window.location.href = "/lib/demo.php";
             }
         }else{
            alert("Sorry, your browser do not support session storage.");
         }
         function logout(){
            sessionStorage.setItem("session_key", "");
            window.location.href = "demo.php";
         }
        </script>
    </head>

    <meta charset="UTF-8">
    <body>
        <div class="users__container">
            <div class="users__header">Welcome, Admin </div>
            <div class="logout-section"><button onClick="logout()" style=" height: 30px">Logout</div>
            <div class="search_container">
            <div class="users__container-list"></div> <br>
            	<form action="validate_admin.php", method="POST">
					<input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Add new admin" formaction="add_new_admin.php"/ ><br> <br>
					<input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Add new member" formaction="add_new_member.php"/> <br> <br> 
					<input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Edit a member" formaction="start_edit.php"/> <br> <br>
                    <input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Extend/Cancel Membership" formaction="extend_membership.php"/> <br> <br> 
					<input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Issue Book" formaction="start_issue.php"/> <br> <br> 
					<input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Return Book" formaction="start_return.php"/> <br> <br>
					<input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Indent Book" formaction="indent.php"/> <br> <br> 
					<input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Approve indent" formaction="approve_indent.php"/> <br> <br> 
                    <input type="submit" name="adminbutton" style="width: 180px; height: 30px" value="Logs" formaction="logs.php"/> <br> <br> 
				</form>
			</div>	
        </div>

        </body>
</html> 
