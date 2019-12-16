<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script>
        	function onSubmitMemberId1() {
           // $('#modal').modal('hide');
            var memberId = $("#memberId").val();
            // alert(bookId);
            // return false;
                $.ajax({
                    url:"start_extend.php",
                    type: "GET", //request type
                    dataType: 'html',
                    data: {memberId: memberId},
                    success:function(result){
                    if(result == "E001"){
                        $("#already-issued-msg").css("display", "block");
                        return false;
                    }
                    if(result == "OK001"){
                        $("#extended").css("display", "block");
                        return false;
                    }
                    $("#appendedText").html(result);
                  }
                });
            }

            function onSubmitMemberId2() {
           // $('#modal').modal('hide');
            var memberId = $("#memberId").val();
            // alert(bookId);
            // return false;
                $.ajax({
                    url:"start_cancel.php",
                    type: "GET", //request type
                    dataType: 'html',
                    data: {memberId: memberId},
                    success:function(result){
                    if(result == "E001"){
                        $("#already-issued-msg").css("display", "block");
                        return false;
                    }
                    if(result.includes("_")){
						var newResult = result.split("_");
						alert("You have to return "+newResult[2] + " books with a total fine of Rs. " +newResult[1]);
						$('#myModal').modal('hide');
						location.reload();
						return false;
					}
                  }
                });
            }



        	function closeModal(){
                $("#memberId").val('');
                location.reload();
            }
        </script>
       </head>

   <body>
        <div class="users__container">
            <div class="users__header">Membership period</div>
            <div class="search_container">
            
            	<form action="" method="GET">
                    <button type="button" data-toggle="modal" style="width: 100px; height: 30px" data-target="#myModal1">Modify</button> <br><br>
                </form>
             <div class="users__container-list"></div> <br>    
            </div>
            </div>

        <div class="modal fade" id="myModal1" role="dialog">
    	<div class="modal-dialog">


   <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onClick="closeModal()">&times;</button>
          <h4 class="modal-title">Edit Membership</h4>
        </div>

       <div class="modal-body">
        <div class="form-group">
            <label for="Book Id">Member Id:</label>
            <input type="text" class="form-control" id="memberId"> <br>
        </div>
        <div class="alert alert-danger" style="display:none" id="already-issued-msg">
            <strong>Sorry!</strong> This member doesn't exist.
        </div>
        <div class="alert alert-success" style="display:none" id="extended">
            <strong>Success!</strong> Membership extended.
        </div>

        <div id="appendedText"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" onClick="onSubmitMemberId1(this.memberId)">Extend</button>
          <button type="submit" class="btn btn-primary" onClick="onSubmitMemberId2(this.memberId)">Cancel</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" onClick="closeModal()" >Close</button>
        </div>
      </div>
      
    </div>
  </div>

    </body>
   </html>