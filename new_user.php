<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-staff">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-12">
            <div id="msg" class=""></div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">First Name</label>
                <input type="text" name="firstname" id="" class="form-control form-control-lm" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Department</label>
                <?php if ($_SESSION['login_type'] == 4): ?>
                  <input type="hidden" name="branch_id" value="<?php echo $_SESSION['login_branch_id'] ?>">
                  <input type="text" name="" class="form-control form-control-lm" value="<?php echo ucwords($conn->query("SELECT department from branches where id = ".$_SESSION['login_branch_id'])->fetch_array()['department']) ?>" disabled>
                <?php else: ?>
                <select name="branch_id" id="" class="form-control input-sm select2">
                  <option value=""></option>
                  <?php
                    $branches = $conn->query("SELECT * FROM branches");
                    while($row = $branches->fetch_assoc()):
                  ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($branch_id) && $branch_id == $row['id'] ? "selected":'' ?>><?php echo $row['department'] ?></option>
                <?php endwhile; ?>
                </select>
                <?php endif; ?>
              </div>
              
            </div>

            <div class="row">
              
			  <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Last Name</label>
                <input type="text" name="lastname" id="" class="form-control form-control-lm" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
              </div>
			        <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Contact Number</label>
                <input type="text" name="contact_number" id="" class="form-control form-control-lm" pattern="^09[0-9]{9}$" title="Please put a valid contact number" value="<?php echo isset($contact_number) ? $contact_number : '' ?>" required>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Email</label>
                <input type="email" name="email" id="" class="form-control form-control-lm" value="<?php echo isset($email) ? $email : '' ?>" required>
              </div>
              <?php if (!isset($_GET['id'])): ?>
              <div class="col-sm-6 form-group ">
                <label for="type" class="control-label">User Type</label>
                <select name="type" id="type" class="form-control input-sm select2">
                  <option value="">--SELECT--</option>
                    <?php if ($_SESSION['login_type'] == '1' ): ?>
                      <option value="1">ADMIN</option>
                    <?php endif; ?>
                    <?php if ($_SESSION['login_type'] == '1' || $_SESSION['login_type'] == '2' ): ?>
                      <option value="2">CED</option>
                    <?php endif; ?>
                    <?php if ($_SESSION['login_type'] != '3' && $_SESSION['login_type'] != '4' ): ?>
                      <option value="3">DEAN</option>
                    <?php endif; ?>
                    <?php if ($_SESSION['login_type'] != '5'): ?>
                      <option value="4">CHAIRPERSON</option>
                      <option value="5">FACULTY</option>
                    <?php endif; ?>
                </select>
              </div>
              <?php endif; ?>
            </div>
			
            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Password</label>
                <input type="password" name="password" id="" class="form-control form-control-lm" <?php echo isset($id) ? '' : 'required' ?>>
                <?php if(isset($id)): ?>
                  <small class=""><i>Leave this blank if you dont want to change this</i></small>
                <?php endif; ?>
              </div>
            </div>

            
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-staff">Save</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=user_list">Cancel</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#manage-staff').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
              location.href = 'index.php?page=user_list'
					})
				}else if(resp == 2){
          $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Email already exist.</div>')
          end_load()
        }
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
</script>