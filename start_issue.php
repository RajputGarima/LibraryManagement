<?php
include_once("config.php");
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script>
        function onSubmitBookId() {
            var bookId = $("#bookId").val();
            var userId = $("#userId").val();
                $.ajax({
                    url:"search.php",
                    type: "GET", //request type
                    dataType: 'html',
                    data: {bookId: bookId, userId: userId},
                    success:function(result){
                    if(result == "E001"){
                        $("#already-issued-msg").css("display", "block");
                        return false;
                    }
                    if(result == "NB001"){
                        $("#book-not-exists").css("display", "block");
                        return false;
                    }
                    if(result == "ERROR001"){
                        $("#invalid-user").css("display", "block");
                        //$("#already-issued-msg").css("display", "none");
                        return false;                         
                     }
                    if(result == "ERROR002"){
                        $("#membership_expired").css("display", "block");
                        //$("#already-issued-msg").css("display", "none");
                        return false;                         
                     }
                     if(result == "B001"){
                        $("#issue-exceed").css("display", "block");
                        //$("#already-issued-msg").css("display", "none");
                        return false;
                     }


                    $("#appendedText").html(result);
                  }
                });
            }

            function closeModal(){
                $("#userId").val('');
                $("#bookId").val('');
                location.reload();
            }

            function issueBook() {
            var bookId = $("#bookId").val();
            var userId = $("#userId").val();
            var issueDate = $("#issueDate").val();
            var returnDate = $("#returnDate").val();
                $.ajax({
                    url:"issueBook.php",
                    type: "GET", //request type
                    dataType: 'html',
                    data: {bookId: bookId, userId: userId,issueDate: issueDate,returnDate: returnDate  },
                    success:function(result){
                
                    if(result == "OK001"){
                         alert("Book issued successfully");
                         $('#modal').modal('hide');
                         location.reload();
                         //$("#book-issued").css("display", "block");
                        //return false;
                     }
                  }
                });
            }
        </script>
    </head>
    
    <body>
        <div class="users__container">
            <div class="users__header">Issuing a book</div>
            <div class="search_container">
                <form action="" method="GET">
                    <button type="button" data-toggle="modal" data-target="#myModal">Issue Book</button>
                </form>    
            </div>
            <div class="users__container-list"> 
            </div>
            </div>

            <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onClick="closeModal()">&times;</button>
          <h4 class="modal-title">Issue Book</h4>
        </div>
        <div class="modal-body">
        <div class="form-group">
            <label for="Book Id">Book Id:</label>
            <input type="text" class="form-control" id="bookId">
            <br>
            <label for="Member Id">User Id:</label>
            <input type="text" class="form-control" id="userId">
            <br>
            <button type="submit" onClick="onSubmitBookId(this.bookId)" class="btn btn-primary">Verify</button>
        </div>
        <div class="alert alert-danger " style="display:none" id="already-issued-msg">
            <strong>Sorry!</strong> This Book has been issued already.
        </div>
        <div class="alert alert-danger" style="display:none" id="invalid-user">
            <strong>Sorry!</strong> This member is not valid.
        </div>
        <div class="alert alert-danger" style="display:none" id="membership_expired">
            <strong>Sorry!</strong> Your membership has expired.
        </div>
         <div class="alert alert-danger" style="display:none" id="book-not-exists">
            <strong>Sorry!</strong> This book doesn't exist.
        </div>
        <div class="alert alert-warning" style="display:none" id="issue-exceed">
            <strong>Sorry!</strong> Issue limit exceeded.
        </div>
        <div class="alert alert-success" style="display:none" id="book-issued">
          <strong>Success!</strong> Book issued successfully.
        </div>
        <div id="appendedText"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" onClick="issueBook()">Issue</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" onClick="closeModal()" >Cancel</button>
        </div>
      </div>
      
    </div>
  </div>
    </body>
</html>

