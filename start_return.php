<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


        <script>
        function onReturn() {
           // $('#modal').modal('hide');
             //  location.reload();
            var memberId = $("#memberId").val();
            var bookId = $("#bookId").val();
            // alert(bookId);
            // return false;
                $.ajax({
                    url:"returnBook.php",
                    type: "GET", //request type
                    dataType: 'html',
                    data: {memberId: memberId, bookId: bookId},
                    success:function(result){
                    if(result == "E001"){
                        $("#return-unsuccessful").css("display", "block");
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
                    if(result == "OK001"){
						$("#book-returned").css("display", "block");
                        return false;
					} 
					if(result.includes("_")){
						var newResult = result.split("_");
						alert("The book has been returned successfully but you have a fine of Rs "+newResult[1]);
						$('#myModal').modal('hide');
						location.reload();
						return false;
					}

                    //$("#appendedText").html(result);
                  }
                });
            }

            function closeModal(){
                $("#memberId").val('');
                $("#bookId").val('');
                location.reload();
            }

        </script>
</head>

<body>
        <div class="users__container">
            <div class="users__header">Returning a book</div>
            <div class="search_container">
                <form action="" method="GET">
                    <button type="button" data-toggle="modal" data-target="#myModal">Return</button>
                </form>    
            </div>
            <div class="users__container-list">
            </div>
            </div>

        <div class="modal fade" id="myModal" role="dialog">
    	<div class="modal-dialog">

    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onClick="closeModal()">&times;</button>
          <h4 class="modal-title">Return Book</h4>
        </div>

    <div class="modal-body">
        <div class="form-group">
            <label for="Book Id">Member Id:</label>
            <input type="text" class="form-control" id="memberId">
        </div>

        <div class="form-group">
            <label for="Book Id">Book Id:</label>
            <input type="text" class="form-control" id="bookId">
        </div>

         
        <div class="alert alert-success" style="display:none" id="book-returned">
          <strong>Success!</strong> Book returned successfully.
        </div>

         <div class="alert alert-danger" style="display:none" id="return-unsuccessful">
           <strong>Sorry!</strong> This book has not been issued to you.
        </div>

        <div class="alert alert-warning" style="display:none" id="invalid-user">
            <strong>Sorry!</strong> This is not a valid member code.
        </div>


        
        <div class="alert alert-info" style="display:none" id="book-not-exists">
            <strong>Sorry!</strong> You have entered a wrong book.
        </div>

        </div>

        <div class="modal-footer">
        	<button type="submit" class="btn btn-primary" onClick="onReturn()">Return</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" onClick="closeModal()" >Cancel</button>
        </div>
      </div>
      
    </div>
  </div>
</body>
</html>