<?php
 include_once("config.php");
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// pg_connect("host=localhost dbname=project1 user=postgres password=postgres");
$name='';
if(!empty($_GET['search_by']) && !empty($_GET['text']) && isset($_GET['submit']) && $_GET['text'] !== '' && $_GET['text'] != null){
    // echo "<pre>";
    // print_r($_GET);
    $name = $_GET['text'];
    $updatedSearchName = str_replace(" ","&", $name);
    if($_GET['search_by'] == '1'){
         $sql = "select * from opac where to_tsvector(title) @@ to_tsquery('%".$updatedSearchName."%')";        
    }else if($_GET['search_by'] == '2'){
         $sql = "select * from opac where to_tsvector(authors) @@ to_tsquery('%".$updatedSearchName."%')";
    }else if($_GET['search_by'] == '3'){
        $sql = "select * from opac where to_tsvector(a620i) @@ to_tsquery('%".$updatedSearchName."%')";
    }
    $result = pg_query($sql);
   }
   else{
    $sql = "select * from opac limit 200";
   $result = pg_query($sql);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script>
        function login() {
        var user_name = $("#user_name").val();
        var password = $("#password").val();
        $.ajax({
        url:"login.php",
        type: "POST", //request type
        dataType: 'html',
        data: {user_name: user_name, password: password},
        success:function(result){
        if(result == "ERROR01"){
        alert('invalid username or password. Please try again!');
        return false;
        }
        if(result == "OK01"){
        if(sessionStorage){
        sessionStorage.setItem("session_key", "lib_admin");
        }else{
        alert("Sorry, your browser does not support session storage.");
        }
        window.location.href = "validate_admin.php";
        }
        }
        });
        }
        </script>

    </head>

        
    <meta charset="UTF-8">
    <body>
        <div class="users__container">
            <div class="users__header">Library Management System</div>
            <div class="search_container">
                <form action="" method="GET">
                    <select name="search_by">
                        <option value="0">--select--</option>
                        <option value="1">Search by Title</option>
                        <option value="2">Search by Author</option>
                        <option value="3">search by Subject</option>
                    </select>
                    <input type="text" name="text" value="<?php echo $name; ?>" />
                    <input type="submit" name="submit" value="Search" />
                    <button type="button" data-toggle="modal" data-target="#Admin-Modal">Admin</button>
                </form>  
                
            </div>
            <div class="users__container-list">
            <?php
             // !empty($_GET['search_by']) && !empty($_GET['text']) &&
            while( $row = pg_fetch_array($result)) {  
                //print_r($row);         
            ?>
                <div class="profile__container">
                <div>
                    <label class="propertyTitle">Title:</label>
                    <label class="propertyValue"><?php echo $row["a200"]; ?></label>
                </div>
                <div>
                    <label class="propertyTitle">Author:</label>
                    <label class="propertyValue"><?php echo (strlen($row["authors"]) > 40) ? substr($row["authors"],0,30).'...' : $row["authors"]; ?></label>
                </div>
                <div>
                    <label class="propertyTitle">Subject:</label>
                    <label class="propertyValue"><?php echo (strlen($row["a620i"]) > 40) ? substr($row["a620i"],0,30).'...' : $row["a620i"] == '' ? "NA" : $row["a620i"] ?></label>
                </div>
                <div>
                    <label class="propertyTitle">Accession No:</label>
                    <label class="propertyValue"><?php echo $row['a900'] ?></label>
                </div>
                <div>
                    <label class="propertyTitle">Publishers:</label>
                    <label class="propertyValue"><?php echo (strlen($row["a400i"]) > 40) ? substr($row["a400i"],0,30).'...' : $row["a400i"] == '' ? "NA" : $row["a400i"] ?></label>
                </div>
                </div>
            <?php }  ?>    
            </div>
            </div>

            <div class="modal fade" id="Admin-Modal" role="dialog">
            <div class="modal-dialog"> 
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Admin Control Panel</h4>
            </div>
            <div class="modal-body">
            <div class="form-group">
            <label for="User_name">User Name :-</label>
            <input type="text" class="form-control" id="user_name" required />
            </div>
            <div class="form-group">
            <label for="password">Password :-</label>
            <input type="password" class="form-control" id="password" required />
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary" onClick="login()">Log In</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>
            </div>
            </div>
    </body>
</html>