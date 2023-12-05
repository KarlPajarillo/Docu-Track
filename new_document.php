<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
            <!-- <div id="dialog-confirm" title="Ready?">
                <p>Are you sure?</p>
            </div> -->
			<form action="" id="manage_document">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <label for="doc_name">Document Name:</label>
                <input type="text" class="form-control" id="doc_name" name="doc_name" placeholder="Enter a name of document" value="<?php echo isset($doc_name) ? $doc_name : '' ?>" required>
                
            </form>
  	    </div>
        <div class="card-footer border-top border-info">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <input id="submit" name="submit" type="submit" value="Save" class="btn btn-flat bg-gradient-primary mx-2">
                <a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=document_list">Cancel</a>
            </div>
        </div>
        <div class="modal fade" id="dialog-confirm" tabindex="-1" role="dialog" aria-labelledby="edit-user-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <form name="confirm" id="confirm" action="" method="post" role="form">
                        <div class="modal-header">
                        <h4 class="modal-title">Are you sure to save this document?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div id="msg" class=""></div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
  			                <button class="btn btn-flat  bg-gradient-primary mx-2" form="confirm">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
</div>
<script>
    
  $('input#submit').click(function(){
    $('#dialog-confirm').modal('show');
  })

  $("#confirm").submit(function(e){
        e.preventDefault()
		// start_load()
		$.ajax({
            url:'ajax.php?action=confirm',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
                if(resp == 1){
                    $('#manage_document').submit();
				}else if(resp == 2){
                    alert_toast('Password is incorrect.',"error");
                    $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Password is incorrect.</div>')
                    // end_load()
                }
			}
		})
	})

    $('#manage_document').submit(function(e){
        e.preventDefault()
		start_load()
        $.ajax({
            url:'ajax.php?action=save_document',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
                if(resp == 1){
                    $("#dialog-confirm").modal('hide');
                    alert_toast('New document successfully saved',"success");
					setTimeout(function(){
                        location.href = 'index.php?page=document_list'
					})
				}else if(resp == 2){
                    alert_toast('Password is incorrect.',"error");
                    $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Password is incorrect.</div>')
                    end_load()
                }
			}
		})
    })

</script>