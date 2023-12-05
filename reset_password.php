<?php
include 'db_connect.php';
// $qry = $conn->query("SELECT * FROM parcels where id = ".$_GET['id'])->fetch_array();
// foreach($qry as $k => $v){
// 	$$k = $v;
// }
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<form action="" id="verify">
					<div class="callout callout-info">
						<div>
							<dl>
								<dt>Email:</dt>
								<dd> <h4><b><?php echo $_GET['email']?></b></h4>
									<input type="hidden" name="email" value="<?php echo $_GET['email']?>">
								</dd>
							</dl>
							<dl>
								<dd><b>Code: </b>
									<input type="text" class="form-control" name="code" required placeholder="Enter code received">
								</dd>
								<dd><b>New Password: </b>
									<input type="password" class="form-control" name="npassword" required placeholder="Enter password">
								</dd>
								<dd><b>Confirm Password: </b>
									<input type="password" class="form-control" name="cpassword" required placeholder="Confirm Password">
								</dd>
							</dl>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
    <button class="btn btn-flat  bg-gradient-primary mx-2" form="verify">Send</button>
    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>
<noscript>
	<style>
		table.table{
			width:100%;
			border-collapse: collapse;
		}
		table.table tr,table.table th, table.table td{
			border:1px solid;
		}
		.text-cnter{
			text-align: center;
		}
	</style>
	<h3 class="text-center"><b>Student Result</b></h3>
</noscript>
<script>
	$('#verify').submit(function(e){
		e.preventDefault()
		start_load()

		if($('#verify input').length <= 0){
		console.log($('#verify input'));
		alert_toast("Invalid inputs.","error")
		end_load()
		return false;
		}

		$.ajax({
			url:'ajax.php?action=verify',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
        if(resp == 1){
            alert_toast('User successfully verified',"success");
			end_load()
			$("#close").click();
        }else if (resp == 2){
            alert_toast('You\'ve entered incorrect code.',"danger");
			end_load()
		}else{
            alert_toast('Password doesn\'t match.',"danger");
			end_load()
		}
			}
		})
	})
</script>