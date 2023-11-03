<?php
include 'db_connect.php';
$etype = $_POST['etype'];
$sy = $_POST['sy'];
$qry = $conn->query("SELECT * from settings limit 1");
if($qry->num_rows > 0){
	foreach($qry->fetch_array() as $k => $val){
		$smeta[$k] = $val;
	}
}
$faculty = $conn->query("SELECT *,concat(firstname,' ',middlename,' ',lastname) as name FROM faculty where status = 1");
$fac_arr = array();
while($row=$faculty->fetch_assoc()){
	$fac_arr[$row['level_section_id']] = ucwords($row['name']);
}
if(isset($_POST['id'])){
	$qry = $conn->query("SELECT e.*,s.firstname,s.lastname,s.middlename,s.gender,s.dob,s.address,l_s.* from enrollment e inner join faculty f on f. id = e.faculty_id inner join level_section ls on e.level_section_id = ls.id inner join student_list s on s.id = e.student_id inner join last_school l_s on l_s.enrollment_id = e.id where e.id=".$_POST['id']);
	foreach ($qry->fetch_array() as $key => $value) {
		$meta[$key] = $value;
	}
	
}
?>
		<?php if($etype == 1 || $etype == 3) : ?>

		

		<div class="col-md-6">
		<div class="form-group">
				<input type="hidden" name="sid" value="<?php echo isset($meta['student_id']) ? $meta['student_id'] : '' ?>">
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
		</div>

		<?php endif; ?>
		

		<div class="col-md-6">
			<?php if($etype == 2 || $etype == 4) : ?>

		<div class="form-group">
			<label for="student_id">Student Name</label>
			<select name="student_id" id="student_id" class="custom-select browser-default select2">
				<option ></option>
				<?php  
				$student = $conn->query("SELECT *,concat(firstname,' ',middlename,' ',lastname) as name from student_list where id not in (SELECT student_id from enrollment where school_year = '".$sy."' )  and status = 1");
				while($row=$student->fetch_assoc()){
				?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['student_code']. " | ".(ucwords($row['name'])) ?></option>
				<?php } ?>	
			</select>

		</div>
		<?php endif; ?>

			<div class="form-group">
			<label for="level_section_id">Enroll to </label>
			<select name="level_section_id" id="level_section_id" class="custom-select browser-default select2">
				<option ></option>
				<?php  
				$ls = $conn->query("SELECT *,concat(level,'-',section) as ls from level_section where status = 1 ");
				while($row=$ls->fetch_assoc()){
					if(isset($fac_arr[$row['id']])){
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($meta['level_section_id']) && $meta['level_section_id'] == $row['id'] ? 'selected' : '' ?>><?php echo (ucwords($row['ls'])) ."  (Adviser: " . $fac_arr[$row['id']] . " )" ?></option>
				<?php }} ?>	
			</select>

		</div>
		<div class="form-group">
			<label for="sla">School Last Attended</label>
			<input name="sla" id="sla" class="form-control" required="" <?php echo $etype == 2 ? 'readonly' : '' ?> value="<?php echo isset($meta['last_school']) ? $meta['last_school'] : (isset($smeta['name']) && $etype == 2 ? $smeta['name'] :'')  ?>">
		</div>
		<div class="form-group">
			<label for="slaa">School Last Attended Address</label>
			<textarea name="slaa" id="slaa" class="form-control" required="" <?php echo $etype == 2 ? 'readonly' : '' ?>><?php echo isset($meta['last_address']) ? $meta['last_address'] :(isset($smeta['address']) && $etype == 2 ? $smeta['address'] :'')  ?></textarea>
		</div>
		</div>
<script>
	$('.select2').select2({
		placeholder:"Please Select Here",
		width : "100%"
	})

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	})
</script>
