<?php 

include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT f.*,u.id as uid,u.username, u.password FROM faculty f inner join users u on u.id = f.user_id where f.id=".$_GET['id']);
	foreach ($qry->fetch_array() as $key => $value) {
		$meta[$key] = $value;
	}
}
?>

<div class="container-fluid">
	<form action="" id="manage-faculty">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
		<input type="hidden" name="uid" value="<?php echo isset($meta['uid']) ? $meta['uid'] : '' ?>">
		<div class="form-group">
			<label for="firstname" class="control-label">Firstname</label>
			<input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="middlename" class="control-label">Middlename</label>
			<input type="text" id="middlename" name="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename'] : '' ?>" >
		</div>
		<div class="form-group">
			<label for="lastname" class="control-label">Lastname</label>
			<input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username" class="control-label">Username</label>
			<input type="text" id="username" name="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="password" class="control-label">Password</label>
			<input type="password" id="password" name="password" class="form-control" value="<?php echo isset($meta['password']) ? $meta['password'] : '' ?>" required>
		</div>

		<div class="form-group">
			<label for="level_section_id" class="control-label">Advisory</label>
			<select id="level_section_id" name="level_section_id" class="custom-select browser-default" required>
				<option value="0">N/A</option>
				<?php 
				$lwhere = '';
				if(isset($meta['level_section_id']))
					$lwhere = " and level_section_id != ".$meta['level_section_id'];
					$ls = $conn->query("SELECT * FROM level_section where status = 1 and id not in (SELECT level_section_id from faculty where status = 1 ".$lwhere." ) ");
					while($row = $ls->fetch_assoc()){
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($meta['level_section_id']) && $meta['level_section_id'] == $row['id'] ? "selected" : '' ?>><?php echo $row['level'] . ' ' . $row['section'] ?></option>
			<?php } ?>
			</select>
		</div>
	</form>
</div>
<script>
	$('#manage-faculty').submit(function(e){
		e.preventDefault();

		start_load()
		$.ajax({
			url:'ajax.php?action=save_faculty',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
			},
			success:function(resp){
				resp = JSON.parse(resp)
				if(resp.status == 1){
					$('.modal').modal('hide')
					end_load()
					alert_toast('Data successfully saved','success');
					load_tbl()

				}else{
					end_load()
					alert_toast(resp.msg,'danger');

				}
			}
		})

	})
</script>