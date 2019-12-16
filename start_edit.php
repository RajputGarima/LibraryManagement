<?php include_once("config.php"); ?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

        <script>
        function onSubmitMemberId() {
           // $('#modal').modal('hide');
            var memberId = $("#memberId").val();
            // alert(bookId);
            // return false;
                $.ajax({
                    url:"searchmember.php",
                    type: "GET", //request type
                    dataType: 'html',
                    data: {memberId: memberId},
                    success:function(result){
                    if(result == "E001"){
                        $("#already-issued-msg").css("display", "block");
                        return false;
                    }
                    $("#appendedText").html(result);
                  }
                });
            }

        function closeModal(){
                $("#memberId").val('');
                location.reload();
            }

        function onsaveChanges() {
            var memberId = $("#memberId").val();
            var name = $("#name").val();
            var desig = $("#your_desig option:selected").text().trim();
            var enrollDate = $("#enroll_date").val();
            var validupto = $("#valid_date").val();
            var address = $("#address").val();
            var lab = $("#your_lab option:selected").text().trim();
                $.ajax({
                    url:"save_changes.php",
                    type: "POST", //request type
                    dataType: 'html',
                    data: {memberId: memberId, name:name, desig: desig , enrollDate: enrollDate, validupto: validupto, address: address, lab: lab  },
                    success:function(result){
                        /*if(result == "ERROR001"){
                        $("#invalid-user").css("display", "block");
                        //$("#already-issued-msg").css("display", "none");
                        return false;                         
                     }
                     else if(result == "ERROR002"){
                        $("#membership_expired").css("display", "block");
                        //$("#already-issued-msg").css("display", "none");
                        return false;                         
                     }*/
                     if(result == "OK001"){
                         alert("Changes saved successfully");
                         $('#modal').modal('hide');
                         location.reload();
                     }
                     /*else if(result == "B001"){
                        $("#issue-exceed").css("display", "block");
                        //$("#already-issued-msg").css("display", "none");
                        return false;
                     }*/
                  }
                });
            }

        </script>
        
  </head>


  <body>
        <div class="users__container">
            <div class="users__header">Editing a member</div>
            <div class="search_container">
                <form action="" method="GET">
                    <button type="button" data-toggle="modal" data-target="#myModal">Edit</button>
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
          <h4 class="modal-title">Edit</h4>
        </div>
        <div class="modal-body">
        <div class="form-group">
            <label for="Book Id">Member Id:</label>
            <input type="text" class="form-control" id="memberId"> <br>
            <button type="submit" onClick="onSubmitMemberId(this.memberId)" class="btn btn-primary">Submit</button>
        </div>
        <div class="alert alert-danger" style="display:none" id="already-issued-msg">
            <strong>Sorry!</strong> This member doesn't exist.
        </div>
       <!-- <div class="alert alert-danger" style="display:none" id="invalid-user">
            <strong>Sorry!</strong> This member is not valid.
        </div>
        <div class="alert alert-danger" style="display:none" id="membership_expired">
            <strong>Sorry!</strong> Your membership has expired.
        </div>
         <div class="alert alert-danger" style="display:none" id="book-not-exists">
            <strong>Sorry!</strong> This book doesn't exist.
        </div>
        <div class="alert alert-danger" style="display:none" id="issue-exceed">
            <strong>Sorry!</strong> Issue limit exceeded.
        </div>-->
        <div id="appendedText"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" onClick="onsaveChanges()">Save Changes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal" onClick="closeModal()" >Cancel</button>
        </div>
      </div>
      
    </div>
  </div>
    </body>
   </html>
