<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_user"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Department</th>
						<th>User Type</th>
						<th>Action</th>

					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					if($_SESSION['login_type'] == 1){
						$qry = $conn->query("SELECT u.*,concat(u.firstname,' ',u.lastname) as name, b.department FROM users u left outer join branches b on b.id = u.branch_id where (u.id != ".$_SESSION['login_id'].") and dlt='1' order by concat(u.firstname,' ',u.lastname) asc ");
					}elseif($_SESSION['login_type'] == 2){
						$qry = $conn->query("SELECT u.*,concat(u.firstname,' ',u.lastname) as name, b.department FROM users u inner join branches b on b.id = u.branch_id where ((u.id != ".$_SESSION['login_id'].") and (u.type != '1' and u.type != '2')) and dlt='1' order by concat(u.firstname,' ',u.lastname) asc ");
					}elseif($_SESSION['login_type'] == 3){
						$qry = $conn->query("SELECT u.*,concat(u.firstname,' ',u.lastname) as name, b.department FROM users u inner join branches b on b.id = u.branch_id where ((u.id != ".$_SESSION['login_id'].") and (u.type != '1' and u.type != '2' and u.type != '3')) and dlt='1' order by concat(u.firstname,' ',u.lastname) asc ");
					}elseif($_SESSION['login_type'] == 4){
						$qry = $conn->query("SELECT u.*,concat(u.firstname,' ',u.lastname) as name, b.department FROM users u inner join branches b on b.id = u.branch_id where ((u.id != ".$_SESSION['login_id']." and u.branch_id = ".$_SESSION['login_branch_id'].") and (u.type = '5')) and dlt='1' order by concat(u.firstname,' ',u.lastname) asc ");
					}
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php echo ($row['email']) ?></b></td>
						<td><b><?php echo ucwords($row['department'] == 0 ? 'N/A' : $row['department']) ?></b></td>
						<td><b><?php echo ucwords($row['type'] == '1' ? 'ADMIN' : ($row['type'] == '2' ? 'CED' : ($row['type'] == '3' ? 'DEAN' : ($row['type'] == '4' ? 'CHAIRPERSON' : 'FACULTY'))) ) ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
								<?php if($row['type'] != '1'): ?>
									<a href="index.php?page=edit_user&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
									<i class="fas fa-edit"></i>
									</a>
									<button type="button" class="btn btn-danger btn-flat delete_staff" data-id="<?php echo $row['id'] ?>">
									<i class="fas fa-trash"></i>
									</button>
								<?php endif; ?>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td{
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
		$('.view_staff').click(function(){
			uni_modal("staff's Details","view_staff.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_staff').click(function(){
	_conf("Are you sure to delete this user?","delete_staff",[$(this).attr('data-id')])
	})
	})
	function delete_staff($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("User successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>