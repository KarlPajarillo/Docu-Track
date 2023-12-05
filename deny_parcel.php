<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM parcels where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
$creator_info = $conn->query("SELECT * FROM users where id = ".$created_by )->fetch_array();
$sender_info = $conn->query("SELECT * FROM users where id = ".$sender_name )->fetch_array();
$receiver_info = $conn->query("SELECT * FROM users where id = ".$recipient_name )->fetch_array();
$cfullname = $creator_info['firstname']. ' ' .$creator_info['lastname'];
$sfullname = $sender_info['firstname']. ' ' .$sender_info['lastname'];
$rfullname = $receiver_info['firstname']. ' ' .$receiver_info['lastname'];
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<form action="" id="deny">
					<div class="callout callout-info">
						<div>
							<dl>
								<dt><h4>Enter a reason to proceed.</h4></dt>
							</dl>
							<dl>
								<dd><b>Message: </b>
									<input type="text" class="form-control" id="deny_message" name="deny_message" value="<?php echo ($deny_message ? $deny_message : '') ?>" required placeholder="Enter reason for denial" required>
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
    <button class="btn btn-flat  bg-gradient-primary mx-2" form="deny">Send</button>
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
	$('#deny').submit(function(e){
		e.preventDefault()
		start_load()

		$.ajax({
			url:'ajax.php?action=save_parcel',
			data: {
				id: '<?php echo $id ?>',
				<?php
					foreach($qry as $key => $value){
						if(in_array($key, array('sender_name','recipient_name','reference_number','created_by'))){
							echo $key.": '".$value."',";
						}
					}
				?>
				status: '2',
				deny_message: $("#deny_message").val(),
				destined_to: '<?php echo $destined_to ?>' + ',' + '<?php echo $sender_name ?>' + ',',
				<?php if($created_by == $sender_name): ?>
					message: '' ,
					cmessage: '<?php echo $rfullname ?>' + ' denied ' + '<?php echo $file_name ?>' ,
				<?php else: ?>
					message: '<?php echo $rfullname ?>' + ' denied ' + '<?php echo $file_name ?>' ,
					cmessage: '' ,
				<?php endif; ?>
			},
			cache: false,
			// contentType: false,
			// processData: false,
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