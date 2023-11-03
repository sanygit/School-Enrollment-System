<?php 

include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM student_list where id=".$_GET['id']);
	foreach ($qry->fetch_array() as $key => $value) {
		$meta[$key] = $value;
	}
	
}
?>

<div class="container-fluid">
	<form action="" id="manage-enroll">
		<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
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
			<label for="gender" class="control-label">Gender</label>
			<select name="gender" id="gender" class="custom-select browser-default">
				<option value="male" <?php echo isset($meta['gender']) && $meta['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
				<option value="female" <?php echo isset($meta['gender']) && $meta['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
			</select>
		</div>
		<div class="form-group">
			<label for="dob" class="control-label">Date of Birth</label>
			<input type="dob" id="dob" name="dob" class="form-control datepicker" value="<?php echo isset($meta['dob']) ? date("Y-m-d",strtotime($meta['dob'])) : '' ?>" required>
		</div>

		<div class="form-group">
			<label for="address" class="control-label">Address</label>
			<textarea type="text" id="address" name="address" class="form-control"  required><?php echo isset($meta['address']) ? $meta['address'] : '' ?></textarea>
		</div>
		<div class="form-group">
			<label for="type" class="control-label">Type</label>
			<select name="type" id="type" class="custom-select browser-default">
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>New</option>
				<?php if(isset($_GET['id'])): ?>
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Regular</option>
				<?php endif; ?>
				<option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected' : '' ?>>Transferee</option>
				<?php if(isset($_GET['id'])): ?>
				<option value="4" <?php echo isset($meta['type']) && $meta['type'] == 4 ? 'selected' : '' ?>>Returnee</option>
				<?php endif; ?>
			</select>
		</div>

		
</div>
<script>
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	})
	$('#manage-enroll').submit(function(e){
		e.preventDefault();

		start_load()
		$.ajax({
			url:'ajax.php?action=save_enroll',
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