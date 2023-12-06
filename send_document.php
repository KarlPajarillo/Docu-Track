<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
  #uploadForm label {
      margin: 2px;
      font-size: 1em;
  }

  #progress-bar {
      background-color: #12CC1A;
      color: #FFFFFF;
      width: 0%;
      -webkit-transition: width .3s;
      -moz-transition: width .3s;
      transition: width .3s;
      border-radius: 5px;
  }

  #targetLayer {
      width: 100%;
      text-align: center;
  }

  input[type="file"] {
    &::file-selector-button {
      display: none;
    }
  }

  input[type="file"]:hover, label[for="file_name"] {
    cursor: pointer;
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
              $user = $conn->query("SELECT * FROM users where id = ".$_SESSION['login_id']);
                while($urow = $user->fetch_assoc()):
            ?>
              <b>Sender Information</b>
              <div class="form-group">
                <label for="dummy_name" class="control-label">Name</label>
                    <input type="text" name="dummy_name" id="dummy_name" class="form-control form-control-lm" value="<?php echo $urow['firstname'].' '.$urow['lastname'] ?>" disabled>
                    <input type="hidden" name="sender_name" id="sender_name" class="form-control form-control-sm" value="<?php echo $_SESSION['login_id']?>" required>
                    <input type="hidden" name="created_by" id="created_by" class="form-control form-control-sm" value="<?php echo $_SESSION['login_id']?>" required>
              </div>
              <div class="form-group">
                <label for="from_branch_street" class="control-label">Department/Office</label>         
                <?php 
                  $branch = $conn->query("SELECT * FROM branches where id = ".$urow['branch_id']);
                    while($row = $branch->fetch_assoc()):
                ?>    
                <input type="text" name="from_branch_street" id="from_branch_street" class="form-control form-control-lm" value="<?php echo $row['department'] ?>" disabled>
                <input type="hidden" name="from_branch_id" id="from_branch_id" class="form-control form-control-sm" value="<?php echo $urow['branch_id'] ?>" required>
                <?php endwhile; ?>
              </div>
              <div class="form-group">
                <label for="sender_contact" class="control-label">Contact #</label>
                <input type="text" name="sender_contact" id="sender_contact" class="form-control form-control-lm" value="<?php echo $urow['contact_number'] ?>" required>
              </div>
            <?php endwhile; ?>
          </div>
          <div class="col-md-6">
            <?php 
              $ruser = $conn->query("SELECT * FROM users where dlt = '1' and id != ".$_SESSION['login_id']." and (branch_id = ".$_SESSION['login_branch_id']." and type = 4)" );
                    while($rurow = $ruser->fetch_assoc()):
            ?>
              <b>Recipient Information</b>
              <div class="form-group">
                <label for="rdummy_name" class="control-label">Name</label>
                    <input type="text" name="rdummy_name" id="rdummy_name" class="form-control form-control-lm" value="<?php echo $rurow['firstname'].' '.$rurow['lastname'] ?>" disabled>
                    <input type="hidden" name="recipient_name" id="recipient_name" class="form-control form-control-sm" value="<?php echo $rurow['id']?>" required>
              </div>
              <div class="form-group">
                <label for="to_branch_street" class="control-label">Department/Office</label>         
                <input type="text" name="to_branch_street" id="to_branch_street" class="form-control form-control-lm" value="<?php echo $conn->query("SELECT * FROM branches where id = ".$rurow['branch_id'])->fetch_array()['department'] ?>" disabled>
                <input type="hidden" name="to_branch_id" id="to_branch_id" class="form-control form-control-sm" value="<?php echo $rurow['branch_id'] ?>" required>
              </div>
              <div class="form-group">
                <label for="recipient_contact" class="control-label">Contact #</label>
                <input type="text" name="recipient_contact" id="recipient_contact" class="form-control form-control-lm" value="<?php echo $rurow['contact_number'] ?>" required>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="doc_type">Document Type</label>
              <select name="doc_type" id="doc_type" class="form-control select2" required>
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
              <label for="remarks">Details</label>
              <input type="text" name="remarks" id="remarks" class="form-control form-control-lm" value="<?php echo isset($remarks) ? $remarks : '' ?>" required>
            </div>
          </div>
        </div>
        <div>
          <div class="row">
            <div class="col-md-6">
              <div class="input-group custom-file-button">
                <label class="input-group-text" for="file_name">Upload File (ex. .doc and .pdf):</label> 
                <input name="file_name" id="file_name" type="file" class="form-control form-control-lm" required />
              </div>
              <div id="err"></div>
            </div>
          </div>
          <div class="row">
              <div id="progress-bar"></div>
          </div>
          <div id="targetLayer"></div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-parcel">Send</button>
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

    console.log($('#file_name').prop('files')[0]['name'], 'asdfsdfs');

    $.ajax({
      url: "upload.php",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $("#err").fadeOut();
      },
      success: function(resp) {
        $arr_resp = resp.split(',');
        if ($arr_resp[0] != 'Success') {
          $("#err").html("<span class='text-danger'>" + resp + "</span>").fadeIn();
          end_load()
        } else {
          $("#err").html("<span class='text-success'>Success!</span>").fadeIn();
          $.ajax({
            url:'ajax.php?action=save_parcel',
            data: {
                id: '',
                sender_name: $("#sender_name").val(),
                created_by: $("#created_by").val(),
                from_branch_id: $("#from_branch_id").val(),
                sender_contact: $("#sender_contact").val(),
                recipient_name: $("#recipient_name").val(),
                to_branch_id: $("#to_branch_id").val(),
                recipient_contact: $("#recipient_contact").val(),
                doc_type: $("#doc_type").val(),
                remarks: $("#remarks").val(),
                message: $("#dummy_name").val() + ' sent you a document.',
                file_name: $arr_resp[1]
              },
              // cache: false,
              // contentType: false,
              // processData: false,
              method: 'POST',
              // type: 'POST',
            success:function(resp){
              if(resp == 1){
                  alert_toast('Document successfully sent',"success");
                  setTimeout(function(){
                    location.href = 'index.php?page=document_transactions';
                  })

              }
            }
          })
          // $("#preview").html(data).fadeIn();
          end_load()
          // $("#manage-parcel")[0].reset(); 
        }
      },
      error: function(e) {
        $("#err").html(e).fadeIn();
      }          
    });

	})
</script>