<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM parcels where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}

?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-parcel">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class=""></div>
        <div class="row">
          <div class="col-md-6">
            <?php 
              $user = $conn->query("SELECT * FROM users where id = ".$sender_name);
                while($urow = $user->fetch_assoc()):
            ?>
              <b>Sender Information</b>
              <div class="form-group">
                <label for="" class="control-label">Name</label>
                    <input type="text" name="dummy_name" id="dummy_name" class="form-control form-control-lm" value="<?php echo $urow['firstname'].' '.$urow['lastname'] ?>" disabled>
                    <input type="hidden" name="sender_name" id="sender_name" class="form-control form-control-sm" value="<?php echo isset($sender_name) ? $sender_name : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Department/Office</label>         
                <?php 
                  $branch = $conn->query("SELECT * FROM branches where id = ".$urow['branch_id']);
                    while($row = $branch->fetch_assoc()):
                ?>    
                <input type="text" name="from_branch_street" id="from_branch_street" class="form-control form-control-lm" value="<?php echo $row['department'] ?>" disabled>
                <input type="hidden" name="from_branch_id" id="from_branch_id" class="form-control form-control-sm" value="<?php echo $urow['branch_id'] ?>" required>
                <?php endwhile; ?>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Contact #</label>
                <input type="text" name="sender_contact" id="sender_contact" class="form-control form-control-lm" value="<?php echo $urow['contact_number'] ?>" required>
              </div>
            <?php endwhile; ?>
          </div>
          <div class="col-md-6">
              <b>Recipient Information</b>
              <div class="form-group">
                <label for="" class="control-label">Name</label>
                <select name="recipient_name" id="recipient_name" class="form-control select2">
                  <option value=""></option>
                  <?php 
                    $user = $conn->query("SELECT * FROM users where id = ".$recipient_name);
                      while($row = $user->fetch_assoc()):
                  ?>
                    <option value="<?php echo $row['id'] ?>" <?php echo isset($recipient_name) && $recipient_name == $row['id'] ? "selected":'' ?>><?php echo ucwords($row['firstname']). ' ' .ucwords($row['lastname']) ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Department/Office</label>
                <?php 
                  $branch = $conn->query("SELECT * FROM branches where id = ".$to_branch_id);
                    while($row = $branch->fetch_assoc()):
                ?>    
                <input type="text" name="to_branch_street" id="to_branch_street" class="form-control form-control-lm" value="<?php echo isset($row['department']) ? $row['department'] : '' ?>" disabled>
                <input type="hidden" name="to_branch_id" id="to_branch_id" class="form-control form-control-sm" value="<?php echo isset($to_branch_id) ? $to_branch_id : '' ?>" required>
                <?php endwhile; ?>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Contact #</label>
                <input type="text" name="recipient_contact" id="recipient_contact" class="form-control form-control-lm" value="<?php echo isset($recipient_contact) ? $recipient_contact : '' ?>" required>
              </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="dtype">Document Type</label>
              <select name="doc_type" id="doc_type" class="form-control select2">
                <option value=""></option>
                <?php 
                  $docs = $conn->query("SELECT * FROM documents");
                    while($row = $docs->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($doc_type) && $doc_type == $row['id'] ? "selected":'' ?>><?php echo ucwords($row['doc_name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="remarks">Remarks</label>
              <input type="text" name="remarks" id="remarks" class="form-control form-control-lm" value="<?php echo isset($remarks) ? $remarks : '' ?>" required>
            </div>
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-parcel">Save</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=document_transactions">Cancel</a>
  		</div>
  	</div>
	</div>
</div>
<script>
  $('#sender_name').change(function(){

    var value = $('#sender_name').val();

    $.ajax({
        url:"ajax.php?action=get_user_data&id=" + value,
          cache: false,
          contentType: false,
          processData: false,
          method: 'GET',
          type: 'GET',          
        success:function(res){
          $res = JSON.parse(res)
          $('#from_branch_street').val($res.department);
          $('#from_branch_id').val($res.branch_id);
          $('#sender_contact').val($res.contact_number);
            }
       });

  });
  $('#recipient_name').change(function(){

  var value = $('#recipient_name').val();

  $.ajax({
      url:"ajax.php?action=get_user_data&id=" + value,
        cache: false,
        contentType: false,
        processData: false,
        method: 'GET',
        type: 'GET',          
      success:function(res){
        $res = JSON.parse(res)
        $('#recipient_contact').val($res.contact_number);
        $('#to_branch_id').val($res.branch_id);
        $('#to_branch_street').val($res.department);
          }
    });

});
    $('[name="price[]"]').keyup(function(){
      calc()
    })
  $('#new_parcel').click(function(){
    var tr = $('#ptr_clone tr').clone()
    $('#parcel-items tbody').append(tr)
    $('[name="price[]"]').keyup(function(){
      calc()
    })
    $('.number').on('input keyup keypress',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9]/, '');
        val = val.replace(/,/g, '');
        val = val > 0 ? parseFloat(val).toLocaleString("en-US") : 0;
        $(this).val(val)
    })

  })
	$('#manage-parcel').submit(function(e){
		e.preventDefault()
		start_load()
    if($('#manage-parcel input').length <= 0){
      console.log($('#manage-parcel input'));
      alert_toast("Please add atleast 1 parcel information.","error")
      end_load()
      return false;
    }
		$.ajax({
			url:'ajax.php?action=save_parcel',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
        if(resp == 1){
            alert_toast('Document successfully sent',"success");
            setTimeout(function(){
              location.href = 'index.php?page=document_transactions';
            })

        }
			}
		})
	})
</script>