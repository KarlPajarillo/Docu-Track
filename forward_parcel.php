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
$type = $conn->query("SELECT * FROM users where id = ".$recipient_name)->fetch_array()['type'];
$creator_info = $conn->query("SELECT * FROM users where id = ".$created_by )->fetch_array();
$cfullname = $creator_info['firstname']. ' ' .$creator_info['lastname'];
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
						</dl>
					</div>
                    <div>
                        <dl>
                            <dt>Type:</dt>
                            <dd><?php echo ucwords($conn->query("SELECT doc_name from documents where id = ".$doc_type)->fetch_array()['doc_name']) ?></dd>
                            <dt>Remarks:</dt>
                            <dd><?php echo ucwords($remarks) ?></dd>
                            <dt>Creator:</dt>
                            <dd><?php echo ucwords($cfullname) ?></dd>
                        </dl>
				    </div>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-lg-12">
                <div class="card card-outline card-light">
                    <div class="card-body">
                        <form action="" id="manage-parcel">
                                <input type="hidden" id="id" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                                <input type="hidden" id="doc_type" name="doc_type" value="<?php echo $doc_type ?>">
                                <input type="hidden" id="remarks" name="remarks" value="<?php echo $remarks ?>">
                                <input type="hidden" id="cfullname" name="cfullname" value="<?php echo $cfullname ?>">
                                <input type="hidden" id="created_by" name="created_by" value="<?php echo $created_by ?>">
                                <input type="hidden" id="reference_number" name="reference_number" value="<?php echo $reference_number ?>">
                                <input type="hidden" id="destined_to" name="destined_to" value="<?php echo $destined_to ?>">
                                <input type="hidden" id="status" name="status" value="0">
                                <div id="msg" class=""></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php 
                                        $user = $conn->query("SELECT * FROM users where id = ".$recipient_name);
                                            while($urow = $user->fetch_assoc()):
                                        ?>
                                        <b>Sender Information</b>
                                        <div class="form-group">
                                            <label for="" class="control-label">Name</label>
                                                <input type="text" name="dummy_name" id="dummy_name" class="form-control form-control-lm" value="<?php echo $urow['firstname'].' '.$urow['lastname'] ?>" disabled>
                                                <input type="hidden" name="sender_name" id="sender_name" class="form-control form-control-sm" value="<?php echo $recipient_name?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="control-label">Department/Office</label>         
                                            <?php 
                                                if($urow['branch_id'] != 0):
                                                    $branch = $conn->query("SELECT * FROM branches where id = ".$urow['branch_id']);
                                                        while($row = $branch->fetch_assoc()):
                                            ?>    
                                                <input type="text" name="from_branch_street" id="from_branch_street" class="form-control form-control-lm" value="<?php echo $row['department'] ?>" disabled>
                                                <input type="hidden" name="from_branch_id" id="from_branch_id" class="form-control form-control-sm" value="<?php echo $urow['branch_id'] ?>" required>
                                            <?php endwhile;?>
                                            <?php else:?>
                                                <input type="text" name="from_branch_street" id="from_branch_street" class="form-control form-control-lm" value="<?php echo 'N/A' ?>" disabled>
                                                <input type="hidden" name="from_branch_id" id="from_branch_id" class="form-control form-control-sm" value="<?php echo $urow['branch_id'] ?>" required>
                                            <?php endif;?>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="control-label">Contact #</label>
                                            <input type="text" name="sender_contact" id="sender_contact" class="form-control form-control-lm" value="<?php echo $urow['contact_number'] ?>" required>
                                        </div>
                                        <?php endwhile; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php 
                                            if($type == 2){
                                                $ruser = $conn->query("SELECT * FROM users where id = ".$created_by );
                                            } else{
                                                $ruser = $conn->query("SELECT * FROM users where dlt = '1' and (branch_id = 0 and type = '".($type - 1)."')" );
                                            }
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
                                            <input type="text" name="to_branch_street" id="to_branch_street" class="form-control form-control-lm" value="<?php echo ($type == 2 ? $conn->query("SELECT * FROM branches where id = ".$rurow['branch_id'])->fetch_array()['department'] : 'N/A') ?>" disabled>
                                            <input type="hidden" name="to_branch_id" id="to_branch_id" class="form-control form-control-sm" value="<?php echo $rurow['branch_id'] ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient_contact" class="control-label">Contact #</label>
                                            <input type="text" name="recipient_contact" id="recipient_contact" class="form-control form-control-lm" value="<?php echo $rurow['contact_number'] ?>" required>
                                        </div>
                                        <?php endwhile; ?>
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
                                </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
    <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-parcel">Send</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
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
                        id: $("#id").val(),
                        sender_name: $("#sender_name").val(),
                        reference_number: $("#reference_number").val(),
                        created_by: $("#created_by").val(),
                        from_branch_id: $("#from_branch_id").val(),
                        sender_contact: $("#sender_contact").val(),
                        recipient_name: $("#recipient_name").val(),
                        to_branch_id: $("#to_branch_id").val(),
                        recipient_contact: $("#recipient_contact").val(),
                        doc_type: $("#doc_type").val(),
                        remarks: $("#remarks").val(),
                        status: '0',
                        destined_to: $("#destined_to").val() + ',' + $("#sender_name").val() + ',',
                        message: $("#dummy_name").val() + ' sent you a document from ' + $("#cfullname").val() ,
                        cmessage: $("#dummy_name").val() + ' sent your document to ' + $("#rdummy_name").val() ,
                        file_name: $arr_resp[1]
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