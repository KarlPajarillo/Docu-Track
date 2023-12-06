<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM parcels where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
if($to_branch_id > 0 || $from_branch_id > 0){
	$to_branch_id = $to_branch_id  > 0 ? $to_branch_id  : '-1';
	$from_branch_id = $from_branch_id  > 0 ? $from_branch_id  : '-1';
$branch = array();
 $branches = $conn->query("SELECT * FROM branches where id in ($to_branch_id,$from_branch_id)");
    while($row = $branches->fetch_assoc()):
    	$branch[$row['id']] = $row['department'];
	endwhile;
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-info">
					<div>
						<dl>
							<dt>Tracking Number:</dt>
							<dd> <h4><b><?php echo $reference_number ?></b></h4></dd>
						</dl>
						<dl>
							<dd><b>Date Created: </b><?php echo date("M jS, Y h:i a", strtotime($date_created)) ?></dd>
							<dd><b>Date Updated: </b><?php echo date("M jS, Y h:i a", strtotime($date_updated)) ?></dd>
							<dd>
								<a href="assets/uploads/<?php echo $file_name ?>" target="blank" class="btn btn-primary btn-flat" style="color:white; text-decoration: none">
									View Document
								</a>
							</dd>
							<?php if($status == 2): ?>
								<dd>
									<b>Reason for denial: </b>
								</dd>
								<dd style="color:red">
									<?php echo $deny_message ?>
								</dd>
							<?php endif; ?>
						</dl>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Sender Information</b>
					<dl>
						<dt>Name:</dt>
						<dd><?php echo ucwords($conn->query("SELECT concat(firstname, ' ', lastname) as name from users where id = ".$sender_name)->fetch_array()['name']) ?></dd>
						<dt>Department:</dt>
						<dd><?php echo ucwords((isset($branch[$from_branch_id]) ? $branch[$from_branch_id] : 'N/A' )) ?></dd>
						<dt>Contact:</dt>
						<dd><?php echo ucwords($sender_contact) ?></dd>
					</dl>
				</div>
			</div>
			<div class="col-md-4">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Recipient Information</b>
					<dl>
						<dt>Name:</dt>
						<dd><?php echo ucwords($conn->query("SELECT concat(firstname, ' ', lastname) as name from users where id = ".$recipient_name)->fetch_array()['name']) ?></dd>
						<dt>Department:</dt>
						<dd><?php echo ucwords((isset($branch[$to_branch_id]) ? $branch[$to_branch_id] : 'N/A' )) ?></dd>
						<dt>Contact:</dt>
						<dd><?php echo ucwords($recipient_contact) ?></dd>
					</dl>
				</div>
			</div>
			<div class="col-md-4">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Document Details</b>
					<!-- <div class="row"> -->
						<!-- <div class="col-sm-12"> -->
							<dl>
								<dt>Type:</dt>
								<dd><?php echo ucwords($conn->query("SELECT doc_name from documents where id = ".$doc_type)->fetch_array()['doc_name']) ?></dd>
							<!-- </dl> -->
							<!-- <dl> -->
								<dt>Remarks:</dt>
								<dd><?php echo ucwords($remarks) ?></dd>
							<!-- </dl> -->
							<!-- <dl> -->
								<dt>Status:</dt>
								<dd>
									<?php 
									switch ($status) {
										case '0':
											echo "<span class='badge badge-pill badge-info'> Sent</span>";
											break;
										case '1':
											echo "<span class='badge badge-pill badge-primary'> Approved</span>";
											break;
										case '2':
											echo "<span class='badge badge-pill badge-danger'> Denied</span>";
											break;
										// case '4':
										// 	echo "<span class='badge badge-pill badge-primary'> Arrived At Destination</span>";
										// 	break;
										// case '5':
										// 	echo "<span class='badge badge-pill badge-primary'> Out for Delivery</span>";
										// 	break;
										// case '6':
										// 	echo "<span class='badge badge-pill badge-primary'> Ready to Pickup</span>";
										// 	break;
										// case '7':
										// 	echo "<span class='badge badge-pill badge-success'>Delivered</span>";
										// 	break;
										// case '8':
										// 	echo "<span class='badge badge-pill badge-success'> Picked-up</span>";
										// 	break;
										// case '9':
										// 	echo "<span class='badge badge-pill badge-danger'> Unsuccessfull Delivery Attempt</span>";
										// 	break;
										
										// default:
										// 	echo "<span class='badge badge-pill badge-info'> Files To Confirm</span>";
											
										// 	break;
									}

									?>
									<!-- <span class="btn badge badge-primary bg-gradient-primary" id='update_status'><i class="fa fa-edit"></i> Update Status</span> -->
								</dd>
							</dl>
						<!-- </div> -->
					<!-- </div> -->
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
	$('#update_status').click(function(){
		uni_modal("Update Status of: <?php echo $reference_number ?>","manage_parcel_status.php?id=<?php echo $id ?>&cs=<?php echo $status ?>","")
	})
</script>