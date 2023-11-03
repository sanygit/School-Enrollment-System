<?php 

include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT e.*,CONCAT(s.firstname,' ',s.middlename,' ',s.lastname) as name,CONCAT(f.firstname,' ',f.middlename,' ',f.lastname) as fname,CONCAT(ls.level,'-',ls.section) as ls,s.type from enrollment e inner join faculty f on f. id = e.faculty_id inner join level_section ls on e.level_section_id = ls.id inner join student_list s on s.id = e.student_id where e.id=".$_GET['id']);
	foreach ($qry->fetch_array() as $key => $value) {
		$meta[$key] = $value;
	}
	
}
$sy = $conn->query("SELECT * from school_year where is_on = 1 ")->fetch_array()['id'];
?>

<div class="container-fluid">
	<div class="card">
		<div class="card-modal col-md-12">
			<form action="" id="manage-student">
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
				<input type="hidden" name="school_year" value="<?php echo $sy ?>">
				<div class="form-group col-md-4">
					<label for="type" class="control-label">Student Type</label>
					<select name="type" id="type" class="custom-select browser-default">
						<option value="" disabled="" selected="">Select here</option>
						<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>New</option>
						<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Regular</option>
						<option value="3" <?php echo isset($meta['type']) && $meta['type'] == 3 ? 'selected' : '' ?>>Transferee</option>
						<option value="4" <?php echo isset($meta['type']) && $meta['type'] == 4 ? 'selected' : '' ?>>Returnee</option>
					</select>
				</div>
			<div id="data-field" class="row"></div>
			</form>
		</div>
	</div>
		
</div>
<script>

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	})
	if('<?php echo isset($_GET['id']) ?>' == 1){
		$.ajax({
			url:'enroll_form_include.php',
			method:"POST",
			data:{etype : $('#type').val(),sy:'<?php echo $sy ?>',id:'<?php echo isset($_GET['id']) ? $_GET['id'] :'' ?>'},
			success:function(resp){
				if(resp){
					$('#data-field').html(resp)
				}
					end_load();

			}
		})
	}
	$('#type').change(function(){
		start_load();
		$.ajax({
			url:'enroll_form_include.php',
			method:"POST",
			data:{etype : $(this).val(),sy:'<?php echo $sy ?>'},
			success:function(resp){
				if(resp){
					$('#data-field').html(resp)
					end_load();
				}
			}
		})
	})
	$('#manage-student').submit(function(e){
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
				if(resp == 1){
					$('.modal').modal('hide')
					end_load()
					alert_toast('Data successfully saved','success');
					load_tbl()

				}else{
					end_load()
					alert_toast('An error occured','danger');

				}
			}
		})

	})
</script>